<?php

namespace App\Http\Middleware;

use App\Http\Controllers\ResponseController;
use App\Http\Controllers\TokenController;
use App\Models\IStatusCode;
use App\Models\Member;
use Closure;
use Facade\FlareClient\Http\Response;
use Throwable;
use Firebase\JWT\ExpiredException;
use Illuminate\Http\Request;

class CustomAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('Authorization');
        if (empty($token)) {
            return ResponseController::SendResponse(['access_token' => 'Empty token'], IStatusCode::Bad_Request, "Your don't have any token.");
        }
        try {
            $userinfo = TokenController::decodeJwt(explode(" ", $token)[1]); //分割後的陣列 0 為 Bearer
            $member = Member::where('email', $userinfo->userEmail)->first();
            if ($member->authority < 1) {
                return ResponseController::SendResponse(null, IStatusCode::Forbidden);
            }
        } catch (ExpiredException $ex) {
            return ResponseController::SendResponse(['access_token' => $ex->getMessage()], IStatusCode::Unauthorized, "Your token has expired");
        } catch (Throwable $ex) {
            return ResponseController::SendResponse(['access_token' => $ex->getMessage()], IStatusCode::Bad_Request, 'Your token is illegal or wrong.');
        }
        return $next($request);
    }
}
