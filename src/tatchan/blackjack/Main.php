<?php

declare(strict_types=1);

namespace tatchan\blackjack;

use PJZ9n\MoneyConnector\MoneyConnectorUtils;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use RuntimeException;
use tatchan\blackjack\Commands\blackjackcommand;

class Main extends PluginBase implements Listener
{
    /** @var self */
    private static $instance;

    public static function getInstance(): self {
        return self::$instance;
    }


    public function onLoad() {
        self::$instance = $this;
    }

    function is_natural($val): bool {
        return (bool)preg_match('/\A[1-9][0-9]*\z/', $val);
    }

    public function onEnable() {
        $this->getServer()->getCommandMap()->register($this->getName(), new blackjackcommand($this));
        new Config($this->getDataFolder() . "config.yml", Config::DETECT, ["min-bet" => 100, "max-bet" => 1000, "step" => 100, "coinrate" => 100]);
        new CoinManager($this);
        if (!MoneyConnectorUtils::isExistsSupportedAPI()) {
            throw new RuntimeException("API is not supported");
        }
        $name = MoneyConnectorUtils::getConnectorByDetect()->getName();
        $this->getLogger()->notice("Using API: " . $name);

    }

    public function onDisable() {
        CoinManager::getInstance()->save();
    }
}