<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        // Traemos todos los usuarios con su rol (eager loading)
        $users = User::with('role')->get();

        return view('usuarios.index', compact('users'));
    }
}
