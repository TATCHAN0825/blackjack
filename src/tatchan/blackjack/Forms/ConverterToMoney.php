<?php


namespace tatchan\blackjack\Forms;


use dktapps\pmforms\MenuOption;
use pocketmine\Player;
use tatchan\blackjack\lang\Lang;
use tatchan\blackjack\pmformsaddon\AbstractMenuForm;

class ConverterToMoney extends AbstractMenuForm
{
    public function __construct() {
        parent::__construct(Lang::t("cointrader"), "§e" . Lang::t("what.you.do"), [new MenuOption(Lang::t("coin.buy")), new MenuOption(Lang::t("coin.sell"))]);

    }

    public function onSubmit(Player $player, int $selectedOption): void {
        switch ($selectedOption) {
            case 0:
                $player->sendForm(new CoinBuyForm($player));
                break;
            case 1:
                $player->sendForm(new CoinSellForm($player));
                break;
        }
    }
}