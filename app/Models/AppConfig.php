<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppConfig extends Model
{
    //
    protected $table = 'config';
    protected $fillable = ['name','value'];
}
