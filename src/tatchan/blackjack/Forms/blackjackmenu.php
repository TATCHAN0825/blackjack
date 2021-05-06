<?php


namespace tatchan\blackjack\Forms;


use dktapps\pmforms\MenuOption;
use pocketmine\Player;
use tatchan\blackjack\Blackjack;
use tatchan\blackjack\lang\Lang;
use tatchan\blackjack\pmformsaddon\AbstractMenuForm;

class blackjackmenu extends AbstractMenuForm
{
    public function __construct() {
        parent::__construct("ブラックジャック", "§b何で遊ぶか選択してね", [
            new MenuOption("§aルール"),
            new MenuOption("§a返金所"),
            new MenuOption("§aスタート")
        ]);
    }

    public function onSubmit(Player $player, int $selectedOption): void {
        switch ($selectedOption) {
            case 0:
                $player->sendForm(new blackjackrule());
                break;
            case 1:
                $player->sendForm(new ConverterToMoney());
                break;
            case 2:
                $bj = new Blackjack(1);
                $bj->addPlayer($player->getName());
                $player->sendForm(new blackjackstart($bj));
                break;
        }

    }
}
