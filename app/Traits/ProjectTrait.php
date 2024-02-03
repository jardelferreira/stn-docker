<?php
namespace App\Traits;

use App\Scopes\ProjectScope;

Trait ProjectTrait
{
    protected static function booted(){
        static::addGlobalScope(new ProjectScope());
    }
}