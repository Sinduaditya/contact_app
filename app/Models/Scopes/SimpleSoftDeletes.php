<?php
namespace App\Models\Scopes;

//global scope
trait SimpleSoftDeletes {

    protected static function bootSimpleSoftDeletes(){
        static::addGlobalScope(new SimpleSoftDeletingScope);
    }
}
