<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnuariousersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anuariousers', function (Blueprint $table) {
            $table->id();
    $table->foreignId('id_anuario')->constrained('anuariosfins')->onDelete('cascade');
    $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
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
        Schema::dropIfExists('anuariousers');
    }
}
