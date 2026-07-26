@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Laporan Keuangan</h1>
    </div>

    <div class="bg-white border shadow-sm rounded-xl p-4 md:p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Ekspor Laporan PDF</h2>
        
        <form action="{{ route('laporan.pdf') }}" method="GET" class="space-y-6">
            
            <p class="text-sm text-gray-600">Pilih salah satu metode filter di bawah ini. Jika Anda tidak memilih apapun, semua transaksi akan diekspor.</p>
            
            <!-- Opsi Filter -->
            <div class="grid sm:grid-cols-2 gap-6">
                <!-- Filter Range Tanggal -->
                <div class="border rounded-lg p-4 bg-gray-50">
                    <h3 class="text-md font-medium text-gray-800 mb-3">1. Filter Range Tanggal</h3>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium mb-1">Tanggal Mulai</label>
                            <input type="date" name="start_date" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Tanggal Akhir</label>
                            <input type="date" name="end_date" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                        </div>
                    </div>
                </div>

                <!-- Filter Bulan/Tahun -->
                <div class="border rounded-lg p-4 bg-gray-50">
                    <h3 class="text-md font-medium text-gray-800 mb-3">2. Filter Bulan & Tahun</h3>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium mb-1">Bulan</label>
                            <select name="bulan" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                                <option value="">-- Pilih Bulan --</option>
                                @for($i=1; $i<=12; $i++)
                                    <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">{{ date('F', mktime(0, 0, 0, $i, 10)) }}</option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Tahun</label>
                            <input type="number" name="tahun" value="{{ date('Y') }}" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-4 border-t">
                <button type="submit" class="py-2 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                    Download Laporan PDF
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
