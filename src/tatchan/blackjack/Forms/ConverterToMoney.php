<?php


namespace tatchan\blackjack\Forms;


use dktapps\pmforms\MenuOption;
use pocketmine\Player;
use tatchan\blackjack\pmformsaddon\AbstractMenuForm;

class ConverterToMoney extends AbstractMenuForm
{
    public function __construct() {
        parent::__construct("返金所", "§e何をするか", [new MenuOption("入金"), new MenuOption("売却")]);

    }

    public function onSubmit(Player $player, int $selectedOption): void {
        switch ($selectedOption) {
            case 0:
                $player->sendForm(new coinbuyform($player));
                break;
        }
    }
}