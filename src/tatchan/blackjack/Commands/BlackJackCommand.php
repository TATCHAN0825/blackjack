<?php

namespace tatchan\blackjack\Commands;

use pocketmine\command\Command;
use pocketmine\command\CommandExecutor;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\Player;
use pocketmine\plugin\Plugin;
use tatchan\blackjack\Forms\BlackJackMenu;
use tatchan\blackjack\lang\Lang;

class BlackJackCommand extends PluginCommand implements CommandExecutor
{
    public function __construct(Plugin $owner) {
        parent::__construct("bj", $owner);
        $this->setUsage(Lang::t("command.blackjack.bj.usage"));
        $this->setDescription(Lang::t("command.blackjack.bj.description"));
        $this->setExecutor($this);
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
        if ($sender instanceof Player) {
            $sender->sendForm(new BlackJackMenu());
            return true;
        } else {
            $sender->sendMessage(Lang::t("command.onlyplayer"));
            return true;
        }
    }
}