<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    protected $table = "new_presensi";
    protected $fillable = ['user_id','masuk','pulang'];
    public $timestamps = false;

    public function userInfo()
    {
        return $this->belongsTo('App\User','user_id');
    }
}
