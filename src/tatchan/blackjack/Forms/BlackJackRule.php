<?php


namespace tatchan\blackjack\Forms;

use dktapps\pmforms\MenuOption;
use pocketmine\Player;
use tatchan\blackjack\lang\Lang;
use tatchan\blackjack\pmformsaddon\AbstractMenuForm;

class BlackJackRule extends AbstractMenuForm
{

    public function __construct() {
        parent::__construct(Lang::t("blackjack.rule"), "", [new MenuOption(Lang::t("gui.back"))]);
    }

    public function onSubmit(Player $player, int $selectedOption): void {
        if ($selectedOption == 0) {
            $player->sendForm(new BlackJackMenu());
        }

    }
}
