<?php


namespace tatchan\blackjack\Forms;

use dktapps\pmforms\MenuForm;
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
            $form = new MenuForm("ブラックジャック", "選択してね", [
                new MenuOption("ルール"),
                new MenuOption("スタート")
            ], function (Player $player, int $select): void {

            });
            $player->sendForm($form);
        }

    }
}
