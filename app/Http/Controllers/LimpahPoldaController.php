<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class LimpahPoldaController extends Controller
{
    public function generateDocumen()
    {
        $pdf =  PDF::setOptions(['isRemoteEnabled' => TRUE])
        ->setPaper('A4', 'potrait')
        ->loadView('pages.data_pelanggaran.generate.limpah-polda');

        return $pdf->download('itsolutionstuff.pdf');
    }

    public function generateDisposisi()
    {
        return view('pages.data_pelanggaran.generate.lembar-disposisi');
        $pdf =  PDF::setOptions(['isRemoteEnabled' => TRUE])
        ->setPaper('A4', 'potrait')
        ->loadView('pages.data_pelanggaran.generate.lembar-disposisi');

        return $pdf->download('itsolutionstuff.pdf');
    }
}