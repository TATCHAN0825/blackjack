<?php

declare(strict_types=1);

namespace tatchan\blackjack;

use pocketmine\utils\Config;

class CoinManager
{

    /** @var Config */
    private $coin;
    /** @var self */
    private static $instance;

    public function __construct(Main $main) {
        $this->coin = new Config($main->getDataFolder() . "coin.yml");
        self::$instance = $this;
    }

    public static function getInstance(): self {
        return self::$instance;
    }

    public function get($name) {
        if ($this->coin->exists($name)) {
            return $this->coin->get($name);
        } else {
            $this->coin->set($name, "0");

            return 0;
        }
    }

    public function getcoinrate() {
        return $this->coin->get("coinrate");
    }

    public function addcoin($name, $coin) {
        $this->coin->set($name, $this->coin->get($name) + $coin);

    }

    public function setcoin($name, $coin) {
        $this->coin->set($name, $coin);
    }

    public function removecoin($name, $coin) {
        $this->coin->set($name, $this->coin->get($name) - $coin);
    }

    public function hasEnoughMoney(string $name, int $pay): bool {
        $have = $this->get($name);
        return $have >= $pay;
    }

    public function save() {
        $this->coin->save();
    }
}