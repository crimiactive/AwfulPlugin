<?php
namespace plugin;
# No use statements, no spacing is applied in the whole code, makes the code hard to read and understand.
class Main extends \pocketmine\plugin\PluginBase implements \pocketmine\event\Listener{
        # var is deprecated. No visibility, bad practice storing Server instance in a class property, when you
        # could do PluginBase->getServer() or Server::getInstance()
        var $server = null;
        # Storing a boolean in a class property, is stupid. It's much easier to simply type true than $this->noError.
        # Class property names SHOULD be in this form: $noError, $hasError. Same applies for method names.
        # For class names the first letter should go in uppercase. For example: Main, PluginBase, PlayerJoinEvent, and so on.
        var $noerror = TRUE;
        var $haserror = FALSE;
        # No visibility is added here for onEnable(). It should be public.
        function onEnable(){
                # Defining a variable that has the Server instance is useless, as explained above.
                $this->server = \pocketmine\Server::getInstance();
        }
        # Always avoid variable names under the 3 characters.
        function onCommand(\pocketmine\command\CommandSender $s, \pocketmine\command\Command $c, string $l, array $a) : bool{
                # Is an isset() check required for every of the command arguments?
                # This could be simplified with: if(count($a) < 5)
                if(!isset($a[0]) || !isset($a[1]) || !isset($a[2]) || !isset($a[3]) || !isset($a[4])){
                        return $this->haserror;
                }
                
                
                # (Readability) Lowercase method calls. It should be setBlockIdAt() instead of setblockidat()
                # Level->setBlockIdAt() will return an error if the level is not loaded...
                #  (can be checked using a === operator, Server->getLevelByName() === null)
                
                # (Perfomance) Prefer a === check over instanceof.
                #  However, it's the same as typehinting, the perfomance gain is minimal. Also, according to the docs...
                #  Server->getLevelByName() returns either a Level instance or null. Hence nothing is wrong using === null here...
                #  (subject to changes), so keep an eye out to updates to the methods your plugin uses.
                $l = $this->server->getlevelbyname($a[3]);
                $l->setblockidat($a[0], $a[1], $a[2], $a[4]);
                
                # The iterative loop is not needed here. We already have the CommmandSender instance, which can be either a Player
                #  or a ConsoleCommandSender. But if you want to hide messages from showing up to the console, with a...
                #  if($s instanceof Player) check it should be fine.
                #
                # The code below applies for both player and console command execution mode, but will just make the code longer...
                #  something we should preferably avoid.
                foreach($this->server->getonlineplayers() as $p){
                        if($p->getname() === $s->getname()){
                                # Prefer double quotes over single quotes. Helps in perfomance? Not really, but you shouldn't be worried
                                # of using double quotes in your plugin. Read below for an explanation.
                                $p->sendmessage('Setted block!');
                        }
                }
                # If you didn't know, you can also get the name of the console. It will simply return CONSOLE, in uppercase, yes.
                #  Usually we do if(CommandSender instanceof Player), however we can also do if(CommandSender->getName() !== "CONSOLE")
                #  This is a perfomance gain too, but it's up to what is your objective with the plugin you're developing...
                #  e.g perfomance, or readability.
                return $this->noerror;
                
        }
        
        # Bonus: Prefer !== (strict checks) over != (loosely checks). What's the difference? !== checks that both values are of the same type.
        #  See this helpful post in Stackoverflow which should answer to all your questions. https://stackoverflow.com/a/80649
}
