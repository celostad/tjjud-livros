<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class RelatorioController extends Controller
{
    public function index(): View
    {
        $dados = DB::table('vw_relatorio_livros_por_autor')
            ->get()
            ->groupBy('CodAu');

        return view('relatorio.index', compact('dados'));
    }

    public function pdf()
    {
        $dados = DB::table('vw_relatorio_livros_por_autor')
            ->get()
            ->groupBy('CodAu');

        $pdf = Pdf::loadView('relatorio.pdf', compact('dados'))
            ->setPaper('a4', 'landscape')
            ->setOptions([
                'defaultFont' => 'DejaVu Sans',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => false,
            ]);

        return $pdf->stream('relatorio-livros-por-autor.pdf');
    }
}
