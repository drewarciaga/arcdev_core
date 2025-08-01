<?php
namespace ArcdevPackages\Core\Enums;

enum SocialMediaType: int
{
    case FACEBOOK   = 0;
    case INSTAGRAM  = 1;
    case TIKTOK     = 2;
    case YOUTUBE    = 3;
    case PINTEREST  = 4;
    case TWITTER    = 5;

    public function label(): string
    {
        return match($this) {
            self::FACEBOOK  => 'Facebook',
            self::INSTAGRAM => 'Instagram',
            self::TIKTOK    => 'TikTok',
            self::YOUTUBE   => 'Youtube',
            self::PINTEREST => 'Pinterest',
            self::TWITTER   => 'X/Twitter',
        };
    }
}