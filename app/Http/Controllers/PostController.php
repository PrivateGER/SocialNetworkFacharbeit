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

        	$comments = [];
        	foreach ($post[0]->comments as $comment) {
				$comments[] = [
					"author_id" => $comment->author_id,
					"author_name" => $comment->user->name,
					"content" => $comment->content
				];
			}
            $postToSend["comments"] = $comments;
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

        if(!isset($content) || empty($content)) {
            return response(array(
                "err" => "Es sind keine leeren Posts möglich!"
            ), 400);
        }

        if(strlen($content) > 5000) {
			return response(array(
				"err" => "Es sind keine Posts über 5000 Zeichen möglich!"
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

    public function createComment(Request $request) {
    	$parentID = $request->parentID;
		$content = $request->postContent;

		if(Post::where("id", $parentID)->count() < 1) {
			return response(array(
				"err" => "Dieser Post existiert nicht."
			), 400);
		}

		$newComment = new \App\Comment();
		$newComment->author_id = AuthTokens::getTokenData($request->token)[0]->user->id;
		$newComment->parent_post = $parentID;
		$newComment->content = $content;
		$newComment->save();

		return response(array(
			"err" => ""
		), 200);
	}
}
