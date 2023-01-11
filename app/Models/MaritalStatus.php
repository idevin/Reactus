<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\MaritalStatus
 *
 * @property integer $id
 * @property string $name
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MaritalStatus whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MaritalStatus whereName($value)
 * @mixin Eloquent
 * @method static Builder|\App\Models\MaritalStatus newModelQuery()
 * @method static Builder|\App\Models\MaritalStatus newQuery()
 * @method static Builder|\App\Models\MaritalStatus query()
 */
class MaritalStatus extends Model
{
    public $timestamps = false;
    protected $table = 'marital_status';
    protected $fillable = ['name'];
    protected $connection = 'mysqlu';
}
