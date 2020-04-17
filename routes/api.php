<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('auth')->group(function () {
    Route::get("info", "AuthController@getTokenInfo");
    Route::post("login", "AuthController@loginAndRetrieveToken");
});

Route::middleware(["valid_token"])->group(function() {
    Route::prefix("post")->group(function () {
        Route::get("feed", "PostController@feed");
        Route::get("view/{id}", "PostController@viewPost");
        Route::post("create", "PostController@createPost");
        Route::post("create_comment", "PostController@createComment");
        Route::post("report/{id}", "PostController@reportPost");
		Route::post("delete/{id}", "PostController@deletePost");

    });

    Route::prefix('auth')->group(function () {
        Route::post("changepassword", "AuthController@changePassword");
        Route::post("logout", "AuthController@deleteToken");
    });
});

Route::middleware(["valid_moderation_token"])->group(function () {
	Route::prefix("admin")->group(function () {
		Route::prefix("reports")->group(function () {
			Route::get("list", "AdministrationController@listReports");
			Route::post("process_report", "AdministrationController@process_report");
		});

		Route::prefix("post")->group(function () {
			Route::post("delete", "AdministrationController@deletePost");
		});

		Route::get("modlog", "AdministrationController@showModlog");
	});
});
