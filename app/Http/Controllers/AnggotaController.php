<?php

namespace App\Http\Controllers;

use App\Models\DataAnggota;
use App\Models\Pangkat;
use Illuminate\Http\Request;
use DataTables;

class AnggotaController extends Controller
{

    public function listAnggota()
    {
        $data['pangkat'] = Pangkat::orderBy('id')->get();
        return view('pages.data_anggota.list-anggota', $data);
    }

    public function getAnggota()
    {
        $query = DataAnggota::get();

        return DataTables::of($query)
            ->addColumn('DT_RowIndex', function ($query) {
                return $query->id;
            })
            ->editColumn('pangkat', function ($query) {
                $pangkat = Pangkat::where('id', $query->pangkat)->first();
                $pangkat = $pangkat->name;
                return $pangkat;
            })
            ->addColumn('action', function ($query) {
                $edit_button = '<a type="button" class="btn" data-bs-toggle="modal" data-bs-target="#editAnggota"><i class="fa fa-edit text-warning"></i></a>';
                $delete_url = route('delete.anggota', ['id' => $query->id]);
                $button = '';
                $button .= '<div class="btn-group" role="group">';
                $button .= $edit_button;
                $button .= '<a class="btn" onclick="deleteAnggota(' . $query->id . ')" href="#"><i class="fa fa-trash text-danger"></i></a>';
                $button .= '</div>';
                return $button;
            })
            ->rawColumns(['DT_RowIndex', 'pangkat', 'action'])
            ->make(true);
    }

    public function tambahAnggota(Request $request)
    {
        foreach ($request->pangkat as $key => $value) {
            DataAnggota::create([
                'nama' => $request->nama[$key],
                'pangkat' => $request->pangkat[$key],
                'nrp' => $request->nrp[$key],
                'jabatan' => $request->jabatan[$key],
                'unit' => ' ',
                'datasemen' => ' '
            ]);
        }

        return redirect()->route('list.anggota');
    }

    public function editAnggota(Request $request, $id)
    {
        return redirect()->route('list.anggota');
    }

    public function deleteAnggota($id)
    {
        $anggota = DataAnggota::where('id', $id)->first();
        return redirect()->route('list.anggota');
    }
}
