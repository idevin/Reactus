<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\BlogSection;
use App\Models\Field;
use App\Models\FieldUserGroup;
use App\Models\FieldUserValue;
use App\Models\Section;
use App\Traits\HasRoles;
use App\Traits\Meta;
use App\Traits\Order;
use App\Traits\Response;
use App\Traits\Site;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    use Site;
    use HasRoles;
    use Meta;
    use Response;
    use Order;

    public array $breadcrumbs = [];

    public function __construct()
    {
        $this->breadcrumbs[] = ['Главная', 'home'];
        self::meta();
    }

    /**
     * @param $sectionModel
     * @param $site
     * @return Section|BlogSection
     */
    public function getRootSection($sectionModel, $site): Section|BlogSection
    {
        return $sectionModel::roots()->bySite($site->id)->get()->first();
    }

    public function getSiteByModel($siteModel)
    {
        return $this->getSite(env('DOMAIN'), $siteModel);
    }

    public function updateSiteSettings($site)
    {
        $sections = Section::bySite($site->id)->get();

        if (count($sections) > 0) {
            $sections->map(function ($section) use ($site) {
                if ($section->setting) {
                    $section->setting->update([
                        'show_rating' => $site->show_section_rating,
                        'show_article_author' => $site->show_article_author,
                        'hide_section_tags' => $site->hide_section_tags
                    ]);
                }
            });
        }

        $articles = Article::bySite($site->id)->get();

        if (count($articles) > 0) {
            $articles->map(function ($article) use ($site) {
                if ($article) {
                    $article->update([
                        'hide_author' => $site->hide_article_author_inside,
                        'show_article_rating' => $site->show_article_rating
                    ]);
                }
            });
        }
    }

    protected function getProfileFields($user, $onHomepage = false)
    {
        $fields = Field::whereFieldGroupId(config('netgamer.user_field_group'))
            ->whereNull('site_id')->get()
            ->makeHidden(['created_at', 'updated_at', 'deleted_at', 'site_id']);

        $fieldUserGroup = FieldUserGroup::whereFieldGroupId(config('netgamer.user_field_group'))
            ->whereUserId($user->id);

        if ($onHomepage == true) {
            $fieldUserGroup = $fieldUserGroup->whereOnHomepage(1);
        }

        $fieldUserGroup = $fieldUserGroup->first();

        $fieldUserValues = null;

        if ($fieldUserGroup) {
            $fieldUserValues = FieldUserValue::whereFieldUserGroupId($fieldUserGroup->id)
                ->with(['field'])->get();

        }

        foreach ($fields as $field) {
            $field->getUserValues($fieldUserValues);
        }

        return $fields;
    }

    protected function getProfileFieldsV2($user, $fieldGroup)
    {
        $fields = Field::whereFieldGroupId($fieldGroup->id)->get()
            ->makeHidden(['created_at', 'updated_at', 'deleted_at', 'site_id']);

        $fieldUserGroup = FieldUserGroup::whereFieldGroupId($fieldGroup->id)
            ->whereUserId($user->id)->first();

        $fieldUserValues = null;

        if ($fieldUserGroup) {
            $fieldUserValues = FieldUserValue::whereFieldUserGroupId($fieldUserGroup->id)
                ->with(['field'])->get();
            $fieldGroup->visibility = $fieldUserGroup->visibility;
        } else {
            $fieldGroup->visibility = FieldUserValue::VISIBILITY_ME;
        }

        foreach ($fields as $index => $field) {
            $fields[$index] = $field->getUserValues($fieldUserValues);
        }

        return $fields;
    }

    protected function getTags($tags)
    {
        $metaTags = null;

        if (count($tags) > 0 && is_object($tags)) {

            $metaTags = $tags->map(function ($tag) {

                return !empty($tag->slug) ? $tag->name : null;
            })->filter()->toArray();

            $metaTags = implode(',', $metaTags);
        } else {
            if (is_string($tags)) {
                if (strstr($tags, ',')) {
                    $metaTags = $tags;
                } else {
                    $metaTags = $tags;
                }
            }
        }

        return $metaTags;
    }
}
