@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Stat Cards -->
    <div class="grid sm:grid-cols-3 gap-4 sm:gap-6">
        <!-- Card -->
        <div class="flex flex-col bg-white border shadow-sm rounded-xl">
            <div class="p-4 md:p-5">
                <div class="flex items-center gap-x-2">
                    <p class="text-xs uppercase tracking-wide text-gray-500 font-semibold">Total Saldo Bersih</p>
                </div>
                <div class="mt-1 flex items-center gap-x-2">
                    <h3 class="text-lg sm:text-xl xl:text-2xl font-bold text-gray-800 whitespace-nowrap">
                        Rp {{ number_format($totalBalance, 0, ',', '.') }}
                    </h3>
                </div>
            </div>
        </div>
        <!-- End Card -->
        <!-- Card -->
        <div class="flex flex-col bg-white border shadow-sm rounded-xl">
            <div class="p-4 md:p-5">
                <div class="flex items-center gap-x-2">
                    <p class="text-xs uppercase tracking-wide text-gray-500 font-semibold">Total Pemasukan (Bulan Ini)</p>
                </div>
                <div class="mt-1 flex items-center gap-x-2">
                    <h3 class="text-lg sm:text-xl xl:text-2xl font-bold text-green-600 whitespace-nowrap">
                        Rp {{ number_format($totalIncomeThisMonth, 0, ',', '.') }}
                    </h3>
                </div>
            </div>
        </div>
        <!-- End Card -->
        <!-- Card -->
        <div class="flex flex-col bg-white border shadow-sm rounded-xl">
            <div class="p-4 md:p-5">
                <div class="flex items-center gap-x-2">
                    <p class="text-xs uppercase tracking-wide text-gray-500 font-semibold">Total Pengeluaran (Bulan Ini)</p>
                </div>
                <div class="mt-1 flex items-center gap-x-2">
                    <h3 class="text-lg sm:text-xl xl:text-2xl font-bold text-red-600 whitespace-nowrap">
                        Rp {{ number_format($totalExpenseThisMonth, 0, ',', '.') }}
                    </h3>
                </div>
            </div>
        </div>
        <!-- End Card -->
    </div>

    <!-- Likuiditas Saldo Akun -->
    <div>
        <h2 class="text-lg font-bold text-gray-800 mb-4">Likuiditas Saldo Akun Rekening</h2>
        <div class="max-h-[14rem] overflow-y-auto pr-2 [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 [&::-webkit-scrollbar-thumb]:rounded-full">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($accounts as $account)
                <div class="flex items-center gap-4 p-5 bg-white rounded-xl border border-gray-100 shadow-sm transition hover:shadow-md">
                    <!-- Kiri: Logo Rekening -->
                    <div class="flex-shrink-0 w-12 h-12 rounded-full overflow-hidden border border-gray-200 flex items-center justify-center bg-gray-50">
                        @if($account->logo)
                            @if(preg_match('/\./', $account->logo))
                                <img src="{{ Storage::url($account->logo) }}" alt="Logo" class="w-full h-full object-contain p-1">
                            @else
                                <span class="text-xl leading-none">{{ $account->logo }}</span>
                            @endif
                        @else
                            <span class="text-xl leading-none">💳</span>
                        @endif
                    </div>

                    <!-- Kanan: Saldo & Nama -->
                    <div class="flex flex-col min-w-0">
                        <p class="text-lg sm:text-xl xl:text-2xl font-extrabold text-gray-900 tracking-tight leading-none whitespace-nowrap">Rp {{ number_format($account->current_balance, 0, ',', '.') }}</p>
                        <h4 class="text-sm font-medium text-gray-500 mt-1 truncate">{{ $account->name }}</h4>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Distribusi & Breakdown Kategori -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <!-- Kolom Kiri: Distribusi Peruntukan Dana -->
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden flex flex-col">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h2 class="text-lg font-bold text-gray-800">Distribusi Peruntukan Dana</h2>
            </div>
            <div class="overflow-x-auto max-h-[16rem] overflow-y-auto pr-2 [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 [&::-webkit-scrollbar-thumb]:rounded-full">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-white sticky top-0 z-10 shadow-sm">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-semibold text-gray-500 uppercase">Peruntukan</th>
                            <th scope="col" class="px-6 py-3 text-end text-xs font-semibold text-gray-500 uppercase">Pemasukan</th>
                            <th scope="col" class="px-6 py-3 text-end text-xs font-semibold text-gray-500 uppercase">Pengeluaran</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($peruntukan as $name => $data)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-800">{{ $name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-emerald-600 text-end">Rp {{ number_format($data['in'], 0, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-rose-600 text-end">Rp {{ number_format($data['out'], 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Kolom Kanan: Breakdown Alokasi Kategori -->
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden flex flex-col">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h2 class="text-lg font-bold text-gray-800">Breakdown Alokasi Kategori</h2>
            </div>
            <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-8 max-h-[16rem] overflow-y-auto pr-2 [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 [&::-webkit-scrollbar-thumb]:rounded-full">
                
                <!-- Top Pemasukan -->
                <div>
                    <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4 border-b border-gray-200 pb-2">Top Pemasukan</h3>
                    <div class="space-y-3">
                        @forelse($topPemasukan as $item)
                        <div class="flex justify-between items-end border-b border-dashed border-gray-300 pb-2">
                            <span class="text-sm font-medium text-gray-800 truncate pr-2 flex items-center gap-1.5">
                                @if($item->category && $item->category->icon)
                                    <span class="text-lg leading-none">{{ $item->category->icon }}</span>
                                @endif
                                <span>{{ $item->category ? $item->category->name : 'Tanpa Kategori' }}</span>
                            </span>
                            <span class="text-sm font-bold text-emerald-600 shrink-0">Rp {{ number_format($item->total, 0, ',', '.') }}</span>
                        </div>
                        @empty
                        <div class="text-sm text-gray-500 italic">Belum ada data</div>
                        @endforelse
                    </div>
                </div>

                <!-- Top Pengeluaran -->
                <div>
                    <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4 border-b border-gray-200 pb-2">Top Pengeluaran</h3>
                    <div class="space-y-3">
                        @forelse($topPengeluaran as $item)
                        <div class="flex justify-between items-end border-b border-dashed border-gray-300 pb-2">
                            <span class="text-sm font-medium text-gray-800 truncate pr-2 flex items-center gap-1.5">
                                @if($item->category && $item->category->icon)
                                    <span class="text-lg leading-none">{{ $item->category->icon }}</span>
                                @endif
                                <span>{{ $item->category ? $item->category->name : 'Tanpa Kategori' }}</span>
                            </span>
                            <span class="text-sm font-bold text-rose-600 shrink-0">Rp {{ number_format($item->total, 0, ',', '.') }}</span>
                        </div>
                        @empty
                        <div class="text-sm text-gray-500 italic">Belum ada data</div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>

    </div>

    <!-- Tabel Riwayat Transaksi -->
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            <h2 class="text-lg font-bold text-gray-800 whitespace-nowrap">Rincian Riwayat Transaksi</h2>
            <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none z-20 ps-3.5">
                        <svg class="shrink-0 size-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                    </div>
                    <input type="text" id="searchInput" placeholder="Cari catatan..." class="py-2 ps-10 pe-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                </div>
                <select id="categoryFilter" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
                <form id="formTimeFilter" action="{{ route('dashboard') }}" method="GET" class="flex flex-col sm:flex-row gap-2 items-center">
                    <select name="time_mode" id="time_mode" class="py-2 px-3 block w-full sm:w-auto border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm" onchange="toggleTimeInputs()">
                        <option value="all" {{ request('time_mode') == 'all' ? 'selected' : '' }}>Semua Waktu</option>
                        <option value="daily" {{ request('time_mode') == 'daily' ? 'selected' : '' }}>Harian Spesifik</option>
                        <option value="monthly" {{ request('time_mode') == 'monthly' ? 'selected' : '' }}>Bulanan Spesifik</option>
                        <option value="yearly" {{ request('time_mode') == 'yearly' ? 'selected' : '' }}>Tahunan Spesifik</option>
                    </select>
                    
                    <input type="date" name="date_val" id="input_daily" class="hidden py-2 px-3 block w-full sm:w-auto border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm" value="{{ request('date_val', \Carbon\Carbon::today()->format('Y-m-d')) }}">
                    <input type="month" name="month_val" id="input_monthly" class="hidden py-2 px-3 block w-full sm:w-auto border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm" value="{{ request('month_val', \Carbon\Carbon::today()->format('Y-m')) }}">
                    <input type="number" name="year_val" id="input_yearly" class="hidden py-2 px-3 block w-full sm:w-auto border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm" value="{{ request('year_val', \Carbon\Carbon::today()->format('Y')) }}" placeholder="Contoh: 2026">
                    
                    <button type="submit" class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-lg border border-transparent font-semibold bg-blue-500 text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all text-sm">
                        Filter
                    </button>
                </form>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200" id="transactionTable">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-start text-xs font-semibold text-gray-500 uppercase">Tanggal</th>
                        <th scope="col" class="px-6 py-3 text-start text-xs font-semibold text-gray-500 uppercase">Jenis</th>
                        <th scope="col" class="px-6 py-3 text-start text-xs font-semibold text-gray-500 uppercase">Kategori</th>
                        <th scope="col" class="px-6 py-3 text-start text-xs font-semibold text-gray-500 uppercase">Rekening</th>
                        <th scope="col" class="px-6 py-3 text-end text-xs font-semibold text-gray-500 uppercase">Nominal</th>
                        <th scope="col" class="px-6 py-3 text-start text-xs font-semibold text-gray-500 uppercase">Catatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($transactions as $trx)
                    <tr class="trx-row hover:bg-gray-50 transition" data-date="{{ $trx->date->format('Y-m-d') }}" data-type="{{ $trx->type }}" data-category="{{ $trx->category ? $trx->category->name : '' }}" data-amount="{{ $trx->amount }}">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $trx->date->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @if($trx->type == 'in') <span class="inline-flex items-center gap-1.5 py-1 px-2 rounded-md text-xs font-medium bg-green-100 text-green-700">Pemasukan</span>
                            @elseif($trx->type == 'out') <span class="inline-flex items-center gap-1.5 py-1 px-2 rounded-md text-xs font-medium bg-red-100 text-red-700">Pengeluaran</span>
                            @else <span class="inline-flex items-center gap-1.5 py-1 px-2 rounded-md text-xs font-medium bg-blue-100 text-blue-700">Mutasi</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $trx->category ? $trx->category->name : '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                            {{ $trx->sourceAccount ? $trx->sourceAccount->name : '-' }}
                            @if($trx->type == 'transfer' && $trx->destinationAccount)
                                <span class="text-gray-400 mx-1">➔</span> {{ $trx->destinationAccount->name }}
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-end font-bold text-gray-900">Rp {{ number_format($trx->amount, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-800 search-target">
                            {{ $trx->description ?? '-' }}
                            @if($trx->details && $trx->details->count() > 0)
                                <ul class="list-disc pl-4 text-[11px] text-gray-500 mt-1">
                                    @foreach($trx->details as $item)
                                        <li>{{ $item->name }} ({{ $item->qty ?? 1 }}x) - Rp{{ number_format($item->price, 0, ',', '.') }}</li>
                                    @endforeach
                                </ul>
                            @endif
                            @if($trx->discount && $trx->discount > 0)
                                <div class="text-[11px] text-orange-600 mt-1 font-semibold">
                                    Diskon Global: Rp {{ number_format($trx->discount, 0, ',', '.') }}
                                </div>
                            @endif
                            <div class="mt-2 flex items-center gap-3">
                                <a href="{{ route('transactions.edit', $trx->id) }}" class="text-blue-600 hover:underline text-xs font-medium">Edit</a>
                                <form action="{{ route('transactions.destroy', $trx->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus transaksi ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline text-xs font-medium">Hapus</button>
                                </form>
                                <div class="hs-tooltip inline-block relative group cursor-pointer ml-1">
                                    <div class="hs-tooltip-toggle flex items-center justify-center text-gray-400 hover:text-blue-600 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="M12 16v-4"></path>
                                            <path d="M12 8h.01"></path>
                                        </svg>
                                        <div class="hs-tooltip-content opacity-0 transition-opacity inline-block absolute invisible z-10 py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm whitespace-nowrap bottom-full mb-2 left-1/2 -translate-x-1/2 group-hover:opacity-100 group-hover:visible" role="tooltip">
                                            Tujuan/Sumber: {{ $trx->related_party ?? 'Tidak ada data' }}<br/>
                                            Peruntukan: {{ $trx->allocation ?? '-' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50 border-t border-gray-200">
                    <tr>
                        <td colspan="4" class="px-6 py-4 whitespace-nowrap text-end text-sm font-bold text-gray-800 uppercase tracking-wider">Summary:</td>
                        <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-bold text-gray-900">
                            <div class="flex flex-col items-end gap-1">
                                <span class="text-green-600">In: Rp <span id="filteredIn">0</span></span>
                                <span class="text-red-600">Out: Rp <span id="filteredOut">0</span></span>
                            </div>
                        </td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const categoryFilter = document.getElementById('categoryFilter');
        const rows = document.querySelectorAll('.trx-row');
        const filteredInEl = document.getElementById('filteredIn');
        const filteredOutEl = document.getElementById('filteredOut');

        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID').format(number);
        }

        function filterTable() {
            const searchTerm = searchInput.value.toLowerCase();
            const category = categoryFilter.value;
            
            let totalIn = 0;
            let totalOut = 0;

            rows.forEach(row => {
                const text = row.querySelector('.search-target').textContent.toLowerCase();
                const rowCat = row.getAttribute('data-category');
                const rowType = row.getAttribute('data-type');
                const rowAmount = parseFloat(row.getAttribute('data-amount'));

                let matchSearch = text.includes(searchTerm);
                let matchCat = category === "" || rowCat === category;

                if (matchSearch && matchCat) {
                    row.style.display = '';
                    if (rowType === 'in') totalIn += rowAmount;
                    if (rowType === 'out') totalOut += rowAmount;
                } else {
                    row.style.display = 'none';
                }
            });

            filteredInEl.textContent = formatRupiah(totalIn);
            filteredOutEl.textContent = formatRupiah(totalOut);
        }

        searchInput.addEventListener('input', filterTable);
        categoryFilter.addEventListener('change', filterTable);

        // Initial calc
        filterTable();
    });

    // Toggle time inputs on change
    function toggleTimeInputs() {
        const mode = document.getElementById('time_mode').value;
        const inputDaily = document.getElementById('input_daily');
        const inputMonthly = document.getElementById('input_monthly');
        const inputYearly = document.getElementById('input_yearly');
        
        if (inputDaily) inputDaily.classList.add('hidden');
        if (inputMonthly) inputMonthly.classList.add('hidden');
        if (inputYearly) inputYearly.classList.add('hidden');
        
        if (mode === 'daily' && inputDaily) {
            inputDaily.classList.remove('hidden');
        } else if (mode === 'monthly' && inputMonthly) {
            inputMonthly.classList.remove('hidden');
        } else if (mode === 'yearly' && inputYearly) {
            inputYearly.classList.remove('hidden');
        }
    }
    
    // Initial toggle
    window.addEventListener('load', toggleTimeInputs);
</script>
@endpush
