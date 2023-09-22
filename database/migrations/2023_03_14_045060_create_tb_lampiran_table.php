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
        Schema::create('tb_lampiran', function (Blueprint $table) {
            $table->increments('id_lampiran');
            $table->unsignedInteger('id_reimbursement');
            $table->unsignedBigInteger('id_supplier')->nullable();
            $table->unsignedBigInteger('id_proyek')->nullable();
            $table->unsignedInteger('id_jenis_reimbursement');
            $table->bigInteger('nomor_kwitansi');
            $table->dateTime('tanggal_kwitansi');
            $table->string('judul_kwitansi', 255);
            $table->string('nama_kwitansi', 255);
            $table->string('file', 255);
            $table->string('keterangan', 255);
            $table->timestamps();
            $table->foreign('id_reimbursement')->references('id_reimbursement')->on('tb_reimbursement')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_proyek')->references('id_proyek')->on('tb_proyek')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_supplier')->references('id_supplier')->on('tb_supplier')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_jenis_reimbursement')->references('id_jenis_reimbursement')->on('tb_jenis_reimbursement')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_lampiran');
    }
};