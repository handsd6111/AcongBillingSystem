<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IStatusCode;
use App\Models\Member;
use Exception;
use Facade\FlareClient\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Throwable;

class AuthController extends Controller
{
    const accessTokenExpireTime = 180;
    const refreshTokenExpireTime = 1800;


    /**
     * 
     */
    public static function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|exists:members,email|min:8|max:30|regex:/(.+)@(.+)\.(.+)/i',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return ResponseController::SendResponse($validator->errors(), IStatusCode::Bad_Request);
        }

        try {
            $member = Member::where('email', $request['email'])->first();
            $data = self::generateAccessItem($member);
            if (password_verify($request['password'], $member->password)) {
                return ResponseController::SendResponse($data, IStatusCode::OK, 'Login Successfully.');
            } else {
                return ResponseController::SendResponse(['password' => 'Your password is wrong.'], IStatusCode::Bad_Request);
            }
        } catch (Throwable $ex) {
            return ResponseController::SendResponse([], IStatusCode::Interal_Server_Error);
        }
    }

    /**
     * 
     */
    private static function generateAccessItem($member)
    {
        $accessTokenData = [
            'iat' => now()->timestamp,
            'nbf' => now()->timestamp,
            'exp' => now()->timestamp + self::accessTokenExpireTime,
            'userId' => $member->id,
            'userEmail' => $member->email,
            'userName' => $member->name,
            'phone' => $member->phone,
            'authority' => $member->authority
        ];

        $accessJwt = TokenController::generateJwt($accessTokenData);
        $refreshToken = TokenController::generateRefreshToken();
        DB::transaction(function () use ($member, $refreshToken) {
            $member->refresh_token = $refreshToken;
            $member->save();
        });

        $data = [
            'access_token' => $accessJwt,
            'refresh_token' => $refreshToken,
            'expires_in' => now()->timestamp + self::refreshTokenExpireTime
        ];
        return $data;
    }


    /**
     * 註冊，利用argon2id為密碼做雜湊後才進資料庫。
     * @param Request $request
     */
    public static function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|unique:members,email|min:8|max:30|regex:/(.+)@(.+)\.(.+)/i',
            'password' => 'required|string|min:8',
            'confirm' => 'required|string|min:8',
            'name' => 'required|unique:members,name|string|min:1|max:30',
            'phone' => 'required|string|min:10|regex:/09\d{8}/i',
        ]);

        if ($validator->fails()) {
            return ResponseController::SendResponse($validator->errors(), IStatusCode::Bad_Request);
        }

        if ($request['password'] != $request['confirm']) {
            return ResponseController::SendResponse(['Password field must consistent with confirm field.'], IStatusCode::Bad_Request);
        }

        try {
            $hashed_password = password_hash(
                $request['password'],
                PASSWORD_ARGON2ID,
                ['memory_cost' => 1024, 'time_cost' => 20]
            );

            MemberController::createMember(
                $request['name'],
                $request['email'],
                $request['phone'],
                $hashed_password
            );

            return ResponseController::SendResponse([], IStatusCode::OK, 'Register Successfully.');
        } catch (Throwable $ex) {
            return ResponseController::SendResponse([], IStatusCode::Interal_Server_Error);
        }
    }

    public static function refreshToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'access_token' => 'required|string',
            'refresh_token' => 'required|string|exists:members,refresh_token'
        ]);

        if ($validator->fails()) {
            return ResponseController::SendResponse($validator->errors(), IStatusCode::Bad_Request);
        }
        try {
            $userInfo = TokenController::verifyAndBase64DecodeJwt($request['access_token']);
        } catch (Exception $ex) {
            return $userInfo;
        }
        if ($userInfo === false) {
            return ResponseController::SendResponse([], IStatusCode::Bad_Request, 'Your token is illegal or wrong.');
        }

        $email = $userInfo['userEmail'];
        $member = Member::where('email', $email)->first();

        if ($member->refresh_token !== $request['refresh_token']) {
            return ResponseController::SendResponse([], IStatusCode::Bad_Request, 'Your token is illegal or wrong.');
        }

        $refreshTokenTime = intval(explode('.', $member->refresh_token)[1]) + self::refreshTokenExpireTime;

        if ($refreshTokenTime < now()->timestamp) {
            return ResponseController::SendResponse([], IStatusCode::Unauthorized, "Your token has expired");
        }
        $data = self::generateAccessItem($member);

        return ResponseController::SendResponse($data, IStatusCode::OK);
    }
}
