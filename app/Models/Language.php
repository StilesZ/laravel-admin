<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    //
    protected $table = 'language';
    protected $fillable = ['language','status','language_code','icon'];

    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            // 把数据从$model取出，插入到其它表中

        });
    }
}
