<?php

namespace App\Traits\Modules;

use App\Models\FieldGroup;
use App\Models\Modules\ModuleArticle;
use App\Models\Modules\ModuleCatalog;
use App\Models\Modules\ModuleComment;
use App\Models\Modules\ModuleCompetitiveAdvantages;
use App\Models\Modules\ModuleCompetitiveAdvantagesItems;
use App\Models\Modules\ModuleContacts;
use App\Models\Modules\ModuleFeedback;
use App\Models\Modules\ModuleInformation;
use App\Models\Modules\ModuleLogo;
use App\Models\Modules\ModuleMenu;
use App\Models\Modules\ModuleMenuAdvanced;
use App\Models\Modules\ModuleMenuAdvancedUrl;
use App\Models\Modules\ModuleMenuUrl;
use App\Models\Modules\ModuleSection;
use App\Models\Modules\ModuleSlide;
use App\Models\Modules\ModuleSlider;
use App\Models\Modules\ModuleSlogan;
use App\Models\Modules\ModuleSocials;
use App\Models\Modules\ModuleText;
use App\Models\NeoUserCatalog;
use App\Traits\MenuAdvanced;
use App\Traits\Response;
use App\Traits\Site as SiteTrait;
use App\Traits\Slide;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;


/**
 * Trait Creators
 * @package App\Traits\Modules
 * @modules Article, CompetitiveAdvantages, Contacts, Information, Menu, Section, Socials, Text,
 * Catalog, Comment, Feedback
 */
trait Creators
{
    use Slide;
    use MenuAdvanced;

    public static function createModuleText($data): Model|Builder|ModuleText
    {
        $site = get_site();

        return ModuleText::query()->create([
            'site_id' => $site->id,
            'content' => $data['settings']['content'],
            'name' => $data['settings']['name'] ?? null
        ]);
    }

    public static function createModuleLogo($data): Model|Builder|ModuleLogo
    {
        $site = get_site();

        reloadSite($site);
        forget(SiteTrait::getSiteCacheKey());

        $data = [
            'name' => $data['settings']['name'] ?? null,
            'site_id' => $site->id,
            'content_options' => $data['content_options'] ?? null,
            'title' => $data['settings']['logo'][0]['title'] ?? null,
            'description' => $data['settings']['logo'][0]['description'] ?? null,
            'thumbs' => $data['settings']['logo'][0]['thumbs'],
            'storage_file_id' => $data['settings']['logo'][0]['id']
        ];

        return ModuleLogo::query()->firstOrCreate($data);
    }

    public static function updateModuleLogo($data, $module)
    {
        $site = get_site();
        $moduleLogo = app($module->module_class)::query()->find($module->module_id);

        if (!$moduleLogo) {
            return Response::response()->error('Блок лого не найден');
        }

        reloadSite($site);
        forget(SiteTrait::getSiteCacheKey());

        $moduleLogo->update([
            'name' => $data['settings']['name'] ?? null,
            'content_options' => $data['content_options'] ?? null,
            'title' => $data['settings']['logo'][0]['title'] ?? null,
            'description' => $data['settings']['logo'][0]['description'] ?? null,
            'thumbs' => $data['settings']['logo'][0]['thumbs'],
            'storage_file_id' => $data['settings']['logo'][0]['id']
        ]);

        $moduleLogo->refresh();

        return $moduleLogo;
    }

    public static function createModuleSlogan($data): Model|Builder|ModuleSlogan
    {
        $site = get_site();

        if (!empty($data['slogan'])) {
            $site->update(['slogan' => $data['slogan']]);
        } else {
            $site->update(['slogan' => null]);
        }

        reloadsite($site);
        forget(SiteTrait::getSiteCacheKey());

        return ModuleSlogan::query()->create([
            'name' => $data['settings']['name'] ?? null,
            'site_id' => $site->id
        ]);
    }

