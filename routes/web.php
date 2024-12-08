<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ProdukController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/loginProses', [AuthController::class, 'loginProses'])->name('loginProses');
Route::get('/logout/{id}', [AuthController::class, 'logout'])->name('logout');



Route::middleware(['token'])->group(function () {
    Route::get('/', [PagesController::class, 'index'])->name('home');
    Route::get('/dashboard', [PagesController::class, 'index'])->name('dashboard');
    Route::get('/profile', [PagesController::class, 'profile'])->name('profile');
    Route::get('/createBarang', [PagesController::class, 'createBarang'])->name('createBarang');

    Route::get('/getKategori', [KategoriController::class, 'getKategori'])->name('getKategori');
    Route::get('/getProduks', [ProdukController::class, 'getProduks'])->name('getProduks');
    Route::post('/getProduksByKategori', [ProdukController::class, 'getProduksByKategori'])->name('getProduksByKategori');
    Route::post('/tambahProduk', [ProdukController::class, 'tambahProduk'])->name('tambahProduk');
    Route::post('/deleteProduk', [ProdukController::class, 'deleteProduk'])->name('deleteProduk');

    
    Route::get('/editProduk/{id}', [PagesController::class, 'editProduk'])->name('editProduk');
    Route::post('/editProses', [ProdukController::class, 'editProses'])->name('editProses');
});