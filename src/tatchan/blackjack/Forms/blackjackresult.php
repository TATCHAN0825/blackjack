<?php

declare(strict_types=1);

namespace tatchan\blackjack\Forms;

use dktapps\pmforms\MenuOption;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use tatchan\blackjack\Blackjack;
use tatchan\blackjack\Card;
use tatchan\blackjack\pmformsaddon\AbstractMenuForm;

class blackjackresult extends AbstractMenuForm
{
    private Blackjack $bj;

    public function __construct(Blackjack $bj, Player $player) {
        $this->bj = $bj;
        $dealer = $this->bj->getDealer();
        $playerState = $this->bj->getPlayer($player->getName());
        if ($dealer->isBust() || $dealer->getScore() > $playerState->getScore()) {
            $winner = "ディーラーの勝ち";
        } elseif ($playerState->isBust() || $playerState->getScore() > $dealer->getScore()) {
            $winner = "プレイヤーの勝ち";
        } else {
            $winner = "引き分け！！";
        }
        parent::__construct(
            "ブラックジャック",
            "21に近づけよう(22以上になったら負けだよ)" . TextFormat::EOL . TextFormat::EOL
            . "掛け金: {$playerState->getBet()}" . TextFormat::EOL
            . TextFormat::WHITE . "ディーラー ({$dealer->getScore()}): " . implode(" ", array_map(function (Card $card): string {
                return $card->toFormattedString();
            }, $dealer->getCards()->getAll())) . ($dealer->isBust() ? TextFormat::RED . " (バースト)" : ($dealer->isBrackjack() ? TextFormat::AQUA . " (ブラックジャック)" : "")) . TextFormat::EOL
            . TextFormat::WHITE . "プレイヤー ({$playerState->getScore()}): " . implode(" ", array_map(function (Card $card): string {
                return $card->toFormattedString();
            }, $playerState->getCards()->getAll())) . ($playerState->isBust() ? TextFormat::RED . " (バースト)" : ($playerState->isBrackjack() ? TextFormat::AQUA . " (ブラックジャック)" : "")) . TextFormat::EOL
            . TextFormat::EOL . "結果: {$winner}",
            [new MenuOption("メニューへ")]
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
