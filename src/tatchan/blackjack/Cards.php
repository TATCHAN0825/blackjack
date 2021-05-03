<?php

declare(strict_types=1);

namespace tatchan\blackjack;

class Cards
{
    public static function make(int $jokerCount = 0): self {
        $cards = [];
        for ($i = 1; $i <= 13; $i++) {
            $cards[] = new Card(Card::CLUB, $i);
            $cards[] = new Card(Card::DIAMOND, $i);
            $cards[] = new Card(Card::HEART, $i);
            $cards[] = new Card(Card::SPADE, $i);
        }
        for ($i = 0; $i < $jokerCount; $i++) {
            $cards[] = new Card(Card::JOKER);
        }
        return new Cards($cards);
    }

    /** @var Card[] */
    private $cards;

    /**
     * @param Card[] $cards
     */
    public function __construct(array $cards = []) {
        $this->cards = $cards;
    }

    public function shuffle(): void {
        shuffle($this->cards);
    }

    public function select(): Card {
        return array_shift($this->cards);
    }

    public function add(Card $card): void {
        $this->cards[] = $card;
    }

    /**
     * @return Card[]
     */
    public function getAll(): array {
        return $this->cards;
    }
}
