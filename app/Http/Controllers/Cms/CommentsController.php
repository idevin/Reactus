<?php

namespace App\Http\Controllers\Cms;

use App\Models\Comment;
use App\Models\Permission;
use App\Models\SectionRole;
use App\Models\SectionUser;
use App\Traits\CustomValidators;
use App\Traits\Domain as DomainTrait;
use App\Traits\Site;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Utils\CmsFilter;
use App\Http\Requests;
use Illuminate\Http\Response;
use Validator;

class CommentsController extends CmsController
{

    use DomainTrait;
    use Site;
    use CustomValidators;

    public function __construct()
    {
        parent::__construct();
        $this->breadcrumbs[] = ['Коментарии', 'comments.index'];
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $title = 'Комментарии';

        $breadcrumbs = $this->breadcrumbs;

        $comments = Comment::query()->with(['author', 'moderator', 'article']);

        $fields = $this->setFields($comments);

        $filter = new CmsFilter(Comment::class, 'comments.index');

        $filter->addField('author|user::username', 'Автор')
            ->addField('site::domain', 'Сайт')
            ->addField('content', 'Комментарий');

        $filter = $filter->render();

        return view('cms.comments.index',
            compact('fields', 'title', 'filter', 'breadcrumbs'));
    }

    public static function getValidator($data)
    {
        $rules = [
            'content' => 'required'
        ];

        $messages = [
            'content.required' => 'Напишите сообщение'
        ];

        return Validator::make($data, $rules, $messages);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Application|Factory|View
     */
    public function edit($id): View|Factory|Application
    {
        $title = 'Редактирование';

        $form = Comment::query()->findOrFail($id);

        $this->breadcrumbs[] = ['Редактирование'];
        $breadcrumbs = $this->breadcrumbs;
        $action = route('comments.update', ['comments' => $form->id]);

        return view('cms.comments.edit', compact('form', 'title', 'breadcrumbs', 'action'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $field = Comment::query()->findOrFail($id);
        $inputData = $request->all();
        $validator = static::getValidator($inputData);

        if ($validator->fails()) {
            return redirect()->back()->withInput($inputData)->withErrors($validator);
        } else {

            $field->update($inputData);
            session()->flash('success', 'Запись сохранена');
            return redirect()->route('comments.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(int $id): RedirectResponse
    {
        $comment = Comment::query()->find($id);
        $comment?->delete();
        session()->flash('success', 'Удалено!');

        return redirect()->route('comments.index');
    }
}
