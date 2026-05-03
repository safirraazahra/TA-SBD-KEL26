<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->string('payment_code')->unique();
            $table->enum('method', ['transfer_bca', 'transfer_mandiri', 'transfer_bri', 'gopay', 'ovo', 'dana', 'cod']);
            $table->decimal('amount', 12, 2);
            $table->enum('status', ['pending', 'verified', 'failed', 'refunded'])->default('pending');
            $table->string('proof_path')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
