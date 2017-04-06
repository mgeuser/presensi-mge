<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $table = "files";
    protected $fillable = ["nama","user_id","privasi"];
    public $timestamps = false;
    public function userInfo(){
        return $this->belongsTo("App\User","user_id");
    }
}
