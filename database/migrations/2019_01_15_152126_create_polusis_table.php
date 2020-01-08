<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePolusisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('polusis', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('waktu');
            $table->decimal('latitude',10,8);
            $table->decimal('longitude',11,8);
            $table->double('suhu',4,2);
            $table->double('kelembaban',4,2);
            $table->double('co',4,2);
            $table->double('debu',4,2);
            $table->double('no',4,2);
        });
        Schema::table('polusis', function (Blueprint $table) {
            $table->string('kode',10)->after('id');
            $table->foreign('kode')->references('kode')->on('stasiuns')->onDelete('cascade');
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('polusis');
    }
}
