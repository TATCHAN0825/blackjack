<?php

declare(strict_types=1);

namespace tatchan\blackjack;

/**
 * プレイヤーの状態
 * 手札を保持したり
 */
class State
{
    public const DEALER = "dealer";

    /** @var string */
    private $playerName;

    /** @var Cards */
    private $cards;

    /** @var int */
    private $bet = 0;

    public function __construct(string $playerName) {
        $this->playerName = $playerName;
        $this->cards = new Cards();
    }

    public function getPlayerName(): string {
        return $this->playerName;
    }

    public function setBet(int $bet): void {
        $this->bet = $bet;
    }

    public function getBet(): int {
        return $this->bet;
    }

    public function getCards(): Cards {
        return $this->cards;
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
        return $this->getScore() > 21;
    }

    public function isBrackjack(): bool {
        return $this->getScore() === 21;
    }
}
