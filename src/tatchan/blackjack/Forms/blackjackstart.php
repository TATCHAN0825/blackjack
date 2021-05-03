<?php


namespace tatchan\blackjack\Forms;


use dktapps\pmforms\CustomFormResponse;
use dktapps\pmforms\element\StepSlider;
use pocketmine\Player;
use tatchan\blackjack\Main;
use tatchan\blackjack\pmformsaddon\AbstractCustomForm;

class blackjackstart extends AbstractCustomForm
{
    public function __construct() {
        $min = Main::getInstance()->getConfig()->get("min-bet");
        $max = Main::getInstance()->getConfig()->get("max-bet");
        $step = Main::getInstance()->getConfig()->get("step");

        $bets = [];

        for ($i = $min; $i <= $max; $i += $step) {
            $bets[] = "$i";
        }

        parent::__construct("ブラックジャック", [new StepSlider("掛け金", "賭ける金額を選んでね", $bets, 0)]);
    }

    public function onSubmit(Player $player, CustomFormResponse $response): void {
        $response->getInt("掛け金");
    }

    public function onClose(Player $player): void {
        var_dump("とじないで！！");
    }
}