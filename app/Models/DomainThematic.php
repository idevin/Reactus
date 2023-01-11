<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * App\Models\DomainThematic
 *
 * @property int $id
 * @property string $name
 * @property-read Collection|\App\Models\Domain[] $domains
 * @method static Builder|\App\Models\DomainThematic whereId($value)
 * @method static Builder|\App\Models\DomainThematic whereName($value)
 * @mixin Eloquent
 * @method static Builder|\App\Models\DomainThematic newModelQuery()
 * @method static Builder|\App\Models\DomainThematic newQuery()
 * @method static Builder|\App\Models\DomainThematic query()
 * @property-read int|null $domains_count
 */
class DomainThematic extends Model
{
    public $timestamps = false;
    protected $table = 'domain_thematic';
    protected $fillable = ['name'];

    public function domains()
    {
        return $this->hasMany(Domain::class);
    }
}
