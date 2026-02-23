<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{

    public function login(Request $request)
    {

        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = DB::table('users')
            ->where('email', $request->email)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'email' => 'Invalid email or password.',
            ]);
        }

        Session::put('user_id', $user->id);
        Session::put('user_role', $user->role);

        return match ($user->role) {
            'hr'        => redirect('/hr/dashboard'),
            'mentor'    => redirect('/mentor/dashboard'),
            'candidate' => redirect('/candidate/dashboard'),
            default     => redirect('/login'),
        };
    }

    public function logout(Request $request)
    {
        Session::forget(['user_id', 'user_role']);
        return redirect('/login');
    }
}
