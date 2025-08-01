<?php
namespace ArcdevPackages\Core\Enums;

enum OrganizerType: int
{
    case BUSINESS   = 0;
    case INDIVIDUAL = 1;

    public function label(): string
    {
        return match($this) {
            self::BUSINESS   => 'Business',
            self::INDIVIDUAL => 'Individual',
        };
    }
}