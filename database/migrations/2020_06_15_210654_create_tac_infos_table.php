<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTacInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tac_infos', function (Blueprint $table) {
            $table->id();
            $table->enum('horaire',['7','13','21','24'])->nullable(true);
            $table->date('date')->default(date('Y-m-d'));
            $table->double('autonomie_charbon',15,4)->nullable(true)->default(0);
            $table->double('production_totale_brut',15,4)->nullable(true)->default(0);
            $table->double('production_totale_net',15,4)->nullable(true)->default(0);
            $table->double('index',15,4)->nullable(true)->default(0);
            $table->unsignedBigInteger('centrale_id');//->nullable(true);
            $table->foreign('centrale_id')->references('id')->on('centrales');

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
        Schema::dropIfExists('tac_infos');
    }
}
