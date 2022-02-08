<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use phpDocumentor\Reflection\Types\Nullable;

class TambahKolomRecruits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recruits', function (Blueprint $table) {
            $table->string('tim_diterima')->after('divisi_alternatif')->nullable();
            $table->string('divisi_diterima')->after('tim_diterima')->nullable();
            $table->integer('batch')->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recruits', function (Blueprint $table) {
            $table->dropColumn('tim_diterima');
            $table->dropColumn('divisi_diterima');
            $table->dropColumn('batch');
        });
    }
}
