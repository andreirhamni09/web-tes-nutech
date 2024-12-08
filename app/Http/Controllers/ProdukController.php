<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produks;
use App\Models\Kategories;
use Illuminate\Support\Facades\Validator;
use Exception;

class ProdukController extends Controller
{
    protected $produksFunction;
    protected $kategoriesFunction;

    public function __construct() {
        $this->produksFunction      = new Produks();
        $this->kategoriesFunction   = new Kategories();
    }
    public function getProduks(Request $request)
    {
        $produks = $this->produksFunction->getProduks();
        $results['produks'] = $produks;
        return response()->json($results);
    }
    
    public function deleteProduk(Request $request)
    {
        $produks_id     = $request->input('id');
        $getProduksById = $this->produksFunction->getProduksById($produks_id);
        $produksImg     = $getProduksById[0]->produks_img;
        $path           = 'CMS Assets/'.$produksImg;
        $filePath       = public_path($path);
        if($filePath) {
            $deleteProduk = $this->produksFunction->deleteProduk($request->input('id'));
            if($deleteProduk > 0) {
                unlink($filePath); // Delete the file
                session()->flash('delete', 'Berhasil Delete Produk');
                return redirect()->back();
            }
        }
    }
    public function tambahProduk(Request $request)
    {
        try {
            $produksExist   = $this->produksFunction->getProduks();
            $inProduk       = '';
            for ($i=0; $i < count($produksExist); $i++) { 
                $no = $i + 1;
                if($no == count($produksExist)) {
                    $inProduk .= $produksExist[$i]->produks_name.'';
                } else {
                    $inProduk .= $produksExist[$i]->produks_name.',';
                }
            }
            $kategorisExist = $this->kategoriesFunction->getKategori();
            $inKategories   = '';
            for ($i=0; $i < count($kategorisExist['data']); $i++) { 
                $no = $i + 1;
                if($no == count($kategorisExist['data'])) {
                    $inKategories .= $kategorisExist['data'][$i]->kategories_id.'';
                } else {
                    $inKategories .= $kategorisExist['data'][$i]->kategories_id.',';
                }
            }
    
            $messages  = [
                'kategori.required'         => 'Kategori Harus Dipilih',
                'kategori.in'               => 'Kategori Tidak Ditemukan',
                
                'namaBarang.required'       => 'Nama Barang Harus Diisi',
                'namaBarang.not_in'         => 'Nama Barang Sudah Ada',

                'hargaBeli.required'        => 'Harga Beli Harus Diisi',
                'hargaBeli.integer'         => 'Harga Beli Harus Berupa Bilangan Bulat',
                'hargaBeli.min'             => 'Harga Beli Diisi Minimal 100',

                'hargaJual.required'        => 'Harga Jual Harus Diisi',
                'hargaJual.integer'         => 'Harga Jual Harus Berupa Bilangan Bulat',
                'hargaJual.min'             => 'Harga Jual Diisi Minimal 100',
                
                'stokBarang.required'       => 'Stok Barang Harus Diisi',
                'stokBarang.integer'        => 'Stok Barang Harus Berupa Bilangan Bulat',
                'stokBarang.min'            => 'Stok Barang Diisi Minimal 1',
                
                'uploadImage.required'      => 'Harap Pilih File',
                'uploadImage.image'         => 'File Harus Berupa Gambar',
                'uploadImage.mimes'         => 'Extensi File Harus jpeg,png,jpg',
                'uploadImage.max'           => 'Size File Harus Tidak Lebih Dari 100KB',
            ];
            $validator = Validator::make($request->all(), [
                'kategori'          => 'required|in:'.$inKategories.'',
                'namaBarang'        => 'required|not_in:'.$inProduk.'',
                'hargaBeli'         => 'required|integer|min:100',   
                'hargaJual'         => 'required|integer|min:100',
                'stokBarang'        => 'required|integer|min:1',
                'uploadImage'       => 'required|image|mimes:jpeg,png,jpg|max:100',
            ], $messages);
    
            if($validator->fails()) {
                $allErrors = $validator->errors();
                return redirect()->back()->withInput()->withErrors($allErrors);
            }
            $kategori               = $request->input('kategori');
            $namaBarang             = $request->input('namaBarang');
            $hargaBeli              = $request->input('hargaBeli');
            $hargaJual              = $request->input('hargaJual');
            $stokBarang             = $request->input('stokBarang');
            $uploadImage            = $request->file('uploadImage');   
            $namaFile               = $uploadImage->getClientOriginalName();
            $insertProduks          = $this->produksFunction->insertProduk($namaFile, $namaBarang, $kategori, $hargaBeli, $hargaJual, $stokBarang);
            if($insertProduks > 0) {
                if($request->file('uploadImage')->move(public_path('CMS Assets'), $namaFile)) {
                    session()->flash('success', 'Berhasil Menambahkan Data Produk');
                    return redirect()->back();
                }
            } else {
                session()->flash('fail', 'Berhasil Menambahkan Data Produk');
                return redirect()->back();
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getProduksByKategori(Request $request) {
        $kategoriSelected = $request->input('kategori');
        $produks['produks'] = $this->produksFunction->getProduksByKategori($kategoriSelected);
        return response()->json($produks);
    }

    
    public function editProses(Request $request) {
        $messages  = [
            'hargaBeli.required'        => 'Harga Beli Harus Diisi',
            'hargaBeli.integer'         => 'Harga Beli Harus Berupa Bilangan Bulat',
            'hargaBeli.min'             => 'Harga Beli Diisi Minimal 100',

            'hargaJual.required'        => 'Harga Jual Harus Diisi',
            'hargaJual.integer'         => 'Harga Jual Harus Berupa Bilangan Bulat',
            'hargaJual.min'             => 'Harga Jual Diisi Minimal 100',
            
            'stokBarang.required'       => 'Stok Barang Harus Diisi',
            'stokBarang.integer'        => 'Stok Barang Harus Berupa Bilangan Bulat',
            'stokBarang.min'            => 'Stok Barang Diisi Minimal 1'
        ];
        $validator = Validator::make($request->all(), [
            'hargaBeli'         => 'required|integer|min:100',   
            'hargaJual'         => 'required|integer|min:100',
            'stokBarang'        => 'required|integer|min:1'
        ], $messages);

        if($validator->fails()) {
            $allErrors = $validator->errors();
            return redirect()->back()->withInput()->withErrors($allErrors);
        }
        $id                     = $request->input('id');
        $kategori               = $request->input('kategori');
        $hargaBeli              = $request->input('hargaBeli');
        $hargaJual              = $request->input('hargaJual');
        $stokBarang             = $request->input('stokBarang');

        $updateBarang           = $this->produksFunction->editProduk($id, $kategori, $hargaBeli, $hargaJual, $stokBarang);
        if($updateBarang > 0) {
            session()->flash('update', 'Berhasil Ubah Data');
            return redirect()->back();
        } else {
            session()->flash('fail', 'Gagal Melakukan Update Data');
            return redirect()->back();
        }
    }
}
