<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Watson\Rememberable\Rememberable;


/**
 * App\Models\FeedbackRecipient
 *
 * @property int $id
 * @property int $site_id
 * @property string $email
 * @property-read Site $site
 * @method static Builder|FeedbackRecipient newModelQuery()
 * @method static Builder|FeedbackRecipient newQuery()
 * @method static Builder|FeedbackRecipient query()
 * @method static Builder|FeedbackRecipient whereEmail($value)
 * @method static Builder|FeedbackRecipient whereId($value)
 * @method static Builder|FeedbackRecipient whereSiteId($value)
 * @mixin Eloquent
 */
class FeedbackRecipient extends Model
{
    use Rememberable;

    public static $md5Alias = true;
    public $timestamps = false;
    public $rememberCacheTag = self::class;
    protected $table = 'feedback_recipient';
    protected $fillable = ['site_id', 'email'];

    public static function getEmails($siteId): array
    {
        return self::query()->whereSiteId($siteId)->get()->toArray();
    }

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }
}
