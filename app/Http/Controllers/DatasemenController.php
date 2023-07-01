<?php

namespace App\Http\Controllers;

use App\Models\Datasemen;
use App\Models\Penyidik;
use Illuminate\Http\Request;

class DatasemenController extends Controller
{
    public function listDatasemen()
    {
        $datasemen = Datasemen::get();
        $units = array();
        $data = [
            'datasemen' => $datasemen,
            'unit' => $units,
        ];
        return view('pages.datasemen.list-datasemen',$data);
    }

    public function tambahDatasemen()
    {
        return view('datasemen.tambah-datasemen');
    }

    public function storeDatasemen(Request $request)
    {
        return view('datasemen.list-datasemen');
    }

    public function editDatasemen($id)
    {
        return view('datasemen.edit-datasemen');
    }

    public function updateDatasemen(Request $request, $id)
    {
        return view('datasemen.list-datasemen');
    }

    public function deleteDatasemen($id)
    {
        return view('datasemen.list-datasemen');
    }
}
