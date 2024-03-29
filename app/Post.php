<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    //

    use SoftDeletes;

    public function user() {
        return $this->belongsTo(User::class, "author_id", "id");
    }

    public function comments() {
    	return $this->hasMany(Comment::class, "parent_post", "id");
	}
}
