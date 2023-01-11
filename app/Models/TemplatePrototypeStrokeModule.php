<?php

namespace App\Models;

use App\Models\Modules\Module;
use Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;


class TemplatePrototypeStrokeModule extends Model
{
    public $timestamps = false;
    protected $table = 'template_prototype_stroke_module';

    protected $fillable = [
        'template_prototype_stroke_id', 'sort_order', 'module_id'
    ];

    public function stroke(): BelongsTo
    {
        return $this->belongsTo(TemplatePrototypeStroke::class);
    }

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }
}
