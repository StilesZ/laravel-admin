<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LanguageData extends Model
{
    //
    protected $table='language_data';
    protected  $fillable=['lan_id','lan_data','lan_value'];

}
