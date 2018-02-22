<?php
namespace plugin;
# for what are the use statements?
class Main extends \pocketmine\plugin\PluginBase implements \pocketmine\event\Listener{
        # var? in what age do you live? no visibility, bad practice storing Server instance
        # in a class property when you could do PluginBase->getServer() or Server::getInstance()
        var $server = null;
        # storing a boolean in a class property
        var $noError = TRUE;
        var $hasError = FALSE;
        # no visibility for onEnable()
        function onEnable(){
                # has no point, as explained above.
                $this->server = \pocketmine\Server::getInstance();
                $this->server->getPluginManager()->registerEvents($this, $this);
        }
        # avoid < 3-character variable names
        function onCommand(\pocketmine\command\CommandSender $s, \pocketmine\command\Command $c, string $l, array $a) : bool{
                # isset() check for every of the args!!?
                # you could simply do if(count($a) < 5)
                if(!isset($a[0]) || !isset($a[1]) || !isset($a[2]) || !isset($a[3]) || !isset($a[4])){
                        return $this->hasError;
                }
                # no check done if level is loaded... e.g === null
                # Level->setBlock() will return error
                $l = $this->server->getLevelByName($a[3]);
                $l->setBlockIdAt($a[0], $a[1], $a[2], $a[4]);
                return $this->noError;
        }
}
