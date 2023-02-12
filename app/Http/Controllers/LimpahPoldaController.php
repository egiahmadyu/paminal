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

    public function generateDisposisi(Request $request)
    {
        // return view('pages.data_pelanggaran.generate.lembar-disposisi');
        $data = [
            'tanggal' => $request->tanggal,
            'surat_dati' => $request->surat_dari,
            'nomor_surat' => $request->nomor_surat,
            'perihal' => $request->perihal,
            'nomor_agenda' => $request->nomor_agenda
        ];
        // dd($data);
        $pdf =  PDF::setOptions(['isRemoteEnabled' => TRUE])
        ->setPaper('A4', 'potrait')
        ->loadView('pages.data_pelanggaran.generate.lembar-disposisi', $data);

        return $pdf->download('itsolutionstuff.pdf');
    }
}