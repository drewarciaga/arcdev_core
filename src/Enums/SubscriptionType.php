<?php
namespace ArcdevPackages\Core\Enums;

enum SubscriptionType: int
{
    case BASIC_TABLET           = 0;
    case PREMIUM_TABLET         = 1;
    case BASIC_PC               = 2;
    case PREMIUM_PC             = 3;
    case BASIC_DUAL_TABLET      = 4;
    case BASIC_DUAL_PC          = 5;
    case PREMIUM_DUAL_TABLET    = 6;
    case PREMIUM_DUAL_PC        = 7;

    public function label(): string
    {
        return match($this) {
            self::BASIC_TABLET          => 'Basic Tablet',
            self::PREMIUM_TABLET        => 'Premium Tablet',
            self::BASIC_PC              => 'Basic PC',
            self::PREMIUM_PC            => 'Premium PC',
            self::BASIC_DUAL_TABLET     => 'Basic Dual Tablet',
            self::BASIC_DUAL_PC         => 'Basic Dual PC',
            self::PREMIUM_DUAL_TABLET   => 'Premium Dual Tablet',
            self::PREMIUM_DUAL_PC       => 'Premium Dual PC',
        };
    }
}