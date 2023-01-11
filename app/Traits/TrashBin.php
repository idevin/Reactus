<?php

namespace App\Traits;

use App\Models\Article;
use App\Models\Section;
use Illuminate\Support\Facades\Auth;

trait TrashBin
{
    public function showTrash($request, int $id)
    {
        if (Auth::user() && !Auth::user()->can('trash_access', new Section())) {
            return $this->error('Вы не можете просматривать корзину');
        }

        if (!$id) {
            return $this->error('Неверный ID');
        }

        $section = Section::query()->find($id);

        if (!$section) {
            return $this->error('Раздел не найден');
        }

        $site = $this->getSite(env('DOMAIN'));

        $sectionChildren = $section->children()->withTrashed()->whereNotNull('deleted_at');

        $sectionField = $request->get('section_field', 'deleted_at');
        $sectionOrder = $request->get('section_order', 'asc');
        $sectionTerm = $request->get('section_term', null);

        $pageArticles = $request->get('article_page', 1);
        $pageSections = $request->get('section_page', 1);

        $articleField = $request->get('article_field', 'deleted_at');
        $articleOrder = $request->get('article_order', 'asc');
        $articleTerm = $request->get('article_term', null);

        $articleField = Article::$sortable[$articleField];
        
        $sectionChildren->orderBy($sectionField, $sectionOrder);

        if ($sectionTerm) {
            $sectionChildren->where('title', 'like', "%$sectionTerm%");
        }

        $allSections = $sectionChildren->paginate(10, ['*'], 'section_page');

        $sectionsFilter = [
            'section_page' => $pageSections,
            'section_field' => $sectionField,
            'section_order' => $sectionOrder,
            'section_term' => $sectionTerm,
            'token' => Auth::user()->auth_token,
            'type' => 'section',
        ];

        $allSections->appends($sectionsFilter);

        collect($allSections->items())->map(function ($section) {
            return $section->makeHidden(['content', 'site', 'react_data', 'last_comment_author']);
        });

        $deletedArticles = $section->articles()->withTrashed()->whereNotNull('deleted_at');

        $deletedArticles->orderBy($articleField, $articleOrder);

        if ($articleTerm) {
            $deletedArticles->where('title', 'like', "%$articleTerm%");
        }

        $allArticles = $deletedArticles->paginate(10, ['*'], 'article_page');

        $articlesFilter = [
            'article_page' => $pageArticles,
            'article_field' => $articleField,
            'article_order' => $articleOrder,
            'article_term' => $articleTerm,
            'token' => Auth::user()->auth_token,
            'type' => 'article',
        ];

        $allArticles->appends($articlesFilter);

        collect($allArticles->items())->map(function ($article) {
            return $article->makeHidden(['content', 'site', 'react_data', 'last_comment_author']);
        });

        $data['sections'] = $allSections;
        $data['articles'] = $allArticles;

        $rootSection = Section::roots()->bySite($site->id)->get()->first();

        $breadcrumbs = [
            ['Главная' => route('home')],
            [$rootSection->title => route('section.index')]
        ];

        if ($section->isChild()) {
            $children = $section->getAncestorsAndSelfWithoutRoot();

            if (count($children) > 0) {
                foreach ($children as $item) {
                    $breadcrumbs[] = [$item->title => route_to_section($item)];
                }
            }
        }

        $breadcrumbs[] = ['Корзина' => ''];

        $sectionsSortOptions = Section::$sortOptions;
        $articlesSortOptions = Article::$sortOptions;

        $sectionsSortOptions['deleted_at'] = 'По дате удаления';
        $articlesSortOptions['deleted_at'] = 'По дате удаления';

        $data = [
            'section' => collect($section)->only(['id']),
            'breadcrumbs' => $breadcrumbs,
            'sections' => $allSections,
            'articles' => $allArticles,
            'sectionsSortOptions' => $sectionsSortOptions,
            'articlesSortOptions' => $articlesSortOptions,
            'articlesFilter' => $articlesFilter,
            'sectionsFilter' => $sectionsFilter
        ];

        return $this->success($data);
    }

}