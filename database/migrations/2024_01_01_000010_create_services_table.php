<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->text('description');
            $table->enum('category', ['print_hitam_putih', 'print_berwarna', 'fotocopy', 'jilid', 'laminating', 'scan', 'banner', 'lainnya']);
            $table->decimal('price_per_unit', 10, 2);
            $table->string('unit')->default('lembar');
            $table->integer('min_order')->default(1);
            $table->integer('turnaround_days')->default(1);
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
