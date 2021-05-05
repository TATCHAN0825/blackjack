<?php


namespace tatchan\blackjack\Forms;


use dktapps\pmforms\CustomFormResponse;
use dktapps\pmforms\element\Input;
use PJZ9n\MoneyConnector\MoneyConnectorUtils;
use pocketmine\Player;
use tatchan\blackjack\CoinManager;
use tatchan\blackjack\Main;
use tatchan\blackjack\pmformsaddon\AbstractCustomForm;
use tatchan\blackjack\Utils\Utils;

class coinbuyform extends AbstractCustomForm
{
    /** @var int */
    private $coin, $coinrate;

    public function __construct(Player $player, string $err = null) {
        $money = MoneyConnectorUtils::getConnectorByDetect()->myMoney($player);
        parent::__construct("入金フォーム", [new Input("入金", "購入するコインの枚数\n現在の所持金:$money\n§e$err")]);
        $this->coin = CoinManager::getInstance()->get($player->getName());
        $this->coinrate = Main::getInstance()->getConfig()->get("coinrate");
    }

    public function onSubmit(Player $player, CustomFormResponse $response): void {
        if (Main::getInstance()->is_natural($response->getString("入金"))) {
            $paymoney = $this->coinrate * (int)$response->getString("入金");
            if (MoneyConnectorUtils::getConnectorByDetect()->myMoney($player) >= $paymoney) {
                MoneyConnectorUtils::getConnectorByDetect()->reduceMoney($player, $paymoney);
                CoinManager::getInstance()->addcoin($player->getName(), 1);
            } else {
                $player->sendMessage("§eお金が足りません");
            }
        } else {
            $err = "§c自然数を入力してね";
            $player->sendForm(new coinbuyform($player, $err));
        }
    }
}