<?php

declare(strict_types=1);

namespace tatchan\blackjack;

class State
{
    /** @var Cards */
    private $cards;

    public function __construct() {
        $this->cards = new Cards();
    }

    public function getCards(): Cards {
        return $this->cards;
    }

    public function getCount(): int {
        $count = 0;
        foreach ($this->cards->getAll() as $card) {
            //$count += max($card->getNumber(), 10);
            $count = $card->getcount();
        }
        return $count;
    }

    public function isBust(): bool {
        return $this->getCount() > 21;
    }

    public function isBrackjack(): bool {
        return $this->getCount() === 21;
    }
}
