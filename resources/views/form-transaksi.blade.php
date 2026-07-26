@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto bg-white border border-gray-200 rounded-xl shadow-sm p-4 sm:p-7">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">{{ $transaction ? 'Edit Transaksi' : 'Catat Transaksi' }}</h2>
            <p class="text-sm text-gray-600 mt-1">Masukkan rincian arus kas pemasukan, pengeluaran, atau mutasi.</p>
        </div>
        @if($transaction)
        <a href="{{ route('dashboard') }}" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none">
            Kembali
        </a>
        @endif
    </div>

    @if(session('success'))
    <div class="bg-teal-50 border-t-2 border-teal-500 rounded-lg p-4 mb-6 shadow-sm" role="alert">
        <div class="flex">
            <div class="flex-shrink-0">
                <span class="inline-flex justify-center items-center size-8 rounded-full border-4 border-teal-100 bg-teal-200 text-teal-800">
                    <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="m9 12 2 2 4-4"/></svg>
                </span>
            </div>
            <div class="ms-3">
                <h3 class="text-gray-800 font-semibold">Berhasil!</h3>
                <p class="text-sm text-gray-700">{{ session('success') }}</p>
            </div>
        </div>
    </div>
    @endif

    <form action="{{ $transaction ? route('transactions.update', $transaction) : route('transactions.store') }}" method="POST" enctype="multipart/form-data" id="trxForm">
        @csrf
        @if($transaction)
            @method('PUT')
        @endif
        
        <div class="grid sm:grid-cols-2 gap-4 sm:gap-6">
            
            <!-- Tombol Tipe Transaksi -->
            <div class="sm:col-span-2">
                <label class="block text-sm font-semibold text-gray-800 mb-2">Tipe Transaksi</label>
                
                <nav class="flex gap-x-1 p-1 bg-gray-100 rounded-xl" aria-label="Tabs" role="tablist" aria-orientation="horizontal">
                    <!-- Tab Pemasukan (Hijau) -->
                    <button type="button" data-val="in" class="btn-type py-2.5 px-4 inline-flex basis-0 grow justify-center items-center gap-x-2 bg-transparent text-sm font-medium text-center text-gray-500 hover:text-gray-700 rounded-lg disabled:opacity-50 disabled:pointer-events-none hs-tab-active:bg-green-600 hs-tab-active:text-white hs-tab-active:shadow-sm active" id="tab-item-pemasukan" data-hs-tab="#tab-pemasukan" aria-controls="tab-pemasukan" role="tab" aria-selected="true">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                        Pemasukan
                    </button>

                    <!-- Tab Pengeluaran (Merah) -->
                    <button type="button" data-val="out" class="btn-type py-2.5 px-4 inline-flex basis-0 grow justify-center items-center gap-x-2 bg-transparent text-sm font-medium text-center text-gray-500 hover:text-gray-700 rounded-lg disabled:opacity-50 disabled:pointer-events-none hs-tab-active:bg-red-600 hs-tab-active:text-white hs-tab-active:shadow-sm" id="tab-item-pengeluaran" data-hs-tab="#tab-pengeluaran" aria-controls="tab-pengeluaran" role="tab" aria-selected="false">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7 7v18"></path></svg>
                        Pengeluaran
                    </button>

                    <!-- Tab Mutasi (Biru) -->
                    <button type="button" data-val="transfer" class="btn-type py-2.5 px-4 inline-flex basis-0 grow justify-center items-center gap-x-2 bg-transparent text-sm font-medium text-center text-gray-500 hover:text-gray-700 rounded-lg disabled:opacity-50 disabled:pointer-events-none hs-tab-active:bg-blue-600 hs-tab-active:text-white hs-tab-active:shadow-sm" id="tab-item-mutasi" data-hs-tab="#tab-mutasi" aria-controls="tab-mutasi" role="tab" aria-selected="false">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                        Mutasi
                    </button>
                </nav>

                <!-- Tab Panel HANYA untuk menampung hidden input tipe -->
                <div class="mt-0">
                  <div id="tab-pemasukan" role="tabpanel" aria-labelledby="tab-item-pemasukan">
                      <input type="hidden" name="type" value="in" class="tipe_transaksi_input" {{ old('type', $transaction->type ?? 'out') == 'in' ? '' : 'disabled' }}>
                  </div>
                  <div id="tab-pengeluaran" class="hidden" role="tabpanel" aria-labelledby="tab-item-pengeluaran">
                      <input type="hidden" name="type" value="out" class="tipe_transaksi_input" {{ old('type', $transaction->type ?? 'out') == 'out' ? '' : 'disabled' }}>
                  </div>
                  <div id="tab-mutasi" class="hidden" role="tabpanel" aria-labelledby="tab-item-mutasi">
                      <input type="hidden" name="type" value="transfer" class="tipe_transaksi_input" {{ old('type', $transaction->type ?? 'out') == 'transfer' ? '' : 'disabled' }}>
                  </div>
                </div>
            </div>

            <div>
                <label for="date" class="block text-sm font-semibold text-gray-800 mb-2">Tanggal</label>
                <input type="date" id="date" name="date" value="{{ old('date', $transaction ? $transaction->date->format('Y-m-d') : date('Y-m-d')) }}" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm" required>
            </div>

            <div id="wrapper_source_account">
                <label for="source_account_id" class="block text-sm font-semibold text-gray-800 mb-2" id="label_source_account">Rekening Sumber</label>
                <select id="source_account_id" name="source_account_id" data-hs-select='{
                  "hasSearch": true,
                  "searchPlaceholder": "Cari rekening...",
                  "searchClasses": "block w-full text-sm border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 py-2 px-3",
                  "searchWrapperClasses": "bg-white p-2 -mx-1 sticky top-0 z-10",
                  "placeholder": "Pilih rekening...",
                  "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                  "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 pl-4 pr-9 flex text-nowrap w-full cursor-pointer bg-white border border-gray-200 text-gray-800 rounded-lg text-left text-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50",
                  "dropdownClasses": "mt-2 z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg shadow-xl overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-none [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300",
                  "optionClasses": "hs-selected:bg-blue-50 py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50",
                  "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-3.5 text-blue-600\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>",
                  "extraMarkup": "<div class=\"absolute top-1/2 -translate-y-1/2\" style=\"right: 0.75rem;\"><svg class=\"shrink-0 size-3.5 text-gray-400\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
                }' class="hidden" required>
                    <option value="">Pilih Rekening</option>
                    @foreach($accounts as $acc)
                        <option value="{{ $acc->id }}" data-icon="{{ $acc->logo ? asset('storage/' . $acc->logo) : asset('images/logos/wallet.png') }}" {{ old('source_account_id', $transaction->source_account_id ?? '') == $acc->id ? 'selected' : '' }}>{{ $acc->name }}</option>
                    @endforeach
                </select>
            </div>

            <div id="wrapper_dest_account" class="hidden">
                <label for="destination_account_id" class="block text-sm font-semibold text-gray-800 mb-2">Rekening Tujuan (Mutasi)</label>
                <select id="destination_account_id" name="destination_account_id" data-hs-select='{
                  "hasSearch": true,
                  "searchPlaceholder": "Cari rekening tujuan...",
                  "searchClasses": "block w-full text-sm border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 py-2 px-3",
                  "searchWrapperClasses": "bg-white p-2 -mx-1 sticky top-0 z-10",
                  "placeholder": "Pilih rekening tujuan...",
                  "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                  "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 pl-4 pr-9 flex text-nowrap w-full cursor-pointer bg-white border border-gray-200 text-gray-800 rounded-lg text-left text-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50",
                  "dropdownClasses": "mt-2 z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg shadow-xl overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-none [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300",
                  "optionClasses": "hs-selected:bg-blue-50 py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50",
                  "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-3.5 text-blue-600\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>",
                  "extraMarkup": "<div class=\"absolute top-1/2 -translate-y-1/2\" style=\"right: 0.75rem;\"><svg class=\"shrink-0 size-3.5 text-gray-400\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
                }' class="hidden">
                    <option value="">Pilih Rekening Tujuan</option>
                    @foreach($accounts as $acc)
                        <option value="{{ $acc->id }}" data-icon="{{ $acc->logo ? asset('storage/' . $acc->logo) : asset('images/logos/wallet.png') }}" {{ old('destination_account_id', $transaction->destination_account_id ?? '') == $acc->id ? 'selected' : '' }}>{{ $acc->name }}</option>
                    @endforeach
                </select>
            </div>

            <div id="wrapper_category">
                <label for="category_id" class="block text-sm font-semibold text-gray-800 mb-2">Kategori</label>
                <select id="category_id" name="category_id" data-hs-select='{
                  "hasSearch": true,
                  "searchPlaceholder": "Cari kategori...",
                  "searchClasses": "block w-full text-sm border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 py-2 px-3",
                  "searchWrapperClasses": "bg-white p-2 -mx-1 sticky top-0 z-10",
                  "placeholder": "Pilih kategori...",
                  "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                  "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 pl-4 pr-9 flex text-nowrap w-full cursor-pointer bg-white border border-gray-200 text-gray-800 rounded-lg text-left text-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50",
                  "dropdownClasses": "mt-2 z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg shadow-xl overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-none [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300",
                  "optionClasses": "hs-selected:bg-blue-50 py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50",
                  "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-3.5 text-blue-600\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>",
                  "extraMarkup": "<div class=\"absolute top-1/2 -translate-y-1/2\" style=\"right: 0.75rem;\"><svg class=\"shrink-0 size-3.5 text-gray-400\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
                }' class="hidden">
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" data-icon="{{ $cat->icon ?? '📁' }}" data-type="{{ $cat->type }}" {{ old('category_id', $transaction->category_id ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div id="wrapper_allocation">
                <label for="allocation" class="block text-sm font-semibold text-gray-800 mb-2">Peruntukan Dana</label>
                <select id="allocation" name="allocation" data-hs-select='{
                  "hasSearch": true,
                  "searchPlaceholder": "Cari peruntukan...",
                  "searchClasses": "block w-full text-sm border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 py-2 px-3",
                  "searchWrapperClasses": "bg-white p-2 -mx-1 sticky top-0 z-10",
                  "placeholder": "Pilih Peruntukan...",
                  "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                  "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 pl-4 pr-9 flex text-nowrap w-full cursor-pointer bg-white border border-gray-200 text-gray-800 rounded-lg text-left text-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50",
                  "dropdownClasses": "mt-2 z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg shadow-xl overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-none [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300",
                  "optionClasses": "hs-selected:bg-blue-50 py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50",
                  "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-3.5 text-blue-600\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>",
                  "extraMarkup": "<div class=\"absolute top-1/2 -translate-y-1/2\" style=\"right: 0.75rem;\"><svg class=\"shrink-0 size-3.5 text-gray-400\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
                }' class="hidden">
                    @php $allocs = ['Pribadi', 'Istri', 'Bersama', 'Kantor']; @endphp
                    @foreach($allocs as $alloc)
                        <option value="{{ $alloc }}" {{ old('allocation', $transaction->allocation ?? 'Pribadi') == $alloc ? 'selected' : '' }}>{{ $alloc }}</option>
                    @endforeach
                </select>
            </div>

            <div id="wrapper_related_party" class="sm:col-span-2">
                <label for="related_party" class="block text-sm font-semibold text-gray-800 mb-2" id="label_related_party">Pihak Terkait (Tujuan Pembayaran)</label>
                <input type="text" id="related_party" name="related_party" value="{{ old('related_party', $transaction->related_party ?? '') }}" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm" placeholder="Contoh: Toko ABC, Budi...">
            </div>

            <div class="sm:col-span-2">
                <label for="description" class="block text-sm font-semibold text-gray-800 mb-2">Keterangan Singkat</label>
                <input type="text" id="description" name="description" value="{{ old('description', $transaction->description ?? '') }}" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm" placeholder="Catatan tambahan...">
            </div>

            <div class="sm:col-span-2 flex items-center mb-2">
                <input type="checkbox" id="toggle_items" class="shrink-0 mt-0.5 border-gray-200 rounded text-blue-600 focus:ring-blue-500 cursor-pointer w-5 h-5" {{ !empty(old('items', $transaction->items ?? [])) ? 'checked' : '' }}>
                <label for="toggle_items" class="text-sm font-medium text-gray-700 ms-3 cursor-pointer">Gunakan Tabel Rincian Banyak Barang (Otomatis hitung total)</label>
            </div>

            <div id="wrapper_items" class="sm:col-span-2 hidden bg-blue-50 p-5 border border-blue-100 rounded-xl w-full">
                <div class="mb-4 flex justify-between items-center">
                    <div class="flex gap-2">
                        <button type="button" id="btnAddDiscount" class="py-2 px-3 inline-flex items-center gap-x-2 text-xs font-bold rounded-lg border border-blue-200 bg-white text-blue-600 hover:bg-blue-50 transition">
                            Tambah Diskon
                        </button>
                        <button type="button" id="btnAddItem" class="py-2 px-3 inline-flex items-center gap-x-2 text-xs font-bold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 transition">
                            <svg class="flex-shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                <path d="M8 0a1 1 0 0 1 1 1v6h6a1 1 0 1 1 0 2H9v6a1 1 0 1 1-2 0V9H1a1 1 0 0 1 1-1z"/>
                            </svg>
                            Tambah Baris
                        </button>
                    </div>
                </div>
                <div id="itemsContainer" class="space-y-3 w-full">
                    <!-- Item rows will be injected here -->
                </div>

                <!-- Transaction Summary -->
                <div class="mt-4 pt-4 border-t border-blue-200 flex flex-col items-end space-y-2 w-full">
                    <div class="flex justify-between w-full sm:w-64 text-sm font-semibold text-gray-600">
                        <span>Subtotal Barang:</span>
                        <span>Rp <span id="summary_subtotal">0</span></span>
                    </div>
                    
                    <div id="wrapper_discount" class="flex items-center justify-between w-full sm:w-72 {{ old('discount', $transaction->discount ?? 0) > 0 ? '' : 'hidden' }}">
                        <span class="text-sm font-semibold text-gray-600">Diskon:</span>
                        <div class="flex items-center gap-2">
                            <div class="relative w-32 shrink-0">
                                <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-3">
                                    <span class="text-gray-500 sm:text-sm">- Rp</span>
                                </div>
                                <input type="text" id="global_discount_display" class="py-1 ps-10 pe-2 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 text-end" value="{{ old('discount', $transaction->discount ?? '') }}">
                                <input type="hidden" id="global_discount" name="discount" value="{{ old('discount', $transaction->discount ?? '') }}">
                            </div>
                            <button type="button" id="btnRemoveDiscount" class="text-gray-400 hover:text-red-500 transition focus:outline-none" title="Hapus Diskon">
                                <svg class="size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>
                            </button>
                        </div>
                    </div>
                    
                    <div class="flex justify-between w-full sm:w-64 text-base font-bold text-gray-900 pt-2 border-t border-dashed border-gray-300">
                        <span>Grand Total:</span>
                        <span>Rp <span id="summary_grand_total">0</span></span>
                    </div>
                </div>
            </div>

            <div class="sm:col-span-2">
                <label for="amount_display" class="block text-lg font-bold text-gray-800 mb-2">Nominal Utama (Rp)</label>
                <input type="text" id="amount_display" class="py-4 px-5 block w-full border-gray-300 rounded-xl text-2xl font-bold focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-colors" required placeholder="0" value="{{ old('amount', $transaction->amount ?? '') }}">
                <input type="hidden" id="amount" name="amount" value="{{ old('amount', $transaction->amount ?? '') }}">
            </div>

            <div class="sm:col-span-2">
                <label for="receipt" class="block text-sm font-semibold text-gray-800 mb-2">Upload Struk (Opsional)</label>
                <input type="file" id="receipt" name="receipt" class="block w-full border border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 file:border-0 file:bg-gray-100 file:me-4 file:py-3 file:px-4 cursor-pointer">
                @if(isset($transaction) && $transaction->receipt_path)
                    <div class="mt-2 text-sm text-gray-500">Struk saat ini: <a href="{{ Storage::url($transaction->receipt_path) }}" target="_blank" class="text-blue-600 hover:underline">Lihat Gambar</a></div>
                @endif
            </div>
        </div>

        <div class="mt-8 flex flex-col sm:flex-row gap-3">
            <button type="submit" name="action" value="save_dashboard" class="w-full sm:w-auto flex-1 py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-bold rounded-xl border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition shadow-md disabled:opacity-50 disabled:pointer-events-none">
                Simpan & Ke Dashboard
            </button>
            @if(!$transaction)
            <button type="submit" name="action" value="save_new" class="w-full sm:w-auto flex-1 py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-bold rounded-xl border border-gray-200 bg-white text-gray-800 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition shadow-sm disabled:opacity-50 disabled:pointer-events-none">
                Simpan & Tambah Baru
            </button>
            @endif
        </div>
    </form>
    
    <!-- Dummy div to force Tailwind to compile classes used inside JSON data attributes -->
    <div class="hidden right-3 pl-4 pr-9 text-left absolute top-1/2 -translate-y-1/2"></div>
