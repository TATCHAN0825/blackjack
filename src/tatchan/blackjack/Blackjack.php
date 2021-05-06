<?php


declare(strict_types=1);

namespace tatchan\blackjack;

use RuntimeException;

/**
 * ゲーム状態を保持する
 * 進行も管理する(テーブルのような感じ)
 */
class Blackjack
{
    public const PHASE_BET = 1;

    /** @var int */
    private $maxPlayers;

    /** @var int */
    private $phase = self::PHASE_BET;

    /** @var Cards */
    private $cards;

    /** @var State */
    private $dealer;

    /** @var State[] */
    private $players = [];

    public function __construct(int $maxPlayers) {
        $this->maxPlayers = $maxPlayers;
        $this->cards = Cards::make();
        $this->cards->shuffle();
        $this->dealer = new State(State::DEALER);
    }

    public function getCards(): Cards {
        return $this->cards;
    }

    public function getDealer(): State {
        return $this->dealer;
    }

    public function isFull(): bool {
        return count($this->players) >= $this->maxPlayers;
    }

    public function addPlayer(string $playerName): void {
        if ($this->isFull()) {
            throw new RuntimeException("満員...");
        }
        $this->players[$playerName] = new State($playerName);
    }

    /**
     * @return State[]
     */
    public function getPlayers(): array {
        return $this->players;
    }

    public function getPlayer(string $playerName): ?State {
        return $this->players[$playerName] ?? null;
    }

    public function getwinner(): ?State {
        $dealer = $this->getDealer();
        $playerState = $this->getPlayers()[array_key_first($this->getPlayers())];
        //TODO::複数人プレイも対応するように
        $playerScore = $playerState->isBust() ? 0 : $playerState->getScore();
        $dealerScore = $dealer->isBust() ? 0 : $dealer->getScore();
        if ($dealerScore > $playerScore) {
            return $dealer;
        } elseif ($playerScore > $dealerScore) {
            return $playerState;
        } else {
            return null;
        }
    }
}
