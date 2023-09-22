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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id_user');
            $table->unsignedInteger('id_divisi');
            $table->unsignedInteger('id_strata');
            $table->unsignedInteger('id_role');
            $table->bigInteger('nomor_identitas_karyawan');
            $table->string('nama_karyawan', 100);
            $table->string('email_karyawan', 100)->unique();
            $table->string('password');
            $table->string('gaji',255);
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('id_divisi')->references('id_divisi')->on('tb_divisi')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_strata')->references('id_strata')->on('tb_strata')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('users');
    }
};