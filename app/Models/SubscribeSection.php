<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\SubscribeSection
 *
 * @property int $id
 * @property int $user_id
 * @property int $section_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\Models\Section $section
 * @property-read \App\Models\User $user
 * @method static Builder|\App\Models\SubscribeSection whereCreatedAt($value)
 * @method static Builder|\App\Models\SubscribeSection whereId($value)
 * @method static Builder|\App\Models\SubscribeSection whereSectionId($value)
 * @method static Builder|\App\Models\SubscribeSection whereUpdatedAt($value)
 * @method static Builder|\App\Models\SubscribeSection whereUserId($value)
 * @mixin Eloquent
 * @method static Builder|\App\Models\SubscribeSection newModelQuery()
 * @method static Builder|\App\Models\SubscribeSection newQuery()
 * @method static Builder|\App\Models\SubscribeSection query()
 */
class SubscribeSection extends Model
{
    protected $connection = 'mysql';
    protected $table = 'subscribe_sections';
    protected $fillable = ['user_id', 'section_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}