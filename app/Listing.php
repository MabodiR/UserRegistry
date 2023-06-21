<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{

    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','surname', 'email','position',
    ];

   
}