    public static function updateModuleSlogan($data, $module)
    {
        $site = get_site();
        $moduleLogo = app($module->module_class)::query()->find($module->module_id);

        if (!$moduleLogo) {
            return Response::response()->error('Блок слогана не найден');
        }

        if (!empty($data['slogan'])) {
            $site->update(['slogan' => $data['slogan']]);
        } else {
            $site->update(['slogan' => null]);
        }


        reloadSite($site);

        forget(SiteTrait::getSiteCacheKey());

        $moduleLogo->update([
            'name' => $data['settings']['name'] ?? null
        ]);

        $moduleLogo->refresh();

        return $moduleLogo;
    }

    public static function updateModuleText($data, $module)
    {
        $moduleText = app($module->module_class)::query()->find($module->module_id);

        if (!$moduleText) {
            return Response::response()->error('Блок текста не найден');
        }

        $moduleText->update([
            'content' => $data['settings']['content'],
            'name' => $data['settings']['name'] ?? null
        ]);

        $moduleText->refresh();

        return $moduleText;
    }

    public static function createModuleMenu($data): Model|Builder|ModuleMenu
    {
        $itemsToUpdate = [];
        $site = get_site();

        $module = ModuleMenu::query()->create([
            'site_id' => $site->id,
            'name' => $data['settings']['urls'][0]['name'],
            'url' => $data['settings']['urls'][0]['url'],
            'sort_order' => $data['settings']['urls'][0]['sort_order']
        ]);

        foreach ($data['settings']['urls'] as $item) {
            if ($item['id'] < 0) {
                $item['module_menu_id'] = $module->id;

                $newItem = ModuleMenuUrl::query()->create($item);
                $item['id'] = $newItem->id;

            } else {
                $moduleMenu = ModuleMenuUrl::query()->find($item['id']);

                if ($moduleMenu) {
                    if ($moduleMenu->id === (int)$item['id']) {
                        $moduleMenu->update($item);
                    }
                }
            }
            $itemsToUpdate[] = $item['id'];
        }


        $items = $module->urls;
        $arItemsIDList = [];

        foreach ($items as $url) {
            $arItemsIDList[] = $url->id;
        }

        $itemsToDelete = array_values(array_diff($arItemsIDList, $itemsToUpdate));

        collect($itemsToDelete)->map(function ($itemId) {
            $moduleMenu = ModuleMenuUrl::query()->find($itemId);
            if ($moduleMenu) {
                $moduleMenu->delete();
            }
        });

        $module->refresh();

        return $module;
    }

    public static function createModuleMenuAdvanced($data): Model|ModuleMenuAdvanced|Builder
    {
        $itemsToUpdate = [];
        $site = get_site();

        $module = ModuleMenuAdvanced::query()->create([
            'name' => $data['settings']['name'] ?? null,
            'site_id' => $site->id,
            'sort_order' => $data['settings']['sort_order'],
            'content_options' => $data['content_options'] ?? null
        ]);

        foreach ($data['settings']['urls'] as $item) {
            if ($item['id'] < 0) {
                $item['module_menu_advanced_id'] = $module->id;

                $newItem = ModuleMenuAdvancedUrl::create($item);
                $item['id'] = $newItem->id;

            } else {
                $moduleMenu = ModuleMenuAdvancedUrl::query()->find($item['id']);

                if ($moduleMenu) {
                    if ($moduleMenu->id === (int)$item['id']) {
                        $moduleMenu->update($item);
                    }
                }
            }
            $itemsToUpdate[] = $item['id'];
        }

        $items = $module->urls;
        $itemIds = [];

        foreach ($items as $url) {
            $itemIds[] = $url->id;
        }

        $itemsToDelete = array_values(array_diff($itemIds, $itemsToUpdate));

        collect($itemsToDelete)->map(function ($itemId) {
            $moduleMenu = ModuleMenuAdvancedUrl::query()->find($itemId);
            if ($moduleMenu) {
                $moduleMenu->delete();
            }
        });

        if (count($module->urls) > 0) {
            self::reindexUrls($module->urls->first()->toArray());
        }

        $module->refresh();

        return $module;
    }

