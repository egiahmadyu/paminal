<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
  public function loginAction(Request $request)
  {

    $credentials = $request->validate([
      'username' => ['required'],
      'password' => ['required'],
    ]);

    $check = Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password']]);

    if ($check) {
      $request->session()->regenerate();

      if ($request->password == '123456') {
        $user = User::where('username', $request->username)->first();
        return redirect()->route('reset.password', ['user_id' => $user->id])->with('error', 'Harap ubah password anda !');
      }

      return redirect()->intended('/');
    } else {
      return back()->with('error', 'Login Failed');
    }
  }

  public function resetPassword(?int $user_id = null)
  {
    return view('auth.reset_password', compact('user_id'));
  }

  public function storeReset(Request $request)
  {
    if ($request->password == '123456') {
      return back()->with('error', 'Gagal mengganti password');
    }

    try {
      $user = User::find($request->user_id);
      $user->password = bcrypt($request->password);
      $user->save();

      return redirect()->route('login')->with('success', 'Berhasil merubah password !');
    } catch (\Exception $e) {
      return back()->with('error', $e->getMessage());
    }
  }

  public function logout()
  {
    Auth::logout();
    return redirect('/login');
  }
}
