<?php


namespace tatchan\blackjack\Forms;


use dktapps\pmforms\CustomFormResponse;
use dktapps\pmforms\element\Input;
use PJZ9n\MoneyConnector\MoneyConnectorUtils;
use pocketmine\Player;
use tatchan\blackjack\CoinManager;
use tatchan\blackjack\lang\Lang;
use tatchan\blackjack\Main;
use tatchan\blackjack\pmformsaddon\AbstractCustomForm;

class coinbuyform extends AbstractCustomForm
{
    /** @var int */
    private $coin, $coinrate;

    public function __construct(Player $player, string $err = null) {
        $money = MoneyConnectorUtils::getConnectorByDetect()->myMoney($player);
        $this->coin = CoinManager::getInstance()->get($player->getName());
        $this->coinrate = Main::getInstance()->getConfig()->get("coinrate");
        parent::__construct(Lang::t("coin.buy.form"), [new Input(Lang::t("coin.buy"), Lang::t("number.coins.buy") . "\n" . Lang::t("coin.mycoin", [$this->coin]) . "\n" . Lang::t("economy.mymoney", [$money]) . "\n" . $err)]);

    }

    public function onSubmit(Player $player, CustomFormResponse $response): void {
        if (Main::getInstance()->is_natural($response->getString(Lang::t("coin.buy")))) {
            $paymoney = $this->coinrate * (int)$response->getString(Lang::t("coin.buy"));
            if (MoneyConnectorUtils::getConnectorByDetect()->myMoney($player) >= $paymoney) {
                MoneyConnectorUtils::getConnectorByDetect()->reduceMoney($player, $paymoney);
                CoinManager::getInstance()->addcoin($player->getName(), (int)$response->getString(Lang::t("coin.buy")));
            } else {
                $player->sendMessage("§e" . Lang::t("not.enough.money"));
            }
        } else {
            $err = "§c" . Lang::t("enter.natural.number");
            $player->sendForm(new coinbuyform($player, $err));
        }
    }
}