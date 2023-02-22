<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use PhpOffice\PhpWord\TemplateProcessor;

class LimpahPoldaController extends Controller
{
    public function generateLimpahPolda(Request $request)
    {
        // dd($request->all());
        $data['ticketDesc'] = $request->ticketDesc;
        $pdf =  PDF::setOptions(['isRemoteEnabled' => TRUE])
        ->setPaper('A4', 'potrait')
        ->loadView('pages.data_pelanggaran.generate.limpah-polda', $data);

        return $pdf->download('limpah-polda.pdf');
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


    public function downloadDisposisi($type)
    {
        if ($type == 1) $template_document = new TemplateProcessor(storage_path('template_surat/lembar_disposisi_kabagbinpam.docx'));
        elseif ($type == 2) $template_document = new TemplateProcessor(storage_path('template_surat/lembar_disposisi_kabagbinpam.docx'));
        elseif ($type == 3) $template_document = new TemplateProcessor(storage_path('template_surat/lembar_disposisi_kabagbinpam.docx'));

        $template_document->saveAs(storage_path('template_surat/surat-disposisi.docx'));

        return response()->download(storage_path('template_surat/surat-disposisi.docx'))->deleteFileAfterSend(true);
    }
}