@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="mb-4">
        <h2 class="text-2xl font-bold text-gray-800">Master Data</h2>
        <p class="text-sm text-gray-600 mt-1">Kelola data Rekening dan Kategori transaksi.</p>
    </div>

    <!-- Error Messages (from Destroy protections) -->
    @if(session('error_account'))
    <div class="bg-red-50 border-s-4 border-red-500 p-4 mb-4" role="alert">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="flex-shrink-0 size-4 text-red-500 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"></path>
                </svg>
            </div>
            <div class="ms-3">
                <p class="text-sm text-red-700 font-medium">{{ session('error_account') }}</p>
            </div>
        </div>
    </div>
    @endif

    @if(session('error_category'))
    <div class="bg-red-50 border-s-4 border-red-500 p-4 mb-4" role="alert">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="flex-shrink-0 size-4 text-red-500 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"></path>
                </svg>
            </div>
            <div class="ms-3">
                <p class="text-sm text-red-700 font-medium">{{ session('error_category') }}</p>
            </div>
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <!-- Manajemen Rekening -->
        <div class="flex flex-col bg-white border shadow-sm rounded-xl">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 rounded-t-xl">
                <h3 id="account_form_title" class="text-lg font-bold text-gray-800">Manajemen Rekening</h3>
            </div>
            
            <div class="p-6">
                @if(session('success_account'))
                <div class="bg-teal-50 border-t-2 border-teal-500 rounded-lg p-4 mb-6 shadow-sm" role="alert">
                    <div class="flex">
                        <div class="ms-3">
                            <p class="text-sm text-gray-700 font-medium">{{ session('success_account') }}</p>
                        </div>
                    </div>
                </div>
                @endif

                <form action="{{ route('accounts.store') }}" method="POST" enctype="multipart/form-data" id="accountForm" class="mb-8">
                    @csrf
                    <input type="hidden" name="_method" id="account_method" value="POST" disabled>
                    <input type="hidden" name="id" id="account_edit_id">
                    
                    <div class="space-y-4">
                        <div>
                            <label for="account_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Rekening</label>
                            <input type="text" id="account_name" name="name" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm" required placeholder="Contoh: BCA, Dompet Utama">
                        </div>
                        <div>
                            <label for="initial_balance_display" class="block text-sm font-medium text-gray-700 mb-2">Saldo Awal (Rp)</label>
                            <input type="text" id="initial_balance_display" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm" required placeholder="0">
                            <input type="hidden" id="initial_balance" name="initial_balance">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="logo_text" class="block text-sm font-medium text-gray-700 mb-2">Logo (Emoji/Teks)</label>
                                <input type="text" id="logo_text" name="logo" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm" placeholder="Contoh: 🏦">
                            </div>
                            <div>
                                <label for="logo_file" class="block text-sm font-medium text-gray-700 mb-2">ATAU Upload Gambar</label>
                                <input type="file" id="logo_file" name="logo_file" class="block w-full border border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 file:border-0 file:bg-gray-100 file:me-4 file:py-2 file:px-3">
                            </div>
                        </div>
                        <div class="flex gap-x-2">
                            <button type="submit" id="account_submit_btn" class="py-2 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none transition w-full sm:w-auto">
                                Tambah Rekening
                            </button>
                            <button type="button" id="account_cancel_btn" class="hidden py-2 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none transition" onclick="resetAccountForm()">
                                Batal
                            </button>
                        </div>
                    </div>
                </form>

                <h4 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-3">Daftar Rekening</h4>
                <div class="overflow-x-auto border rounded-lg max-h-[400px] overflow-y-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 sticky top-0 z-10">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-start text-xs font-semibold text-gray-500 uppercase">Rekening</th>
                                <th scope="col" class="px-4 py-3 text-end text-xs font-semibold text-gray-500 uppercase">Saldo Awal</th>
                                <th scope="col" class="px-4 py-3 text-end text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse($accounts as $acc)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-bold text-gray-800 flex items-center gap-3">
                                    @if($acc->logo)
                                        @if(preg_match('/\./', $acc->logo))
                                            <img src="{{ Storage::url($acc->logo) }}" alt="Logo" class="w-8 h-8 rounded-full object-cover border border-gray-200">
                                        @else
                                            <span class="text-2xl leading-none">{{ $acc->logo }}</span>
                                        @endif
                                    @endif
                                    <span>{{ $acc->name }}</span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-semibold text-gray-800 text-end">Rp {{ number_format($acc->initial_balance, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-end text-sm font-medium">
                                    <button type="button" class="inline-flex items-center gap-x-1 text-sm font-semibold rounded-lg border border-transparent text-amber-600 hover:text-amber-800 disabled:opacity-50 disabled:pointer-events-none mr-2" 
                                        onclick="editAccount({{ $acc->id }}, '{{ addslashes($acc->name) }}', '{{ $acc->initial_balance }}', '{{ !preg_match('/\./', $acc->logo ?? '') ? addslashes($acc->logo) : '' }}')">
                                        Edit
                                    </button>
                                    <form action="{{ route('accounts.destroy', $acc->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-x-1 text-sm font-semibold rounded-lg border border-transparent text-red-600 hover:text-red-800 disabled:opacity-50 disabled:pointer-events-none" onclick="return confirm('Yakin ingin menghapus rekening ini?')">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="px-4 py-3 text-center text-sm text-gray-500">Belum ada rekening</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- End Manajemen Rekening -->

        <!-- Manajemen Kategori -->
        <div class="flex flex-col bg-white border shadow-sm rounded-xl">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 rounded-t-xl">
                <h3 id="category_form_title" class="text-lg font-bold text-gray-800">Manajemen Kategori</h3>
            </div>
            
            <div class="p-6">
                @if(session('success_category'))
                <div class="bg-teal-50 border-t-2 border-teal-500 rounded-lg p-4 mb-6 shadow-sm" role="alert">
                    <div class="flex">
                        <div class="ms-3">
                            <p class="text-sm text-gray-700 font-medium">{{ session('success_category') }}</p>
                        </div>
                    </div>
                </div>
                @endif

                <form action="{{ route('categories.store') }}" method="POST" id="categoryForm" class="mb-8">
                    @csrf
                    <input type="hidden" name="_method" id="category_method" value="POST" disabled>
                    <input type="hidden" name="id" id="category_edit_id">
                    
                    <div class="space-y-4">
                        <div class="grid grid-cols-3 gap-4">
                            <div class="col-span-2">
                                <label for="category_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Kategori</label>
                                <input type="text" id="category_name" name="name" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm" required placeholder="Contoh: Makanan, Gaji">
                            </div>
                            <div>
                                <label for="category_icon" class="block text-sm font-medium text-gray-700 mb-2">Icon (Emoji)</label>
                                <input type="text" id="category_icon" name="icon" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm" placeholder="🍔" maxlength="10">
                            </div>
                        </div>
                        <div>
                            <label for="category_type" class="block text-sm font-medium text-gray-700 mb-2">Tipe Kategori</label>
                            <select id="category_type" name="type" data-hs-select='{
                                "placeholder": "Pilih Tipe",
                                "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                                "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 pl-4 pr-9 flex text-nowrap w-full cursor-pointer bg-white border border-gray-200 text-gray-800 rounded-lg text-start text-sm hover:bg-gray-50 focus:outline-none focus:border-blue-500 focus:ring-blue-500",
                                "dropdownClasses": "mt-2 z-[100] w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg shadow-lg overflow-hidden overflow-y-auto",
                                "optionClasses": "hs-selected:bg-blue-50 hs-selected:text-blue-600 py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100"
                            }' class="hidden" required>
                                <option value="out">Pengeluaran</option>
                                <option value="in">Pemasukan</option>
                            </select>
                        </div>
                        <div class="flex gap-x-2">
                            <button type="submit" id="category_submit_btn" class="py-2 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none transition w-full sm:w-auto">
                                Tambah Kategori
                            </button>
                            <button type="button" id="category_cancel_btn" class="hidden py-2 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none transition" onclick="resetCategoryForm()">
                                Batal
                            </button>
                        </div>
                    </div>
                </form>

                <h4 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-3">Daftar Kategori</h4>
                <div class="overflow-x-auto border rounded-lg max-h-[400px] overflow-y-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 sticky top-0 z-10">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-start text-xs font-semibold text-gray-500 uppercase">Kategori</th>
                                <th scope="col" class="px-4 py-3 text-start text-xs font-semibold text-gray-500 uppercase">Tipe</th>
                                <th scope="col" class="px-4 py-3 text-end text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse($categories as $cat)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-bold text-gray-800 flex items-center gap-3">
                                    @if($cat->icon)
                                        <span class="text-2xl leading-none">{{ $cat->icon }}</span>
                                    @else
                                        <span class="w-8"></span>
                                    @endif
                                    <span>{{ $cat->name }}</span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm">
                                    @if($cat->type == 'in') <span class="inline-flex items-center gap-1.5 py-1 px-2 rounded-md text-xs font-medium bg-green-100 text-green-800">Pemasukan</span>
                                    @else <span class="inline-flex items-center gap-1.5 py-1 px-2 rounded-md text-xs font-medium bg-red-100 text-red-800">Pengeluaran</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-end text-sm font-medium">
                                    <button type="button" class="inline-flex items-center gap-x-1 text-sm font-semibold rounded-lg border border-transparent text-amber-600 hover:text-amber-800 disabled:opacity-50 disabled:pointer-events-none mr-2"
                                        onclick="editCategory({{ $cat->id }}, '{{ addslashes($cat->name) }}', '{{ addslashes($cat->icon) }}', '{{ $cat->type }}')">
                                        Edit
                                    </button>
                                    <form action="{{ route('categories.destroy', $cat->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-x-1 text-sm font-semibold rounded-lg border border-transparent text-red-600 hover:text-red-800 disabled:opacity-50 disabled:pointer-events-none" onclick="return confirm('Yakin ingin menghapus kategori ini?')">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="px-4 py-3 text-center text-sm text-gray-500">Belum ada kategori</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- End Manajemen Kategori -->

    </div>
