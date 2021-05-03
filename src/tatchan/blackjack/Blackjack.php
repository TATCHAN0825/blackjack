<?php


declare(strict_types=1);

namespace tatchan\blackjack;

use pocketmine\Player;

/**
 * ゲーム状態を保持する
 * 進行も管理する(テーブルのような感じ)
 */
class Blackjack
{
    public const PHASE_BET = 0;

    /** @var Player */
    private $player;

    /** @var Cards */
    private $cards;

    /** @var State */
    private $dealerState;

    /** @var State */
    private $playerState;

    public function __construct(Player $player) {
        $this->player = $player;
        $this->cards = Cards::make();
        $this->cards->shuffle();
        $this->dealerState = new State();
        $this->playerState = new State();
    }

    public function hit(): void {
        //
    }
}
