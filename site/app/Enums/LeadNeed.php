<?php

namespace App\Enums;

enum LeadNeed: string
{
    case TranslatorCertification = 'translator_certification';
    case Notarization = 'notarization';
    case Apostille = 'apostille';
    case Booths = 'booths';
    case Receivers = 'receivers';
    case Technician = 'technician';
    case Platform = 'platform';
}
