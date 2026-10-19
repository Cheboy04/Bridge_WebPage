<?php

namespace App\Enums;

enum LeadType: string
{
    case Contact = 'contact';
    case Translation = 'translation';
    case Interpreting = 'interpreting';
}
