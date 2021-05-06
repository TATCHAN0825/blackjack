<?php

declare(strict_types=1);


namespace tatchan\blackjack\lang;

use pocketmine\lang\BaseLang;
use pocketmine\lang\TextContainer;

class Lang
{
    /** @var BaseLang */
    private static $lang;

    public static function init(BaseLang $lang): void {
        self::$lang = $lang;
    }

    public static function get(): BaseLang {
        return self::$lang;
    }

    /**
     * 翻訳する
     * @param TextContainer|string $text
     */
    public static function t($text, array $params = []): string {
        if ($text instanceof TextContainer) {
            return self::$lang->translate($text);
        } else {
            return self::$lang->translateString($text, $params);
        }
    }
}
