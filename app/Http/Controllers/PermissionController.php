<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{
    public function index()
    {
        $data['permission'] = Permission::all();

        return view('pages.role.list_permission', $data);
    }

    public function getPermission()
    {
        $query = Permission::all();

        return DataTables::of($query)
            ->addColumn('name', function ($query) {
                return $query->name;
            })
            ->addColumn('guard_name', function ($query) {
                return $query->guard_name;
            })
            ->addColumn('action', function ($query) {
                $edit_button = '<a class="btn" onclick="editPermission(' . $query->id . ')" href="#"><i class="fa fa-edit text-warning"></i></a>';
                $delete_button = '<a class="btn" onclick="deletePermission(' . $query->id . ')" href="#"><i class="fa fa-trash text-danger"></i></a>';
                $delete_url = route('delete.permission', ['id' => $query->id]);


                $button = '';
                $button .= '<div class="btn-group" role="group">';
                // $button .= $edit_button;
                $button .= $delete_button;
                $button .= '</div>';
                return $button;
            })
            ->rawColumns(['name', 'guard_name', 'action'])
            ->make(true);
    }

    public function storePermission(Request $request)
    {
        Permission::create([
            'name' => $request->name,
            'guard_name' => $request->guard_name
        ]);
        return redirect()->back()->with('success', 'Successfully Add Permission!');
        return redirect()->back();
    }

    public function deletePermission($id)
    {
        $permission = Permission::find($id);
        $permission->delete();
        return redirect()->back()->with('success', 'Permission has been deleted!');
    }
}
