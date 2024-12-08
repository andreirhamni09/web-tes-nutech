<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Session;
use App\Models\Users;
use App\Models\Token;

class AuthController extends Controller
{
    public function index()
    {
        if(session('token')){
            return redirect('/');
        } else {
            return view('auth/login');
        }
    }

    public function loginProses(Request $request){
        try {
            $userFunction       = new Users();
            $users              = $userFunction->usersLogin($request->input('email'),$request->input('password'));
            if(count($users) > 0) {
                $users_id       = $users[0]->users_id;
                $tokenFunction  = new Token();
                $token          = $tokenFunction->create_jwt($users);
                $usersToken     = $tokenFunction->cekTokenByUserId($users_id);
                if (count($usersToken) > 0) {
                    session([
                        'token' => $usersToken[0]->tokens,
                        'users' => $users
                    ]);
                    return redirect()->route('dashboard');
                } else {
                    $insertTokens   = $tokenFunction->insertTokens($users_id, $token);
                    if($insertTokens > 0 ) {
                        session([
                            'token' => $token,
                            'users' => $users
                        ]);
                        return redirect()->route('dashboard');
                    } else {
                        session()->flash('error', 'Gagal Menambahkan Token');
                        return redirect()->back();
                    }
                }
                return $users_id;
                
            } else {
                session()->flash('error', 'User Tidak Ditemukan');
                return redirect()->back();
            }
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
        
    }
    public function logout($id){  
        $tokenFunction  = new Token();
        $logout         = $tokenFunction->deleteTokens($id);
        if ($logout > 0) {
            session()->flush();
            return redirect()->route('login');
        } 
    }
}
