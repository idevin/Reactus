<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

/**
 * App\Models\FeedbackLog
 *
 * @property int $id
 * @property int $site_id
 * @property int|null $from_user_id
 * @property string|null $from_name
 * @property string|null $from_email
 * @property string|null $from_phone
 * @property array|null $to_emails
 * @property int|null $to_user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|\App\Models\FeedbackLogField[] $fields
 * @property-read \App\Models\User|null $fromUser
 * @property-read \App\Models\Site $site
 * @property-read \App\Models\User|null $toUser
 * @method static Builder|\App\Models\FeedbackLog newModelQuery()
 * @method static Builder|\App\Models\FeedbackLog newQuery()
 * @method static Builder|\App\Models\FeedbackLog query()
 * @method static Builder|\App\Models\FeedbackLog whereCreatedAt($value)
 * @method static Builder|\App\Models\FeedbackLog whereFromEmail($value)
 * @method static Builder|\App\Models\FeedbackLog whereFromName($value)
 * @method static Builder|\App\Models\FeedbackLog whereFromPhone($value)
 * @method static Builder|\App\Models\FeedbackLog whereFromUserId($value)
 * @method static Builder|\App\Models\FeedbackLog whereId($value)
 * @method static Builder|\App\Models\FeedbackLog whereSiteId($value)
 * @method static Builder|\App\Models\FeedbackLog whereToEmails($value)
 * @method static Builder|\App\Models\FeedbackLog whereToUserId($value)
 * @method static Builder|\App\Models\FeedbackLog whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read int|null $fields_count
 */
class FeedbackLog extends Model
{


    public $timestamps = true;
    public $rememberCacheTag = self::class;
    protected $connection = 'mysqlu';
    protected $table = 'feedback_log';
    protected $fillable = [
        'site_id', 'from_user_id', 'from_name',
        'from_email', 'to_emails', 'to_user_id', 'from_phone'
    ];

    protected $casts = [
        'to_emails' => 'json'
    ];

    public function fromUser()
    {
        return $this->belongsTo(User::class);
    }

    public function toUser()
    {
        return $this->belongsTo(User::class);
    }

    public function site()
    {
        $this->setConnection('mysql');
        return $this->belongsTo(Site::class);
    }

    public function fields()
    {
        return $this->hasMany(FeedbackLogField::class)->with(['field']);
    }

}
