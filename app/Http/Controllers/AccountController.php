<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = Account::all();
        $categories = Category::all();
        return view('master-data', compact('accounts', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'initial_balance' => 'required|numeric|min:0',
            'logo' => 'nullable|string|max:255',
            'logo_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('logo_file')) {
            $path = $request->file('logo_file')->store('logos', 'public');
            $validated['logo'] = $path;
        }

        Account::create($validated);

        return redirect()->back()->with('success_account', 'Rekening baru berhasil ditambahkan.');
    }

    public function update(Request $request, Account $account)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'initial_balance' => 'required|numeric|min:0',
            'logo' => 'nullable|string|max:255',
            'logo_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('logo_file')) {
            if ($account->logo && Storage::disk('public')->exists($account->logo)) {
                Storage::disk('public')->delete($account->logo);
            }
            $path = $request->file('logo_file')->store('logos', 'public');
            $validated['logo'] = $path;
        }

        $account->update($validated);

        return redirect()->back()->with('success_account', 'Data Rekening berhasil diperbarui.');
    }

    public function destroy(Account $account)
    {
        if ($account->sourceTransactions()->exists() || $account->destinationTransactions()->exists()) {
            return redirect()->back()->with('error_account', 'Gagal dihapus: Rekening ini masih digunakan pada data transaksi.');
        }

        if ($account->logo && Storage::disk('public')->exists($account->logo)) {
            Storage::disk('public')->delete($account->logo);
        }

        $account->delete();

        return redirect()->back()->with('success_account', 'Rekening berhasil dihapus.');
    }
}
