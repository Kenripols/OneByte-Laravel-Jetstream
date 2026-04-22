<?php

namespace App\Enums;

enum QREventType: string
{
    case GENERATED  = 'generated';  //1
    case DOWNLOADED = 'downloaded'; //2
    case CLAIMED    = 'claimed';    //3
    //case REGISTERED = 'registered'; //
    case ASSIGNED   = 'assigned';   //4
    case EXPIRED    = 'expired';    //5
    case REPLACED   = 'replaced';   //6     
}