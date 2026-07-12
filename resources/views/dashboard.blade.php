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
                    <thead class="bg-white sticky top-0 z-10">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Peruntukan</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Pemasukan</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Pengeluaran</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($peruntukan as $name => $data)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-800">{{ $name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-emerald-600 text-right">Rp {{ number_format($data['in'], 0, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-rose-600 text-right">Rp {{ number_format($data['out'], 0, ',', '.') }}</td>
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

    <!-- Tabel Riwayat Transaksi (Datatables Preline) -->
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-bold text-gray-800">Rincian Riwayat Transaksi</h2>
        </div>
        <div id="hs-datatable-transaksi" class="flex flex-col --prevent-on-load-init p-6" data-hs-datatable='{
          "pagingOptions": {
            "pageBtnClasses": "min-w-10 flex justify-center items-center text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 py-2.5 text-sm rounded-full disabled:opacity-50 disabled:pointer-events-none"
          },
          "ordering": false,
          "language": {
            "zeroRecords": "<div class=\"py-10 px-5 flex flex-col justify-center items-center text-center\"><svg class=\"shrink-0 size-6 text-gray-400\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><circle cx=\"11\" cy=\"11\" r=\"8\"/><path d=\"m21 21-4.3-4.3\"/></svg><div class=\"max-w-sm mx-auto\"><p class=\"mt-2 text-sm text-gray-500\">Tidak ada data ditemukan</p></div></div>"
          }
        }'>
          
          <!-- Header (Pencarian & Baris per Halaman) -->
          <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
            <!-- Search & Filters -->
            <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
              <!-- Search Box -->
              <div class="relative w-full sm:w-64">
                <label for="hs-table-search" class="sr-only">Cari</label>
                <input type="text" id="hs-table-search" class="py-2 px-3 ps-9 block w-full border border-gray-200 shadow-sm rounded-lg text-sm text-gray-800 placeholder-gray-400 focus:z-10 focus:border-blue-500 focus:ring-blue-500" placeholder="Cari transaksi..." data-hs-datatable-search>
                <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-3">
                  <svg class="size-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                </div>
              </div>
              
              <!-- Date Range Filter -->
              <div class="flex items-center gap-2 w-full sm:w-auto">
                <input type="date" id="filter-start-date" class="py-2 px-3 block w-full sm:w-36 bg-white border border-gray-200 rounded-lg shadow-sm text-sm focus:border-blue-500 focus:ring-blue-500 text-gray-600" title="Dari Tanggal">
                <span class="text-sm font-medium text-gray-400 shrink-0">to</span>
                <input type="date" id="filter-end-date" class="py-2 px-3 block w-full sm:w-36 bg-white border border-gray-200 rounded-lg shadow-sm text-sm focus:border-blue-500 focus:ring-blue-500 text-gray-600" title="Sampai Tanggal">
              </div>

              <!-- Bulan & Tahun Filter -->
              <div class="flex items-center gap-2 w-full sm:w-auto">
                <select id="filter-month" class="hidden" data-hs-select='{
                  "placeholder": "Semua Bulan",
                  "toggleClasses": "relative py-2 px-3 pr-9 flex text-nowrap w-full sm:w-40 cursor-pointer bg-white border border-gray-200 rounded-lg text-left text-sm text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50",
                  "dropdownClasses": "mt-2 z-[100] w-full sm:w-40 max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg shadow-md overflow-hidden overflow-y-auto",
                  "optionClasses": "py-2 px-3 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-md focus:outline-none focus:bg-gray-100",
                  "extraMarkup": "<div class=\"absolute top-1/2 -translate-y-1/2\" style=\"right: 0.75rem;\"><svg class=\"shrink-0 size-3.5 text-gray-400\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
                }'>
                  <option value="">Semua Bulan</option>
                  <option value="1">Januari</option>
                  <option value="2">Februari</option>
                  <option value="3">Maret</option>
                  <option value="4">April</option>
                  <option value="5">Mei</option>
                  <option value="6">Juni</option>
                  <option value="7">Juli</option>
                  <option value="8">Agustus</option>
                  <option value="9">September</option>
                  <option value="10">Oktober</option>
                  <option value="11">November</option>
                  <option value="12">Desember</option>
                </select>
                <select id="filter-year" class="hidden" data-hs-select='{
                  "placeholder": "Semua Tahun",
                  "toggleClasses": "relative py-2 px-3 pr-9 flex text-nowrap w-full sm:w-36 cursor-pointer bg-white border border-gray-200 rounded-lg text-left text-sm text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50",
                  "dropdownClasses": "mt-2 z-[100] w-full sm:w-36 max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg shadow-md overflow-hidden overflow-y-auto",
                  "optionClasses": "py-2 px-3 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-md focus:outline-none focus:bg-gray-100",
                  "extraMarkup": "<div class=\"absolute top-1/2 -translate-y-1/2\" style=\"right: 0.75rem;\"><svg class=\"shrink-0 size-3.5 text-gray-400\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
                }'>
                  <option value="">Semua Tahun</option>
                  @php $currentYear = date('Y'); @endphp
                  @for($i = $currentYear; $i >= $currentYear - 5; $i--)
                    <option value="{{ $i }}">{{ $i }}</option>
                  @endfor
                </select>
              </div>
            </div>
            
            <!-- Items per page -->
            <div class="flex items-center justify-end w-full md:w-auto">
              <select class="hidden" data-hs-select='{
                "toggleClasses": "relative py-2 px-3 pr-9 flex text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-left text-sm text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50",
                "dropdownClasses": "mt-2 right-0 z-[100] w-20 max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg shadow-md overflow-hidden overflow-y-auto",
                "optionClasses": "py-2 px-3 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-md focus:outline-none focus:bg-gray-100",
                "extraMarkup": "<div class=\"absolute top-1/2 -translate-y-1/2\" style=\"right: 0.75rem;\"><svg class=\"shrink-0 size-3.5 text-gray-400\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
              }' data-hs-datatable-page-entities>
                <option value="10" selected>10</option>
                <option value="25">25</option>
                <option value="50">50</option>
              </select>
            </div>
          </div>

          <!-- Tabel -->
          <div class="min-h-[300px] overflow-x-auto">
            <table class="min-w-full">
              <thead class="border-b border-gray-200 bg-gray-50">
                <tr>
                  <th scope="col" class="py-3 px-4 text-start font-medium text-sm text-gray-500">Tanggal</th>
                  
                  <!-- Kolom Tipe dengan Filter -->
                  <th scope="col" class="py-3 px-4 text-start font-medium text-sm text-gray-500 --exclude-from-ordering">
                    <div class="inline-block">
                      <select id="hs-select-tipe" class="hidden" data-hs-select='{
                        "toggleClasses": "group relative py-1 px-2 pr-9 inline-flex text-nowrap w-full cursor-pointer rounded-lg text-left text-sm text-gray-500 font-medium hover:bg-gray-200 focus:outline-none",
                        "dropdownClasses": "mt-2 z-[100] w-full min-w-[150px] max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg shadow-md",
                        "optionClasses": "py-2 px-3 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg",
                        "extraMarkup": "<div class=\"absolute top-1/2 -translate-y-1/2\" style=\"right: 0.75rem;\"><svg class=\"shrink-0 size-3.5 text-gray-500 group-hover:text-gray-700\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
                      }'>
                        <option value="all" selected>Tipe (Semua)</option>
                        <option value="Pemasukan">Pemasukan</option>
                        <option value="Pengeluaran">Pengeluaran</option>
                        <option value="Mutasi">Mutasi</option>
                      </select>
                    </div>
                  </th>
                  
                  <th scope="col" class="py-3 px-4 text-start font-medium text-sm text-gray-500">Kategori</th>
                  <th scope="col" class="py-3 px-4 text-end font-medium text-sm text-gray-500">Nominal</th>
                  <th scope="col" class="py-3 px-4 text-start font-medium text-sm text-gray-500">Keterangan</th>
                  <th scope="col" class="py-3 px-4 text-center font-medium text-sm text-gray-500 --exclude-from-ordering">Aksi</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200">
                @foreach($transactions as $trx)
                <tr class="hover:bg-gray-50">
                  <td class="p-4 whitespace-nowrap text-sm text-gray-800">{{ $trx->date->format('d/m/Y') }}</td>
                  <td class="p-4 whitespace-nowrap text-sm text-gray-800">
                        @if($trx->type == 'in') <span class="inline-flex items-center gap-1.5 py-1 px-2 rounded-md text-xs font-medium bg-green-100 text-green-700">Pemasukan</span>
                        @elseif($trx->type == 'out') <span class="inline-flex items-center gap-1.5 py-1 px-2 rounded-md text-xs font-medium bg-red-100 text-red-700">Pengeluaran</span>
                        @else <span class="inline-flex items-center gap-1.5 py-1 px-2 rounded-md text-xs font-medium bg-blue-100 text-blue-700">Mutasi</span>
                        @endif
                  </td>
                  <td class="p-4 whitespace-nowrap text-sm text-gray-800" title="{{ $trx->category ? $trx->category->name : '' }}">{{ $trx->category ? Str::limit($trx->category->name, 30) : '-' }}</td>
                  <td class="p-4 whitespace-nowrap text-end text-sm font-bold text-gray-900">Rp {{ number_format($trx->amount, 0, ',', '.') }}</td>
                  <td class="p-4 text-sm text-gray-800">
                    <div class="flex items-start justify-between gap-2">
                      <div class="flex-1 w-full max-w-[300px]">
                        <div class="font-medium text-gray-800">{{ $trx->description ?? 'Tanpa Keterangan' }}</div>
                        @if($trx->details && $trx->details->count() > 0)
                            <div class="mt-2 text-xs text-gray-600 bg-gray-50 rounded-lg p-2 border border-gray-100">
                                <ul class="space-y-1.5">
                                    @foreach($trx->details as $item)
                                        @php
                                            $subtotal = ($item->qty ?? 1) * $item->price;
                                        @endphp
                                        <li class="flex justify-between items-start gap-3 border-b border-gray-200 pb-1.5 last:border-0 last:pb-0">
                                            <div class="flex flex-col">
                                                <span class="font-medium text-gray-700" title="{{ $item->name }}">{{ Str::limit($item->name, 30) }}</span>
                                                <span class="text-[10px] text-gray-500">{{ $item->qty ?? 1 }}x @ Rp{{ number_format($item->price, 0, ',', '.') }}</span>
                                            </div>
                                            <div class="text-right shrink-0 font-medium text-gray-800">
                                                Rp{{ number_format($subtotal, 0, ',', '.') }}
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                      </div>

                      <!-- Info Icon with Preline Tooltip -->
                      <div class="hs-tooltip group [--placement:left] inline-block shrink-0 mt-0.5 relative">
                        <button type="button" class="hs-tooltip-toggle text-gray-400 hover:text-blue-600 focus:outline-none transition-colors cursor-help inline-flex justify-center items-center">
                          <svg class="size-4 shrink-0" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
                          <span class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible group-hover:opacity-100 group-hover:visible z-[100] py-1 px-2 bg-gray-900 border border-gray-700 text-xs font-medium text-white rounded-md shadow-2xl text-left right-full mr-2" role="tooltip">
                            <span class="block w-60 p-2 space-y-2 cursor-default font-normal">
                              <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1 border-b border-gray-700 pb-1">Info Tambahan</span>
                              
                              @if($trx->type == 'out')
                              <span class="grid grid-cols-3 gap-1 text-xs">
                                <span class="text-gray-400">Tujuan</span>
                                <span class="col-span-2 font-medium">{{ $trx->related_party ?: '-' }}</span>
                              </span>
                              @elseif($trx->type == 'in')
                              <span class="grid grid-cols-3 gap-1 text-xs">
                                <span class="text-gray-400">Sumber</span>
                                <span class="col-span-2 font-medium">{{ $trx->related_party ?: '-' }}</span>
                              </span>
                              @else
                              <span class="grid grid-cols-3 gap-1 text-xs">
                                <span class="text-gray-400">Sumber</span>
                                <span class="col-span-2 font-medium">{{ $trx->sourceAccount ? $trx->sourceAccount->name : '-' }}</span>
                              </span>
                              <span class="grid grid-cols-3 gap-1 text-xs">
                                <span class="text-gray-400">Tujuan</span>
                                <span class="col-span-2 font-medium">{{ $trx->destinationAccount ? $trx->destinationAccount->name : '-' }}</span>
                              </span>
                              @endif
                              
                              <span class="grid grid-cols-3 gap-1 text-xs">
                                <span class="text-gray-400">Peruntukan</span>
                                <span class="col-span-2 font-medium">{{ $trx->allocation ?? '-' }}</span>
                              </span>
                            </span>
                          </span>
                        </button>
                      </div>
                    </div>
                  </td>
                  <td class="p-4 whitespace-nowrap text-center text-sm font-medium">
                      <a href="{{ route('transactions.edit', $trx->id) }}" class="text-blue-600 hover:underline text-xs font-medium mr-2">Edit</a>
                      <form action="{{ route('transactions.destroy', $trx->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus transaksi ini?');">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="text-red-600 hover:underline text-xs font-medium">Hapus</button>
                      </form>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          <!-- Footer (Paginasi) -->
          <div class="flex flex-wrap justify-between items-center gap-2 mt-4 px-4 pb-4">
            <div class="inline-flex items-center gap-1 hidden" data-hs-datatable-paging>
              <button type="button" class="p-2.5 min-w-10 inline-flex justify-center items-center gap-x-2 text-sm rounded-full text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50" data-hs-datatable-paging-prev>
                <span aria-hidden="true">«</span>
              </button>
              <div class="flex items-center space-x-1 [&>.active]:bg-gray-200 [&>.active]:font-bold" data-hs-datatable-paging-pages></div>
              <button type="button" class="p-2.5 min-w-10 inline-flex justify-center items-center gap-x-2 text-sm rounded-full text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50" data-hs-datatable-paging-next>
                <span aria-hidden="true">»</span>
              </button>
            </div>
            <div class="whitespace-nowrap text-sm text-gray-500" data-hs-datatable-info>
              Menampilkan <span data-hs-datatable-info-from></span> hingga <span data-hs-datatable-info-to></span> dari <span data-hs-datatable-info-length></span> data
            </div>
          </div>
        </div>
    </div> <!-- Penutup untuk div wrapper Rincian Riwayat Transaksi -->

    <!-- Summary Totals Card (Di luar datatable) -->
    <div class="mt-6 flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl overflow-hidden">
        <div class="p-6 grid grid-cols-2 gap-6" style="padding: 1.5rem;">
                <div>
                    <div class="text-xs font-medium text-gray-500 uppercase tracking-wider">Total Pemasukan</div>
                    <div class="mt-1 text-2xl font-bold text-green-600" id="total-pemasukan-val">Rp 0</div>
                </div>
                <div class="text-right">
                    <div class="text-xs font-medium text-gray-500 uppercase tracking-wider">Total Pengeluaran</div>
                    <div class="mt-1 text-2xl font-bold text-red-600" id="total-pengeluaran-val">Rp 0</div>
                </div>
            </div>
    </div>
