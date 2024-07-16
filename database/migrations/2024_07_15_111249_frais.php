<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('frais', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Ajout de la colonne user_id
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade'); // Ajout de la relation de clé étrangère
            $table->date('Date');
            $table->string('Trajet');
            $table->string('Motif');
            $table->string('Hebergement');
            $table->string('repas');
            $table->string('Justificatif');
            $table->string('pice')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('frais');
    }
};

