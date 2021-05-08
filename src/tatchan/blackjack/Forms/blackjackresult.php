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
use tatchan\blackjack\State;

class blackjackresult extends AbstractMenuForm
{
    private Blackjack $bj;

    public function __construct(Blackjack $bj, Player $player) {
        $this->bj = $bj;
        $dealer = $this->bj->getDealer();
        $playerState = $this->bj->getPlayer($player->getName());
        if ($this->bj->getwinner($player->getName()) === null) {
            $winner = Lang::t("blackjack.result.draw");
        } elseif ($this->bj->getwinner($player->getName())->getPlayerName() == State::DEALER) {
            $winner = Lang::t("blackjack.result.winner.dealer");
        } else {
            $winner = Lang::t("blackjack.result.winner.player");
        }
        parent::__construct(
            Lang::t("blackjack"),
            Lang::t("blackjack.action.rule") . TextFormat::EOL . TextFormat::EOL
            . Lang::t("blackjack.bet", [$playerState->getBet()]) . TextFormat::EOL
            . TextFormat::WHITE . Lang::t("dealer") . "({$dealer->getScore()}): " . implode(" ", array_map(function (Card $card): string {
                return $card->toFormattedString();
            }, $dealer->getCards()->getAll())) . ($dealer->isBust() ? TextFormat::RED . " (" . Lang::t("bust") . ")" : ($dealer->isBlackjack() ? TextFormat::AQUA . " (" . Lang::t("blackjack") . ")" : "")) . TextFormat::EOL
            . TextFormat::WHITE . Lang::t("player") . " ({$playerState->getScore()}): " . implode(" ", array_map(function (Card $card): string {
                return $card->toFormattedString();
            }, $playerState->getCards()->getAll())) . ($playerState->isBust() ? TextFormat::RED . " (" . Lang::t("bust") . ")" : ($playerState->isBlackjack() ? TextFormat::AQUA . " (" . Lang::t("blackjack") . ")" : "")) . TextFormat::EOL
            . TextFormat::EOL . Lang::t("blackjack.result.winner", [$winner]),
            [new MenuOption("gui.back")]
        );
    }

    public function onSubmit(Player $player, int $selectedOption): void {
        switch ($selectedOption) {
            case 0:
                $player->sendForm(new blackjackmenu());
                break;
        }
    }
}
