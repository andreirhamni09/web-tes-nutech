<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Users extends Model
{
    public function usersLogin($email, $pass) {
        $sql                = "SELECT * FROM users WHERE users.users_email = ? AND users.users_pass = ?";
        $login             = DB::select($sql,[$email, $pass]);
        return $login;
    }
    public function getUsersById($users_id){
        $sql                = "SELECT * FROM users WHERE users_id = ?";
        $result             = DB::select($sql,[$users_id]);
        return $result;
    }
}
