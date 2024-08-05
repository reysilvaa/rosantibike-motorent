<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stok', function (Blueprint $table) {
            $table->id();
            $table->string('merk', 50); // Limit merk to 50 characters
            $table->string('judul', 100)->nullable();
            $table->string('deskripsi1', 100)->nullable();
            $table->string('deskripsi2', 100)->nullable();
            $table->string('deskripsi3', 100)->nullable();
            $table->enum('kategori', ['matic','manual']);
            $table->decimal('harga_perHari');
            $table->string('foto')->nullable();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok');
    }
};
