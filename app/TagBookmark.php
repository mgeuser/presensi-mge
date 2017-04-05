<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TagBookmark extends Model
{
    protected $table = "tag_bookmark";
    protected $fillable = ['tag'];
    public $timestamps = false;

    public function listBookmark(){
        return $this->hasMany('App\BookmarkTag');
    }
}
