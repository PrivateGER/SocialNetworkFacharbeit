<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reports extends Model
{
    //

	public function reporter() {
		return $this->belongsTo(User::class, "reporter", "id");
	}
}
