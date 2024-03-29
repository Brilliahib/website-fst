<?php

use App\Models\Post;
use App\Models\Bidang;
use App\Models\Anggota;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardPostController;
use App\Http\Controllers\DashboardPagesController;
use App\Http\Controllers\DashboardBidangController;

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

Route::get('/', function () {
    return view('home', [
        "title" => "Forum Studi Teknik (FST)"
    ]);
});

Route::get('/profile', function () {
    return view('profile', [
        "title" => "Profile - Forum Studi Teknik (FST)"
    ]);
});

Route::get('/blog', [PostController::class, 'index']);

// SINGLE POST
Route::get('blog/{post:slug}', [PostController::class, 'show']);

Route::get('/prestasi', function () {
    return view('prestasi', [
        "title" => "Prestasi - Forum Studi Teknik (FST)"
    ]);
});

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/register', [RegisterController::class, 'index']);
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/dashboard', function () {
    return view('dashboard.index');
})->middleware('auth');

Route::resource('/dashboard/posts', DashboardPostController::class)->middleware('auth');
Route::resource('/dashboard/pages', DashboardPagesController::class)->middleware('auth');
Route::resource('/dashboard/bidang-kabinet', DashboardBidangController::class)->middleware('auth');
Route::get('/dashboard/posts/checkSlug/{title?}', [DashboardPostController::class, 'checkSlug'])->middleware('auth');

Route::get('/pages/{pages:slug}', [PageController::class, 'index']);
Route::get('pages/{id}', [PostController::class, 'show']);
Route::get('/categories/{category:slug}', function (Category $category) {
    return view('category', [
        'title' => $category->name,
        'posts' => $category->posts,
        'category' => $category->name
    ]);
});

Route::get('/pages/bidang-kabinet/{bidang:slug}', function (Bidang $bidang) {
    return view('bidang', [
        'title' => $bidang->name,
        'anggota' => $bidang->anggota,
        'bidang' => $bidang->name
    ]);
});

Route::put('/dashboard/bidang-kabinet/{anggota:id}', 'DashboardBidangController@update');