    public static function updateModuleMenu($data, $module)
    {

        $moduleMenu = app($module->module_class)::query()->with('urls')->find($module->module_id);

        if (!$moduleMenu) {
            return Response::response()->error('Блок меню не найден');
        }

        $itemsToUpdate = [];

        foreach ($data['settings']['urls'] as $item) {
            $item['module_menu_id'] = $module->id;

            if ($item['id'] < 0) {
                $newItem = ModuleMenuUrl::query()->create($item);
                $item['id'] = $newItem->id;

            } else {
                $moduleMenuUrl = ModuleMenuUrl::query()->find($item['id']);

                if ($moduleMenuUrl) {
                    if ($moduleMenu->id === (int)$item['id']) {
                        $moduleMenuUrl->update($item);
                    }
                }
            }
            $itemsToUpdate[] = $item['id'];
        }

        $items = $moduleMenu->urls;
        $arItemsIDList = [];

        foreach ($items as $url) {
            $arItemsIDList[] = $url->id;
        }

        $itemsToDelete = array_values(array_diff($arItemsIDList, $itemsToUpdate));

        collect($itemsToDelete)->map(function ($itemId) {
            $moduleMenuUrl = ModuleMenuUrl::query()->find($itemId);
            if ($moduleMenuUrl) {
                $moduleMenuUrl->delete();
            }
        });

        $moduleMenu->refresh();

        return $moduleMenu;
    }

    public static function createModuleCompetitiveAdvantages($data): Model|Builder|ModuleCompetitiveAdvantages
    {
        $site = get_site();

        $moduleData = [
            'site_id' => $site->id,
            'name' => $data['settings']['name'] ?? null,
            'template_id' => $data['template_id'] ?? null,
            'content_options' => $data['content_options'] ?? null,
            'full_screen' => $data['full_screen'] ?? false
        ];

        $moduleAdvantages = ModuleCompetitiveAdvantages::query()->create($moduleData);

        if (isset($data['settings']['items']) && !empty($data['settings']['items'])) {

            ModuleCompetitiveAdvantagesItems::remove($data);

            foreach ($data['settings']['items'] as $item) {

                $contentOptions = null;

                if (isset($item['content_options']) && !empty($item['content_options'])) {
                    $contentOptions = $item['content_options'];
                }

                $itemData = [
                    "content_options" => $contentOptions,
                    "name" => $item['name'] ?? null,
                    "description" => $item['description'] ?? null,
                    "advantages_id" => $moduleAdvantages->id,
                    "sort_order" => isset($item['sort_order']) ? (int)$item['sort_order'] : 1
                ];

                if ((int)$item['id'] <= 0) {
                    ModuleCompetitiveAdvantagesItems::create($itemData);
                } else {
                    $compItem = ModuleCompetitiveAdvantagesItems::query()->find($item['id']);
                    $compItem?->update($itemData);
                }
            }
        }
        return $moduleAdvantages;
    }

