<?php

declare(strict_types=1);

namespace tatchan\blackjack;

use pocketmine\utils\TextFormat;
use RuntimeException;

/**
 * カード。とらんぷ
 */
class Card
{
    public const CLUB = 0;
    public const DIAMOND = 1;
    public const HEART = 2;
    public const SPADE = 3;
    public const JOKER = 4;
    //public const CARDS = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52];
    public const COUNT = [2, 3, 4, 5, 6, 7, 8, 9, 10 => [1], 11, 12, 13 => [2], 1 => [3]];
    /** @var int */
    private $type;

    /** @var int|null */
    private $number;

    public function __construct(int $type, ?int $number = null) {
        $this->type = $type;
        $this->number = $number;
    }

    public function getType(): int {
        return $this->type;
    }

    public function getNumber(): int {
        if ($this->number === null) throw new RuntimeException("Joker");
        return $this->number;
    }

    public function getCount(): ?int {
        switch (self::COUNT[$this->number]) {
            case 1:
                return $this->number;
            case 2:
                return 10;
            case 3:
                return 1;
        }
        return null;
    }

    public function toFormattedString(): string {
        switch ($this->getType()) {
            case self::CLUB:
                $type = TextFormat::WHITE . "♣";
                break;
            case self::DIAMOND:
                $type = TextFormat::RED . "♦";
                break;
            case self::HEART:
                $type = TextFormat::RED . "♥";
                break;
            case self::SPADE:
                $type = TextFormat::WHITE . "♠";
                break;
        }
        if ($this->getNumber() === 1) {
            $number = "A";
        } elseif ($this->getNumber() === 11) {
            $number = "J";
        } elseif ($this->getNumber() === 12) {
            $number = "Q";
        } else if ($this->getNumber() === 13) {
            $number = "K";
        } else {
            $number = $this->getNumber();
        }
        return TextFormat::RESET . $type . $number . TextFormat::RESET;
    }
}
