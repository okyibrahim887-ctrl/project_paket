<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pakets', function (Blueprint $table) {
            $table->id();
            $table->string('nama_penerima', 100)->nullable();
            $table->string('no_wa', 20)->nullable();
            $table->string('nama_satpam', 100)->nullable();
            $table->string('status_cod', 1)->nullable();
            $table->integer('harga_cod')->nullable();
            $table->text('catatan')->nullable();
            $table->dateTime('tanggal')->useCurrent();
            $table->string('status_paket', 1)->nullable()->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pakets');
    }
}
