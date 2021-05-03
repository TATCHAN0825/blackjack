<?php

declare(strict_types=1);

namespace tatchan\blackjack;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use tatchan\blackjack\Commands\blackjackcommand;

class Main extends PluginBase implements Listener
{
    /** @var self */
    private static $instance;

    public static function getInstance(): self {
        return self::$instance;
    }

    /** @var Config */
    private $coin;

    public function onLoad() {
        self::$instance = $this;
    }

    public function onEnable() {
        $this->getServer()->getCommandMap()->register($this->getName(), new blackjackcommand($this));
        //$this->getLogger()->notice('プラグインをさくじょしました。Ver' . $this->getDescription()->getVersion() . "を削除しました。");
        //$this->getLogger()->notice('Github -> ' . $this->getDescription()->getW());
        new Config($this->getDataFolder() . "config.yml", Config::DETECT, ["min-bet" => 100, "max-bet" => 1000,"step" => 100]);
        new CoinManager($this);


    }
}