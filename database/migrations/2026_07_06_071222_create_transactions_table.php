<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->enum('type', ['in', 'out', 'transfer']);
            $table->enum('allocation', ['Pribadi', 'Istri', 'Bersama', 'Kantor']);
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->foreignId('source_account_id')->constrained('accounts')->cascadeOnDelete();
            $table->foreignId('destination_account_id')->nullable()->constrained('accounts')->cascadeOnDelete();
            $table->bigInteger('amount');
            $table->string('related_party')->nullable();
            $table->text('description')->nullable();
            $table->json('items')->nullable();
            $table->string('receipt_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
