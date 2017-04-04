<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    protected $table = "new_bookmark";
    protected $fillable = ["alamat","judul","tag","user_id","privasi"];

    public function userInfo(){
        return $this->belongsTo("App\User","user_id");
    }
}