</div>

@endsection

@push('scripts')
<script>
    function formatNumber(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
    
    function unformatNumber(str) {
        return str.toString().replace(/\./g, '');
    }

    // --- Variables for Account Form ---
    const accountForm = document.getElementById('accountForm');
    const accountActionBase = "{{ route('accounts.store') }}";
    
    const accountFormTitle = document.getElementById('account_form_title');
    const accountSubmitBtn = document.getElementById('account_submit_btn');
    const accountCancelBtn = document.getElementById('account_cancel_btn');
    
    const accountMethod = document.getElementById('account_method');
    const accountEditId = document.getElementById('account_edit_id');
    const accountName = document.getElementById('account_name');
    const accountLogoText = document.getElementById('logo_text');
    const balanceDisplay = document.getElementById('initial_balance_display');
    const balanceHidden = document.getElementById('initial_balance');

    // --- Variables for Category Form ---
    const categoryForm = document.getElementById('categoryForm');
    const categoryActionBase = "{{ route('categories.store') }}";
    
    const categoryFormTitle = document.getElementById('category_form_title');
    const categorySubmitBtn = document.getElementById('category_submit_btn');
    const categoryCancelBtn = document.getElementById('category_cancel_btn');
    
    const categoryMethod = document.getElementById('category_method');
    const categoryEditId = document.getElementById('category_edit_id');
    const categoryName = document.getElementById('category_name');
    const categoryIcon = document.getElementById('category_icon');
    const categoryType = document.getElementById('category_type');

    document.addEventListener('DOMContentLoaded', function() {
        // Account Balance Formatting
        balanceDisplay.addEventListener('input', function(e) {
            let val = unformatNumber(this.value).replace(/[^0-9]/g, '');
            if(val === '') {
                this.value = '';
                balanceHidden.value = '';
                return;
            }
            this.value = formatNumber(val);
            balanceHidden.value = val;
        });

        accountForm.addEventListener('submit', function(e) {
            if(!balanceHidden.value) balanceHidden.value = '0';
        });
    });

    // --- Functions for Account ---
    function editAccount(id, name, balance, logo) {
        accountFormTitle.textContent = 'Edit Data Rekening';
        accountSubmitBtn.textContent = 'Update Data';
        accountCancelBtn.classList.remove('hidden');
        
        accountEditId.value = id;
        accountMethod.disabled = false;
        accountMethod.value = 'PUT';
        accountForm.action = accountActionBase + '/' + id; // e.g. /accounts/5

        accountName.value = name;
        balanceHidden.value = balance;
        balanceDisplay.value = formatNumber(balance);
        accountLogoText.value = logo;
        
        // Scroll to form smoothly
        accountFormTitle.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    function resetAccountForm() {
        accountFormTitle.textContent = 'Manajemen Rekening';
        accountSubmitBtn.textContent = 'Tambah Rekening';
        accountCancelBtn.classList.add('hidden');
        
        accountEditId.value = '';
        accountMethod.disabled = true;
        accountForm.action = accountActionBase; // Back to /accounts
        
        accountForm.reset();
        balanceHidden.value = '';
    }

    // --- Functions for Category ---
    function editCategory(id, name, icon, type) {
        categoryFormTitle.textContent = 'Edit Data Kategori';
        categorySubmitBtn.textContent = 'Update Data';
        categoryCancelBtn.classList.remove('hidden');
        
        categoryEditId.value = id;
        categoryMethod.disabled = false;
        categoryMethod.value = 'PUT';
        categoryForm.action = categoryActionBase + '/' + id; // e.g. /categories/5

        categoryName.value = name;
        categoryIcon.value = icon;
        categoryType.value = type;
        
        // Scroll to form smoothly
        categoryFormTitle.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    function resetCategoryForm() {
        categoryFormTitle.textContent = 'Manajemen Kategori';
        categorySubmitBtn.textContent = 'Tambah Kategori';
        categoryCancelBtn.classList.add('hidden');
        
        categoryEditId.value = '';
        categoryMethod.disabled = true;
        categoryForm.action = categoryActionBase; // Back to /categories
        
        categoryForm.reset();
    }
</script>
@endpush
