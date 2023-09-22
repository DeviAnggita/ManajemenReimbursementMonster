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
        Schema::create('tb_jenis_reimbursement', function (Blueprint $table) {
            $table->increments('id_jenis_reimbursement');
            $table->string('memiliki_supplier', 255);
            $table->string('nama_jenis_reimbursement', 100);
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
        Schema::dropIfExists('tb_jenis_reimbursement');
    }
};