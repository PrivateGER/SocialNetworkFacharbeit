<?php

namespace APIAuthentication;

use App\AuthTokens;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TokenManager {
    /**
     * @param $token
     * @return array - First element: Authentication Success, second element: further information
     *
     */
    public static function getTokenData($token) : array {

        if(!isset($token) || empty($token) || strlen($token) !== 128) {
            return array(
                "code" => 400,
                "response" => [
                    "err" => true,
                    "msg" => "No token supplied."
                ]
            );
        }

        $valid_tokens = \App\AuthTokens::getTokenData($token);

        foreach ($valid_tokens as $authToken) {
            if($authToken->token === $token) {
                return array(
                    "code" => 200,
                    "response" => [
                        "err" => false,
                        "data" => array(
                            "userid" => $authToken["user_id"],
                            "username" => $authToken->user->name,
                            "email" => $authToken->user->email,
                            "profile_picture_url" => $authToken->user->profile_picture_url,
                            "permission_level" => $authToken->user->permission_level,
                            "created" => $authToken["created_at"]
                        )
                    ]
                );
            }
        }

        return [
            "code" => 401,
            "response" => [
                "err" => true,
                "msg" => "Invalid / expired token.",
                "data" => []
            ]
        ];
    }

    public static function  verifyToken($token) : bool {

        if(!isset($token) || empty($token) || strlen($token) !== 128) {
            return false;
        }

        $valid_tokens = AuthTokens::getTokenData($token);

        return count($valid_tokens) > 0;
    }

    public static function loginAndRetrieveToken($email, $password) : array {

        if(!isset($email) || !isset($password) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return array(
                "err" => true
            );
        }

        $parent_user = User::emailToUser($email);

        if($parent_user === null) {
            return array(
                "err" => true
            );
        }

        if(Auth::attempt(array( "email" => $email, "password" => $password ))) {
            $newToken = hash("sha512", random_bytes(36));

            $token = new AuthTokens();
            $token->user_id = $parent_user->id;
            $token->token = $newToken;
            $token->save();

            return [
                "err" => false,
                "token" => $newToken
            ];
        } else {
            return array(
                "err" => true
            );
        }
    }

    public static function changePassword($token, $newPassword) : array {
        $commonPasswords = array(
            "hallo",
            "123",
            "123456",
            "123456789",
            "passwort",
            "password",
            "1234",
            "12345",
            "hallo123",
            "qwertz",
            "passwort1",
            "schalke04"
        );

        if(!isset($newPassword) || empty($newPassword) || strlen($newPassword) <= 6) {
            return array(
                "code" => 400,
                "response" => [
                    "err" => "Mindestens 6 Zeichen."
                ]
            );
        }

        if(in_array($newPassword, $commonPasswords)) {
            return array(
                "code" => 400,
                "response" => [
                    "err" => "Das Passwort ist in der Top-1000 Liste der häufigen Passwörter enthalten. Bitte wähle ein sichererers."
                ]
            );
        }

        $user = AuthTokens::getTokenData($token)[0]->user;
        $user->password = Hash::make($newPassword);
        $user->save();

        AuthTokens::where("user_id", $user->id)
            ->update(["deactivated" => 1]);

        return array(
            "code" => 200,
            "response" => [
                "err" => "",
                "msg" => "Errfolgreich. Bitte melden sie sich erneut an."
            ]
        );
    }
}
