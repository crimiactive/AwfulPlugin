<?php
namespace plugin;
# No use statements, no spacing is applied in the whole code, makes the code hard to read and understand.
class Main extends \pocketmine\plugin\PluginBase implements \pocketmine\event\Listener{
        # var? no visibility, bad practice storing Server instance
        # in a class property when you could do PluginBase->getServer() or Server::getInstance()
        var $server = null;
        # storing a boolean in a class property... stupid. it's even much easier to type true than $this->noError
        # class property names SHOULD be in this form: noError, hasError, same goes for method names.
        # for classes it should be the first letter uppercase. e.g Main, PluginBase, PlayerJoinEvent...
        var $noerror = TRUE;
        var $haserror = FALSE;
        # no visibility for onEnable()
        function onEnable(){
                # has no point, as explained above.
                $this->server = \pocketmine\Server::getInstance();
        }
        # avoid < 3-character variable names
        function onCommand(\pocketmine\command\CommandSender $s, \pocketmine\command\Command $c, string $l, array $a) : bool{
                # isset() check for every of the args???
                # you could simply do if(count($a) < 5)
                if(!isset($a[0]) || !isset($a[1]) || !isset($a[2]) || !isset($a[3]) || !isset($a[4])){
                        return $this->haserror;
                }
                # no check done if level is loaded... e.g === null
                # Level->setBlockIdAt() will return error if level is not loaded.
                # (readability) lowercase method calls.
                $l = $this->server->getlevelbyname($a[3]);
                $l->setblockidat($a[0], $a[1], $a[2], $a[4]);
                
                # this doesn't make sense. you could just do $s->sendMessage()
                # or if you want to hide messages to console.... if($s instanceof Player)
                # (thought this will apply for both console and players command execution)
                foreach($this->server->getonlineplayers() as $p){
                        if($p->getName() === $s->getname()){
                                $p->sendmessage("Setted block!");
                        }
                }
                return $this->noerror;
        }
}
