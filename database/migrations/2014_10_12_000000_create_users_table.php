<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->enum('role',['admin','pch','user'])->default("user");
            $table->string('password');
            $table->rememberToken();
//            $table->unsignedBigInteger('centrale_id')->nullable(true);
            $table->timestamps();

//            $table->foreign('centrale_id')->references('id')->on('centrales');
        });
        // Insert Admin and pch
        DB::table('users')->insert(
            array(
                'username' => 'admin',
                'password' => bcrypt("admin"),
                'role' => 'admin'
            )
        );
        DB::table('users')->insert(
            array(
                'username' => 'pch',
                'password' => bcrypt("pch"),
                'role' => 'pch'
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
