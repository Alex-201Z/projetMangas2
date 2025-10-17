<?php

use App\Http\Controllers\MangaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/listerMangas', [ MangaController::class, 'listMangas' ])->name('listMangas');;

Route::get('/ajouterMangas', [ MangaController::class, 'addManga' ])->name('addManga');;

Route::post('/validerMangas', [ MangaController::class, 'validManga' ])->name('validManga');;

Route::get('/editerManga/{id}', [ MangaController::class, 'editManga' ])->name('editManga');

Route::get('/supprimeManga/{id}', [ MangaController::class, 'removeManga' ])->name('removeManga');
