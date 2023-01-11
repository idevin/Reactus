<?php

namespace App\Models;

use Vinelab\NeoEloquent\Eloquent\Relations\BelongsTo;
use Vinelab\NeoEloquent\Eloquent\Relations\HasMany;

class NeoUserFieldGroup extends Neo4j
{
    public $timestamps = false;

    protected $label = 'FieldGroup';
    protected $fillable = ['user_id', 'field_group_id'];

    protected $connection = 'neo4j';

    public function card(): BelongsTo
    {
        return $this->belongsTo(NeoUserCard::class, 'USER_FIELD_GROUP');
    }

    public function relatedGroup(): BelongsTo
    {
        return $this->belongsTo(NeoFieldGroup::class, 'RELATED');
    }

    public function userFields(): HasMany
    {
        return $this->hasMany(NeoUserField::class, 'USER_FIELD');
    }

    public function userField(): BelongsTo
    {
        return $this->belongsTo(NeoUserField::class, 'USER_FIELD');
    }
}