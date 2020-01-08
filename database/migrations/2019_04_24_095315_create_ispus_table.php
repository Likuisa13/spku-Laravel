<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIspusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ispus', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('waktu');
            $table->double('Ico',6,2);
            $table->double('Idebu',6,2);
            $table->double('Ino2',6,2);
            $table->string('Kco');
            $table->string('Kdebu');
            $table->string('Kno2');
        });
        Schema::table('ispus', function (Blueprint $table) {
            $table->string('kode',10)->after('id');
            // $table->foreign('kode')->references('kode')->on('stasiuns')->onDelete('cascade');
        });
    } 

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ispus');
    }
}
