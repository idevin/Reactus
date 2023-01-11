<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Watson\Rememberable\Rememberable;


/**
 * App\Models\Model
 *
 * @mixin \Eloquent
 * @method static Builder|Model newModelQuery()
 * @method static Builder|Model newQuery()
 * @method static Builder|Model query()
 */
class Model extends Eloquent
{
    use Rememberable;

    public static function make($attributes = [])
    {
        return new static($attributes);
    }
}
