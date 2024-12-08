<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Token;
use App\Models\Users;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $authorizationHeader = $request->header('Authorization');
        if(!session()->has('token') && !$authorizationHeader) {
            session()->flash('error', 'Anda Belum Melakukan Login');
            return redirect()->route('login');
        } else if(!session()->has('token') && $authorizationHeader) {
            $tokenReq       = str_replace("Bearer", "", $authorizationHeader);
            $tokenFunction  = new Token();
            $strTokenReq    = $tokenReq;
            $cekTokenExist  = $tokenFunction->cekTokenByToken($strTokenReq);
            // print_r($cekTokenExist);
            if(count($cekTokenExist) > 0) {
                $users_id       = $cekTokenExist[0]->users_id;
                $usersFunction  = new Users();
                $users          = $usersFunction->getUsersById($users_id);
                session([
                    'token' => $tokenReq,
                    'users' => $users
                ]);
                return $next($request);
            } else {
                session()->flash('error', 'Anda Belum Melakukan Login');
                return redirect()->route('login');
            }
        } else if(session()->has('token') && !$authorizationHeader)  {
            return $next($request);
        }
    }
}
