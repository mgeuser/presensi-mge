<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FileTag extends Model
{
    protected $table = "file_tag";
    protected $fillable = ['file_id','tag_id'];
    public $timestamps = false;

    public function bookmarkInfo(){
        return $this->belongsTo('App\Bookmark','bookmark_id');
    }

    public function tagInfo(){
        return $this->hasMany('App\TagBookmark','tag_bookmark_id');
    }
}
