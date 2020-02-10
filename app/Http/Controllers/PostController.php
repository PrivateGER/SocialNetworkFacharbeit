<?php

namespace App\Http\Controllers;

use App\AuthTokens;
use App\Post;
use FeedManager\FeedManager;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function viewPost($id) {
        $post = Post::where("id", $id)->get();

        if(count($post) === 1) {
            $postToSend = $post->toArray()[0];
            $postToSend["author_name"] = $post[0]->user->name;
            return response($postToSend, 200);
        } else {
            return response(array(
                "err" => "Post not found / no access to post."
            ), 403);
        }
    }

    public function createPost(Request $request) {
        $postTypes = ["text"];

        $typ = $request->postType;
        $content = $request->postContent;
        $media = $request->attachedMedia;

        if(!isset($content) || empty($content) || strlen($content) < 10) {
            return response(array(
                "err" => "No content supplied or less than 10 chars."
            ), 400);
        }

        if(!isset($typ) || !in_array($typ, $postTypes, true)) {
            return response(array(
                "err" => "Invalid post type. Valid: " . json_encode($postTypes)
            ), 400);
        }

        $newPost = new Post();
        $newPost->type = $typ;
        $newPost->content = $content;
        $newPost->attached_media = null;
        $newPost->author_id = AuthTokens::getTokenData($request->token)[0]->user->id;
        $newPost->save();

        return response(array(
            "err" => "",
            "id" => $newPost->id,
        ), 200);
    }

    public function feed(Request $request) {
        $page = $request->page;
        $limit = $request->limit;

        $userID = AuthTokens::getTokenData($request->token)[0]->user->id;

        echo json_encode(FeedManager::getUserFeed($page, $limit, $userID));
    }
}
