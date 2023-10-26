<?php

namespace App\Service\Purchase;

enum PaymentStatusEnum: string
{
    case Pending = 'pending';
    case Payed = 'payed';
    case Error = 'error';
}
