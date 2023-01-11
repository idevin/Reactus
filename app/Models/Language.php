<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Language
 *
 * @property int $id
 * @property string $alias
 * @property string $title
 * @property int $priority
 * @property-read Collection|Domain[] $domains
 * @property-read Collection|LanguageObject[] $languageObjects
 * @property-read Collection|User[] $users
 * @method static Builder|Language newModelQuery()
 * @method static Builder|Language newQuery()
 * @method static Builder|Language query()
 * @method static Builder|Language whereAlias($value)
 * @method static Builder|Language whereId($value)
 * @method static Builder|Language wherePriority($value)
 * @method static Builder|Language whereTitle($value)
 * @mixin Eloquent
 * @property-read int|null $domains_count
 * @property-read int|null $language_objects_count
 * @property-read int|null $users_count
 */
class Language extends Model
{
    public $timestamps = false;
    protected $table = 'language';
    protected $fillable = ['title', 'alias', 'priority'];

    public function domains(): HasMany
    {
        return $this->hasMany(Domain::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function languageObjects(): HasMany
    {
        return $this->hasMany(LanguageObject::class);
    }

    public static function default(): self
    {
        $site = get_site();

        if ($site->siteDomain->language) {
            $language = $site->siteDomain->language;
        } else {
            $language = self::query()->whereAlias(config('app.locale'))->first();
        }

        return $language;
    }
}
