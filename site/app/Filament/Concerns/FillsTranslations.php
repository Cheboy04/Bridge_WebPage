<?php

namespace App\Filament\Concerns;

/**
 * Spatie casts translatable columns to arrays, so Filament would fill the
 * form with `['es' => …]`. This fills each one with the current locale's
 * value instead; saving already writes that locale (D3.6, spec brg-03 §3.3).
 */
trait FillsTranslations
{
    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $record = $this->getRecord();

        if (! method_exists($record, 'getTranslatableAttributes')) {
            return $data;
        }

        foreach ($record->getTranslatableAttributes() as $attribute) {
            $data[$attribute] = $record->getAttribute($attribute);
        }

        return $data;
    }
}
