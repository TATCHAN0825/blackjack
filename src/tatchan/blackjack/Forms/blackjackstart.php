<?php


namespace tatchan\blackjack\Forms;


use dktapps\pmforms\CustomFormResponse;
use dktapps\pmforms\element\Slider;
use pocketmine\Player;
use tatchan\blackjack\Main;
use tatchan\blackjack\pmformsaddon\AbstractCustomForm;

class blackjackstart extends AbstractCustomForm
{
    public function __construct() {
        $min = Main::getInstance()->getConfig()->get("min-bet");
        $max = Main::getInstance()->getConfig()->get("max-bet");
        $step = Main::getInstance()->getConfig()->get("step");
        parent::__construct("ブラックジャック",[new Slider("掛け金","掛け金を選択してね",$step,floor($max / 2))]);
    }

    public function onSubmit(Player $player, CustomFormResponse $response): void {
        $response->getInt("掛け金");
    }

    public function onClose(Player $player): void {
        var_dump("とじないで！！");
    }
}