@endsection

@push('scripts')
<script>
  window.addEventListener('load', () => {
    (function () {
      // Ambil elemen dropdown filter Tipe Transaksi
      const tipeEl = document.querySelector('#hs-select-tipe');
      
      // Inisialisasi DataTable Preline
      const { dataTable } = new HSDataTable('#hs-datatable-transaksi');
      
      // Fix: Inisialisasi manual select filter karena terhalang --prevent-on-load-init
      const dtContainer = document.querySelector('#hs-datatable-transaksi');
      if (dtContainer) {
          dtContainer.classList.remove('--prevent-on-load-init');
          if (window.HSStaticMethods && typeof window.HSStaticMethods.autoInit === 'function') {
              window.HSStaticMethods.autoInit(['select']);
          }
          dtContainer.classList.add('--prevent-on-load-init');
      }

      // Fix: Datatables removes DOM elements and clones them, which destroys Preline's JS events.
      // We must re-initialize tooltips every time the table body changes (pagination, search, sort).
      const reinitPrelinePlugins = () => {
          document.querySelectorAll('#hs-datatable-transaksi .hs-tooltip').forEach(p => {
              p.removeAttribute('data-hs-tooltip-initialized');
              p.removeAttribute('data-hs-initialized');
          });
          if (window.HSStaticMethods && typeof window.HSStaticMethods.autoInit === 'function') {
              window.HSStaticMethods.autoInit(['tooltip']);
          }
      };
      
      // Initialize tooltips once on load
      setTimeout(reinitPrelinePlugins, 50);
      
      // Observe the table body for changes to re-init tooltips on pagination/sorting
      const tbody = document.querySelector('#hs-datatable-transaksi tbody');
      if (tbody) {
          const observer = new MutationObserver((mutations) => {
              // Only trigger if rows are added/removed (childList)
              let hasRowChanges = false;
              mutations.forEach(m => {
                  if (m.type === 'childList') hasRowChanges = true;
              });
              if (hasRowChanges) {
                  setTimeout(reinitPrelinePlugins, 50);
              }
          });
          observer.observe(tbody, { childList: true });
      }
      
      // Buat aturan pencarian custom
      dataTable.search.fixed('range', function (searchStr, data, index) {
        const filterTipe = tipeEl.value === 'all' ? '' : tipeEl.value;
        const tipeTransaksi = data[1] || ''; // Kolom indeks 1 = Tipe
        
        // Logika Tipe
        let matchTipe = (filterTipe === tipeTransaksi || filterTipe === '');

        // Logika Tanggal
        const startInput = document.querySelector('#filter-start-date').value;
        const endInput = document.querySelector('#filter-end-date').value;
        const monthInput = document.querySelector('#filter-month').value;
        const yearInput = document.querySelector('#filter-year').value;
        
        let start = null;
        let end = null;
        
        // Parse the HTML5 date input (YYYY-MM-DD) as LOCAL time, not UTC!
        if (startInput) {
            const pStart = startInput.split('-');
            start = new Date(pStart[0], pStart[1]-1, pStart[2]);
        }
        if (endInput) {
            const pEnd = endInput.split('-');
            end = new Date(pEnd[0], pEnd[1]-1, pEnd[2], 23, 59, 59, 999);
        }

        const rowDateStr = data[0] || ''; // Kolom indeks 0 = Tanggal
        const parts = rowDateStr.split('/');
        let rowDate = null;
        if(parts.length === 3) rowDate = new Date(parts[2], parts[1]-1, parts[0]);

        let matchDate = true;
        if (start && rowDate && rowDate < start) matchDate = false;
        if (end && rowDate && rowDate > end) matchDate = false;
        if (monthInput && rowDate && (rowDate.getMonth() + 1).toString() !== monthInput) matchDate = false;
        if (yearInput && rowDate && rowDate.getFullYear().toString() !== yearInput) matchDate = false;

        return matchTipe && matchDate;
      });

      // Helper function: Hitung total berdasar filter aktif
      window.transactionsData = [
      @foreach($transactions as $trx)
          @php
              $rowText = $trx->date->format('d/m/Y') . ' ' . 
                          ($trx->type == 'in' ? 'Pemasukan' : ($trx->type == 'out' ? 'Pengeluaran' : 'Mutasi')) . ' ' . 
                          ($trx->category ? $trx->category->name : '-') . ' ' . 
                          'Rp ' . number_format($trx->amount, 0, ',', '.') . ' ' . 
                          ($trx->description ?? 'Tanpa Keterangan');
              if($trx->details) {
                  foreach($trx->details as $item) {
                      $rowText .= ' ' . $item->name . ' ' . ($item->qty ?? 1) . 'x @ Rp' . number_format($item->price, 0, ',', '.') . ' Rp' . number_format(($item->qty ?? 1) * $item->price, 0, ',', '.');
                  }
              }
              $rowText = strtolower($rowText);
          @endphp
          {
              type: "{{ $trx->type == 'in' ? 'Pemasukan' : ($trx->type == 'out' ? 'Pengeluaran' : 'Mutasi') }}",
              amount: {{ $trx->amount }},
              dateStr: "{{ $trx->date->format('d/m/Y') }}",
              searchStr: {!! json_encode($rowText) !!}
          },
      @endforeach
      ];

      const calculateTotals = () => {
          const filterTipe = tipeEl.value;
          const startInput = document.querySelector('#filter-start-date').value;
          const endInput = document.querySelector('#filter-end-date').value;
          const monthInput = document.querySelector('#filter-month').value;
          const yearInput = document.querySelector('#filter-year').value;
          const searchInput = document.querySelector('#hs-table-search').value.toLowerCase();

          let start = null;
          let end = null;
          
          if (startInput) {
              const pStart = startInput.split('-');
              start = new Date(pStart[0], pStart[1]-1, pStart[2]);
          }
          if (endInput) {
              const pEnd = endInput.split('-');
              end = new Date(pEnd[0], pEnd[1]-1, pEnd[2], 23, 59, 59, 999);
          }

          let totalPemasukan = 0;
          let totalPengeluaran = 0;

          window.transactionsData.forEach(trx => {
              if (filterTipe !== 'all' && filterTipe !== '' && trx.type !== filterTipe) return;

              const parts = trx.dateStr.split('/');
              let rowDate = null;
              if(parts.length === 3) rowDate = new Date(parts[2], parts[1]-1, parts[0]);

              if (start && rowDate && rowDate < start) return;
              if (end && rowDate && rowDate > end) return;
              if (monthInput && rowDate && (rowDate.getMonth() + 1).toString() !== monthInput) return;
              if (yearInput && rowDate && rowDate.getFullYear().toString() !== yearInput) return;

              if (searchInput) {
                  const searchTerms = searchInput.split(' ').filter(t => t.trim() !== '');
                  let match = true;
                  for (const term of searchTerms) {
                      if (!trx.searchStr.includes(term)) {
                          match = false;
                          break;
                      }
                  }
                  if (!match) return;
              }

              if (trx.type === 'Pemasukan') {
                  totalPemasukan += trx.amount;
              } else if (trx.type === 'Pengeluaran') {
                  totalPengeluaran += trx.amount;
              }
          });

          document.querySelector('#total-pemasukan-val').innerText = 'Rp ' + totalPemasukan.toLocaleString('id-ID');
          document.querySelector('#total-pengeluaran-val').innerText = 'Rp ' + totalPengeluaran.toLocaleString('id-ID');
      };

      // Hitung total saat halaman dimuat
      calculateTotals();

      // Jika dropdown tipe diubah, gambar ulang tabelnya dan hitung ulang
      tipeEl.addEventListener('change', () => { dataTable.draw(); calculateTotals(); });

      // Tambahkan event listener untuk filter tanggal, bulan, dan tahun
      document.querySelector('#filter-start-date').addEventListener('change', () => { dataTable.draw(); calculateTotals(); });
      document.querySelector('#filter-end-date').addEventListener('change', () => { dataTable.draw(); calculateTotals(); });
      document.querySelector('#filter-month').addEventListener('change', () => { dataTable.draw(); calculateTotals(); });
      document.querySelector('#filter-year').addEventListener('change', () => { dataTable.draw(); calculateTotals(); });
      
      // Hitung ulang juga ketika input pencarian diubah
      document.querySelector('#hs-table-search').addEventListener('keyup', () => { calculateTotals(); });
    })();
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
