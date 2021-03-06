<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\JeuController;
use App\Http\Controllers\CommentaireController;
use App\Http\Controllers\UserController;

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

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth'])->get('/dashboard', [HomeController::class, 'cinqAleatoires'])->name('dashboard');

Route::middleware(['auth'])->get('/meilleurs', [HomeController::class, 'cinqMeilleurs'])->name('jeu_meilleur');

//Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/jeux/show/{id}', [JeuController::class, 'show'])->name('jeu_show');

Route::get('/jeux/rules/{id}', [JeuController::class, 'rules'])->name('jeu_rules');

Route::get('/jeux/create', [JeuController::class, 'create'])->name('jeu_create');

Route::post('/jeux/create', [JeuController::class, 'store'])->name('jeu_store')->middleware('auth');

Route::get('/jeux/{sort?}', [JeuController::class, 'index'])->name('jeu_index');

Route::get('/jeux/{filter?}/{sort?}', [JeuController::class, 'index'])
    ->where('filter', '[a-z]+')
    ->name('jeu_index');

Route::post('/commentaire/store',[CommentaireController::class,'store'])->name('commentaire_store');

//Route::get('/profil',[\App\Http\Controllers\UserController::class,'index'])->name('user_profile');

Route::post('/collection/store',[\App\Http\Controllers\AchatController::class,'store'])->name('achat_store');

Route::get('/collection/create',[\App\Http\Controllers\AchatController::class,'create'])->name('achat_create');

Route::get('/collection/all',[\App\Http\Controllers\AchatController::class,'index'])->name('achat_index');

Route::get('/enonce', function () {
    return view('enonce.index');
});

Route::prefix('users')->middleware('auth')->group(function () {
    Route::get('/profil', [UserController::class, 'index'])->name('users.profile');
    Route::get('/achat', [UserController::class, 'createAchat'])->name('users.achat');
    Route::post('/achat', [UserController::class, 'achatStore'])->name('users.achatStore');
    Route::get('/achat/supprime/{id}', [UserController::class, 'afficheAchat'])->name('users.afficheAchat');
    Route::delete('/achat/{id}', [UserController::class, 'supprimeAchat'])->name('users.supprimeAchat');
});


