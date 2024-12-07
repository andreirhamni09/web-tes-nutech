<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index()
    {
        return view('dashboard'); // Tampilkan halaman dashboard
    }
    
    public function profile(){
        return view('pages/profile');
    }
}
