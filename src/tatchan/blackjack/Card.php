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

    public function toFormattedString(): string {
        $type = "";
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
