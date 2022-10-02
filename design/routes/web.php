<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\AreasController;
use App\Http\Controllers\AprovacaoController;
use App\Http\Controllers\FornecedorController;
use App\Http\Controllers\SolicitacaoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::redirect('/', '/login');


// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

// Route::any('/dashboard', [PagesController::class, 'dashboard'])->middleware(['auth']);
Route::any('/testeIndex', [PagesController::class, 'getIndex'])->middleware(['auth']);
Route::any('/killSession', [PagesController::class, 'killSession'])->middleware(['auth']);

//Areas
Route::redirect('/dashboard', '/fornecedor')->middleware(['auth']);
// Route::any('/', [AreasController::class, 'getIndex'])->middleware(['auth']);
Route::any('/areas', [AreasController::class, 'getIndex'])->middleware(['auth']);
Route::any('/areas/form/{id?}', [AreasController::class, 'getForm'])->middleware(['auth']);

Route::any('/aprovacao', [AprovacaoController::class, 'getIndex'])->middleware(['auth']);
Route::any('/aprovacao/form/{id?}', [AprovacaoController::class, 'getForm'])->middleware(['auth']);
Route::any("/aprovacao/sendForm", [AprovacaoController::class, 'sendForm'])->middleware(['auth']);

Route::any('/fornecedor', [FornecedorController::class, 'getIndex'])->middleware(['auth']);
Route::any('/fornecedor/form/{id?}', [FornecedorController::class, 'getForm'])->middleware(['auth']);
Route::any("/fornecedor/sendForm", [FornecedorController::class, 'sendForm'])->middleware(['auth']);    

Route::any('/solicitacao', [SolicitacaoController::class, 'getIndex'])->middleware(['auth']);
Route::any('/solicitacao_andamento', [SolicitacaoController::class, 'getIndexAndamento'])->middleware(['auth']);
Route::any('/solicitacao/form/{id?}', [SolicitacaoController::class, 'getForm'])->middleware(['auth']);
Route::any("/solicitacao/sendForm", [SolicitacaoController::class, 'sendForm'])->middleware(['auth']);
Route::any("/solicitacao/getUsers", [SolicitacaoController::class, 'getUsers'])->middleware(['auth']);


require __DIR__.'/auth.php';
