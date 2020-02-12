<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function messages() {
        return $this->hasMany(ChatMessage::class);
    }

    public function authTokens() {
        return $this->hasMany(AuthTokens::class);
    }

    public function posts() {
        return $this->hasMany(Post::class);
    }

    public function comments() {
    	return $this->hasMany(Comment::class, "id", "author_id");
	}

    public static function emailToUser($email) : User {
        $results = User::where("email", $email)->take(1)->get();
        if(count($results) === 1) {
            return $results[0];
        } else {
            return null;
        }
    }
}
