<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\ProfileModule
 *
 * @property int $id
 * @property string $name
 * @property string $class
 * @method static Builder|\App\Models\ProfileModule whereClass($value)
 * @method static Builder|\App\Models\ProfileModule whereId($value)
 * @method static Builder|\App\Models\ProfileModule whereName($value)
 * @mixin Eloquent
 * @method static Builder|\App\Models\ProfileModule newModelQuery()
 * @method static Builder|\App\Models\ProfileModule newQuery()
 * @method static Builder|\App\Models\ProfileModule query()
 */
class ProfileModule extends Model
{
    public $timestamps = false;
    protected $table = 'profile_module';
    protected $fillable = ['name', 'class'];
}
