<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('booking', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_jenis')->constrained('jenis_motor');
            $table->string('nama_penyewa');
            $table->string('wa1');
            $table->string('wa2')->nullable();
            $table->string('wa3')->nullable();
            $table->dateTime('tgl_sewa');
            $table->dateTime('tgl_kembali');
            $table->integer('helm');
            $table->integer('jashujan');
            $table->decimal('total', 10, 2);
            $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking');
    }
};
