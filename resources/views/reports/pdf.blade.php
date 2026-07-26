<!DOCTYPE html>
<html>
<head>
    <title>Laporan Keuangan</title>
    <style>
        body { font-family: sans-serif; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2, h3 { text-align: center; margin-bottom: 5px; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .rincian-table { width: 100%; border: none; margin: 0; }
        .rincian-table td { border: none; border-bottom: 1px dashed #ccc; padding: 2px 0; }
    </style>
</head>
<body>

    <h2>LAPORAN KEUANGAN</h2>
    <p class="text-center">Periode: {{ $periode ?? 'Semua Waktu' }}</p>

    <!-- BAGIAN 1: RINGKASAN UMUM -->
    <h3>1. Ringkasan Umum</h3>
    <table>
        <tr>
            <th>Total Pemasukan</th>
            <td class="text-right">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Total Pengeluaran</th>
            <td class="text-right">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Saldo Bersih</th>
            <td class="text-right"><strong>Rp {{ number_format($saldoBersih, 0, ',', '.') }}</strong></td>
        </tr>
    </table>

    <!-- BAGIAN 2: RINCIAN TRANSAKSI -->
    <h3>2. Rincian Detail Transaksi</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tgl & Tipe</th>
                <th>Rekening & Kategori</th>
                <th>Pihak / Peruntukan</th>
                <th>Keterangan</th>
                <th>Detail Barang (Item, Jml, Hrg)</th>
                <th>Total Transaksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksis as $index => $trx)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>
                    {{ \Carbon\Carbon::parse($trx->date)->format('d/m/Y') }}<br>
                    <strong>
                        @if($trx->type == 'in') Pemasukan
                        @elseif($trx->type == 'out') Pengeluaran
                        @else Mutasi @endif
                    </strong>
                </td>
                <td>
                    S: {{ $trx->sourceAccount->name ?? '-' }}<br>
                    P: {{ $trx->destinationAccount->name ?? '-' }}<br>
                    Kat: {{ $trx->category->name ?? '-' }}
                </td>
                <td>
                    Pihak: {{ $trx->related_party ?? '-' }}<br>
                    Untuk: {{ $trx->allocation ?? '-' }}
                </td>
                <td>{{ $trx->description }}</td>
                <td>
                    <!-- Menampilkan Rincian Banyak Barang -->
                    @if($trx->details && $trx->details->count() > 0)
                        <table class="rincian-table">
                            @foreach($trx->details as $barang)
                            <tr>
                                <td>{{ $barang->name }} ({{ $barang->qty }}x)</td>
                                <td class="text-right">Rp{{ number_format($barang->price, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                            @if($trx->discount > 0)
                            <tr>
                                <td>Diskon Transaksi</td>
                                <td class="text-right">- Rp{{ number_format($trx->discount, 0, ',', '.') }}</td>
                            </tr>
                            @endif
                        </table>
                    @else
                        -
                    @endif
                </td>
                <td class="text-right font-bold">
                    Rp {{ number_format($trx->amount, 0, ',', '.') }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
