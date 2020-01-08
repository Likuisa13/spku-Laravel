<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStasiunsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stasiuns', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kode',10)->unique();
            $table->string('nama');
            $table->string('alamat');
            $table->decimal('latitude',10,8);
            $table->decimal('longitude',11,8);
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
        Schema::dropIfExists('stasiuns');
    }
}