    public static function updateModuleCompetitiveAdvantages($data, $module)
    {
        $moduleAdvantages = app($module->module_class)::query()->find($module->module_id);

        if (!$moduleAdvantages) {
            return Response::response()->error('Блок преймуществ не найден');
        }

        $site = get_site();

        $moduleData = [
            'site_id' => $site->id,
            'name' => $data['settings']['name'] ?? null,
            'module_id' => $data['id'] ?? null,
            'template_id' => $data['template_id'] ?? null,
            'content_options' => $data['content_options'] ?? null,
            'full_screen' => $data['full_screen'] ?? false
        ];

        $moduleAdvantages->update($moduleData);

        if (isset($data['settings']['items']) && !empty($data['settings']['items'])) {

            ModuleCompetitiveAdvantagesItems::remove($data);

            foreach ($data['settings']['items'] as $item) {
                $itemData = [
                    "content_options" => $item['content_options'] ?? null,
                    "name" => $item['name'] ?? null,
                    "description" => $item['description'] ?? null,
                    "advantages_id" => $moduleAdvantages->id,
                    "sort_order" => isset($item['sort_order']) ? (int)$item['sort_order'] : 1
                ];

                if ((int)$item['id'] <= 0) {
                    ModuleCompetitiveAdvantagesItems::create($itemData);
                } else {
                    $compItem = ModuleCompetitiveAdvantagesItems::query()->find($item['id']);
                    if ($compItem) {
                        $compItem->update($itemData);
                    }
                }
            }
        }

        $moduleAdvantages->refresh();

        return $moduleAdvantages;
    }

    public static function createModuleInformation($data): Model|ModuleInformation|Builder
    {
        $site = get_site();

        return ModuleInformation::query()->create([
            'site_id' => $site->id,
            'content' => $data['settings']['content'] ?? null,
            'name' => $data['settings']['name'] ?? null,
            'react_data' => $data['settings']['react_data'] ?? null
        ]);
    }

    public static function updateModuleInformation($data, $module)
    {
        $moduleInformation = app($module->module_class)::query()->find($module->module_id);

        if (!$moduleInformation) {
            return Response::response()->error('Модуль не найден');
        }

        $moduleInformation->update([
            'content' => $data['settings']['content'] ?? null,
            'name' => $data['settings']['name'] ?? null,
            'react_data' => $data['settings']['react_data'] ?? null
        ]);

        $moduleInformation->refresh();

        return $moduleInformation;
    }

    public static function createModuleArticle($data): Model|ModuleArticle|Builder
    {
        $site = get_site();

        $sortBy = ($data['settings'] && $data['settings']['sort_by']) ? $data['settings']['sort_by'] : null;

        $sortOrder = ($data['settings'] && $data['settings']['sort_order']) ?
            $data['settings']['sort_order'] : null;

        $view = ($data['settings'] && $data['settings']['view']) ? $data['settings']['view'] : null;

        $sectionId = ($data['settings'] && $data['settings']['section_id']) ?
            $data['settings']['section_id'] : null;

        $blockView = ($data['settings'] && $data['settings']['block_view']) ?
            $data['settings']['block_view'] : 0;

        $name = ($data['settings'] && $data['settings']['name']) ? $data['settings']['name'] : null;

        $articleData = [
            'sort_by' => $sortBy,
            'sort_order' => $sortOrder,
            'view' => $view,
            'site_id' => $site->id,
            'name' => $name,
            'section_id' => $sectionId,
            'block_view' => $blockView
        ];

        return ModuleArticle::query()->create($articleData);
    }

    public static function updateModuleArticle($data, $module)
    {
        $site = get_site();

        $moduleArticle = app($module->module_class)::query()->find($module->module_id);

        if (!$moduleArticle) {
            return Response::response()->error('Блок статьи не найден');
        }

        $sortBy = ($data['settings'] && $data['settings']['sort_by']) ? $data['settings']['sort_by'] : null;

        $sortOrder = ($data['settings'] && $data['settings']['sort_order']) ?
            $data['settings']['sort_order'] : null;

        $view = ($data['settings'] && $data['settings']['view']) ? $data['settings']['view'] : null;

        $sectionId = ($data['settings'] && $data['settings']['section_id']) ?
            $data['settings']['section_id'] : null;

        $blockView = ($data['settings'] && $data['settings']['block_view']) ?
            $data['settings']['block_view'] : 0;

        $name = ($data['settings'] && $data['settings']['name']) ? $data['settings']['name'] : null;

        $articleData = [
            'sort_by' => $sortBy,
            'sort_order' => $sortOrder,
            'view' => $view,
            'site_id' => $site->id,
            'name' => $name,
            'section_id' => $sectionId,
            'block_view' => $blockView
        ];

        $moduleArticle->update($articleData);

        $moduleArticle->refresh();

        return $moduleArticle;
    }

