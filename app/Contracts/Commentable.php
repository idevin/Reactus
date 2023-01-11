<?php

namespace App\Contracts;


use App\Models\Comment;

abstract class Commentable extends Moderated
{
    protected $casts = ['settings' => 'json'];

    public static $defaultSettings = [
        'allow_comments' => 0,
        'sort_comments' => 0,
        'moderate_comments' => 0
    ];

    public abstract function getSortCommentsOptions();

    public abstract function getLastCommentUrlAttribute();

    public abstract function getNotFoundText();

    public function comments()
    {
        return $this->hasMany(Comment::class, 'object_id');
    }

    public function lastComment()
    {
        return $this->hasOne(Comment::class, 'id', 'last_comment_id')->with('author');
    }

    public function getLastCommentAttribute()
    {
        if ($this->last_comment_id) {
            return $this->lastComment()->get()->first();
        }

        return null;
    }

    abstract public function getApiUrl($comment);
}