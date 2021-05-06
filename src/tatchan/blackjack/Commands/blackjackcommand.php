<?php

namespace tatchan\blackjack\Commands;

use pocketmine\command\Command;
use pocketmine\command\CommandExecutor;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\Player;
use pocketmine\plugin\Plugin;
use tatchan\blackjack\Forms\blackjackmenu;
use tatchan\blackjack\lang\Lang;

class blackjackcommand extends PluginCommand implements CommandExecutor
{
    public function __construct(Plugin $owner) {
        parent::__construct("bj", $owner);
        $this->setUsage("こんな使い方もわからないの？♡♡playerのざぁこ♡♡かぁす♡♡無能♡♡ざぁこ♡♡ざぁこ♡♡");
        $this->setDescription("ブラックジャックのメニューをだします");
        $this->setExecutor($this);
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
        if ($sender instanceof Player) {
            $sender->sendForm(new blackjackmenu());
            return true;
        } else {
            $sender->sendMessage("プレイヤーで実行しろざこ");
            return true;
        }
    }
}