<?php

namespace App\Traits;

use App\Models\Announcement;
use App\Models\Article;
use App\Models\BlogSection;
use App\Models\Domain as DomainModel;
use App\Models\NeoAnnouncement;
use DOMDocument;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Routing\RouteCompiler;
use Route;

trait Announceable
{
    use NeoObject;

    public static array $announceObject = [];

    public static function bootAnnounceable()
    {
        static::retrieved(function ($model) {
            $model->appends = array_merge($model->appends, ['announce', 'announce_object']);
        });
    }

    public static function setAnnounce(&$children)
    {
        if (count($children) > 0) {
            foreach ($children as &$child) {
                $child['announce'] = 1;
                Announceable::setAnnounce($child['children']);
            }
        }
    }

    public static function setAnnounceFromContent($content, $comment, $site)
    {
        $document = new DOMDocument('1.0');
        $document->loadHTML('<?xml encoding="utf-8" />' . $content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $urls = $document->getElementsByTagName('a');
        $objectId = $comment->id;
        $objectType = get_class($comment);

        if ($urls->length > 0) {
            foreach ($urls as $url) {
                $href = $url->getAttribute('href');
                $url = parse_url($href);

                $matchedRoute = null;
                $matchedMatch = null;
                $routes = Route::getRoutes()->getRoutes();

                foreach ($routes as $route) {
                    $route->compiled = (new RouteCompiler($route))->compile();

                    if (is_null($route->getCompiled())) {
                        continue;
                    }

                    preg_match($route->getCompiled()->getRegex(), rawurldecode($url['path']), $matches);
                    if (!empty($matches)) {
                        $matchedRoute = $route;

                        foreach ($matches as $i => $match) {
                            if (is_numeric($i)) {
                                unset($matches[$i]);
                            }
                            if ($match == $url['path']) {
                                unset($matches[$i]);
                            }
                        }

                        $matchedMatch = $matches;
                    }
                }

                $options = null;
                if ($matchedRoute) {
                    list($controller, $action) = explode('@', $matchedRoute->getActionName());
                    if ($controller && $action) {
                        $method = 'url' . last(preg_split('/\\\/', $controller));
                        $options = self::{$method . ucfirst($action)}($matchedMatch);
                    }
                }

                if ($options['announce_id'] && $options['announce_type']) {

                    $domain = DomainModel::query()->whereName($url['host'])->first();
                    if ($domain && $domain->site) {
                        if ($objectId && $objectType && $options['announce_id'] && $options['announce_type']) {
                            Announcement::firstOrCreate([
                                'object_id' => $objectId,
                                'object_type' => $objectType,
                                'announce_id' => $options['announce_id'],
                                'announce_type' => $options['announce_type'],
                                'title' => $options['title'],
                                'site_id' => $site->id
                            ]);
                        }
                    }
                }
            }
        } else {
            Announcement::whereObjectId($objectId)->whereObjectType($objectType)->delete();
        }
    }

    public static function urlArticleControllerShow($options = []): array
    {
        if (isset($options['id'])) {
            $article = Article::query()->published()->active()->find((int)$options['id']);
            if ($article) {
                return [
                    'title' => $article->title,
                    'announce_type' => get_class($article),
                    'announce_id' => $article->id
                ];
            }
        }
        return [];
    }

    public static function urlSectionControllerIndex(): array
    {
        $site = get_site();

        $sectionClass = self::getSectionClass($site);

        $root = $sectionClass::roots()->bySite($site->id)->first();
        if ($root) {
            return [
                'title' => $root->title,
                'announce_type' => $sectionClass,
                'announce_id' => $root->id
            ];
        }
        return [];
    }

    public static function getSectionClass($site): string
    {
        $sectionClass = \App\Models\Section::class;
        if ($site->siteDomain->domain_type == DomainModel::DOMAIN_TYPE_PERSONAL) {
            $sectionClass = BlogSection::class;
        }
        return $sectionClass;
    }

    public static function urlSectionControllerShow($options = []): array
    {
        $site = get_site();
        $sectionClass = self::getSectionClass($site);

        if (isset($options['id'])) {
            $section = $sectionClass::query()->find((int)$options['id']);
        } else {
            $section = $sectionClass::roots()->bySite($site->id)->first();
        }

        if (!$section) {
            return [];
        }

        return [
            'title' => $section->title,
            'announce_type' => $sectionClass,
            'announce_id' => $section->id
        ];
    }

    public static function urlObjectsControllerCard($options = []): array
    {

        $card = self::getCard($options);

        if (!$card) {
            return [];
        }

        return [
            'title' => $card->name,
            'announce_type' => get_class($card),
            'announce_id' => $card->id
        ];
    }

    public function scopeAnnounced($query, $id, $objectClass, $modelClass, $term = null)
    {
        $queryBuilder = $query;

        $modelClass::$announceObject = [
            $id, $objectClass
        ];

        $object = app($objectClass)->find($id);
        $announcements = $object->announcements()->whereAnnounceType($modelClass);

        if ($term) {
            $announcements = $announcements->where('title', 'like', '%' . $term . '%');
        }

        $announcements = $announcements->get();

        if (count($announcements) > 0) {
            $announceIds = collect($announcements->pluck('announce'))->pluck('id');

            $queryBuilder = $query->orWhereIn('id', function ($query) use ($object, $modelClass, $announceIds) {
                $query->select('id')->from((new $modelClass)->getTable())->whereIn('id', $announceIds);
            });
        }

        return $queryBuilder;
    }

    public function announces(): MorphMany
    {
        return $this->announcements();
    }

    public function announcements(): MorphMany
    {
        $parentClass = get_class($this);
        $class = Announcement::class;
        if (strstr($parentClass, 'Neo4j')) {
            $class = NeoAnnouncement::class;
        }
        return $this->morphMany($class, 'object')->with('announce');
    }

    public function getAnnounceAttribute(): int
    {
        $value = 0;

        if (!empty(static::$announceObject)) {
            $announce = self::getAnnouncement(get_class($this), $this->id);
            if ($announce) {
                $value = 1;
            }
        }

        return $value;
    }

    private static function getAnnouncement($class, $id): ?Announcement
    {
        $announce = null;
        if (static::$announceObject) {
            $announce = Announcement::query()->whereObjectId(static::$announceObject[0])
                ->whereObjectType(static::$announceObject[1])
                ->whereAnnounceType($class)
                ->whereAnnounceId($id)->first();
        }
        return $announce;
    }

    public function getAnnounceObjectAttribute(): ?Announcement
    {
        return self::getAnnouncement(get_class($this), $this->id);
    }

    public function setAnnounceObjectAttribute($announce)
    {
        $this->attributes['announce_object'] = $announce;
    }
}