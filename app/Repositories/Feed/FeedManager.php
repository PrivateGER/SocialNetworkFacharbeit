<?php

namespace FeedManager;

use App\AuthTokens;
use App\Post;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class FeedManager {

    public static function getUserFeed($page = 1, $limit = 50, $userID) : Collection {
        if(!is_numeric($page)) {
            $page = 1;
        }

        if(!is_numeric($limit)) {
            $limit = 50;
        }

        $maxPostId = Post::max('id');

        $visiblePosts = [];

        $posts = Post::select("id")
            ->where("id", ">", $maxPostId - ($limit *  $page))
            ->limit(50)
            ->get();

        /*foreach ($posts as $post) {
            echo $post->user->name;
            $blockedUsersOfPoster = explode($post->user->blocked_users, ",");
            $blockedUsersOfUser = explode(User::where("id", $userID)->get()[0], ",");

            if(in_array($userID, $blockedUsersOfPoster)) { // User is blocked by author of post in feed
                continue;
            }
            if(in_array($post->author_id, $blockedUsersOfUser)) { // User has blocked author of post in feed
                continue;
            }

            $visiblePosts[] = $post;
        }*/

        return $posts;
    }

}
