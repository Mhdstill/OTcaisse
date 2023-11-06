<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SellController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::resource('articles', ArticleController::class);
    Route::resource('categories', CategoryController::class);

    Route::get('/caisse', [SellController::class, 'index'])->name('dashboard');
    Route::post('/add-to-cart/{article}', [SellController::class, 'add'])->name('add');
    Route::post('/remove-from-cart/{article}', [SellController::class, 'remove'])->name('remove')->middleware('auth');
    Route::post('/update-cart/{article}', [SellController::class, 'update'])->name('update')->middleware('auth');
    Route::get('/confirm-purchase', [SellController::class, 'confirm'])->name('confirm')->middleware('auth');
    Route::post('/store-purchase', [SellController::class, 'store'])->name('store')->middleware('auth');
    Route::get('/success', function () {
        return view('success');
    })->name('success');
});

// index affiche la liste des ventes actives.
// create affiche le formulaire de création d'une nouvelle vente.
// store crée une nouvelle vente dans la base de données à partir des données du formulaire.
// show affiche les détails d'une vente spécifique.
// edit affiche le formulaire de modification d'une vente existante.
// update met à jour une vente existante dans la base de données à partir des données du formulaire.
// destroy supprime une vente de la base de données.