</div>
@endsection

@push('scripts')
<script>
    window.allCategoriesData = @json($categories);
    document.addEventListener('DOMContentLoaded', function() {
        const typeInputs = document.querySelectorAll('.tipe_transaksi_input');
        const btnTypes = document.querySelectorAll('.btn-type');
        const categorySelect = document.getElementById('category_id');
        const categoryOptions = categorySelect.querySelectorAll('option[data-type]');
        
        const wrapperDestAccount = document.getElementById('wrapper_dest_account');
        const wrapperCategory = document.getElementById('wrapper_category');
        const wrapperAllocation = document.getElementById('wrapper_allocation');
        const wrapperRelatedParty = document.getElementById('wrapper_related_party');
        const labelRelatedParty = document.getElementById('label_related_party');
        const labelSourceAccount = document.getElementById('label_source_account');

        const amountDisplay = document.getElementById('amount_display');
        const amountHidden = document.getElementById('amount');
        
        const toggleItems = document.getElementById('toggle_items');
        const wrapperItems = document.getElementById('wrapper_items');
        const btnAddItem = document.getElementById('btnAddItem');
        const btnAddDiscount = document.getElementById('btnAddDiscount');
        const btnRemoveDiscount = document.getElementById('btnRemoveDiscount');
        const wrapperDiscount = document.getElementById('wrapper_discount');
        const globalDiscountDisplay = document.getElementById('global_discount_display');
        const globalDiscountHidden = document.getElementById('global_discount');
        const summarySubtotal = document.getElementById('summary_subtotal');
        const summaryGrandTotal = document.getElementById('summary_grand_total');
        const itemsContainer = document.getElementById('itemsContainer');
        const form = document.getElementById('trxForm');

        // Existing old items for edit mode
        const existingItems = @json(old('items', $transaction->details ?? []));

        // Format Number helper
        function formatNumber(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
        function unformatNumber(str) {
            return str.toString().replace(/\./g, '');
        }

        // Logic for Type Buttons
        function updateTypeUI(val) {
            btnTypes.forEach(btn => {
                const btnVal = btn.getAttribute('data-val');
                btn.classList.remove('active');
                btn.setAttribute('aria-selected', 'false');
                
                if (btnVal === val) {
                    btn.classList.add('active');
                    btn.setAttribute('aria-selected', 'true');
                }
            });

            // Update type hidden inputs state
            typeInputs.forEach(input => {
                input.disabled = (input.value !== val);
            });

            // Update visible fields
            if (val === 'transfer') {
                wrapperDestAccount.classList.remove('hidden');
                wrapperCategory.classList.add('hidden');
                wrapperAllocation.classList.add('hidden');
                wrapperRelatedParty.classList.add('hidden');
                labelSourceAccount.textContent = 'Rekening Asal';
                
            } else {
                wrapperDestAccount.classList.add('hidden');
                wrapperCategory.classList.remove('hidden');
                wrapperAllocation.classList.remove('hidden');
                wrapperRelatedParty.classList.remove('hidden');
                
                if (val === 'in') {
                    labelRelatedParty.textContent = 'Pihak Terkait (Sumber Dana)';
                    labelSourceAccount.textContent = 'Rekening Penerima';
                } else {
                    labelRelatedParty.textContent = 'Pihak Terkait (Tujuan Pembayaran)';
                    labelSourceAccount.textContent = 'Rekening Sumber';
                }

                // Filter Categories based on data-type
                const wrapperCategory = document.getElementById('wrapper_category');
                const oldSelect = document.getElementById('category_id');
                const currentVal = oldSelect ? oldSelect.value : "";
                
                // Destroy existing instance if it exists
                if (window.HSSelect && oldSelect) {
                    const instance = window.HSSelect.getInstance(oldSelect);
                    if (instance) {
                        instance.destroy();
                    }
                }
                
                let optionsHtml = '<option value="">Pilih Kategori</option>';
                let hasValidSelection = false;
                
                if (window.allCategoriesData) {
                    window.allCategoriesData.forEach(cat => {
                        if (cat.type === val) {
                            const selected = (currentVal == cat.id) ? 'selected' : '';
                            if (selected) hasValidSelection = true;
                            optionsHtml += `<option value="${cat.id}" data-icon="${cat.icon || '📁'}" data-type="${cat.type}" ${selected}>${cat.name}</option>`;
                        }
                    });
                }
                
                const selectConfig = `{
                  "hasSearch": true,
                  "searchPlaceholder": "Cari kategori...",
                  "searchClasses": "block w-full text-sm border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 py-2 px-3",
                  "searchWrapperClasses": "bg-white p-2 -mx-1 sticky top-0 z-10",
                  "placeholder": "Pilih kategori...",
                  "toggleTag": "<button type='button' aria-expanded='false'></button>",
                  "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 pl-4 pr-9 flex text-nowrap w-full cursor-pointer bg-white border border-gray-200 text-gray-800 rounded-lg text-left text-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50",
                  "dropdownClasses": "mt-2 z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg shadow-xl overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-none [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300",
                  "optionClasses": "hs-selected:bg-blue-50 py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50",
                  "optionTemplate": "<div class='flex justify-between items-center w-full'><span data-title></span><span class='hidden hs-selected:block'><svg class='shrink-0 size-3.5 text-blue-600' xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><polyline points='20 6 9 17 4 12'/></svg></span></div>",
                  "extraMarkup": "<div class='absolute top-1/2 -translate-y-1/2' style='right: 0.75rem;'><svg class='shrink-0 size-3.5 text-gray-400' xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><path d='m7 15 5 5 5-5'/><path d='m7 9 5-5 5 5'/></svg></div>"
                }`;
                
                const label = wrapperCategory.querySelector('label');
                wrapperCategory.innerHTML = '';
                if (label) wrapperCategory.appendChild(label);
                
                const newSelect = document.createElement('select');
                newSelect.id = 'category_id';
                newSelect.name = 'category_id';
                newSelect.className = 'hidden';
                newSelect.setAttribute('data-hs-select', selectConfig);
                newSelect.innerHTML = optionsHtml;
                wrapperCategory.appendChild(newSelect);
                
                if (window.HSStaticMethods && typeof window.HSStaticMethods.autoInit === 'function') {
                    window.HSStaticMethods.autoInit(['select']);
                }
            }
        }

        btnTypes.forEach(btn => {
            btn.addEventListener('click', function() {
                const val = this.getAttribute('data-val');
                updateTypeUI(val);
            });
        });

        // Initialize Type UI
        const activeTypeInput = Array.from(typeInputs).find(input => !input.disabled);
        const initialType = activeTypeInput ? activeTypeInput.value : 'out';
        updateTypeUI(initialType);
        if(amountDisplay.value) {
            amountDisplay.value = formatNumber(amountDisplay.value);
        }

        // Nominal Utama formatting
        amountDisplay.addEventListener('input', function(e) {
            if (toggleItems.checked) return; // Read only when items toggled
            let val = unformatNumber(this.value).replace(/[^0-9]/g, '');
            if(val === '') {
                this.value = '';
                amountHidden.value = '';
                return;
            }
            this.value = formatNumber(val);
            amountHidden.value = val;
        });

        // Items logic
        toggleItems.addEventListener('change', function() {
            if (this.checked) {
                wrapperItems.classList.remove('hidden');
                amountDisplay.readOnly = true;
                amountDisplay.classList.add('bg-gray-100', 'text-gray-500');
                if(itemsContainer.children.length === 0) {
                    if(existingItems && existingItems.length > 0) {
                        existingItems.forEach(item => addEmptyItemRow(item));
                    } else {
                        addEmptyItemRow();
                    }
                }
                calculateTotalItems();
            } else {
                wrapperItems.classList.add('hidden');
                amountDisplay.readOnly = false;
                amountDisplay.classList.remove('bg-gray-100', 'text-gray-500');
            }
        });

        function calculateTotalItems() {
            let subtotal = 0;
            const subtotalInputs = itemsContainer.querySelectorAll('.item-subtotal-hidden');
            subtotalInputs.forEach(input => {
                let val = parseInt(input.value) || 0;
                subtotal += val;
            });
            
            let disc = parseInt(globalDiscountHidden.value) || 0;
            let grandTotal = subtotal - disc;
            if (grandTotal < 0) grandTotal = 0;

            summarySubtotal.textContent = formatNumber(subtotal);
            summaryGrandTotal.textContent = formatNumber(grandTotal);
            amountDisplay.value = formatNumber(grandTotal);
            amountHidden.value = grandTotal;
        }

        // Global discount listener
        globalDiscountDisplay.addEventListener('input', function() {
            let val = unformatNumber(this.value).replace(/[^0-9]/g, '');
            if(val === '') {
                this.value = '';
                globalDiscountHidden.value = '';
            } else {
                this.value = formatNumber(val);
                globalDiscountHidden.value = val;
            }
            calculateTotalItems();
        });

        btnAddDiscount.addEventListener('click', function() {
            wrapperDiscount.classList.remove('hidden');
            globalDiscountDisplay.focus();
        });

        btnRemoveDiscount.addEventListener('click', function() {
            globalDiscountDisplay.value = '';
            globalDiscountHidden.value = '';
            wrapperDiscount.classList.add('hidden');
            calculateTotalItems();
        });

        // Initialize global discount display
        if (globalDiscountDisplay.value) {
            globalDiscountDisplay.value = formatNumber(globalDiscountDisplay.value);
        }

        function addEmptyItemRow(data = null) {
            const index = itemsContainer.children.length;
            const row = document.createElement('div');
            row.className = 'flex flex-col sm:flex-row gap-2 sm:items-center bg-white p-3 rounded-lg border border-gray-200 shadow-sm';
            
            const name = data ? data.name : '';
            const price = data ? data.price : '';
            const qty = data ? data.qty : '1';
            const subtotal = data ? data.subtotal : '0';

            row.innerHTML = `
                <div class="flex-grow">
                    <input type="text" name="items[${index}][name]" value="${name}" placeholder="Nama Barang" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500" required>
                </div>
                <div class="w-full sm:w-36 shrink-0 relative">
                    <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-3">
                        <span class="text-gray-500 sm:text-sm">Rp</span>
                    </div>
                    <input type="text" name="items[${index}][price]" value="${price ? formatNumber(price) : ''}" placeholder="Harga Satuan" class="item-price py-2 ps-9 pe-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500" required>
                </div>
                <div class="w-full sm:w-20 shrink-0">
                    <input type="number" name="items[${index}][qty]" value="${qty}" placeholder="Qty" min="1" class="item-qty py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500" required>
                </div>
                <div class="w-full sm:w-36 shrink-0 relative bg-gray-50 rounded-lg border border-gray-200 flex items-center px-3 py-2">
                    <span class="text-gray-500 sm:text-sm me-1">Rp</span>
                    <span class="item-subtotal-display text-sm font-semibold text-gray-800 truncate">${formatNumber(subtotal)}</span>
                    <input type="hidden" name="items[${index}][subtotal]" class="item-subtotal-hidden" value="${subtotal}">
                </div>
                <button type="button" class="btn-remove-item shrink-0 inline-flex justify-center items-center size-9 text-sm font-semibold rounded-lg border border-transparent text-red-500 hover:bg-red-100 disabled:opacity-50 disabled:pointer-events-none">
                    <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                </button>
            `;
            itemsContainer.appendChild(row);

            const priceInput = row.querySelector('.item-price');
            const qtyInput = row.querySelector('.item-qty');
            const subtotalDisplay = row.querySelector('.item-subtotal-display');
            const subtotalHidden = row.querySelector('.item-subtotal-hidden');

            function updateSubtotal() {
                let priceStr = unformatNumber(priceInput.value).replace(/[^0-9]/g, '');
                if(priceStr === '') priceStr = '0';
                priceInput.value = formatNumber(priceStr);
                
                let qtyVal = parseInt(qtyInput.value) || 0;
                let subtotalVal = parseInt(priceStr) * qtyVal;
                
                subtotalDisplay.textContent = formatNumber(subtotalVal);
                subtotalHidden.value = subtotalVal;
                
                calculateTotalItems();
            }

            priceInput.addEventListener('input', updateSubtotal);
            qtyInput.addEventListener('input', updateSubtotal);

            row.querySelector('.btn-remove-item').addEventListener('click', function() {
                row.remove();
                calculateTotalItems();
            });
        }

        btnAddItem.addEventListener('click', () => addEmptyItemRow());

        // Init items if toggle was checked by old input or edit mode
        if (toggleItems.checked) {
            toggleItems.dispatchEvent(new Event('change'));
        }

        // Pre-submit hook to clean item prices
        form.addEventListener('submit', function(e) {
            // Unformat all item prices and discounts so they are saved as integers
            const priceInputs = itemsContainer.querySelectorAll('.item-price');
            priceInputs.forEach(input => {
                input.value = unformatNumber(input.value);
            });
            const discountInputs = itemsContainer.querySelectorAll('.item-discount');
            discountInputs.forEach(input => {
                input.value = unformatNumber(input.value);
            });
            
            if(!amountHidden.value) {
                amountHidden.value = '0';
            }
        });
        // Ensure Preline re-initializes Selects after we've changed their wrapper visibility
        setTimeout(() => {
            if (window.HSStaticMethods && typeof window.HSStaticMethods.autoInit === 'function') {
                window.HSStaticMethods.autoInit();
            }
        }, 100);

    });
</script>
@endpush
