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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->string('peminjam');
            $table->enum('status',['Dipinjam', 'Hilang/Rusak', 'Dikembalikan']);
            $table->integer('lama_pinjam');
            $table->integer('jumlah_barang')->default(1);
            $table->foreignId('inventory_id')->constrained('inventories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
