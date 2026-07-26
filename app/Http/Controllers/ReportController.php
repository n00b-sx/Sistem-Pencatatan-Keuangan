<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function exportPdf(Request $request)
    {
        $query = Transaction::with(['category', 'sourceAccount', 'destinationAccount', 'details']);

        // Filter Range Tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        } 
        // Filter Bulan & Tahun
        elseif ($request->filled('bulan') && $request->filled('tahun')) {
            $query->whereMonth('date', $request->bulan)
                  ->whereYear('date', $request->tahun);
        }
        // Filter Tahun Saja
        elseif ($request->filled('tahun')) {
            $query->whereYear('date', $request->tahun);
        }

        $transaksis = $query->orderBy('date', 'asc')->get();

        // Perhitungan Bagian 1: Ringkasan Umum
        $totalPemasukan = $transaksis->where('type', 'in')->sum('amount');
        $totalPengeluaran = $transaksis->where('type', 'out')->sum('amount');
        $totalMutasi = $transaksis->where('type', 'transfer')->sum('amount');
        $saldoBersih = $totalPemasukan - $totalPengeluaran;

        $periode = $this->getPeriodeLabel($request);

        $data = [
            'transaksis' => $transaksis,
            'totalPemasukan' => $totalPemasukan,
            'totalPengeluaran' => $totalPengeluaran,
            'totalMutasi' => $totalMutasi,
            'saldoBersih' => $saldoBersih,
            'periode' => $periode
        ];

        // Generate PDF
        $pdf = Pdf::loadView('reports.pdf', $data)->setPaper('a4', 'landscape');
        return $pdf->download('Laporan_Keuangan_'.date('Ymd').'.pdf');
    }
    
    private function getPeriodeLabel(Request $request)
    {
        if ($request->filled('start_date') && $request->filled('end_date')) {
            return $request->start_date . ' s/d ' . $request->end_date;
        } elseif ($request->filled('bulan') && $request->filled('tahun')) {
            return date('F', mktime(0, 0, 0, $request->bulan, 10)) . ' ' . $request->tahun;
        } elseif ($request->filled('tahun')) {
            return 'Tahun ' . $request->tahun;
        }
        return 'Semua Waktu';
    }
}
