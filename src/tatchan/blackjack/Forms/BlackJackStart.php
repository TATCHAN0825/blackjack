<?php


namespace tatchan\blackjack\Forms;


use dktapps\pmforms\CustomFormResponse;
use dktapps\pmforms\element\StepSlider;
use pocketmine\Player;
use tatchan\blackjack\Blackjack;
use tatchan\blackjack\CoinManager;
use tatchan\blackjack\lang\Lang;
use tatchan\blackjack\Main;
use tatchan\blackjack\pmformsaddon\AbstractCustomForm;

class BlackJackStart extends AbstractCustomForm
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

        parent::__construct(Lang::t("blackjack"), [new StepSlider(Lang::t("bet.coin"), Lang::t("choose.number.coins.bet"), $this->bets, 0)]);
    }

    public function onSubmit(Player $player, CustomFormResponse $response): void {
        $bet = (int)$this->bets[$response->getInt(Lang::t("bet.coin"))];
        $playerState = $this->bj->getPlayer($player->getName());
        $playerState->setBet($bet);
        if (CoinManager::getInstance()->hasEnoughMoney($player->getName(), $playerState->getBet())) {
            CoinManager::getInstance()->removecoin($player->getName(), $playerState->getBet());
            $cards = $this->bj->getCards();
            $dealerCards = $this->bj->getDealer()->getCards();
            $dealerCards->add($cards->select());
            $dealerCards->add($cards->select());
            $playerCards = $this->bj->getPlayer($player->getName())->getCards();
            $playerCards->add($cards->select());
            $playerCards->add($cards->select());
            $player->sendForm(new BlackJackAction($this->bj, $player));
        } else {
            $player->sendMessage(Lang::t("not.enough.coin"));
        }
    }
}
