<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Storage;

class TokenController extends Controller
{
    public static function generateJwt(array $payload, $privateKeyPath)
    {
        $privateKey = Storage::disk('local')->get($privateKeyPath);
        $realPrivateKey = <<<EOD
        $privateKey
        EOD;

        $jwt = JWT::encode($payload, $realPrivateKey, 'RS256');
        return $jwt;
    }

    public static function generateRefreshToken()
    {
        
    }

    public static function decodeJwt(string $jwt)
    {
        $publicKey = Storage::disk('local')->get(env('ACCESS_JWT_PUBLIC_KEY_FILE_NAME'));
        $data = JWT::decode($jwt, new Key($publicKey, 'RS256'));
        return $data;
    }

    // try {
    //     $jwt = self::decodeAccessJwt($jwt);
    // } catch (ExpiredException $ex) {
    //     return ResponseController::SendResponse(['jwt' => $ex->getMessage()], IStatusCode::Unauthorized);
    // } catch (Throwable $ex) {
    //     return ResponseController::SendResponse([], IStatusCode::Bad_Request, 'Your token is illegal or wrong.');
    // }
}
