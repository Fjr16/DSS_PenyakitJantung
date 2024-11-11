<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DemsterRuleController;
use App\Http\Controllers\DiseaseController;
use App\Http\Controllers\SymtomController;
use App\Http\Controllers\UserController;
use App\Models\Disease;
use App\Models\Symtom;
use App\Models\User;
use Illuminate\Support\Facades\Route;

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
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $penyakit = Disease::all();
        $gejala = Symtom::all();
        $pengguna = User::all();
        return view('pages.dashboard.index', [
            'title' => 'dashboard',
            'menu' => 'dashboard',
            'penyakit' => $penyakit,
            'gejala' => $gejala,
            'pengguna' => $pengguna,
        ]);
    });


    Route::get('user', [UserController::class, 'index'])->name('user.index');
    Route::get('user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('user/store', [UserController::class, 'store'])->name('user.store');
    Route::get('user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::put('user/update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('user/destroy/{id}', [UserController::class, 'destroy'])->name('user.destroy');

    Route::get('penyakit', [DiseaseController::class, 'index'])->name('penyakit.index');
    Route::get('penyakit/create', [DiseaseController::class, 'create'])->name('penyakit.create');
    Route::post('penyakit/store', [DiseaseController::class, 'store'])->name('penyakit.store');
    Route::get('penyakit/edit/{id}', [DiseaseController::class, 'edit'])->name('penyakit.edit');
    Route::put('penyakit/update/{id}', [DiseaseController::class, 'update'])->name('penyakit.update');
    Route::delete('penyakit/destroy/{id}', [DiseaseController::class, 'destroy'])->name('penyakit.destroy');

    Route::get('gejala', [SymtomController::class, 'index'])->name('gejala.index');
    Route::get('gejala/create', [SymtomController::class, 'create'])->name('gejala.create');
    Route::post('gejala/store', [SymtomController::class, 'store'])->name('gejala.store');
    Route::get('gejala/edit/{id}', [SymtomController::class, 'edit'])->name('gejala.edit');
    Route::put('gejala/update/{id}', [SymtomController::class, 'update'])->name('gejala.update');
    Route::delete('gejala/destroy/{id}', [SymtomController::class, 'destroy'])->name('gejala.destroy');

    Route::get('demster/rule', [DemsterRuleController::class, 'index'])->name('demster/rule.index');
    Route::post('demster/rule/store', [DemsterRuleController::class, 'store'])->name('demster/rule.store');
    Route::delete('demster/rule/destroy/{id}', [DemsterRuleController::class, 'destroy'])->name('demster/rule.destroy');

});

// customer page
Route::get('/', [CustomerController::class, 'index'])->name('homepage');
Route::get('/test', [CustomerController::class, 'combineBeliefs'])->name('test');
Route::get('/diagnosa/jantung/create', [CustomerController::class, 'create'])->name('diagnosa.create');
Route::post('/diagnosa/jantung/store', [CustomerController::class, 'store'])->name('diagnosa.store');

require __DIR__.'/auth.php';
