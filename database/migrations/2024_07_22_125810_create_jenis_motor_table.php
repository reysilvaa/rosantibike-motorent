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
            $table->foreignId('id_stok')
                  ->constrained('stok')
                  ->onDelete('cascade'); // Menambahkan onDelete('cascade')
            $table->string('nopol', 10)->unique();
            $table->enum('status', ['ready', 'disewa', 'perpanjang'])->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jenis_motor');
    }
}
