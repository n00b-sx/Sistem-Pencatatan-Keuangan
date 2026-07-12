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
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained('transactions')->cascadeOnDelete();
            $table->string('name');
            $table->bigInteger('price');
            $table->integer('qty');
            $table->bigInteger('discount')->default(0);
            $table->bigInteger('subtotal');
            $table->timestamps();
        });

        // Migrate data
        $transactions = DB::table('transactions')->whereNotNull('items')->get();
        foreach ($transactions as $trx) {
            $items = json_decode($trx->items, true);
            if (is_array($items)) {
                foreach ($items as $item) {
                    if (isset($item['name']) && isset($item['price']) && isset($item['qty'])) {
                        $price = (int)$item['price'];
                        $qty = (int)$item['qty'];
                        $subtotal = isset($item['subtotal']) ? (int)$item['subtotal'] : ($price * $qty);
                        
                        DB::table('transaction_details')->insert([
                            'transaction_id' => $trx->id,
                            'name' => $item['name'],
                            'price' => $price,
                            'qty' => $qty,
                            'discount' => 0,
                            'subtotal' => $subtotal,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
        }

        // Drop items column from transactions
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('items');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->json('items')->nullable();
        });

        // Restore data
        $transactions = DB::table('transactions')->get();
        foreach ($transactions as $trx) {
            $details = DB::table('transaction_details')->where('transaction_id', $trx->id)->get();
            if ($details->count() > 0) {
                $items = [];
                foreach ($details as $detail) {
                    $items[] = [
                        'name' => $detail->name,
                        'price' => $detail->price,
                        'qty' => $detail->qty,
                        'subtotal' => $detail->subtotal,
                    ];
                }
                DB::table('transactions')->where('id', $trx->id)->update([
                    'items' => json_encode($items)
                ]);
            }
        }

        Schema::dropIfExists('transaction_details');
    }
};
