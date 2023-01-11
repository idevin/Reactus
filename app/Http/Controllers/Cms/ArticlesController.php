<?php

namespace App\Http\Controllers\Cms;

use App\Models\Article;
use App\Models\Comment;
use App\Models\Section;
use App\Models\Site as SiteModel;
use App\Models\User;
use App\Traits\CustomValidators;
use App\Traits\Domain as DomainTrait;
use App\Traits\Media;
use App\Utils\CmsFilter;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Intervention\Image\Image;
use Throwable;
use Validator;

class ArticlesController extends CmsController
{
    use DomainTrait;
    use Media;
    use CustomValidators;

    public function __construct()
    {
        parent::__construct();
        $this->breadcrumbs[] = ['Статьи', 'articles.index'];
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View|RedirectResponse|Redirector
     */
    public function index()
    {
        $sites = SiteModel::thematic()->get()->all();

        if (empty($sites)) {
            return $this->redirectToSites('Сначала добавьте сайт, чтоб добавить статью');
        }

        $title = 'Статьи';

        $breadcrumbs = $this->breadcrumbs;

        $articles = Article::withTrashed()->with('author', 'site', 'section');

        $fields = $this->setFields($articles);

        $filter = new CmsFilter(Article::class, 'articles.index');

        $filter->addField('title', 'Название')
            ->addField('content', 'Контент')
            ->addField('site::domain', 'Сайт')
            ->addField('author|user::username', 'Автор')
            ->addField('created_at', 'Дата')
            ->addButton('Создать', 'articles.create');

        $filter = $filter->render();

        $users = User::orderBy('username', 'desc')->get();

        return view('cms.articles.index',
            compact('fields', 'title', 'filter', 'breadcrumbs', 'users'));
    }

    public function searchAuthor(Request $request)
    {
        $query = $request->get('query');

        $users = User::orWhere('username', 'like', "%$query%")
            ->orWhere('first_name', 'like', "%$query%")
            ->orWhere('last_name', 'like', "%$query%")->get();

        if (count($users) > 0) {
            $users = $users->map(function ($user) {
                return [
                    'value' => username($user),
                    'data' => (string)$user->id
                ];
            });
        }

        return ['suggestions' => $users];
    }

    public function massDelete(Request $request)
    {
        $objects = $request->get('o');

        if (!empty($objects)) {
            $objects = explode(',', $objects);

            if (!empty($objects)) {
                foreach ($objects as $object) {
                    $article = Article::withTrashed()->find($object);
                    if ($article) {
                        if ($article->trashed()) {

                            Comment::where('object', Article::class)
                                ->where('object_id', $article->id)->delete();

                            $article->forceDelete();
                        } else {
                            $article->delete();
                        }
                    }
                }
            }
        }

        return response()->json($objects);
    }

    public function restore(Request $request)
    {
        $objects = $request->get('o');

        if (!empty($objects)) {
            $objects = explode(',', $objects);

            if (!empty($objects)) {
                foreach ($objects as $object) {
                    $article = Article::withTrashed()->find($object);

                    if ($article && $article->trashed()) {
                        $article->restore();
                    }
                }
            }
        }

        session()->flash('success', 'Статьи восстановлены!');
    }

    public function massUpdateAuthor(Request $request)
    {
        $objects = $request->get('o');
        $authorId = $request->get('author_id');

        $articleIds = explode(',', $objects);
        $user = User::find($authorId);

        if ($user && !empty($articleIds)) {
            (new \App\Models\Article)->whereIn('id', $articleIds)->update([
                'author_id' => $user->id
            ]);
            session()->flash('success', 'Автор изменен!');
        } else {
            session()->flash('success', 'Что-то пошло не так!');
        }
    }

    public function undelete($id)
    {
        $article = Article::withTrashed()->find($id);

        if ($article) {
            $article->restore();
            session()->flash('success', 'Статья восстановлена!');
        } else {
            session()->flash('success', 'Статья не найдена!');
        }

        return redirect(route('articles.index'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $inputData = $request->all();

        $validator = static::getValidator($inputData);

        if ($validator->fails()) {
            return redirect()->back()->withInput($inputData)->withErrors($validator);
        } else {

            if (empty($inputData['published_at'])) {
                $inputData['published_at'] = Carbon::now();
            }

            Article::create($inputData);

            session()->flash('success', 'Запись сохранена');

            return redirect()->route('articles.index');
        }
    }

    public static function getValidator($data)
    {
        return Validator::make($data, [
            'site_id' => 'required',
            'section_id' => 'required',
            'author_id' => 'required',
            'title' => 'required',
            'content' => 'required'
        ], [
            'site_id.required' => 'Выберите сайт...',
            'section_id.required' => 'Поле "Раздел" обязательно для заполнения',
            'author_id.required' => 'Выберите пользователя',
            'title.required' => 'Заголовок обязателен для заполнения',
            'content.required' => 'Напишите контент'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return void
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|Response|View
     */
    public function edit($id)
    {
        $title = 'Редактирование статьи';

        $sites = SiteModel::getTreeOptions(null, false, true);
        $form = Article::findOrFail($id);

        $this->breadcrumbs[] = ['Редактирование'];
        $breadcrumbs = $this->breadcrumbs;
        $action = 'articles.update';
        $sections = Section::getTreeOptions($form->site, true);
        $statusOptions = (new Article())->getStatusOptions();

        return view('cms.articles.edit',
            compact('form', 'title', 'breadcrumbs', 'action', 'sites', 'sections', 'statusOptions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        $title = 'Создать';

        $this->breadcrumbs[] = [$title];
        $breadcrumbs = $this->breadcrumbs;
        $form = new Article();
        $action = 'articles.store';

        $flashData = $request->session()->get('_old_input');
        $site = SiteModel::first();

        if ($flashData && !empty($flashData['site_id'])) {
            $site = SiteModel::find($flashData['site_id']);
        }

        $sites = SiteModel::getTreeOptions(null, false, false);
        $sections = Section::getTreeOptions($site, true);
        $statusOptions = ($form)->getStatusOptions();

        return view('cms.articles.new_form', compact('form', 'title', 'breadcrumbs', 'action', 'sites', 'sections', 'statusOptions'));
    }

    /**
     * @param Request $request
     * @return string
     * @throws Throwable
     */
    public function changeSection(Request $request)
    {
        $siteId = $request->get('site_id', 0);

        $site = SiteModel::find($siteId);
        $sections = [];

        if ($site) {
            $sections = Section::getTreeOptions($site, true);
        }

        return view('cms.partials.sections_select', compact('sections'))->render();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $inputData = $request->all();
        $validator = static::getValidator($inputData);

        if ($validator->fails()) {
            return redirect()->back()->withInput($inputData)->withErrors($validator);
        } else {

            $this->processImages($inputData, $article);

            $article->update($inputData);

            session()->flash('success', 'Запись сохранена');
            return redirect()->route('articles.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     * @throws Exception
     */
    public function destroy($id)
    {
        $article = Article::find($id);

        if ($article) {
            $article->delete();
        }

        session()->flash('success', 'Записи удалены!');

        return redirect()->route('articles.index');
    }

    public function destroyForever($id)
    {
        $article = Article::withTrashed()->find($id);

        if ($article) {
            $article->forceDelete();
        }

        session()->flash('success', 'Записи удалены навсегда!');

        return redirect()->route('articles.index');
    }

    public function processImages(&$inputData, $article)
    {

        $saveImages = function (&$inputData, $article, $attribute, $folder = 'section') {

            $image = $inputData['image'];

            if (!empty($image)) {
                $mimeType = $image->getMimeType();
                if (in_array($mimeType, array_values(config('netgamer.scoped_image_types')))) {
                    $mimeTypes = collect(config('netgamer.scoped_image_types'))->flip()->toArray();
                    $extension = $mimeTypes[$mimeType];

                    if (!empty($article->$attribute)) {
                        $filename = $article->$attribute;
                    } else {
                        $filename = generate_upload_name() . '.' . $extension;
                    }

                    $fullPath = domain_upload_path(null, 'storage/' . $folder) . $filename;

                    file_put_contents($fullPath, file_get_contents($image->getRealPath()));
                    $this->thumbs($fullPath, $folder);
                    $inputData[$attribute] = $filename;
                }
            }
        };

        if (!empty($inputData['image_remove'])) {
            self::deleteImage($article->image, 'article_slider');
            unset($inputData['image_remove']);
        }

        if (!empty($inputData['image'])) {
            $saveImages($inputData, $article, 'image', 'article_slider');
        }
    }

    public function thumbs($image, $folder)
    {
        /** @var Image $image */
        $fullPath = $image;

        $config = collect(config('image.thumb.' . $folder))->map(function ($item) {
            return [
                'size' => $item['size'],
                'generateImage' => true,
                'watermark' => false,
                'text' => false,
                'color' => null
            ];
        });

        $this->createThumbs($fullPath, $config, $folder);
    }
}
