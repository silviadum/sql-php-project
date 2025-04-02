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
        Schema::create('antrenori', function (Blueprint $table) {
            $table->id(); // ID-ul unic al antrenorului
            $table->string('nume');
            $table->string('prenume');
            $table->string('specializare'); // Ex: Fitness, Yoga etc.
            $table->string('email')->unique();
            $table->string('telefon')->unique();
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
        Schema::dropIfExists('antrenori');
    }
};
