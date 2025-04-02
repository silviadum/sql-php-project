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
        Schema::create('abonamente', function (Blueprint $table) {
            $table->id(); // ID-ul unic al abonamentului
            $table->string('tip_abonament'); // Ex: Basic, Premium
            $table->decimal('pret', 8, 2); // Prețul abonamentului
            $table->date('data_incepere');
            $table->date('data_sfarsit');
            $table->foreignId('membru_id')->constrained('membri')->onDelete('cascade'); // Legătură cu tabelul membri
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
        Schema::dropIfExists('abonamente');
    }
};
