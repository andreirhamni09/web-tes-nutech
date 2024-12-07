<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
class KategoriController extends Controller
{
    public function getKategori()
    {
        try {
            $sql     = "SELECT * FROM kategories"; 
            $results = DB::select($sql);
            return response()->json($results);            
        } catch (Exception $e) {
            return "Query Error: " . $e->getMessage();
        }
    }
}
