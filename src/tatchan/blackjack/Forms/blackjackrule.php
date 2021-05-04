<?php


namespace tatchan\blackjack\Forms;

use dktapps\pmforms\MenuOption;
use pocketmine\Player;
use tatchan\blackjack\pmformsaddon\AbstractMenuForm;

class blackjackrule extends AbstractMenuForm
{

    public function __construct() {
        parent::__construct("ブラックジャックのルール", "", [new MenuOption("戻る")]);
    }

    public function onSubmit(Player $player, int $selectedOption): void {
        if ($selectedOption == 0) {
            $player->sendForm(new blackjackmenu());
        }

    }
}
