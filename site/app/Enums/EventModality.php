<?php

namespace App\Enums;

enum EventModality: string
{
    case InPerson = 'in_person';
    case Hybrid = 'hybrid';
    case Remote = 'remote';
}
