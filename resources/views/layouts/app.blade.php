<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Keuangan</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1E40AF',
                    }
                }
            }
        }
    </script>
    <!-- Preline UI CSS & Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r border-gray-200 flex flex-col h-full shrink-0">
        <div class="h-16 flex items-center px-6 border-b border-gray-200">
            <a class="text-xl font-bold text-blue-600" href="{{ route('dashboard') }}">KeuanganKu</a>
        </div>
        <div class="flex-1 overflow-y-auto py-4">
            <nav class="space-y-1 px-3">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
                    Dashboard
                </a>
                <a href="{{ route('transactions.create') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('transactions.create') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
                    Pencatatan Transaksi
                </a>
                <a href="{{ route('accounts.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('accounts.index') || request()->routeIs('categories.index') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
                    Data Master
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-100">
                    Laporan
                </a>
            </nav>
        </div>
        <div class="p-4 border-t border-gray-200">
            <div class="mb-4 px-2">
                <p class="text-sm font-semibold text-gray-800">{{ Auth::check() ? Auth::user()->name : 'User' }}</p>
                <p class="text-xs text-gray-500">{{ Auth::check() ? Auth::user()->email : 'user@example.com' }}</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors">
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col h-full overflow-hidden bg-gray-50">
        <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
            <div class="max-w-7xl mx-auto">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Preline UI JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/preline@2.0.3/dist/preline.min.js"></script>
    @stack('scripts')
</body>
</html>
