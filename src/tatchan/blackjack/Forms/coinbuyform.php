<?php


namespace tatchan\blackjack\Forms;


use dktapps\pmforms\CustomFormResponse;
use dktapps\pmforms\element\Input;
use PJZ9n\MoneyConnector\MoneyConnectorUtils;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use tatchan\blackjack\CoinManager;
use tatchan\blackjack\lang\Lang;
use tatchan\blackjack\Main;
use tatchan\blackjack\pmformsaddon\AbstractCustomForm;

class coinbuyform extends AbstractCustomForm
{
    /** @var int */
    private $coin, $coinrate;

    public function __construct(Player $player, array $messages = []) {
        $money = MoneyConnectorUtils::getConnectorByDetect()->myMoney($player);
        $this->coin = CoinManager::getInstance()->get($player->getName());
        $this->coinrate = Main::getInstance()->getConfig()->get("coinrate");
        parent::__construct(
            Lang::t("coin.buy.form"),
            [
                new Input("coinbuy", Lang::t("number.coins.buy") . "\n"
                    . Lang::t("coin.mycoin", [$this->coin]) . "\n"
                    . Lang::t("economy.mymoney", [$money]) . "\n"
                    . implode(TextFormat::EOL, $messages)
                )
            ]
        );
    }

    public function onSubmit(Player $player, CustomFormResponse $response): void {
        $amount = $response->getString("coinbuy");
        $paymoney = $this->coinrate * (int)$response->getString("coinbuy");
        if (!is_numeric($amount)) {
            $player->sendForm(new coinbuyform($player, [Lang::t("enter.natural.number")]));
            return;
        }
        $amount = (int)$amount;
        if ($amount <= 0) {
            $player->sendForm(new coinbuyform($player, [Lang::t("make.it.1")]));
        }
        if (!MoneyConnectorUtils::getConnectorByDetect()->myMoney($player) >= $paymoney) {
            $player->sendForm(new coinbuyform($player, [Lang::t("not.enough.money")]));
            return;
        }
        MoneyConnectorUtils::getConnectorByDetect()->reduceMoney($player, $paymoney);
        MoneyConnectorUtils::getConnectorByDetect()->addMoney($player, $amount);
        $player->sendMessage(Lang::t("coin.buy.it"));
    }

}