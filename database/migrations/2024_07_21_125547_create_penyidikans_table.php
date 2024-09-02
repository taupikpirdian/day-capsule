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
        Schema::create('penyidikans', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->unsignedBigInteger('actor_id');
            $table->string('no_sp_dik');
            $table->date('date_sp_dik');
            $table->string('nilai_kerugian');
            $table->boolean('disertai_tppu');
            $table->string('perkara_pasal_35_ayat_1');
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
        Schema::dropIfExists('penyidikans');
    }
};
