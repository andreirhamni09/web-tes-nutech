<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategories;
use Exception;
class KategoriController extends Controller
{
    protected $kategoriFunction;
    public function __construct() {
        $this->kategoriFunction = new Kategories();
    }

    public function getKategori()
    {
        $results = $this->kategoriFunction->getKategori();
        return response()->json($results);
    }
}
