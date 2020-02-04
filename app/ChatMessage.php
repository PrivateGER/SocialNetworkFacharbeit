<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    //

    protected $fillable = ['message'];

    public function parentChatRoom() {
        return $this->belongsTo(ChatRoom::class, "chat_room", "id");
    }

    public function user() {
        return $this->belongsTo(User::class, "user_id", "id");
    }
}
