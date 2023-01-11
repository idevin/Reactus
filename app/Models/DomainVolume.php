<?php

namespace App\Models;


use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;
use Webpatser\Uuid\Uuid;

/**
 * Class DomainVolume
 *
 * @package App\Models
 * @property int $id
 * @property string $uuid
 * @property int $size
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\Models\BlogSite|null $blogSite
 * @property-read \App\Models\Domain|null $domain
 * @method static Builder|DomainVolume newModelQuery()
 * @method static Builder|DomainVolume newQuery()
 * @method static Builder|DomainVolume query()
 * @method static Builder|DomainVolume whereCreatedAt($value)
 * @method static Builder|DomainVolume whereId($value)
 * @method static Builder|DomainVolume whereSize($value)
 * @method static Builder|DomainVolume whereUpdatedAt($value)
 * @method static Builder|DomainVolume whereUuid($value)
 * @mixin \Eloquent
 */
class DomainVolume extends Model
{
    protected $table = 'domain_volume';

    protected $fillable = ['id', 'uuid', 'size'];

    public $timestamps = true;

    public function domain(): HasOne
    {
        return $this->hasOne(Domain::class);
    }

    public function blogSite(): HasOne
    {
        return $this->hasOne(BlogSite::class);
    }

    public function getName(): string
    {
        return "domain-data-" . $this->uuid;
    }

    public function getSize(): string
    {
        return (string)$this->size . "G";
    }

    /**
     * @param null $uuid
     * @param float $size
     * @return DomainVolume
     * @throws Exception
     */
    public static function createPvc($uuid = null, float $size = 0.1): DomainVolume
    {
        if (!$uuid) {
            $uuid = Uuid::generate(5, microtime(true), Uuid::NS_OID)->string;
        }

        return self::query()->create([
            'uuid' => $uuid,
            'size' => $size
        ]);
    }

    /**
     * @param $domainVolumeId
     * @return bool
     * @throws Exception
     */
    public static function deletePvc($domainVolumeId): bool
    {
        $pvc = self::query()->find($domainVolumeId);

        if ($pvc) {
            $pvc->delete();
            return true;
        } else {
            return false;
        }
    }
}
