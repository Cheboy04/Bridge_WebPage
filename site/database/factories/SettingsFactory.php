<?php

namespace Database\Factories;

use App\Models\Settings;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Invented data only (ADR D2.2): the real values go into the admin (placeholder register).
 *
 * @extends Factory<Settings>
 */
class SettingsFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'phone_landline' => '+593 2 000 0000',
            'phone_mobile' => '+593 99 000 0000',
            'whatsapp_number' => '593990000000',
            'whatsapp_default_message' => ['es' => 'Hola, quisiera una cotización.'],
            'contact_email' => 'contacto@bridge.example.test',
            'notification_email' => 'solicitudes@bridge.example.test',
            'address' => 'Quito, Ecuador',
            'office_hours' => ['es' => 'Horario: [por confirmar]'],
        ];
    }
}
