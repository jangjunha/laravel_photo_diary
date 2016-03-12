<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Password extends Model
{
    protected $table = 'passwords';

    protected $hidden = ['password'];

    public $timestamps = true;
}
