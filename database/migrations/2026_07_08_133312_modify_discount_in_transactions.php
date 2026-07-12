<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->bigInteger('discount')->default(0)->after('amount');
        });

        // Migrate data
        $transactions = DB::table('transactions')->get();
        foreach ($transactions as $trx) {
            $totalDiscount = DB::table('transaction_details')
                ->where('transaction_id', $trx->id)
                ->sum('discount');
                
            if ($totalDiscount > 0) {
                DB::table('transactions')
                    ->where('id', $trx->id)
                    ->update(['discount' => $totalDiscount]);
            }
        }

        Schema::table('transaction_details', function (Blueprint $table) {
            $table->dropColumn('discount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            //
        });
    }
};
