<?php

namespace App\Http\Controllers;

use App\Models\Datasemen;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $datasemens = Datasemen::all();
        $units = Unit::where('datasemen', 1)->get();

        $data = [
            'users' => User::all(),
            'roles' => Role::all(),
            'datasemens' => $datasemens,
            'units' => $units,
            'title' => 'SETTING - USERS',
        ];

        return view('pages.user.index', $data);
    }

    public function store(Request $request)
    {
        try {
            $role = Role::find($request->role);
            $user = User::create([
                'name' => $request->name,
                'username' => strtolower($request->username),
                'password' => bcrypt('Paminal123456'),
                'jabatan' => $request->jabatan,
                'datasemen' => $request->datasemen,
                'unit' => $request->unit
            ]);
            $user->assignRole($role);

            return redirect()->back()->with('success', 'Success Create User');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Failed Create User');
        }
    }

    public function edit($id)
    {
        $user = User::find($id);
        $datasemens = Datasemen::all();
        $datasemen = $datasemens->find($user->datasemen);
        $data = [
            'user' => $user,
            'all_datasemen' => $datasemens,
            'password' => bcrypt('Paminal123456'),
            'datasemen' => $datasemen,
        ];

        return response()->json([
            'status' => JsonResponse::HTTP_OK,
            'message' => 'OK!',
            'data' => $data,
        ]);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if ($user) $user->delete();
        else return redirect()->back()->with('error', 'Data not Found!');
        return redirect()->back()->with('success', 'Success!');
    }
}
