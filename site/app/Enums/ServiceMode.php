<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ServiceMode: string implements HasLabel
{
    case Documento = 'documento';
    case Cabina = 'cabina';

    public function getLabel(): string
    {
        return __('admin.modes.'.$this->value);
    }
}
