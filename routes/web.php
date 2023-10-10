<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SellController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;

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
    return view('welcome');
})->name('welcome');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/caisse', [SellController::class, 'index'])->name('dashboard');

    Route::resource('articles', ArticleController::class);
    Route::resource('categories', CategoryController::class);

    Route::get('/cart', [SellController::class, 'cart'])->name('cart.index');
    Route::post('/cart/{article}', [SellController::class, 'addToCart'])->name('cart.add');
    Route::delete('/cart/{article}', [SellController::class, 'removeFromCart'])->name('cart.remove');

});

// index affiche la liste des ventes actives.
// create affiche le formulaire de création d'une nouvelle vente.
// store crée une nouvelle vente dans la base de données à partir des données du formulaire.
// show affiche les détails d'une vente spécifique.
// edit affiche le formulaire de modification d'une vente existante.
// update met à jour une vente existante dans la base de données à partir des données du formulaire.
// destroy supprime une vente de la base de données.