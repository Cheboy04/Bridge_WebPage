<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('language_lead', function (Blueprint $table) {
            $table->foreignId('language_id')->constrained()->restrictOnDelete();
            $table->foreignId('lead_id')->constrained()->cascadeOnDelete();
            $table->primary(['language_id', 'lead_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('language_lead');
    }
};
