<?php

namespace App\Http\Controllers;

use App\Models\DataAnggota;
use App\Models\Datasemen;
use App\Models\Pangkat;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AnggotaController extends Controller
{

    public function listAnggota()
    {
        $data['pangkat'] = Pangkat::orderBy('id')->get();
        $data['title'] = 'LIST ANGGOTA';
        return view('pages.data_anggota.list-anggota', $data);
    }

    public function getAnggota()
    {

        $query = DataAnggota::get();

        return DataTables::of($query)
            ->editColumn('pangkat', function ($query) {
                $pangkat = Pangkat::where('id', $query->pangkat)->first();
                $pangkat = $pangkat->alias;
                return $pangkat;
            })
            ->addColumn('action', function ($query) {
                $roles = auth()->user()->roles()->get();
                $roles = $roles[0];
                if ($roles->name == 'admin' || $roles->name == 'operator') {
                    $btn_edit = '<button type="button" class="btn" onclick="editAnggota(' . $query->id . ')"><i class="fa fa-edit text-warning"></i></button>';
                    $btn_delete = '<button type="button" class="btn" onclick="deleteAnggota(' . $query->id . ')"><i class="fa fa-trash text-danger"></i></button>';
                } else {
                    $btn_edit = '';
                    $btn_delete = '';
                }

                $button = '<div class="btn-group" role="group">';
                $button .= $btn_edit;
                $button .= $btn_delete;
                $button .= '</div>';
                return $button;
            })
            ->rawColumns(['pangkat', 'action'])
            ->make(true);
    }

    public function tambahAnggota(Request $request)
    {
        // dd($anggota);
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
        $anggota = DataAnggota::where('id', $id)->first();
        $pangkat = Pangkat::all();

        $result = response()->json([
            'status' => 200,
            'anggota' => $anggota,
            'pangkat' => $pangkat,
        ]);

        return $result;
    }

    public function updateAnggota(Request $request, $id)
    {
        DataAnggota::where('id', $id)->update([
            'nama' => $request->nama,
            'pangkat' => $request->pangkat,
            'nrp' => $request->nrp,
            'jabatan' => $request->jabatan,
        ]);
        return redirect()->route('list.anggota')->with('success', 'Berhasil Diupdate !');
    }

    public function deleteAnggota($id)
    {
        $anggota = DataAnggota::find($id);
        $kadens = Datasemen::where('kaden', $anggota->id)->first();
        $wakadens = Datasemen::where('wakaden', $anggota->id)->first();

        if ($kadens) {
            return response()->json([
                'status' => 500,
                'success' => false,
                'message' => 'Anggota merupakan Ka. ' . $kadens->name . ', mohon ubah jabatan Ka. ' . $kadens->name . ' terlebih dahulu'
            ]);
        }

        if ($wakadens) {
            return response()->json([
                'status' => 500,
                'success' => false,
                'message' => 'Anggota merupakan Wakil Ka. ' . $wakadens->name . ', mohon ubah jabatan Wakil Ka. ' . $wakadens->name . ' terlebih dahulu'
            ]);
        }

        $anggota->delete();

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Data berhasil terhapus...'
        ]);
    }
}
