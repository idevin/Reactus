<?php


namespace App\Traits;


use App\Models\Menu;
use App\Models\Section;
use App\Models\SectionSetting;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

trait SiteMenu
{
    public static function getParentId($request): array
    {
        $data = $request->all();
        $result = self::getParent($data);

        if (!is_int($result)) {
            return Response::response()->error($result);
        } else {
            $parentId = $result;
        }

        return [
            'title' => Utils::cleanChars($data['title']),
            'sort_order' => (int)$data['sort_order'],
            'url' => $data['url'],
            'image' => $data['image'] ?? null,
            'parent_id' => $parentId,
            'site_id' => get_site()->id
        ];
    }

    public static function getParent($data)
    {

        $validator = static::createMainMenuValidator($data);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $parentId = null;

        if (isset($data['parent_id'])) {
            $parent = Menu::query()->find((int)$data['parent_id']);
            if (!$parent) {
                return $validator->errors()->add('parent', 'Не найден родитель');
            }
            $parentId = $parent->id;
        }

        return $parentId;
    }

    /**
     * @param $data
     * @param array $except
     * @param array $customErrors
     * @param array $customMessages
     */
    public static function createMainMenuValidator($data, array $except = [],
                                                   array $customErrors = [], array $customMessages = [])
    {
        $default = [
            'title' => 'required',
            'sort_order' => 'required|numeric',
            'url' => 'required|url'
        ];

        $messages = [
            'title.required' => 'Название пустое',
            'url.required' => 'Поле Url пустое',
            'sort_order.required' => 'Не задан порядок сортировки',
            'sort_order.numeric' => 'Неверный порядок сортировки',
            'url.url' => 'Неправильный формат URL'
        ];

        return Utils::makeValidator($data, $messages, $customMessages, $default, $customErrors, $except);
    }

    /**
     * @param array $url
     * @param $siteId
     * @return Menu[]|Builder[]|Collection
     */
    public static function reindexUrls(array $url, $siteId)
    {
        $urls = Menu::query()->orderBy('sort_order')->bySite($siteId);

        if ($url['parent_id']) {
            $urls = $urls->whereParentId($url['parent_id']);
        }

        $urls = $urls->get();

        return Utils::updateSortOrder($urls, start: 1);
    }

    public function item($id): Model|Collection|Builder|array|null
    {
        return Menu::with('site')->findOrFail($id);
    }

    private function getChildren($site, $rootChildren = null, $hashedImg = null): array
    {
        $dataArray = [];
        if ($rootChildren) {
            $sectionSetting = SectionSetting::whereSectionId($rootChildren->id)->first();

            if ($sectionSetting) {
                $sortOptions = $sectionSetting;
            } else {
                $sortOptions = $site;
            }

            $field = $sortOptions->filter_sections_sort;
            $order = $sortOptions->filter_sections_sort_direction;
            $limit = $sortOptions->sections_limit;

            $data = $rootChildren->descendantsWithSort($field, $order)
                ->depth($rootChildren->depth + 1)
                ->whereIsSecret(0)
                ->orderBy(Section::$sortable[$field], $order)->limit($limit)
                ->get();

            if (!empty($data)) {
                foreach ($data as $section) {

                    self::populateMenuArray($dataArray, $section, $hashedImg);

                    $children = [];
                    if (!empty($section->children)) {

                        foreach ($section->children as $child) {

                            self::populateMenuArray($children, $child, $hashedImg);

                            $children[$child->id]['children'] = $this->getChildren($site, $child);
                        }
                    }

                    $dataArray[$section->id]['children'] = $children;
                }
            }
        }

        return $dataArray;
    }

    public function populateMenuArray(&$array, $section, $hashedImg)
    {
        $imageUrl = $this->getImage($section);
        $imageUrl = $hashedImg ? ($imageUrl . '?' . sha1($imageUrl)) : $imageUrl;

        $array[$section->id] = [
            'link' => parse_url(route_to_section($section))['path'],
            'text' => $section->title,
            'id' => $section->id,
            'img' => $imageUrl
        ];
    }

    public function getImage($section)
    {
        if (!empty($section->thumbs)) {
            return $section->thumbs['thumb70x70'];
        } else {
            return $section->imageUrl('70x70', 'section');
        }
    }
}