<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BuatTabelRecruits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recruits', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id')->unsigned();
            $table->string("nim");
            $table->string("prodi");
            $table->string("fakultas");
            $table->string("tempat_lahir");
            $table->date("tanggal_lahir");
            $table->string("alamat");
            $table->string("kos")->nullable();
            $table->bigInteger('no_wa');
            $table->string("sosmed");
            $table->longText('kegiatan');
            $table->longText('keahlian');
            $table->string('tim_prioritas');
            $table->string('divisi_prioritas');
            $table->string('tim_alternatif');
            $table->string('divisi_alternatif');
            $table->longText('alasan');
            $table->longText('essay')->nullable();
            $table->string("pas_photo");
            $table->string("karmas");
            $table->string("krs");
            $table->string("status")->default('diproses');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            // $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recruits');
    }
}
