<?php

declare(strict_types=1);

namespace tatchan\blackjack;

use RuntimeException;

class Cards
{

    /** @var Card[] */
    private $cards;

    /**
     * @param Card[] $cards
     */
    public function __construct(array $cards) {
        $this->cards = $cards;
    }

    public function selectOne(): Card {
        if (count($this->cards) <= 0) throw new RuntimeException("カードが足りません");
        return $this->cards[array_rand($this->cards)];
    }
}