    public static function createModuleSection($data): Model|Builder|ModuleSection
    {
        $site = get_site();

        $sectionData = [
            'sort_by' => $data['settings']['sort_by'] ?? null,
            'sort_order' => $data['settings']['sort_order'] ?? null,
            'view' => $data['settings']['view'] ?? null,
            'site_id' => $site->id,
            'name' => $data['settings']['name'] ?? null,
            'block_view' => $data['settings']['block_view'] ?? 0
        ];

        return ModuleSection::query()->create($sectionData);
    }

    public static function updateModuleSection($data, $module)
    {
        $site = get_site();

        $moduleSection = app($module->module_class)::query()->find($module->module_id);

        if (!$moduleSection) {
            return Response::response()->error('Модуль разделов не найден');
        }

        $sectionData = [
            'sort_by' => $data['settings']['sort_by'] ?? null,
            'sort_order' => $data['settings']['sort_order'] ?? null,
            'view' => $data['settings']['view'] ?? null,
            'site_id' => $site->id,
            'name' => $data['settings']['name'] ?? null,
            'block_view' => $data['settings']['block_view'] ?? 0
        ];

        $moduleSection->update($sectionData);

        $moduleSection->refresh();

        return $moduleSection;
    }

    public static function createModuleContacts($data): Model|ModuleContacts|Builder
    {
        $site = get_site();

        return ModuleContacts::query()->create([
            'site_id' => $site->id,
            'name' => $data['settings']['name'] ?? null,
            'template_id' => $data['settings']['template_id'] ?? null,
            'phone' => $data['settings']['phone'] ?? null,
            'address' => $data['settings']['address'] ?? null
        ]);
    }

    public static function updateModuleContacts($data, $module)
    {
        $site = get_site();

        $moduleContacts = app($module->module_class)::query()->find($module->module_id);

        if (!$moduleContacts) {
            return Response::response()->error('Модуль контактов не найден');
        }

        $moduleContacts->update([
            'site_id' => $site->id,
            'name' => $data['settings']['name'] ?? null,
            'template_id' => $data['settings']['template_id'] ?? null,
            'phone' => $data['settings']['phone'] ?? null,
            'address' => $data['settings']['address'] ?? null
        ]);

        $moduleContacts->refresh();

        return $moduleContacts;
    }

    public static function createModuleSocials($data): Model|Builder|ModuleSocials
    {
        $site = get_site();

        $updateData = [
            'site_id' => $site->id,
            'facebook_url' => $data['settings']['facebook_url'] ?? null,
            'vk_url' => $data['settings']['vk_url'] ?? null,
            'twitter_url' => $data['settings']['twitter_url'] ?? null,
            'instagram_url' => $data['settings']['instagram_url'] ?? null,
            'ok_url' => $data['settings']['ok_url'] ?? null,
            'name' => $data['settings']['name'] ?? null
        ];

        $site->update($updateData);

        return ModuleSocials::query()->create($updateData);
    }

    public static function updateModuleSocials($data, $module)
    {
        $moduleSocials = app($module->module_class)::query()->find($module->module_id);

        if (!$moduleSocials) {
            return Response::response()->error('Модуль социальных сетей не найден');
        }

        $site = get_site();
        $updateData = [
            'facebook_url' => $data['settings']['facebook_url'] ?? null,
            'vk_url' => $data['settings']['vk_url'] ?? null,
            'twitter_url' => $data['settings']['twitter_url'] ?? null,
            'instagram_url' => $data['settings']['instagram_url'] ?? null,
            'ok_url' => $data['settings']['ok_url'] ?? null,
            'name' => $data['settings']['name'] ?? null
        ];

        $moduleSocials->update($updateData);
        $site->update($updateData);
        $moduleSocials->refresh();

        return $moduleSocials;
    }

