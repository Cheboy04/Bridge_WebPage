<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('singleton')->default(true)->unique();
            $table->string('phone_landline')->nullable();
            $table->string('phone_mobile')->nullable();
            $table->string('whatsapp_number')->nullable();
            $table->json('whatsapp_default_message')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('notification_email')->nullable();
            $table->string('address')->nullable();
            $table->string('map_url')->nullable();
            $table->json('office_hours')->nullable();
            $table->json('socials')->nullable();
            $table->unsignedSmallInteger('founding_year')->nullable();
            $table->json('stats')->nullable();
            $table->json('ata_text')->nullable();
            $table->json('hero_hook')->nullable();
            $table->string('legal_name')->nullable();
            $table->timestamps();
        });

        // ERD I10: one row. MySQL refuses a CHECK on the auto-increment id, so the guard column carries it.
        DB::statement('ALTER TABLE settings ADD CONSTRAINT settings_single_row CHECK (singleton = 1)');
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
