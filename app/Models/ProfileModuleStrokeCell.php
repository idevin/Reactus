<?php

namespace App\Models;

use App\Contracts\ProfileModuleObserver;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\ProfileModuleStrokeCell
 *
 * @property int $id
 * @property int $profile_module_stroke_id
 * @property int $index 0,1,2...
 * @property int $profile_module_id
 * @property-read mixed $data
 * @property-read \App\Models\ProfileModule $profileModule
 * @property-read \App\Models\ProfileModuleStroke $profileModuleStroke
 * @method static Builder|\App\Models\ProfileModuleStrokeCell whereId($value)
 * @method static Builder|\App\Models\ProfileModuleStrokeCell whereIndex($value)
 * @method static Builder|\App\Models\ProfileModuleStrokeCell whereProfileModuleId($value)
 * @method static Builder|\App\Models\ProfileModuleStrokeCell whereProfileModuleStrokeId($value)
 * @mixin Eloquent
 * @method static Builder|\App\Models\ProfileModuleStrokeCell newModelQuery()
 * @method static Builder|\App\Models\ProfileModuleStrokeCell newQuery()
 * @method static Builder|\App\Models\ProfileModuleStrokeCell query()
 */
class ProfileModuleStrokeCell extends Model
{
    public $timestamps = false;
    protected $table = 'profile_module_stroke_cell';
    protected $fillable = [
        'profile_module_stroke_id', 'index', 'profile_module_id'
    ];

    protected $appends = ['data'];

    public function profileModuleStroke()
    {
        return $this->belongsTo(ProfileModuleStroke::class);
    }

    public function profileModule()
    {
        return $this->belongsTo(ProfileModule::class);
    }

    public function getDataAttribute()
    {
        return (new ProfileModuleObserver($this->profileModule))->getData();
    }
}
