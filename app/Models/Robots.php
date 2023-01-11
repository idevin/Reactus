<?php

namespace App\Models;


use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\Robots
 *
 * @method static Builder|\App\Models\Robots newModelQuery()
 * @method static Builder|\App\Models\Robots newQuery()
 * @method static Builder|\App\Models\Robots query()
 * @mixin Eloquent
 */
class Robots extends Model
{
    public $timestamps = false;
    protected $table = 'robots';


}
