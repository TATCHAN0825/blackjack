<?php


namespace tatchan\blackjack\Forms;


use dktapps\pmforms\CustomFormResponse;
use pocketmine\Player;
use tatchan\blackjack\pmformsaddon\AbstractCustomForm;

class blackjackstart extends AbstractCustomForm
{
    public function __construct(string $title, array $elements) {
        parent::__construct("ブラックジャック",);
    }

    public function onSubmit(Player $player, CustomFormResponse $response): void {

    }
}