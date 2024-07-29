<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTransaksisForeignKey extends Migration
{
    public function up()
    {
        Schema::table('transaksi', function (Blueprint $table) {
            // Drop existing foreign key if it exists
            $table->dropForeign(['id_jenis']);

            // Add the foreign key constraint with cascading delete
            $table->foreign('id_jenis')
                ->references('id')
                ->on('jenis_motor')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('transaksi', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['id_jenis']);

            // Re-add the foreign key constraint without cascading delete
            $table->foreign('id_jenis')
                ->references('id')
                ->on('jenis_motor');
        });
    }
}

