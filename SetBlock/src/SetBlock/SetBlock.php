<?php

declare(strict_types=1);

namespace SetBlock;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\level\Level;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;

class SetBlock extends PluginBase{
    const CMD_PREFIX = "[SetBlock]";
    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool{
        if(count($args) < 5){
            return false;
        }
        /*
         * $args[3] = Level name
         */
        $level = $this->getServer()->getLevelByName($args[3]);
        if(!$level instanceof Level){
            $sender->sendMessage(self::CMD_PREFIX . " Level is not loaded");
            return true;
        }
        /*
         * $args[0] = X
         * $args[1] = Y
         * $args[2] = Z
         * $args[4] = Block ID
         */
        $level->setBlockIdAt($args[0], $args[1], $args[2], $args[4]);
        if($sender instanceof Player){
            $sender->sendMessage(self::CMD_PREFIX . " Block has been set."):
            return true;
        }
    }
    
}
