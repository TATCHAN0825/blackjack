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

    //自分のスコアを計算するコード
    public function getScore(): int {
        $score = 0;
        $aceCount = 0;
        foreach ($this->cards->getAll() as $card) {
            $num = $card->getNumber();
            if ($num >= 10) $num = 10;
            if ($num == 1) $aceCount++;
            else $score += $num;
        }
        if ($aceCount == 0) return $score;

        $aceScore = 11 + $aceCount - 1;
        if ($aceScore + $score > 21) {
            $aceScore = $aceCount;
        }
        return $score + $aceScore;
    }

    public function isBust(): bool {
        return $this->getCount() > 21;
    }

    public function isBrackjack(): bool {
        return $this->getCount() === 21;
    }
}
