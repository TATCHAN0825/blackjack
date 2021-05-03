<?php


namespace tatchan\blackjack\Forms;


use dktapps\pmforms\MenuOption;
use pocketmine\Player;
use tatchan\blackjack\pmformsaddon\AbstractMenuForm;

class blackjackmenu extends AbstractMenuForm
{
    public function __construct() {
        parent::__construct("ブラックジャック", "選択してね", [
            new MenuOption("ルール"),
            new MenuOption("スタート")
        ]);
    }

    public function onSubmit(Player $player, int $selectedOption): void {
        switch ($selectedOption) {
            case 0:
                $player->sendForm(new blackjackrule());
                break;
            case 1:
                $player->sendForm(new blackjackstart);
        }

    }
}