<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TambahKolomTabelUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('tipe')->after('role');
            $table->string('bio')->after('tipe')->nullable();
            $table->bigInteger('xp')->after('email_verified');
            $table->integer('reputasi')->after('xp');
            $table->string('photo')->after('reputasi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('tipe');
            $table->dropColumn('bio');
            $table->dropColumn('xp');
            $table->dropColumn('reputasi');
            $table->dropColumn('photo');
        });
    }
}
