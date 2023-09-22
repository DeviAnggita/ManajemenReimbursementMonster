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
        Schema::create('tb_status_pengajuan', function (Blueprint $table) {
            $table->increments('id_status_pengajuan');
            $table->unsignedInteger('id_role');
            $table->string('nama_status_pengajuan', 100);
            $table->timestamps();
            $table->foreign('id_role')->references('id_role')->on('tb_role')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_status_pengajuan');
    }
};