<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublicacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publicaciones', function (Blueprint $table) {
            $table->id();
    $table->string('foto')->nullable();
    $table->text('descripcion')->nullable();
    $table->foreignId('id_anuario')->constrained('anuariosfins')->onDelete('cascade');
    $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
    $table->boolean('moderada')->default(false);
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
        Schema::dropIfExists('publicaciones');
    }
}
