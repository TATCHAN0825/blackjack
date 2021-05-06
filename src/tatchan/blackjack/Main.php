<?php

declare(strict_types=1);

namespace tatchan\blackjack;

use PJZ9n\MoneyConnector\MoneyConnectorUtils;
use pocketmine\event\Listener;
use pocketmine\lang\BaseLang;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use RuntimeException;
use tatchan\blackjack\Commands\blackjackcommand;
use tatchan\blackjack\lang\Lang;

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
        new Config($this->getDataFolder() . "config.yml", Config::DETECT, ["min-bet" => 100, "max-bet" => 1000, "step" => 100, "coinrate" => 100, "coinwinrate" => 1.25, "lang" => "default"]);
        $lang = $this->getConfig()->get("lang");
        if ($lang === "default") $lang = $this->getServer()->getLanguage()->getLang();
        Lang::init(new BaseLang($lang, $this->getFile() . "resources/", $this->getServer()->getLanguage()->getLang()));
        $this->getServer()->getCommandMap()->register($this->getName(), new blackjackcommand($this));
        $this->getLogger()->notice(Lang::t("language.selected", [Lang::get()->getName(), Lang::get()->getLang()]));
        new CoinManager($this);
        if (!MoneyConnectorUtils::isExistsSupportedAPI()) {
            throw new RuntimeException(Lang::t("economy.notfound"));
        }
        $name = MoneyConnectorUtils::getConnectorByDetect()->getName();
        $this->getLogger()->notice(Lang::get()->translateString("economy.using", [$name]));
    }

    public function onDisable() {
        CoinManager::getInstance()->save();
    }
}