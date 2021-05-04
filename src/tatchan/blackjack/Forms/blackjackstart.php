<?php


namespace tatchan\blackjack\Forms;


use dktapps\pmforms\CustomFormResponse;
use dktapps\pmforms\element\StepSlider;
use pocketmine\Player;
use tatchan\blackjack\Blackjack;
use tatchan\blackjack\Main;
use tatchan\blackjack\pmformsaddon\AbstractCustomForm;

class blackjackstart extends AbstractCustomForm
{
    /** @var Blackjack */
    private $bj;

    /** @var string[] */
    private $bets;

    public function __construct(Blackjack $bj) {
        $this->bj = $bj;

        $min = Main::getInstance()->getConfig()->get("min-bet");
        $max = Main::getInstance()->getConfig()->get("max-bet");
        $step = Main::getInstance()->getConfig()->get("step");

        $this->bets = [];

        for ($i = $min; $i <= $max; $i += $step) {
            $this->bets[] = "$i";
        }

        parent::__construct("ブラックジャック", [new StepSlider("掛け金", "賭ける金額を選んでね", $this->bets, 0)]);
    }

    public function onSubmit(Player $player, CustomFormResponse $response): void {
        $bet = (int)$this->bets[$response->getInt("掛け金")];
        $playerState = $this->bj->getPlayer($player->getName());
        $playerState->setBet($bet);

        //全カード
        $cards = $this->bj->getCards();
        //ディーラーに2枚
        $dealerCards = $this->bj->getDealer()->getCards();
        $dealerCards->add($cards->select());
        $dealerCards->add($cards->select());
        //プレイヤーに2枚
        $playerCards = $this->bj->getPlayer($player->getName())->getCards();
        $playerCards->add($cards->select());
        $playerCards->add($cards->select());

        $player->sendForm(new blackjackaction($this->bj, $player));
    }
}
