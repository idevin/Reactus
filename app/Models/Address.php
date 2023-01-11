<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\Address
 *
 * @property int $id
 * @property string $name
 * @property-read \App\Models\User $user
 * @method static Builder|\App\Models\Address newModelQuery()
 * @method static Builder|\App\Models\Address newQuery()
 * @method static Builder|\App\Models\Address query()
 * @method static Builder|\App\Models\Address whereId($value)
 * @method static Builder|\App\Models\Address whereName($value)
 * @mixin Eloquent
 */
class Address extends Model
{
    public $timestamps = false;
    protected $table = 'address';
    protected $fillable = ['name'];
    protected $connection = 'mysqlu';


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
