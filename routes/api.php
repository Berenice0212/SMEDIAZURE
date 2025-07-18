<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UbicacionAntenaController;

Route::get('/ubicacion-antena', [UbicacionAntenaController::class, 'apiIndex']);