<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\WorkPlace
 *
 * @property int $id
 * @property string $name
 * @property-read \App\Models\User $user
 * @method static Builder|\App\Models\WorkPlace whereId($value)
 * @method static Builder|\App\Models\WorkPlace whereName($value)
 * @mixin Eloquent
 * @method static Builder|\App\Models\WorkPlace newModelQuery()
 * @method static Builder|\App\Models\WorkPlace newQuery()
 * @method static Builder|\App\Models\WorkPlace query()
 */
class WorkPlace extends Model
{
    public $timestamps = false;
    protected $table = 'work_place';
    protected $fillable = ['name'];
    protected $connection = 'mysqlu';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
