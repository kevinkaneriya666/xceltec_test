<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $table = 'admin';
}
