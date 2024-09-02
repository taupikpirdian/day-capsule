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
        Schema::create('penuntutans', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->unsignedBigInteger('actor_id');
            $table->string('no_spdp');
            $table->date('date_spdp');
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
        Schema::dropIfExists('penuntutans');
    }
};
