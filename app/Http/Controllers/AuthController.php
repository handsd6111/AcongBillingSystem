<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IStatusCode;
use App\Models\Member;
use Illuminate\Support\Facades\Validator;
use Throwable;

class AuthController extends Controller
{
    public static function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|exists:members,email|min:8|max:30',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return ResponseController::SendResponse($validator->errors(), IStatusCode::Bad_Request);
        }
        try {
            $member = Member::where('email', $request['email'])->first();
            $access = [
                'iat' => now()->timestamp,
                'nbf' => now()->timestamp,
                'exp' => now()->timestamp + 180,
                // 'userId' => $member->id,
                'userEmail' => $member->email,
                'userName' => $member->name,
                'phone' => $member->phone
            ];

            $accessJwt = TokenController::generateJwt($access, env('ACCESS_JWT_PRIVATE_KEY_FILE_NAME'));
            $refreshToken = 'asdfjopiwejfopijoijaosipduv89weja';

            $data = [
                'access_token' => $accessJwt,
                'refresh_token' => $refreshToken,
                'expires_in' => now()->timestamp + 1800
            ];

            if (password_verify($request['password'], $member->password)) {
                return ResponseController::SendResponse($data, IStatusCode::OK, 'Login Successfully');
            } else {
                return ResponseController::SendResponse(['password' => 'Your password is wrong.'], IStatusCode::Bad_Request);
            }
        } catch (Throwable $ex) {
            return ResponseController::SendResponse([], IStatusCode::Interal_Server_Error);
        }
    }

    public static function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|unique:members,email|min:8|max:30',
            'password' => 'required|string|min:8',
            'name' => 'required|unique:members,name|string|min:1|max:30',
            'phone' => 'required|string|min:10',
        ]);

        if ($validator->fails()) {
            return ResponseController::SendResponse($validator->errors(), IStatusCode::Bad_Request);
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

            return ResponseController::SendResponse([], IStatusCode::OK, 'Register Successfully');
        } catch (Throwable $ex) {
            return ResponseController::SendResponse([], IStatusCode::Interal_Server_Error);
        }
    }
}