    public static function createModuleCatalog($data): Model|Builder|ModuleCatalog
    {
        $site = get_site();

        $neoObject = NeoUserCatalog::query()->find((int)$data['settings']['object_id']);

        if (!$neoObject) {
            return Response::response()->error(__('errors.catalog.no_catalog',
                ['key' => 'object_id', 'value' => $data['settings']['object_id']]));
        }

        return ModuleCatalog::query()->create([
            'site_id' => $site->id,
            'name' => $data['settings']['name'] ?? null,
            'filter_settings' => $data['settings']['filter_settings'] ?? null,
            'object_id' => $data['settings']['object_id'] ?? null,
            'sort_by' => $data['settings']['sort_by'] ?? ModuleCatalog::DEFAULT_SORT_BY,
            'sort_order' => $data['settings']['sort_order'] ?? ModuleCatalog::DEFAULT_SORT_ORDER,
            'hide_filter' => $data['settings']['hide_filter'] ?? 0
        ]);
    }

    public static function updateModuleCatalog($data, $module)
    {
        $site = get_site();

        $moduleCatalog = app($module->module_class)::query()->find($module->module_id);

        $neoObject = NeoUserCatalog::query()->find((int)$data['settings']['object_id']);

        if (!$neoObject) {
            return Response::response()->error(__('errors.catalog.no_catalog',
                ['key' => 'object_id', 'value' => $data['settings']['object_id']]));
        }

        $moduleCatalog->update([
            'site_id' => $site->id,
            'name' => $data['settings']['name'] ?? null,
            'filter_settings' => $data['settings']['filter_settings'] ?? null,
            'object_id' => $data['settings']['object_id'] ?? null,
            'sort_by' => $data['settings']['sort_by'] ?? ModuleCatalog::DEFAULT_SORT_BY,
            'sort_order' => $data['settings']['sort_order'] ?? ModuleCatalog::DEFAULT_SORT_ORDER,
            'hide_filter' => $data['settings']['hide_filter'] ?? 0
        ]);

        $moduleCatalog->refresh();

        return $moduleCatalog;
    }

    public static function createModuleComment($data): Model|Builder|ModuleComment
    {
        $site = get_site();

        $commentData = [
            'sort_by' => $data['settings']['sort_by'] ?? null,
            'sort_order' => $data['settings']['sort_order'] ?? null,
            'view' => $data['settings']['view'] ?? null,
            'site_id' => $site->id,
            'name' => $data['settings']['name'] ?? null,
            'block_view' => $data['settings']['block_view'] ?? 0
        ];

        return ModuleComment::query()->create($commentData);
    }

    public static function updateModuleComment($data, $module)
    {
        $moduleComments = app($module->module_class)::query()->find($module->module_id);
        $site = get_site();

        if (!$moduleComments) {
            return Response::response()->error('Модуль комментариев не найден');
        }

        $commentData = [
            'sort_by' => $data['settings']['sort_by'] ?? null,
            'sort_order' => $data['settings']['sort_order'] ?? null,
            'view' => $data['settings']['view'] ?? null,
            'site_id' => $site->id,
            'name' => $data['settings']['name'] ?? null,
            'block_view' => $data['settings']['block_view'] ?? 0
        ];

        $moduleComments->update($commentData);
        $moduleComments->refresh();

        return $moduleComments;
    }

    public static function createModuleFeedback($data): Model|ModuleFeedback|Builder
    {
        $fieldGroupId = $data['settings']['field_group_id'] ?? null;
        $fieldGroup = FieldGroup::query()->find($fieldGroupId);

        if (!$fieldGroup) {
            return Response::response()->error('Группа полей не найдена');
        }

        $sortOrder = $data['settings']['sort_order'] ?? 1;
        $site = get_site();

        $feedbackData = [
            'sort_order' => $sortOrder,
            'site_id' => $site->id,
            'name' => $data['settings']['name'] ?? null,
            'field_group_id' => $fieldGroupId,
            'registration' => $data['settings']['registration'] ?? false,
            'modal' => $data['settings']['modal'] ?? false
        ];

        return ModuleFeedback::query()->create($feedbackData);
    }

