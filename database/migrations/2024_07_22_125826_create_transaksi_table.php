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
            // $table->foreignId('id_user')->constrained('users');
            $table->foreignId('id_jenis')->constrained('jenis_motor');
            $table->string('nama_penyewa',50);
            $table->string('wa1',50);
            $table->string('wa2',50)->nullable();
            $table->string('wa3',50)->nullable();
            $table->dateTime('tgl_sewa');
            $table->dateTime('tgl_kembali');
            $table->integer('helm');
            $table->integer('jashujan');
            $table->decimal('total', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transaksi');
    }
}
