<?php


namespace App\Contracts;


use App\Models\Model;

abstract class Moderated extends Model
{
    public abstract function getStatusOptions();

    public abstract function onUpdateComplain($complain);

    public abstract function complains($id);
}