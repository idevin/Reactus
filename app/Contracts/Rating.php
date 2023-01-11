<?php

namespace App\Contracts;

interface Rating
{
    public static function ratingValues();

    public static function calculateRating($object);
}