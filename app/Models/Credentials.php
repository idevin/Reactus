<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\Credentials
 *
 * @method static Builder|\App\Models\Credentials newModelQuery()
 * @method static Builder|\App\Models\Credentials newQuery()
 * @method static Builder|\App\Models\Credentials query()
 * @mixin Eloquent
 */
class Credentials extends Model
{
    public $timestamps = false;
    protected $table = 'credentials';


}
