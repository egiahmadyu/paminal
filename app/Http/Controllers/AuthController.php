<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
  public function index()
  {
    $data = [
      'login' => true,
      'title' => 'SIGN IN'
    ];
    return view('auth.login', $data);
  }

  public function loginAction(Request $request)
  {

    try {
      //code...
      $request->validate([
        'username' => 'required',
        'password' => 'required',
      ]);

      $check = Auth::attempt(['username' => $request->username, 'password' => $request->password]);

      if ($check) {
        $request->session()->regenerate();

        if ($request->password == '123456') {
          $user = User::where('username', $request->username)->first();
          return redirect()->route('reset.password', ['user_id' => $user->id])->with('error', 'HARAP UBAH KATA SANDI ANDA.');
        }

        return redirect()->route('dashboard')->with('info', 'BERHASIL MASUK.');
      } else {
        return back()->with('warning', 'USERNAME / KATA SANDI SALAH.');
      }
    } catch (\Exception $e) {
      return back()->with('error', $e->getMessage());
    }
  }

  public function resetPassword($user_id = null)
  {
    $user_id = base64_decode($user_id);
    $data = [
      'login' => true,
      'user_id' => $user_id,
      'title' => 'RESET PASSWORD'
    ];
    return view('auth.reset_password', $data);
  }

  public function storeReset(Request $request, $id)
  {
    if ($request->password == '123456') {
      return back()->with('error', 'GAGAL MENGGANTI KATA SANDI.');
    }

    try {
      $id = base64_decode($id);

      $rules = [
        'password' => ['required', 'min:8'],
      ];

      $validator = Validator::make(['password' => $request->password], $rules);
      if ($validator->fails()) {

        // get the error messages from the validator
        $messages = $validator->messages();
        $messages = $messages->messages();

        // redirect our user back to the form with the errors from the validator
        return back()->with('error', $messages['password']->password);
      }

      $user = User::find($id);
      if ($user) {
        # code...
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect('/')->with('success', 'BERHASIL MENGUBAH KATA SANDI.');
      } else {
        return back()->with('error', 'USER TIDAK DITEMUKAN.');
      }
    } catch (\Exception $e) {
      return back()->with('error', $e->getMessage());
    }
  }

  public function logout()
  {
    Auth::logout();
    return redirect()->route('login')->with('info', 'ANDA TELAH KELUAR.');
  }
}
