<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('membri_clase', function (Blueprint $table) {
            $table->id();
            $table->foreignId('membru_id')->constrained('membri')->onDelete('cascade');
            $table->foreignId('clasa_id')->constrained('clase')->onDelete('cascade');
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
        Schema::dropIfExists('membri_clase');
    }
};
