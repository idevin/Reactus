<?php

namespace App\Models;

use Cache;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\DomainMirror
 *
 * @property int $id
 * @property int $domain_id
 * @property int $domain_mirror_id
 * @property-read \App\Models\Domain $domain
 * @property-read \App\Models\Domain $domainMirror
 * @method static Builder|\App\Models\DomainMirror newModelQuery()
 * @method static Builder|\App\Models\DomainMirror newQuery()
 * @method static Builder|\App\Models\DomainMirror query()
 * @method static Builder|\App\Models\DomainMirror whereDomainId($value)
 * @method static Builder|\App\Models\DomainMirror whereDomainMirrorId($value)
 * @method static Builder|\App\Models\DomainMirror whereId($value)
 * @mixin Eloquent
 */
class DomainMirror extends Model
{
    public $timestamps = false;


    protected $table = 'domain_mirror';

    protected $fillable = ['domain_id', 'domain_mirror_id'];

    public static function getByDomainMirrorId($id)
    {
        $domainKey = 'domain_mirror.' . $id;

        $domain = Cache::get($domainKey);

        if (!$domain) {
            $domain = self::whereDomainMirrorId($id)->first();

            if ($domain) {
                remember($domainKey, function () use ($domain) {
                    return $domain;
                });

                if (env('APP_DEBUG_VARS') == true) {
                    debugvars('SET MIRROR CACHE');
                }
            }
        }

        return $domain;
    }

    public function domain()
    {
        return $this->belongsTo(Domain::class);
    }

    public function domainMirror()
    {
        return $this->belongsTo(Domain::class, 'domain_mirror_id');
    }
}