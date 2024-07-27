<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJenisMotorTable extends Migration
{
    public function up()
    {
        Schema::create('jenis_motor', function (Blueprint $table) {
            $table->id();
            $table->string('merk');
            $table->string('nopol');
            $table->string('foto')->nullable();
            $table->decimal('harga_perHari');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jenis_motor');
    }
}
