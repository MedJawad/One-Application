<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarrageInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barrage_infos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('centrale_id');//->nullable(true);
            $table->enum('horaire',['7','13','21','24']);
            $table->date('date')->default(date('now'));
            $table->double( 'cote',15,4)->default(0);
            $table->double('turbine',15,4)->default(0);
            $table->double('irrigation',15,4)->default(0);
            $table->double('lache',15,4)->default(0);
            $table->double('production_totale_brut',15,4)->default(0);
            $table->double('production_totale_net',15,4)->default(0);

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
        Schema::dropIfExists('barrage_infos');
    }
}
