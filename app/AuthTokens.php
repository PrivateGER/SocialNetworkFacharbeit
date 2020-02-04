<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AuthTokens extends Model
{
    public function user() {
        return $this->belongsTo(User::class, "user_id", "id");
    }

    public static function getTokenData($token) {
        if(strlen($token) != 128) {
            return null;
        }

        return AuthTokens::where("token", "=", $token)
            ->where("deactivated", 0)
            ->whereRaw("created_at > TIMESTAMP(DATE_SUB(NOW(), INTERVAL 7 DAY))")
            ->take(1)
            ->get(); // Tokens sind 7 Tage lang gültig, solange sie nicht deaktivert wurden
    }
}
