<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

	public function post() {
		return $this->belongsTo(Post::class, "parent_post", "id");
	}

	public function user() {
		return $this->belongsTo(User::class, "author_id", "id");
	}
}
