<?php

declare(strict_types=1);

namespace tatchan\blackjack;

use RuntimeException;

class Card
{
    public const CLUB = 0;
    public const DIAMOND = 1;
    public const HEART = 2;
    public const SPADE = 3;
    public const JOKER = 4;
    //public const CARDS = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52];

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
}
