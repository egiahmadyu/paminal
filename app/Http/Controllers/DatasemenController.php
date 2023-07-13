<?php

namespace App\Http\Controllers;

use App\Models\DataAnggota;
use App\Models\Datasemen;
use App\Models\Pangkat;
use App\Models\Penyidik;
use App\Models\Unit;
use Illuminate\Http\Request;
use DataTables;

class DatasemenController extends Controller
{
    public function listDatasemen()
    {
        return view('pages.datasemen.list-datasemen');
    }

    public function unitDatasemen()
    {
        $datasemen = Datasemen::get();
        $units = array();
        $data = [
            'datasemen' => $datasemen,
            'unit' => $units,
        ];
        return view('pages.datasemen.unit-datasemen',$data);
    }

    public function getDatasemen()
    {
        $query = Datasemen::get();

        return DataTables::of($query)
            ->editColumn('kaden', function($query) {
                $anggota = DataAnggota::where('id',$query->kaden)->first();
                $pangkat = Pangkat::where('id',$anggota->pangkat)->first();
                $kaden = $pangkat->name.' '.$anggota->nama;
                return $kaden;
            })
            ->editColumn('wakaden', function($query) {
                $anggota = DataAnggota::where('id',$query->wakaden)->first();
                $pangkat = Pangkat::where('id',$anggota->pangkat)->first();
                $wakaden = $pangkat->name.' '.$anggota->nama;
                return $wakaden;
            })
            ->addColumn('action', function($query){
                $edit_url = route('edit.datasemen',$query->id);
                $delete_url = route('delete.datasemen',$query->id);
                $button = '';
                $button .= '<div class="btn-group" role="group">';
                $button .= '<a class="btn" href="'.$edit_url.'"><i class="fa fa-edit text-warning"></i></a>';
                $button .= '<a class="btn" onclick="return confirm(\'Are you sure?\')"  href="'.$delete_url.'"><i class="fa fa-trash text-danger"></i></a>';
                $button .= '</div>';
                return $button;
            })
            ->rawColumns(['kaden','wakaden','action'])
            ->make(true);
    }

    public function getUnit()
    {
        $query = Unit::get();

        return DataTables::of($query)
            ->editColumn('datasemen', function($query) {
                $datasemen = Datasemen::where('id',$query->datasemen)->first();
                $datasemen = $datasemen->name;
                return $datasemen;
            })
            // ->addColumn('action', function($query){
            //     $edit_url = route('edit.datasemen',$query->id);
            //     $delete_url = route('delete.datasemen',$query->id);
            //     $button = '';
            //     $button .= '<div class="btn-group" role="group">';
            //     $button .= '<a class="btn" href="'.$edit_url.'"><i class="fa fa-edit text-warning"></i></a>';
            //     $button .= '<a class="btn" onclick="return confirm(\'Are you sure?\')"  href="'.$delete_url.'"><i class="fa fa-trash text-danger"></i></a>';
            //     $button .= '</div>';
            //     return $button;
            // })
            ->rawColumns(['datasemen'])
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
        ];
        return view('pages.datasemen.tambah-datasemen',$data);
    }

    public function storeDatasemen(Request $request)
    {
        $den = explode(' ',$request->name);
        $pangkat = Pangkat::where('id',$request->pangkat)->first();
        $datasemen = Datasemen::get();
        foreach ($datasemen as $key => $valDatasemen) {
            if ($valDatasemen->name == $request->name) {
                return redirect()->back()->withInput()->with('error','Nama Datasemen sudah dibuat !');
            }
        }

        if ($request->kaden == $request->wakaden) {
            return redirect()->back()->withInput()->with('error','Kepala Datasemen tidak boleh sama dengan Wakil Datasemen !');
        }

        Datasemen::create([
            'name' => $request->nama_datasemen,
            'kaden' => $request->kaden,
            'wakaden' => $request->wakaden
        ]);
        return redirect()->route('list.datasemen')->with('success','Berhasil Dibuat !');
    }

    public function editDatasemen($id)
    {
        $datasemen = Datasemen::where('id',$id)->first();
        $kaden = DataAnggota::where('id',$datasemen->kaden)->first();
        $wakaden = DataAnggota::where('id',$datasemen->wakaden)->first();
        $anggota = DataAnggota::get();
        $pangkat = Pangkat::get();
        $url = route('update.datasemen',['id'=>$id]);
        $data = [
            'datasemen' => $datasemen,
            'pangkat' => $pangkat,
            'kaden' => $kaden,
            'wakaden' => $wakaden,
            'anggota' => $anggota,
            'url' => $url,
        ];
        return view('pages.datasemen.tambah-datasemen',$data);
    }

    public function updateDatasemen(Request $request, $id)
    {
        if ($request->kaden == $request->wakaden) {
            return redirect()->back()->withInput()->with('error','Kepala Datasemen tidak boleh sama dengan Wakil Datasemen !');
        }

        $den = explode(' ',$request->nama_datasemen);
        $kaden = DataAnggota::where('id',$request->kaden)->first();
        if ($kaden) {
            $kaden->jabatan = 'KADEN '.$den[1];
            $kaden->update();
        }

        $wakaden = DataAnggota::where('id',$request->wakaden)->first();
        if ($wakaden) {
            $wakaden->jabatan = 'WAKADEN '.$den[1];
            $wakaden->update();
        }

        $datasemen = Datasemen::where('id',$id)->first();
        $datasemen->update([
            'name' => $request->nama_datasemen,
            'kaden' => $kaden->id,
            'wakaden' => $wakaden->id,
        ]);

        return redirect()->route('list.datasemen')->with('success','Berhasil Diupdate !');
    }

    public function deleteDatasemen($id)
    {
        Datasemen::where('id',$id)->delete();
        return redirect()->route('list.datasemen')->with('success','Berhasil Dihapus !');
    }
}
