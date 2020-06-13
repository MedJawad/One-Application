<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrevisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('previsions', function (Blueprint $table) {
            $table->id();
            $table->enum('horaire',['0H','1H','2H','3H','4H','5H','6H','7H','8H','9H','10H','11H','12H','13H','14H','15H','16H','17H','18H','19H','20H','21H','22H','23H','24H']);
            $table->double('value',15,4)->default(0);

            $table->unsignedBigInteger('previsionable_id');//->nullable(true);
            $table->string('previsionable_type');//->nullable(true);

            $table->timestamps();
//            $table->foreign('barrage_infos_id')->references('id')->on('barrage_infos');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('previsions');
    }
}
