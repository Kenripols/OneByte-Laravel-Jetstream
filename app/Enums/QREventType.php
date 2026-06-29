<?php

namespace App\Enums;

enum QREventType: string
{
    case GENERATED  = 'generated';  //1 Flujo 3 HECHO
    case DOWNLOADED = 'downloaded'; //2 Flujo 4 HECHO 
    case CLAIMED    = 'claimed';    //3 Flujo 2 HECHO
    //case REGISTERED = 'registered'; //
    case ASSIGNED   = 'assigned';   //5 Flujo 1 HECHO
    case EXPIRED    = 'expired';    //6 Flujo 3 HECHO
    case REPLACED   = 'replaced';   //7 Flujo HECHO
}