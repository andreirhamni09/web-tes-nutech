<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Produks extends Model
{
    public function insertProduk($produks_img, $produks_name, $kategories_id, $produks_harga, $produks_jual, $produks_stok) {
        $sql            = "INSERT INTO produks(produks_img, produks_name, kategories_id, produks_harga, produks_jual, produks_stok)
                                  VALUES (?, ?, ?, ?, ?, ?)";
        $insertProduk   = DB::statement($sql, [$produks_img, $produks_name, $kategories_id, $produks_harga, $produks_jual, $produks_stok]);
        return $insertProduk;
    }
    public function getProduks() {
        $sql            = " SELECT p.produks_id, p.produks_img, p.produks_name, 
                                  p.kategories_id, k.kategories_name, p.produks_harga,
                                  p.produks_jual, p.produks_stok
                            FROM produks p
                            INNER JOIN kategories k ON k.kategories_id = p.kategories_id";
        $getProduk      = DB::select($sql);
        return $getProduk;
    }
    public function getProduksById($id) {
        $sql            = " SELECT p.produks_id, p.produks_img, p.produks_name, 
                                  p.kategories_id, k.kategories_name, p.produks_harga,
                                  p.produks_jual, p.produks_stok
                            FROM produks p
                            INNER JOIN kategories k ON k.kategories_id = p.kategories_id
                            WHERE p.produks_id = ?";
        $getProduk      = DB::select($sql, [$id]);
        return $getProduk;
    }
    public function getProduksByKategori($kategori) {
        $result         = '';
        if($kategori == 'all') {
            $sql            = " SELECT p.produks_id, p.produks_img, p.produks_name, 
                                  p.kategories_id, k.kategories_name, p.produks_harga,
                                  p.produks_jual, p.produks_stok
                            FROM produks p
                            INNER JOIN kategories k ON k.kategories_id = p.kategories_id
                            WHERE p.kategories_id = ?";
            $result      = DB::select($sql, [$kategori]);
        } else {
            $sql            = " SELECT p.produks_id, p.produks_img, p.produks_name, 
                                      p.kategories_id, k.kategories_name, p.produks_harga,
                                      p.produks_jual, p.produks_stok
                                FROM produks p
                                INNER JOIN kategories k ON k.kategories_id = p.kategories_id
                                WHERE p.kategories_id = ?";
            $result      = DB::select($sql, [$kategori]);
        }
        return $result;
    }

    public function deleteProduk($produks_id) {
        $sql            = "DELETE FROM produks WHERE produks_id = ?";
        $deleteProduk   = DB::select($sql, [$produks_id]);
        return $deleteProduk;
    }

    public function editProduk($id, $kategori, $hargaBeli, $hargaJual, $stokBarang) {
        $sql            = " UPDATE produks 
                            SET kategories_id = ?, produks_harga = ?, 
                                produks_jual  = ?, produks_stok =?
	                        WHERE produks_id  = ?";
        $getProduk      = DB::statement($sql, [$kategori, $hargaBeli, $hargaJual, $stokBarang, $id]);
        return $getProduk;
    }
}
