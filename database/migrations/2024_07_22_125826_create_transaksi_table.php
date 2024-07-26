<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiTable extends Migration
{
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('users');
            $table->foreignId('id_jenis')->constrained('jenis_motor');
            $table->string('nama_penyewa');
            $table->string('wa1');
            $table->string('wa2')->nullable();
            $table->string('wa3')->nullable();
            $table->date('tgl_sewa');
            $table->date('tgl_kembali');
            $table->enum('status', ['disewa', 'tersedia', 'perpanjang']);
            $table->decimal('total', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transaksi');
    }
}
