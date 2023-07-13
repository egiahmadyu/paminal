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
        return view('pages.data_anggota.list-anggota');
    }

    public function getAnggota()
    {
        $query = DataAnggota::get();

        return DataTables::of($query)
            ->addColumn('DT_RowIndex', function($query) {
                return $query->id;
            })
            ->editColumn('pangkat', function($query) {
                $pangkat = Pangkat::where('id',$query->pangkat)->first();
                $pangkat = $pangkat->name;
                return $pangkat;
            })
            // ->addColumn('action', function($query){
            //     $edit_url = route('edit.anggota',$query->id);
            //     $delete_url = route('delete.anggota',$query->id);
            //     $button = '';
            //     $button .= '<div class="btn-group" role="group">';
            //     $button .= '<a class="btn" href="'.$edit_url.'"><i class="fa fa-edit text-warning"></i></a>';
            //     $button .= '<a class="btn" onclick="return confirm(\'Are you sure?\')"  href="'.$delete_url.'"><i class="fa fa-trash text-danger"></i></a>';
            //     $button .= '</div>';
            //     return $button;
            // })
            ->rawColumns(['DT_RowIndex','pangkat'])
            ->make(true);
    }
}
