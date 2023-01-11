<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class TemplatePrototypeStroke extends Model
{
    public $timestamps = false;
    protected $table = 'template_prototype_stroke';

    protected $fillable = [
        'template_prototype_id', 'sort_order', 'position'
    ];

    public function templatePrototype(): BelongsTo
    {
        return $this->belongsTo(TemplatePrototype::class);
    }

    public function modules(): HasMany
    {
        return $this->hasMany(TemplatePrototypeStrokeModule::class);
    }
}
