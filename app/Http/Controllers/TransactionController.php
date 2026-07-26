<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Account;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        // Calculate account balances with transaction logic
        $accounts = Account::all()->map(function($account) {
            $in = Transaction::where('type', 'in')->where('source_account_id', $account->id)->sum('amount');
            $out = Transaction::where('type', 'out')->where('source_account_id', $account->id)->sum('amount');
            $transferOut = Transaction::where('type', 'transfer')->where('source_account_id', $account->id)->sum('amount');
            $transferIn = Transaction::where('type', 'transfer')->where('destination_account_id', $account->id)->sum('amount');
            
            $account->current_balance = $account->initial_balance + $in - $out - $transferOut + $transferIn;
            return $account;
        });

        // Overall balance is sum of all account current balances
        $totalBalance = $accounts->sum('current_balance');

        $now = Carbon::now();

        $totalIncomeThisMonth = Transaction::where('type', 'in')
            ->whereMonth('date', $now->month)
            ->whereYear('date', $now->year)
            ->sum('amount');

        $totalExpenseThisMonth = Transaction::where('type', 'out')
            ->whereMonth('date', $now->month)
            ->whereYear('date', $now->year)
            ->sum('amount');
            
        $peruntukan = [];
        foreach (['Pribadi', 'Istri', 'Bersama', 'Kantor'] as $alloc) {
            $peruntukan[$alloc] = [
                'in' => Transaction::where('allocation', $alloc)->where('type', 'in')->sum('amount'),
                'out' => Transaction::where('allocation', $alloc)->where('type', 'out')->sum('amount'),
            ];
        }

        $topPemasukan = Transaction::with('category')
            ->where('type', 'in')
            ->select('category_id', \DB::raw('SUM(amount) as total'))
            ->groupBy('category_id')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $topPengeluaran = Transaction::with('category')
            ->where('type', 'out')
            ->select('category_id', \DB::raw('SUM(amount) as total'))
            ->groupBy('category_id')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $query = Transaction::with(['category', 'sourceAccount', 'destinationAccount', 'details'])
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc');

        $timeMode = $request->input('time_mode');
        if ($timeMode === 'daily') {
            $date = $request->input('date_val');
            if (!$date) $date = Carbon::today()->format('Y-m-d');
            $query->whereDate('date', $date);
        } elseif ($timeMode === 'monthly') {
            $month = $request->input('month_val');
            if (!$month) $month = Carbon::today()->format('Y-m');
            $parts = explode('-', $month);
            if (count($parts) == 2) {
                $query->whereYear('date', $parts[0])->whereMonth('date', $parts[1]);
            }
        } elseif ($timeMode === 'yearly') {
            $year = $request->input('year_val');
            if (!$year) $year = Carbon::today()->format('Y');
            $query->whereYear('date', $year);
        }

        $transactions = $query->get();
        $categories = \App\Models\Category::all();

        return view('dashboard', compact(
            'totalBalance',
            'totalIncomeThisMonth',
            'totalExpenseThisMonth',
            'accounts',
            'peruntukan',
            'topPemasukan',
            'topPengeluaran',
            'transactions',
            'categories'
        ));
    }

    public function create()
    {
        $accounts = Account::all();
        $categories = \App\Models\Category::all();
        $transaction = null;
        return view('form-transaksi', compact('accounts', 'categories', 'transaction'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'type' => 'required|in:in,out,transfer',
            'allocation' => 'required|in:Pribadi,Istri,Bersama,Kantor',
            'category_id' => 'nullable|exists:categories,id',
            'source_account_id' => 'required|exists:accounts,id',
            'destination_account_id' => 'nullable|exists:accounts,id|required_if:type,transfer',
            'amount' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'related_party' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'items' => 'nullable|array',
            'items.*.name' => 'required_with:items|string',
            'items.*.price' => 'required_with:items|numeric|min:0',
            'items.*.qty' => 'required_with:items|integer|min:1',
            'items.*.subtotal' => 'required_with:items|numeric|min:0',
            'receipt' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Upload file struk jika ada
        if ($request->hasFile('receipt')) {
            $path = $request->file('receipt')->store('receipts', 'public');
            $validated['receipt_path'] = $path;
        }

        // Hapus field 'receipt' dan 'items' dari array karena tidak ada di kolom database transactions
        unset($validated['receipt']);
        $items = $validated['items'] ?? [];
        unset($validated['items']);

        // Pastikan discount tidak null
        $validated['discount'] = $validated['discount'] ?? 0;

        $transaction = Transaction::create($validated);

        if (!empty($items)) {
            foreach ($items as $item) {
                $transaction->details()->create([
                    'name' => $item['name'],
                    'price' => $item['price'],
                    'qty' => $item['qty'],
                    'subtotal' => $item['subtotal']
                ]);
            }
        }

        if ($request->input('action') === 'save_new') {
            return redirect()->route('transactions.create')->with('success', 'Transaksi berhasil disimpan.');
        }

        return redirect()->route('dashboard')->with('success', 'Transaksi berhasil disimpan.');
    }

    public function edit(Transaction $transaction)
    {
        // Load details untuk form
        $transaction->load('details');
        
        $accounts = Account::all();
        $categories = \App\Models\Category::all();
        return view('form-transaksi', compact('accounts', 'categories', 'transaction'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'type' => 'required|in:in,out,transfer',
            'allocation' => 'required|in:Pribadi,Istri,Bersama,Kantor',
            'category_id' => 'nullable|exists:categories,id',
            'source_account_id' => 'required|exists:accounts,id',
            'destination_account_id' => 'nullable|exists:accounts,id|required_if:type,transfer',
            'amount' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'related_party' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'items' => 'nullable|array',
            'items.*.name' => 'required_with:items|string',
            'items.*.price' => 'required_with:items|numeric|min:0',
            'items.*.qty' => 'required_with:items|integer|min:1',
            'items.*.subtotal' => 'required_with:items|numeric|min:0',
            'receipt' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($request->hasFile('receipt')) {
            $path = $request->file('receipt')->store('receipts', 'public');
            $validated['receipt_path'] = $path;
        }

        unset($validated['receipt']);
        $items = $validated['items'] ?? [];
        unset($validated['items']);

        // Pastikan discount tidak null
        $validated['discount'] = $validated['discount'] ?? 0;

        $transaction->update($validated);

        $transaction->details()->delete();
        if (!empty($items)) {
            foreach ($items as $item) {
                $transaction->details()->create([
                    'name' => $item['name'],
                    'price' => $item['price'],
                    'qty' => $item['qty'],
                    'subtotal' => $item['subtotal']
                ]);
            }
        }

        return redirect()->route('dashboard')->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return redirect()->route('dashboard')->with('success', 'Transaksi berhasil dihapus.');
    }
}
