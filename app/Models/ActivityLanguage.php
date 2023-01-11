<?php

namespace App\Models;

use App\Traits\Activity as ActivityTrait;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\ActivityLanguage
 *
 * @property int $id
 * @property string|null $activity_key
 * @property string|null $translated
 * @property string $lang
 * @property-read \App\Models\Activity $activity
 * @method static Builder|\App\Models\ActivityLanguage newModelQuery()
 * @method static Builder|\App\Models\ActivityLanguage newQuery()
 * @method static Builder|\App\Models\ActivityLanguage query()
 * @method static Builder|\App\Models\ActivityLanguage whereActivityKey($value)
 * @method static Builder|\App\Models\ActivityLanguage whereId($value)
 * @method static Builder|\App\Models\ActivityLanguage whereLang($value)
 * @method static Builder|\App\Models\ActivityLanguage whereTranslated($value)
 * @mixin Eloquent
 */
class ActivityLanguage extends Model
{
    use ActivityTrait;

    public $timestamps = false;
    protected $table = 'activity_language';
    protected $fillable = ['activity_key', 'lang', 'translated'];

    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class, 'title', 'activity_key');
    }
}
