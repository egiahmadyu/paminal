<?php

namespace App\Http\Controllers;

use App\Models\DataAnggota;
use App\Models\Datasemen;
use App\Models\Pangkat;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class DatasemenController extends Controller
{
    public function listDatasemen()
    {
        $data['title'] = 'LIST BAG / DEN';
        return view('pages.datasemen.list-datasemen', $data);
    }

    public function getDatasemen()
    {
        $query = Datasemen::get();

        return DataTables::of($query)
            ->editColumn('kaden', function ($query) {
                $anggota = DataAnggota::where('id', $query->kaden)->first();
                $pangkat = Pangkat::where('id', $anggota->pangkat)->first();
                if ($pangkat) {
                    $kaden = $pangkat->name . ' ' . $anggota->nama;
                } else {
                    $kaden = $anggota->nama;
                }

                return $kaden;
            })
            ->editColumn('wakaden', function ($query) {
                $anggota = DataAnggota::where('id', $query->wakaden)->first();
                $pangkat = Pangkat::where('id', $anggota->pangkat)->first();
                if ($pangkat) {
                    $wakaden = $pangkat->name . ' ' . $anggota->nama;
                } else {
                    $wakaden = $anggota->nama;
                }

                return $wakaden;
            })
            ->addColumn('action', function ($query) {
                $user = Auth::getUser();
                $role = $user->roles->first();
                if ($role->name == 'admin') {
                    $btn_edit = '<a class="btn" href="' . route('edit.datasemen', $query->id) . '"><i class="fa fa-edit text-warning"></i></a>';
                    $btn_delete = '<button type="button" class="btn" onclick="deleteDatasemen(' . $query->id . ')"><i class="fa fa-trash text-danger"></i></button>';
                } else {
                    $btn_edit = '';
                    $btn_delete = '';
                }

                $button = '';
                $button .= '<div class="btn-group" role="group">';
                $button .= $btn_edit;
                $button .= $btn_delete;
                $button .= '</div>';
                return $button;
            })
            ->rawColumns(['kaden', 'wakaden', 'action'])
            ->make(true);
    }

    public function tambahDatasemen()
    {

        $pangkat = Pangkat::get();
        $anggota = DataAnggota::get();
        $url = route('store.datasemen');
        $data = [
            'anggota' => $anggota,
            'pangkat' => $pangkat,
            'url' => $url,
            'title' => 'TAMBAH BAG / DEN',
        ];
        return view('pages.datasemen.tambah-datasemen', $data);
    }

    public function storeDatasemen(Request $request)
    {
        $datasemen = Datasemen::get();

        $valInput = preg_replace('/\s+/', '', $request->nama_datasemen);

        foreach ($datasemen as $key => $valDatasemen) {
            $valDat = preg_replace('/\s+/', '', $valDatasemen->name);

            if (strtoupper($valDat) == strtoupper($valInput)) {
                return redirect()->back()->withInput()->with('error', 'Nama Bag / Den sudah dibuat !');
            }
        }

        if ($request->kaden == $request->wakaden) {
            return redirect()->back()->withInput()->with('error', 'Kepala tidak boleh sama dengan Wakil Kepala !');
        }

        Datasemen::create([
            'name' => $request->nama_datasemen,
            'kaden' => $request->kaden,
            'wakaden' => $request->wakaden
        ]);

        DataAnggota::where('id', $request->kaden)->update([
            'jabatan' => 'KEPALA ' . $request->nama_datasemen,
            'datasemen' => $request->datasemen
        ]);

        DataAnggota::where('id', $request->wakaden)->update([
            'jabatan' => 'WAKIL KEPALA. ' . $request->nama_datasemen,
            'datasemen' => $request->datasemen
        ]);
        return redirect()->route('list.datasemen')->with('success', 'Berhasil Dibuat !');
    }

    public function editDatasemen($id)
    {
        $datasemen = Datasemen::where('id', $id)->first();
        $kaden = DataAnggota::where('id', $datasemen->kaden)->first();
        $wakaden = DataAnggota::where('id', $datasemen->wakaden)->first();
        $anggota = DataAnggota::get();
        $pangkat = Pangkat::get();
        $url = route('update.datasemen', ['id' => $id]);
        $data = [
            'datasemen' => $datasemen,
            'pangkat' => $pangkat,
            'kaden' => $kaden,
            'wakaden' => $wakaden,
            'anggota' => $anggota,
            'url' => $url,
            'title' => 'EDIT BAG / DEN',
        ];
        return view('pages.datasemen.tambah-datasemen', $data);
    }

    public function updateDatasemen(Request $request, $id)
    {
        if ($request->kaden == $request->wakaden) {
            return redirect()->back()->withInput()->with('error', 'Kepala Datasemen tidak boleh sama dengan Wakil Datasemen !');
        }

        $kaden = DataAnggota::where('id', $request->kaden)->first();
        if ($kaden) {
            $kaden->jabatan = 'KEPALA ' . $request->nama_datasemen;
            $kaden->update();
        }

        $wakaden = DataAnggota::where('id', $request->wakaden)->first();
        if ($wakaden) {
            $wakaden->jabatan = 'WAKIL KEPALA ' . $request->nama_datasemen;
            $wakaden->update();
        }

        $datasemen = Datasemen::where('id', $id)->first();
        $datasemen->update([
            'name' => $request->nama_datasemen,
            'kaden' => $kaden->id,
            'wakaden' => $wakaden->id,
        ]);

        return redirect()->route('list.datasemen')->with('success', 'Berhasil Diupdate !');
    }

    public function deleteDatasemen($id)
    {
        Datasemen::find($id)->delete();

        $result = response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Berhasil dihapus !'
        ]);

        return $result;
    }

    public function unitDatasemen()
    {
        $datasemen = Datasemen::all();
        $units = Unit::all();
        $data = [
            'datasemen' => $datasemen,
            'unit' => $units,
            'title' => 'UNIT BAG / DEN',
        ];
        return view('pages.datasemen.unit-datasemen', $data);
    }

    public function getUnit()
    {
        $query = Unit::get();

        return DataTables::of($query)
            ->editColumn('datasemen', function ($query) {
                $datasemen = Datasemen::where('id', $query->datasemen)->first();
                $datasemen = $datasemen->name;
                return $datasemen;
            })
            ->addColumn('action', function ($query) {
                $btn_detail = '<a type="button" class="btn" href="/detail-unit/' . $query->id . '"><i class="far fa-eye text-info"></i></a>';
                $btn_edit = '<button type="button" class="btn" onclick="editUnit(' . $query->id . ')"><i class="fa fa-edit text-warning"></i></button>';
                $btn_delete = '<button type="button" class="btn" onclick="deleteUnit(' . $query->id . ')"><i class="fa fa-trash text-danger"></i></button>';

                $button = '<div class="btn-group" role="group">';
                $button .= $btn_detail;
                $button .= $btn_edit;
                $button .= $btn_delete;
                $button .= '</div>';
                return $button;
            })
            ->rawColumns(['datasemen', 'action'])
            ->make(true);
    }

    public function storeUnit(Request $request)
    {
        $units = Unit::get();
        foreach ($units as $key => $val) {
            $datasemen = Datasemen::where('id', $val->datasemen)->first();
            if ($val->unit == $request->nama && $val->datasemen == $request->datasemen) {
                return redirect()->back()->withInput()->with('error', $val->name . ' ' . $datasemen->name . ' sudah dibuat !');
            }
        }

        Unit::create([
            'unit' => $request->nama,
            'datasemen' => $request->datasemen,
        ]);
        return redirect()->route('unit.datasemen')->with('success', 'Berhasil Dibuat !');
    }

    public function editUnit($id)
    {
        $unit = Unit::where('id', $id)->first();
        $datasemen = Datasemen::all();

        $result = response()->json([
            'status' => 200,
            'unit' => $unit,
            'datasemen' => $datasemen,
        ]);

        return $result;
    }

    public function deleteUnit($id)
    {
        $unit = Unit::find($id);
        $unit->delete();

        $result = response()->json([
            'status' => 200,
            'success' => true,
        ]);

        return $result;
    }

    public function updateUnit(Request $request, $id)
    {
        Unit::where('id', $id)->update([
            'unit' => $request->nama,
            'datasemen' => $request->datasemen,
        ]);
        return redirect()->route('unit.datasemen')->with('success', 'Berhasil Diupdate !');
    }

    public function detailUnit($id)
    {
        $anggota = DataAnggota::where('unit', ' ')->where('datasemen', ' ')->get();
        $unit = Unit::find($id);
        $datasemen = Datasemen::find($unit->datasemen);
        $data = [
            'datasemen' => $datasemen,
            'unit' => $unit,
            'anggota' => $anggota,
            'id_unit' => $id,
            'title' => 'LIST ANGGOTA',
        ];
        return view('pages.datasemen.detail-unit', $data);
    }

    public function getDetailUnit($id)
    {
        $query = DataAnggota::where('unit', $id);

        return DataTables::of($query)
            ->editColumn('nama', function ($query) {
                $pangkat = Pangkat::where('id', $query->pangkat)->first();
                $pangkat = $pangkat->name;
                return $pangkat . ' ' . $query->nama;
            })
            ->addColumn('action', function ($query) {
                $btn_edit = '<button type="button" class="btn" onclick="editAnggotaUnit(' . $query->id . ')"><i class="fa fa-edit text-warning"></i></button>';
                $btn_delete = '<button type="button" class="btn" onclick="deleteAnggotaUnit(' . $query->id . ')"><i class="fa fa-trash text-danger"></i></button>';

                $button = '<div class="btn-group" role="group">';
                // $button .= $btn_edit;
                $button .= $btn_delete;
                $button .= '</div>';
                return $button;
            })
            ->rawColumns(['nama', 'action'])
            ->make(true);
    }

    public function tambahAnggotaUnit(Request $request, $id)
    {
        $anggota = DataAnggota::find($request->anggota);

        $unit = Unit::find($id);
        $datasemen = Datasemen::find($unit->datasemen);

        $anggota->update([
            'unit' => $id,
            'datasemen' => $datasemen->id
        ]);

        return redirect()->route('detail.unit', ['id' => $unit->id]);
    }

    public function editAnggotaUnit($id)
    {
        $unit = Unit::where('id', $id)->first();
        $datasemen = Datasemen::all();

        $result = response()->json([
            'status' => 200,
            'unit' => $unit,
            'datasemen' => $datasemen,
        ]);

        return $result;
    }

    public function deleteAnggotaUnit($id)
    {
        $anggota = DataAnggota::find($id);

        $anggota->update([
            'unit' => ' ',
            'datasemen' => ' ',
        ]);

        $result = response()->json([
            'status' => 200,
            'success' => true,
        ]);

        return $result;
    }

    public function updateAnggotaUnit(Request $request, $id)
    {
        Unit::where('id', $id)->update([
            'unit' => $request->nama,
            'datasemen' => $request->datasemen,
        ]);
        return redirect()->route('unit.datasemen')->with('success', 'Berhasil Diupdate !');
    }
}
