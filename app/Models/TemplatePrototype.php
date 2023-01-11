<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class TemplatePrototype extends Model
{
    public $timestamps = false;
    protected $table = 'template_prototype';

    protected $fillable = [
        'template_id', 'name', 'description'
    ];

    public function template(): BelongsTo
    {
        return $this->belongsTo(Template::class);
    }

    public function strokes(): HasMany
    {
        return $this->hasMany(TemplatePrototypeStroke::class);
    }
}
