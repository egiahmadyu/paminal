<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $data['roles'] = Role::all();
        $data['title'] = 'SETTING - ROLES';

        return view('pages.role.index', $data);
    }

    public function save(Request $request)
    {
        Role::create(['name' => strtolower($request->name)]);
        return redirect()->back();
    }

    public function edit(Request $request, $id)
    {
        $role = Role::find($id);

        if ($role) {
            $result = response()->json([
                'status' => 200,
                'message' => 'success',
                'role' => $role,
            ]);
        } else {
            return response()->json([
                'status' => 200,
                'success' => false,
                'message' => 'DATA TIDAK DITEMUKAN...'
            ]);
        }

        return $result;
    }

    public function update(Request $request, $id)
    {
        $role = Role::find($id);

        if ($role) {
            $role->update([
                'name' => $request->name
            ]);
            return redirect()->back()->with("success", "DATA BERHASIL DIUPDATE !");
        } else {
            return redirect()->back()->with("success", "DATA TIDAK DITEMUKAN !");
        }
    }

    public function delete($id)
    {
        $role = Role::find($id);

        if ($role) {
            $role->delete();
            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => 'DATA BERHASIL TERHAPUS...'
            ]);
        } else {
            return response()->json([
                'status' => 200,
                'success' => false,
                'message' => 'DATA TIDAK DITEMUKAN...'
            ]);
        }
    }

    public function permission($id)
    {
        $data['role'] = Role::find($id);
        $data['permissions'] = Permission::all();
        $data['title'] = 'SETTING - PERMISSION';
        $data['myPermissions'] = $data['role']->getAllPermissions()->pluck('name')->toarray();
        return view('pages.role.permission', $data);
    }

    public function savePermission(Request $request, $id)
    {
        $role = Role::find($id);
        $role->syncPermissions($request->permissions);

        return redirect()->back()->with('success', 'Update Permission Success!');
        return redirect()->back();
    }
}
