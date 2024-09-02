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
        Schema::create('actors', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('name');
            $table->string('tahapan');
            $table->unsignedBigInteger('jenis_perkara_id');
            $table->unsignedBigInteger('institution_category_id');
            $table->unsignedBigInteger('institution_category_part_id');
            $table->string('status');
            $table->unsignedBigInteger('pekerjaan_id')->nullable();
            $table->string('jenis_perkara_prioritas');
            $table->string('asal_perkara');
            $table->text('kasus_posisi')->nullable();
            $table->string('jpu')->nullable();
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
        Schema::dropIfExists('actors');
    }
};
