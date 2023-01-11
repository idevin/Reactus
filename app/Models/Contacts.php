<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\Contacts
 *
 * @method static Builder|\App\Models\Contacts newModelQuery()
 * @method static Builder|\App\Models\Contacts newQuery()
 * @method static Builder|\App\Models\Contacts query()
 * @mixin Eloquent
 */
class Contacts extends Model
{
    public $timestamps = false;
    protected $table = 'contacts';


}
