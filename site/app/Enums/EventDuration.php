<?php

namespace App\Enums;

enum EventDuration: string
{
    case HalfDay = 'half_day';
    case FullDay = 'full_day';
    case MultiDay = 'multi_day';
}
