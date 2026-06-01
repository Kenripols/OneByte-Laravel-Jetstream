<?php

namespace App\Enums;

enum QREventType: string
{
    case GENERATED  = 'generated';  //1 Flujo 3 HECHO
    case DOWNLOADED = 'downloaded'; //2 Flujo 4 HECHO (no admin)
    case CLAIMED    = 'claimed';    //3 Flujo 2 HECHO (no sesion iniciada)
    //case REGISTERED = 'registered'; //
    case ASSIGNED   = 'assigned';   //4 Flujo 1 
    case EXPIRED    = 'expired';    //5 Flujo 3 HECHO
    case REPLACED   = 'replaced';   //6 Flujo 3 HECHO    
}