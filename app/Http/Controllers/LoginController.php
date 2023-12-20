<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index()
    {
        if(empty(Auth::user())){
            return view('auth.login');
        }else{
            return redirect()->route('home');
        }
    }

    public function checkLogin(Request $request)
    {
        $akun = $request->input('email');
        $password = $request->input('password');

        $validator = Validator::make($request->all(), [
            'email' => 'required|string',
            'password' => 'required|string',
        ], [
            'email.required' => 'Email harus diisi',
            'password.required' => 'Password harus diisi',
        ]);

        if ($validator->fails()) {
            return redirect()->route('manage.login')->with('messages', ['status' => 'danger', 'desc' => $validator->errors()->first()]);
        }

        $user = User::where('username', $akun)->orWhere('email', $akun)->whereNotNull('email_verified_at')->first();

        if($user){
            if (Hash::check($password, $user->password)) {
                Auth::login($user);
                return redirect()->route('home');
            }else{
                $desc = 'Login gagal. Cek kembali username/email dan password Anda.';
                return redirect()->route('manage.login')->with('messages', ['status' => 'danger', 'desc' => $desc]);
            }
        }else{
            $desc = 'Akun yang anda inputkan tidak tersedia/silahkan verifikasi email anda terlebih dahulu.';
            return redirect()->route('manage.login')->with('messages', ['status' => 'danger', 'desc' => $desc]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('manage.login');
    }
}
