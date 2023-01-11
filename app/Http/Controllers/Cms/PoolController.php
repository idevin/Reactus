<?php

namespace App\Http\Controllers\Cms;

use App\Models\Article;
use App\Models\Comment;
use App\Models\Complain;
use App\Models\Section;
use App\Models\SectionSite;
use App\Traits\CustomValidators;
use App\Traits\Domain as DomainTrait;
use App\Traits\Site;
use Auth;
use Exception;
use Illuminate\Http\Response;
use Session;

class PoolController extends CmsController
{
    use DomainTrait;
    use Site;
    use CustomValidators;

    public function __construct()
    {
        parent::__construct();
        $this->breadcrumbs[] = ['Пул модераторов', 'cms.pool.index'];

    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $title = 'Модераторский пул';
        $breadcrumbs = $this->breadcrumbs;

        $articles = Article::query()->onModeration()->orderBy('id', 'DESC')->get();
        $comments = Comment::query()->onModeration()->orderBy('id', 'DESC')->get();
        $arComments = [];
        foreach ($comments as $comment) {
            if (empty($comment) || !$comment) {
                continue;
            }

            if (empty($comment->article) || !$comment->article) {
                continue;
            }

            $arComments[] = $comment;
        }
        $complains = Complain::query()->onModeration()->orderBy('id', 'DESC')->get();
        $sections = SectionSite::where('moderated', 0)->get();

        return view('cms.pool.index', compact('title', 'breadcrumbs', 'arComments', 'articles', 'complains', 'sections'));
    }

    public function delete($object, $id)
    {
        return $this->{'delete' . $object}($id);
    }

    public function deleteComplain($id)
    {
        try {
            Complain::findOrFail($id)->delete();
        } catch (Exception $e) {
        }

        session()->flash('success', 'Жалоба удалена!');
        return redirect()->route('cms.pool.index');
    }

    public function deleteComment($id)
    {
        try {
            Comment::findOrFail($id)->delete();
        } catch (Exception $e) {
        }

        session()->flash('success', 'Комментарий удален!');
        return redirect()->route('cms.pool.index');
    }

    public function approveComplain($id)
    {
        $complain = Complain::findOrFail($id);
        $value = 0;

        if ($complain) {
            $value = (int)$complain->complain_option->value;
            $complain->on_user->increment('rating', $value);
            $complain->setConnection('mysql')->update([
                'status' => Complain::STATUS_APPROVED,
                'moderator_id' => Session::get('user')->id
            ]);
        }

        session()->flash('success', 'В рейтинг пользователя ' . username($complain->on_user) . ' добавлено ' . $value);
        return redirect()->route('cms.pool.index');
    }

    public function approve($object, $id)
    {
        $data = $this->{'approve' . $object}($id);

        session()->flash('success', $data['message']);
        return redirect()->route('cms.pool.index');
    }

    public function approveComment($id)
    {
        $comment = Comment::find($id);

        if ($comment) {
            $comment->update([
                'moderator_id' => Auth::user()->id,
                'status' => Comment::STATUS_APPROVED,
                'moderated' => 1
            ]);

            $message = 'Комментарий подтвержден';
        } else {
            $message = 'Комментарий не найден';
        }

        return compact('message');
    }

    public function approveArticle($id)
    {
        $article = Article::find($id);

        if ($article) {
            $article->update([
                'moderator_id' => Auth::user()->id,
                'status' => Article::STATUS_PUBLISHED
            ]);

            $message = 'Статья подтверждена';
        } else {
            $message = 'Статья не найдена';
        }

        return compact('message');
    }

    public function approveSectionTransfer($id)
    {
        $sectionSite = SectionSite::find($id);

        if (!$sectionSite) {
            session()->flash('error', 'Раздел не перенесен или не найден');
            return redirect()->route('cms.pool.index');
        }

        $newSection = Section::find($sectionSite->to_section_id);

        if (!$newSection) {
            session()->flash('error', 'Раздел, в который переносится, не найден');
            return redirect()->route('cms.pool.index');
        }

        $sectionSite->update([
            'moderated' => 1
        ]);

        session()->flash('success', 'Раздел не перенесен');
        return redirect()->route('cms.pool.index');
    }

    public function denySectionTransfer($id)
    {
        $sectionSite = SectionSite::find($id);

        if (!$sectionSite) {
            session()->flash('error', 'Раздел не перенесен или не найден');
            return redirect()->route('cms.pool.index');
        }

        $transferedSection = Section::find($sectionSite->section_id);

        $sections = $transferedSection->getDescendantsAndSelf();
        $sectionToDelete = Section::find($sectionSite->to_section_id);

        if (count($sections) > 0) {
            foreach ($sections as $section) {
                $section->update([
                    'transfer_to_section' => null,
                    'transfered' => 0,
                    'announce' => 0
                ]);
            }
        }

        $sectionToDelete?->forceDelete();

        $sectionSite->forceDelete();

        session()->flash('success', 'Раздел не перенесен');
        return redirect()->route('cms.pool.index');
    }

    public function denyComplain($id)
    {
        $complain = Complain::findOrFail($id);
        $value = -1;
        if ($complain) {
            $value = (int)$complain->complain_option->value;
            $complain->user->increment('rating', $value);
            $complain->setConnection('mysql')->update([
                'status' => Complain::STATUS_DENIED,
                'moderator_id' => Session::get('user')->id
            ]);
        }

        session()->flash('success', 'В рейтинг пользователя ' .
            username($complain->user) . ' добавлено ' . $value);

        return redirect()->route('cms.pool.index');
    }
}
