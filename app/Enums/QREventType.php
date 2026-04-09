<?php

namespace App\Enums;

enum QREventType: string
{
    case GENERATED  = 'generated';
    case DOWNLOADED = 'downloaded';
    case CLAIMED    = 'claimed';
    case REGISTERED = 'registered';
    case ASSIGNED   = 'assigned';
    case EXPIRED    = 'expired';
    case REPLACED   = 'replaced';
}