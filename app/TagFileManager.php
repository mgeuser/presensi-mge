<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TagFileManager extends Model
{
    protected $table = "tag_file_manager";
    protected $fillable = ['tag'];
    public $timestamps = false;

    public function listBookmark(){
        return $this->hasMany('App\BookmarkTag');
    }
}
