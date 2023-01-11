<?php namespace App\Contracts;

interface Rss {
    public function getRssItem() : string;

    public function scopeGetForRss($obQuery, $obSite);
}