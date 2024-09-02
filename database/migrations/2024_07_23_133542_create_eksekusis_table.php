<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eksekusis', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->unsignedBigInteger('actor_id');
            $table->string('pidana_badan');
            $table->string('subsider_pidana_badan');
            $table->bigInteger('denda');
            $table->string('subsider_denda');
            $table->bigInteger('uang_pengganti');
            $table->string('barang_bukti');
            $table->string('pelelangan_barang_sitaan');
            $table->text('keterangan')->nullable();
            $table->text('catatan')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eksekusis');
    }
};
