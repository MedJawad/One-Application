<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCentralesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('centrales', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->unique();
            $table->string('adresse')->nullable();
            $table->string('description')->nullable();
            $table->enum('type',['Barrage','Eolien','Solaire','Cycle Combine','Thermique a charbon','Turbine a gaz','Interconnexion']);
            $table->string('subtype')->default("normal");
            $table->unsignedBigInteger('user_id');//->nullable(true);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('centrales');
    }
}
