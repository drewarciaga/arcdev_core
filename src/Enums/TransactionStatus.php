<?php

namespace ArcdevPackages\Core\Enums;

enum TransactionStatus: int
{
    case PENDING  = 0;
    case APPROVED = 1;
    case REJECTED = 2;
    case CANCELED = 3;
    case ONHOLD   = 4;
    case STARTED  = 5;
    case FINISHED = 6;
    case CLOSED   = 7;

    public function label(): string
    {
        return match($this) {
            self::PENDING   => 'Pending',
            self::APPROVED  => 'Approved',
            self::REJECTED  => 'Rejected',
            self::CANCELED  => 'Canceled',
            self::ONHOLD    => 'On Hold',
            self::STARTED   => 'Started',
            self::FINISHED  => 'Finished',
            self::CLOSED    => 'Closed',
        };
    }
}