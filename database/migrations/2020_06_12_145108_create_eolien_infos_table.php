<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEolienInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eolien_infos', function (Blueprint $table) {
            $table->id();
            $table->enum('type',['productions','previsions']);
            $table->enum('horaire',['7','13','21','24'])->nullable(true);
            $table->date('date')->default(date('Y-m-d'));
            $table->double('production_totale_brut',15,4)->nullable(true);
            $table->double('production_totale_net',15,4)->nullable(true);
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
        Schema::dropIfExists('eolien_infos');
    }
}
