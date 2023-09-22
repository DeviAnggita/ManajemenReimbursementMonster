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
        Schema::create('tb_reimbursement', function (Blueprint $table) {
            $table->increments('id_reimbursement');
            $table->unsignedInteger('id_user');
            $table->unsignedInteger('id_jenis_reimbursement');
            $table->unsignedInteger('id_status_pengajuan');
            $table->bigInteger('nomor_identitas_karyawan');
            $table->string('nama_karyawan', 100);
            $table->dateTime('tanggal_bayar');
            $table->dateTime('tanggal_reimbursement');
            $table->string('keterangan', 255);
            $table->bigInteger('total');
            $table->timestamps();
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_jenis_reimbursement')->references('id_jenis_reimbursement')->on('tb_jenis_reimbursement')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_status_pengajuan')->references('id_status_pengajuan')->on('tb_status_pengajuan')->onDelete('cascade')->onUpdate('cascade');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_reimbursement');
    }
};