<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Models\RegisterCode
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $field
 * @property string $value
 * @property string $code
 * @property int $sent
 * @method static Builder|\App\Models\RegisterCode newModelQuery()
 * @method static Builder|\App\Models\RegisterCode newQuery()
 * @method static Builder|\App\Models\RegisterCode query()
 * @method static Builder|\App\Models\RegisterCode whereCode($value)
 * @method static Builder|\App\Models\RegisterCode whereCreatedAt($value)
 * @method static Builder|\App\Models\RegisterCode whereField($value)
 * @method static Builder|\App\Models\RegisterCode whereId($value)
 * @method static Builder|\App\Models\RegisterCode whereSent($value)
 * @method static Builder|\App\Models\RegisterCode whereUpdatedAt($value)
 * @method static Builder|\App\Models\RegisterCode whereValue($value)
 * @mixin Eloquent
 */
class RegisterCode extends Model
{
    protected $table = 'register_code';

    protected $fillable = ['field', 'value', 'code', 'sent'];


}
