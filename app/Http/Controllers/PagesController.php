<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produks;

class PagesController extends Controller
{
    protected $produksFunction;

    public function __construct() {
        $this->produksFunction = new Produks();
    }

    public function index(Request $request)
    {
        return view('dashboard'); // Tampilkan halaman dashboard
    }

    
    public function createBarang(){
        return view('pages/createBarang');
    }
    
    public function profile(){
        return view('pages/profile');
    }

    
    public function editProduk($id){
        $produks    = $this->produksFunction->getProduksById($id);

        $data['produks']    = $produks;
        return view('pages/editBarang', $data);
    }
}
