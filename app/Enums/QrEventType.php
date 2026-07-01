<?php

namespace App\Enums;

enum QrEventType: string
{
    case GENERATED  = 'generated';  //1 Flujo 3 HECHO
    case DOWNLOADED = 'downloaded'; //2 Flujo 4 HECHO 
    case CLAIMED    = 'claimed';    //3 Flujo 2 HECHO
    //case REGISTERED = 'registered'; //
<<<<<<< HEAD:app/Enums/QrEventType.php
    case ASSIGNED   = 'assigned';   //4 Flujo 1 HECHO
    case EXPIRED    = 'expired';    //5 Flujo 3 HECHO
    case REPLACED   = 'replaced';   //6 Flujo 3 HECHO    
}
=======
    case ASSIGNED   = 'assigned';   //5 Flujo 1 HECHO
    case EXPIRED    = 'expired';    //6 Flujo 3 HECHO
    case REPLACED   = 'replaced';   //7 Flujo HECHO
}
>>>>>>> origin/debug:app/Enums/QREventType.php
