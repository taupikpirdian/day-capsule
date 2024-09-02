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
        Schema::create('file_storages', function (Blueprint $table) {
            $table->id();
            $table->string('data_uuid');
            $table->string('file_type')->nullable();
            $table->string('file_name');
            $table->string('file_path');
            $table->string('url')->nullable();
            $table->integer('file_size')->nullable();
            $table->string('file_format')->nullable();
            $table->string('data_type')->nullable();
            $table->string('url_gdrive')->nullable();
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
        Schema::dropIfExists('file_storages');
    }
};
