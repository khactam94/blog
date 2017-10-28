<?php
/**
 * Created by PhpStorm.
 * User: Tam
 * Date: 21-Oct-17
 * Time: 12:04
 */

namespace App\Models;
use App\Scopes\PublicScope;

class PublicPost extends Post
{
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new PublicScope);
    }
}