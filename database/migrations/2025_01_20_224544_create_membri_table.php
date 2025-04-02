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
        Schema::create('membri', function (Blueprint $table) {
            $table->id(); // ID-ul unic al membrului
            $table->string('nume');
            $table->string('prenume');
            $table->date('data_nasterii');
            $table->string('email')->unique();
            $table->string('telefon')->unique();
            $table->string('parola'); // Parola (hashuită)
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
        Schema::dropIfExists('membri');
    }
};
