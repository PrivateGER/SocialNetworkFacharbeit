<?php

namespace App\Http\Controllers;

use APIAuthentication\TokenManager;
use App\AuthTokens;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function getTokenInfo(Request $request) {
        $token = $request->token;

        $res = TokenManager::getTokenData($token);

        return response()->json($res["response"], $res["code"]);
    }

    public function loginAndRetrieveToken(Request $request) {
        $email = $request->email;
        $password = $request->password;

        $newToken = TokenManager::loginAndRetrieveToken($email, $password);

        if($newToken["err"]) {
            usleep(random_int(200, 1000) * 1000);
            if(isset($newToken["banned"])) {
				return response($newToken, 403);
			}
           	return response($newToken, 401);
        } else {
            return response($newToken, 200);
        }
    }

    public function changePassword(Request $request) {
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

        $token = $request->token;
        $newPassword = $request->newPassword;

        if(!isset($newPassword) || empty($newPassword) || strlen($newPassword) <= 6) {
            return response(array(
                "err" => "Mindestens 6 Zeichen."
            ), 400);
        }

        if(in_array($newPassword, $commonPasswords)) {
            return response(array(
               "err" => "Das Passwort ist in der Top-1000 Liste der häufigen Passwörter enthalten. Bitte wähle ein sichererers."
            ), 400);
        }

        $user = AuthTokens::getTokenData($token)[0]->user;
        $user->password = Hash::make($newPassword);
        $user->save();

        AuthTokens::where("user_id", $user->id)
            ->update(["deactivated" => 1]);

        return response(array(
            "err" => "",
            "msg" => "Errfolgreich. Bitte melden sie sich erneut an."
        ), 200);
    }
}
