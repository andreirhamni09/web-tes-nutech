<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Firebase\JWT\JWT;
use Exception;
use Carbon\Carbon;

class Token extends Model
{
    protected $key;
    public function __construct() {
        $this->key = 'APP-Laravel-Test';
    }
    public function create_jwt($data){
        $issuedAt = Carbon::now()->timestamp;
        $expirationTime = Carbon::now()->addHours(1)->timestamp;
        $payload = [
            'iat' => $issuedAt,
            'exp' => $expirationTime,
            'data' => $data,
        ];
        return JWT::encode($payload, $this->key, 'HS256');
    }
    public function cekTokenByUserId($users_id) {
        $sql                = "SELECT * FROM tokens WHERE users_id = ?";                 
        $getTokens          = DB::select($sql, [$users_id]);
        return $getTokens;
    }
    public function cekTokenByToken($token) {
        $sql                = "SELECT * FROM public.tokens t WHERE t.tokens = ?";                 
        $getTokens          = DB::select($sql, [$token]);
        return $getTokens;
    }    
    public function insertTokens($users_id, $tokens) {
        $sql                = "INSERT INTO tokens(users_id, tokens) VALUES (?, ?)";                 
        $insertToken        = DB::statement($sql, [$users_id, $tokens]);
        return $insertToken;
    }
    public function deleteTokens($users_id) {
        $sql                = "DELETE FROM tokens WHERE users_id = ?";                 
        $deleteTokens       = DB::statement($sql, [$users_id]);
        return $deleteTokens;
    }
}
