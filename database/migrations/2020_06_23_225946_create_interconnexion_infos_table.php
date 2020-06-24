<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterconnexionInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interconnexion_infos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('centrale_id');//->nullable(true);
            $table->enum('horaire', ['7', '13', '21', '24']);
            $table->date('date')->default(date('Y-m-d'));
            $table->double('production_totale_recu', 15, 4)->nullable(true)->default(0);
            $table->double('production_totale_fourni', 15, 4)->nullable(true)->default(0);
            $table->timestamps();
            $table->foreign('centrale_id')->references('id')->on('centrales');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('interconnexion_infos');
    }
}
