<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        // Get the authenticated user

        $user = Auth::user();
        // Get the tasks of the authenticated user

        $tasks = $user->tasks;
        return view('user.dashboard', compact('tasks'));
    }
}
