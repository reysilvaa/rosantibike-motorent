<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateJenisMotorTable extends Migration
{
    public function up()
    {
        Schema::create('jenis_motor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_stok')->constrained('stok');
            $table->string('nopol', 10)->unique();
            $table->enum('status', ['ready','disewa', 'perpanjang'])->nullable();

        });
        // DB::unprepared('
        //     CREATE TRIGGER reduce_stok_after_insert
        //     AFTER INSERT ON jenis_motor
        //     FOR EACH ROW
        //     BEGIN
        //         UPDATE stok
        //         SET stok = stok - 1
        //         WHERE id = NEW.id_stok;
        //     END
        // ');
    }

    public function down()
    {
        Schema::dropIfExists('jenis_motor');
    }
}
