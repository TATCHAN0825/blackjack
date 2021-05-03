<?php


declare(strict_types=1);

namespace tatchan\blackjack;

use pocketmine\Player;

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
