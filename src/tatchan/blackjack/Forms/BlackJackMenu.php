<?php


namespace tatchan\blackjack\Forms;


use dktapps\pmforms\MenuOption;
use pocketmine\Player;
use tatchan\blackjack\Blackjack;
use tatchan\blackjack\lang\Lang;
use tatchan\blackjack\pmformsaddon\AbstractMenuForm;

class BlackJackMenu extends AbstractMenuForm
{
    public function __construct() {
        parent::__construct(Lang::t("blackjack"), Lang::t("§b%whatplay.select"), [
            new MenuOption(Lang::t("§a%rule")),
            new MenuOption(Lang::t("§a%cointrader")),
            new MenuOption(Lang::t("§a%start"))
        ]);
    }

    public function onSubmit(Player $player, int $selectedOption): void {
        switch ($selectedOption) {
            case 0:
                $player->sendForm(new BlackJackRule());
                break;
            case 1:
                $player->sendForm(new ConverterToMoney());
                break;
            case 2:
                $bj = new Blackjack(1);
                $bj->addPlayer($player->getName());
                $player->sendForm(new BlackJackStart($bj));
                break;
        }

    }
}
