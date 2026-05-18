<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isStudent()) {
            return redirect()->route('student.dashboard');
        } elseif ($user->isDepartmentAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isSuperAdmin()) {
            return redirect()->route('superadmin.dashboard');
        }

        return redirect()->route('login');
    }
}
