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
        Schema::create('clase', function (Blueprint $table) {
            $table->id(); // ID-ul unic al clasei
            $table->string('denumire_clasa'); // Ex: Yoga Basics
            $table->time('durata'); // Durata clasei
            $table->foreignId('antrenor_id')->constrained('antrenori')->onDelete('cascade'); // Legătură cu tabelul antrenori
            $table->timestamps(); // Coloane pentru created_at și updated_at
        });
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clase');
    }
};
