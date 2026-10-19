<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('status')->default('new');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('company')->nullable();
            $table->text('message')->nullable();
            // ERD I13: a lead keeps what the client asked for, so these rows can't be deleted.
            $table->foreignId('service_id')->nullable()->constrained()->restrictOnDelete();
            $table->foreignId('source_language_id')->nullable()->constrained('languages')->restrictOnDelete();
            $table->foreignId('target_language_id')->nullable()->constrained('languages')->restrictOnDelete();
            $table->json('needs')->nullable();
            $table->date('deadline')->nullable();
            $table->date('event_date')->nullable();
            $table->date('event_end_date')->nullable();
            $table->string('venue')->nullable();
            $table->string('modality')->nullable();
            $table->string('duration')->nullable();
            $table->unsignedTinyInteger('days')->nullable();
            $table->unsignedTinyInteger('language_count')->nullable();
            $table->unsignedSmallInteger('attendees')->nullable();
            $table->timestamp('consent_at');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // ERD I14: email or phone (ARCHITECTURE §3).
        DB::statement('ALTER TABLE leads ADD CONSTRAINT leads_contact_channel CHECK (email IS NOT NULL OR phone IS NOT NULL)');
    }

    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
