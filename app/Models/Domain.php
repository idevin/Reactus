<?php

namespace App\Models;

use App;
use Baum\Extensions\Eloquent\Collection;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * Class Domain
 *
 * @package App\Models
 * @author Ilya Beltyukov, 968597@gmail.com
 * @property int $id
 * @property bool $active
 * @property int $domain_type
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $parent_id
 * @property int $is_default
 * @property int $environment 0 - DEV, 1 - ENV
 * @property int|null $user_id
 * @property string|null $info
 * @property int|null $domain_thematic_id
 * @property int|null $language_id
 * @property int $hide_from_registration
 * @property-read DomainThematic|null $domainThematic
 * @property-read \Illuminate\Database\Eloquent\Collection|Feedback[] $feedback
 * @property-read mixed $domain_id
 * @property-read Language|null $language
 * @property-read \Illuminate\Database\Eloquent\Collection|DomainMirror[] $mirror
 * @property-read Site $site
 * @property-read Collection|Site[] $sites
 * @property-read User|null $user
 * @method static Builder|Domain active()
 * @method static Builder|Domain languages()
 * @method static Builder|Domain newModelQuery()
 * @method static Builder|Domain newQuery()
 * @method static Builder|Domain own()
 * @method static Builder|Domain personal()
 * @method static Builder|Domain byLanguage()
 * @method static Builder|Domain query()
 * @method static Builder|Domain roots()
 * @method static Builder|Domain system()
 * @method static Builder|Domain thematic()
 * @method static Builder|Domain whereActive($value)
 * @method static Builder|Domain whereCreatedAt($value)
 * @method static Builder|Domain whereDomainThematicId($value)
 * @method static Builder|Domain whereDomainType($value)
 * @method static Builder|Domain whereEnvironment($value)
 * @method static Builder|Domain whereHideFromRegistration($value)
 * @method static Builder|Domain whereId($value)
 * @method static Builder|Domain whereInfo($value)
 * @method static Builder|Domain whereIsDefault($value)
 * @method static Builder|Domain whereLanguageId($value)
 * @method static Builder|Domain whereName($value)
 * @method static Builder|Domain whereParentId($value)
 * @method static Builder|Domain whereUpdatedAt($value)
 * @method static Builder|Domain whereUserId($value)
 * @mixin Eloquent
 * @property int $ssl
 * @method static Builder|Domain whereSsl($value)
 * @property-read int|null $feedback_count
 * @property-read int|null $mirror_count
 * @property-read int|null $sites_count
 * @property int|null $is_customer_domain
 * @property int|null $domain_volume_id
 * @property-read \App\Models\DomainVolume|null $domainVolume
 * @property-read Domain|null $parent
 * @method static Builder|Domain whereDomainVolumeId($value)
 * @method static Builder|Domain whereIsCustomerDomain($value)
 * @method static firstOrCreate(array $array, array $array2)
 */
class Domain extends Model
{
    const DOMAIN_TYPE_THEMATIC = 0;
    const DOMAIN_TYPE_PERSONAL = 1;
    const DOMAIN_TYPE_SYSTEM = 2;
    const DOMAIN_TYPE_LANGUAGE = 3;

    const PRODUCTION = 1;
    const DEVELOPMENT = 0;

    public $timestamps = true;

    protected $table = 'domain';

    protected $fillable = [
        'domain_type', 'name', 'is_default', 'environment', 'parent_id', 'user_id', 'info',
        'language_id', 'domain_thematic_id', 'hide_from_registration', 'active', 'ssl',
        'domain_volume_id', 'is_customer_domain'
    ];

    protected $appends = [
        'domain_id'
    ];

    public static function export($domainFrom, $domainTo)
    {
        return null;
    }

    public static function getTree(): array|\Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
    {
        return self::query()->thematic()->where('name', '!=', config('netgamer.local_content_domain'))
            ->whereUserId(null)->orderBy('name')->get(['id', 'name'])->pluck('name', 'id');
    }

    public function sites(): HasMany
    {
        return $this->hasMany(Site::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isPersonal(): bool
    {
        return $this->domain_type == self::DOMAIN_TYPE_PERSONAL;
    }

    public function scopeThematic($query)
    {
        return $query->where('domain_type', static::DOMAIN_TYPE_THEMATIC);
    }

    public function scopeLanguages($query)
    {
        return $query->where('domain_type', static::DOMAIN_TYPE_LANGUAGE)
            ->where('parent_id', $this->id);
    }

    public function scopeByLanguage($query)
    {
        $lang = Language::query()->whereAlias(App::getLocale())->first();
        if ($lang) {
            $query->whereLanguageId($lang->id);
        }

        return $query;
    }

    public function scopeSystem($query)
    {
        return $query->where('domain_type', static::DOMAIN_TYPE_SYSTEM);
    }

    public function scopeOwn($query)
    {
        return $query->whereNull('user_id');
    }

    public function scopeRoots($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopePersonal($query)
    {
        return $query->whereDomainType(static::DOMAIN_TYPE_PERSONAL);
    }

    public function scopeActive($query)
    {
        return $query->whereActive(1);
    }

    public function feedback(): HasMany
    {
        return $this->hasMany(Feedback::class);
    }

    public function site(): HasOne
    {
        return $this->hasOne(Site::class);
    }

    public function domainVolume(): BelongsTo
    {
        return $this->belongsTo(DomainVolume::class);
    }

    public function domainThematic(): BelongsTo
    {
        return $this->belongsTo(DomainThematic::class);
    }

    public function hasUsers(): bool
    {
        $foundPersonal = User::where('domain', 'like', '%' . $this->name . '%')->get(['id'])->first();

        if ($foundPersonal) {
            return true;
        }
        return false;
    }

    public function getDomainIdAttribute(): int
    {
        return $this->id;
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    public function mirror(): HasMany
    {
        return $this->hasMany(DomainMirror::class);
    }
}