    public static function updateModuleFeedback($data, $module)
    {
        $fieldGroupId = $data['settings']['field_group_id'] ?? null;
        $fieldGroup = FieldGroup::query()->find($fieldGroupId);

        if (!$fieldGroup) {
            return Response::response()->error('Группа полей не найдена');
        }

        $moduleFeedback = app($module->module_class)::query()->find($module->module_id);

        $sortOrder = $data['settings']['sort_order'] ?? 1;
        $site = get_site();

        $feedbackData = [
            'sort_order' => $sortOrder,
            'site_id' => $site->id,
            'name' => $data['settings']['name'] ?? null,
            'field_group_id' => $fieldGroupId,
            'registration' => $data['settings']['registration'] ?? false,
            'modal' => $data['settings']['modal'] ?? false
        ];

        $moduleFeedback->update($feedbackData);
        $moduleFeedback->refresh();

        return $moduleFeedback;
    }


    public static function createModuleSlider($data)
    {
        $sliderName = $data['settings']['name'] ?? null;

        $miniature = $data['settings']['miniature'] ?? null;

        $navigation = $data['settings']['navigation'] ?? null;

        if (isset($data['settings']['show_statistic'])) {
            $showStatistic = (int)$data['settings']['show_statistic'];
        } else {
            $showStatistic = 0;
        }

        $site = get_site();

        $moduleData = [
            'site_id' => $site->id,
            'name' => $sliderName,
            'view' => $data['settings']['view'],
            'miniature' => $miniature,
            'navigation' => $navigation,
            'block_type' => $data['settings']['block_type'],
            'show_statistic' => $showStatistic
        ];

        $moduleSlider = ModuleSlider::create($moduleData);

        foreach ($data['settings']['slides'] as $slide) {
            self::createSlide($slide, $moduleSlider);
        }

        $moduleSlider->refresh();

        return $moduleSlider;
    }

    public static function updateModuleSlider($data, $module)
    {
        $moduleSlider = app($module->module_class)::query()->find($module->module_id);

        $sliderName = $data['settings']['name'] ?? null;

        $miniature = $data['settings']['miniature'] ?? null;

        $navigation = $data['settings']['navigation'] ?? null;

        if (isset($data['settings']['show_statistic'])) {
            $showStatistic = (int)$data['settings']['show_statistic'];
        } else {
            $showStatistic = 0;
        }

        $site = get_site();

        $moduleData = [
            'site_id' => $site->id,
            'name' => $sliderName,
            'view' => $data['settings']['view'],
            'miniature' => $miniature,
            'navigation' => $navigation,
            'block_type' => $data['settings']['block_type'],
            'show_statistic' => $showStatistic
        ];

        $moduleSlider->update($moduleData);

        foreach ($data['settings']['slides'] as $index => $slide) {
            if (isset($slide['remove']) && isset($slide['id'])) {
                $moduleSlide = ModuleSlide::query()->find($slide['id']);

                if (!$moduleSlide) {
                    return Response::response()->error('Слайд не найден');
                }

                try {
                    $moduleSlide->delete();
                } catch (Exception $e) {
                    if (env('APP_DEBUG_VARS') == true) {
                        debugvars($e->getTraceAsString());
                    }
                }

                unset($data['settings']['slides'][$index]);
            }
        }

        foreach ($data['settings']['slides'] as $slide) {
            self::createSlide($slide, $moduleSlider);
        }

        $moduleSlider->refresh();

        return $moduleSlider;
    }
}