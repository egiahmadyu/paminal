<?php

namespace App\Http\Controllers;

use App\Models\Polda;

class PoldaController extends Controller
{
    public function getAllPolda()
    {
        $data['poldas'] = Polda::all();
        return view('pages.data_pelanggaran.select-polda', $data);
    }
}
