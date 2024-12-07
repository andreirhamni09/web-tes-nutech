<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class ProdukController extends Controller
{
    public function getProduks()
    {
        try {
            $sql     = "SELECT  p.produks_id, p.produks_img, p.produks_name, 
                                p.kategories_id, k.kategories_name, p.produks_harga,
                                p.produks_jual, p.produks_stok
                        FROM produks p
                        INNER JOIN kategories k ON k.kategories_id = p.kategories_id"; 
            $results['produks'] = DB::select($sql);
            return response()->json($results);            
        } catch (Exception $e) {
            return "Query Error: " . $e->getMessage();
        }
    }
}
