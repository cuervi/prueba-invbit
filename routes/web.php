<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

/*
 * |--------------------------------------------------------------------------
 * | Web Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register web routes for your application. These
 * | routes are loaded by the RouteServiceProvider within a group which
 * | contains the "web" middleware group. Now create something great!
 * |
 */

// Route::get('/', function () {
// return view('welcome');
// });

Route::get('/', [IndexController::class,'index']);
Route::get('/crear-usuario', [IndexController::class,'createView'])->name('testuser.create-view');
Route::get('/editar-usuario/{user}', [IndexController::class,'editView'])->name('testuser.edit-view');

Route::post('/create', [IndexController::class, 'create'])->name('testuser.create');
Route::post('/edit', [IndexController::class, 'edit'])->name('testuser.edit');
Route::post('/delete', [IndexController::class, 'delete'])->name('testuser.delete');