<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\FeedbackLogField
 *
 * @property int $id
 * @property int $feedback_log_id
 * @property int $field_id
 * @property string|null $value
 * @property-read \App\Models\FeedbackLog $feedbackLog
 * @property-read \App\Models\Field $field
 * @method static Builder|\App\Models\FeedbackLogField newModelQuery()
 * @method static Builder|\App\Models\FeedbackLogField newQuery()
 * @method static Builder|\App\Models\FeedbackLogField query()
 * @method static Builder|\App\Models\FeedbackLogField whereFeedbackLogId($value)
 * @method static Builder|\App\Models\FeedbackLogField whereFieldId($value)
 * @method static Builder|\App\Models\FeedbackLogField whereId($value)
 * @method static Builder|\App\Models\FeedbackLogField whereValue($value)
 * @mixin Eloquent
 */
class FeedbackLogField extends Model
{
    public $timestamps = false;
    protected $connection = 'mysqlu';
    protected $table = 'feedback_log_field';
    protected $fillable = ['feedback_log_id', 'field_id', 'value'];

    public function field()
    {
        $this->setConnection('mysql');
        return $this->belongsTo(Field::class);
    }

    public function feedbackLog()
    {
        return $this->belongsTo(FeedbackLog::class);
    }
}
