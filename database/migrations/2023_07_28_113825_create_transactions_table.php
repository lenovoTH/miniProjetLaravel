<?php

use App\Models\Compte;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('typetransaction');
            $table->float('montant');
            $table->datetime('date');
            $table->foreignId('expediteur_id')->constrained('comptes')->onDelete('cascade')->nullable();
            $table->foreignId('recepteur_id')->constrained('comptes')->onDelete('cascade')->nullable();
            $table->string('code')->nullable();
            $table->boolean('annuler')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
