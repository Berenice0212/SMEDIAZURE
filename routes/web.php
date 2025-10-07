<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MunicipioController;
use App\Http\Controllers\LocalidadController;
use App\Http\Controllers\EstadoEnergiaController;
use App\Http\Controllers\DispositivoController;
use App\Http\Controllers\UbicacionAntenaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\ReportePrincipalController;
use App\Http\Controllers\SubreporteController;
use App\Http\Controllers\SubreporteMediaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('homepage.homepage');
});


/*Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');*/
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Reporte principal (admin)
    Route::resource('reporte-principal', ReportePrincipalController::class)
        ->only(['index','create','store','show','edit','update']);

    // Subreportes (técnico)
    Route::post('reporte-principal/{reporte}/subreportes', [SubreporteController::class, 'store'])
        ->name('subreportes.store');

    // Subida de archivos para un subreporte
    Route::post('subreportes/{subreporte}/medias', [SubreporteMediaController::class, 'store'])
        ->name('subreporte.medias.store');
});

Route::resource('municipios', MunicipioController::class);
Route::resource('localidades', LocalidadController::class);
Route::resource('estado-energia', EstadoEnergiaController::class);
Route::resource('dispositivos', DispositivoController::class);
Route::resource('ubicacion_antenas', UbicacionAntenaController::class);

Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');

Route::resource('reportes', ReporteController::class);


require __DIR__.'/auth.php';
