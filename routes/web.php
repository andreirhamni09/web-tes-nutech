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


Route::get('/login', [AuthController::class, 'index'])->name('index');
Route::post('/loginProses', [AuthController::class, 'loginProses'])->name('loginProses');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard
Route::get('/', [PagesController::class, 'index']);
Route::get('/dashboard', [PagesController::class, 'index'])->name('dashboard');

Route::get('/getKategori', [KategoriController::class, 'getKategori'])->name('getKategori');
Route::get('/getProduks', [ProdukController::class, 'getProduks'])->name('getProduks');
Route::get('/profile', [PagesController::class, 'profile'])->name('profile');
Route::get('/getProduksByKategori', [ProdukController::class, 'getProduksByKategori'])->name('getProduksByKategori');
Route::get('/createBarang', [PagesController::class, 'createBarang'])->name('createBarang');
//     $routes->post('getProduksByKategori', 'ProduksController::getProduksByKategori', ['as' => 'getProduksByKategori']);
//     $routes->get('createBarang', 'PagesController::createBarang', ['as' => 'createBarang']);





// $routes->get('', 'PagesController::index');
//     $routes->get('dashboard', 'PagesController::index');
//     $routes->get('profile', 'PagesController::profile', ['as' => 'profile']);
//     $routes->get('createBarang', 'PagesController::createBarang', ['as' => 'createBarang']);


//     $routes->get('getKategori', 'KategoriController::getKategori', ['as' => 'getKategori']);
//     $routes->get('getProduks', 'ProduksController::getProduks', ['as' => 'getProduks']);

//     $routes->post('getProduksByKategori', 'ProduksController::getProduksByKategori', ['as' => 'getProduksByKategori']);
//     $routes->post('tambahProduk', 'ProduksController::tambahProduk', ['as' => 'tambahProduk']);

//     $routes->post('deleteProduk', 'ProduksController::deleteProduk', ['as' => 'deleteProduk']);
