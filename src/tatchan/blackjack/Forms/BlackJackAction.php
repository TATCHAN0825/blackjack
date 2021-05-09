<?php

declare(strict_types=1);

namespace tatchan\blackjack\Forms;

use dktapps\pmforms\MenuOption;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use tatchan\blackjack\Blackjack;
use tatchan\blackjack\Card;
use tatchan\blackjack\lang\Lang;
use tatchan\blackjack\pmformsaddon\AbstractMenuForm;

class BlackJackAction extends AbstractMenuForm
{
    /** @var Blackjack */
    private $bj;


    public function __construct(Blackjack $bj, Player $player) {
        $this->bj = $bj;
        $dealer = $this->bj->getDealer();
        $playerState = $this->bj->getPlayer($player->getName());
        parent::__construct(
            Lang::t("blackjack"),
            Lang::t("blackjack.rule") . TextFormat::EOL . TextFormat::EOL
            . Lang::t("blackjack.bet", [$playerState->getBet()]) . TextFormat::EOL
            . TextFormat::WHITE . Lang::t("dealer") . "(?): " . implode(" ", array_merge([$dealer->getCards()->getAll()[0]->toFormattedString()], array_fill(0, count($dealer->getCards()->getAll()) - 1, TextFormat::GRAY . "?"))) . TextFormat::EOL
            . TextFormat::WHITE . Lang::t("player") . "({$playerState->getScore()}): " . implode(" ", array_map(function (Card $card): string {
                return $card->toFormattedString();
            }, $playerState->getCards()->getAll())),
            [
                new MenuOption(Lang::t("blackjack.hit")),
                new MenuOption(Lang::t("blackjack.stand"))
            ]
        );
    }

    public function onSubmit(Player $player, int $selectedOption): void {
        switch ($selectedOption) {
            /** @noinspection PhpMissingBreakStatementInspection */
            case 0:
                $playerState = $this->bj->getPlayer($player->getName());
                $playerCards = $playerState->getCards();
                $playerCards->add($this->bj->getCards()->select());
                if (!$playerState->isBust()) {
                    $player->sendForm(new self($this->bj, $player));
                    break;
                }
            //no break
            case 1:
                $dealer = $this->bj->getDealer();
                while ($dealer->getScore() < 17) {
                    $dealer->getCards()->add($this->bj->getCards()->select());
                }
                $player->sendForm(new BlackJackResult($this->bj, $player));
                break;
        }
    }
}
