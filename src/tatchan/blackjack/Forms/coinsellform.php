<?php


namespace tatchan\blackjack\Forms;


use dktapps\pmforms\CustomFormResponse;
use dktapps\pmforms\element\Input;
use dktapps\pmforms\element\Label;
use PJZ9n\MoneyConnector\MoneyConnectorUtils;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use tatchan\blackjack\CoinManager;
use tatchan\blackjack\lang\Lang;
use tatchan\blackjack\Main;
use tatchan\blackjack\pmformsaddon\AbstractCustomForm;

class coinsellform extends AbstractCustomForm
{
    public function __construct(Player $player, array $messages = []) {
        $coin = CoinManager::getInstance()->get($player->getName());
        $money = MoneyConnectorUtils::getConnectorByDetect()->myMoney($player);
        parent::__construct(Lang::t("コイン売却"), array_merge(count($messages) > 0 ? [new Label(
            "messages", implode(TextFormat::EOL, $messages)
        )] : [], [
            new Label("info", implode(TextFormat::EOL, [
                Lang::t("所持コイン", [$coin]),
                Lang::t("所持金", [$money]),
            ])),
            new Input("amount", Lang::t("売却するコインの量")),
        ]));
    }

    public function onSubmit(Player $player, CustomFormResponse $response): void {
        $amount = $response->getString("amount");
        if (!is_numeric($amount)) {
            $player->sendForm(new coinsellform($player, [Lang::t(TextFormat::RED . "%数字しか使えないよ")]));
            return;
        }
        $amount = (int)$amount;
        if ($amount <= 0) {
            $player->sendForm(new coinsellform($player, [Lang::t(TextFormat::RED . "%1以上にしてね")]));
            return;
        }
        if (!CoinManager::getInstance()->hasEnoughMoney($player->getName(), $amount)) {
            $player->sendForm(new coinsellform($player, [Lang::t(TextFormat::RED . "%コインが足りないよ")]));
            return;
        }
        $rate = (int)Main::getInstance()->getConfig()->get("coinrate");
        MoneyConnectorUtils::getConnectorByDetect()->addMoney($player, $rate * $amount);
        $player->sendMessage(Lang::t("売却したよ！"));
    }
}