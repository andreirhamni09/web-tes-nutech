<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Kategories extends Model
{
    public function getKategori()
    {
        $sql     = "SELECT * FROM kategories"; 
        $results['data'] = DB::select($sql);
        return $results;  
    } 
}
