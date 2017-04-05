<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookmarkTag extends Model
{
    protected $table = "bookmark_tag";
    protected $fillable = ['bookmark_id','tag_bookmark_id'];
    public $timestamps = false;

    public function bookmarkInfo(){
        return $this->belongsTo('App\Bookmark','bookmark_id');
    }

    public function tagInfo(){
        return $this->hasMany('App\TagBookmark','tag_bookmark_id');
    }
}
