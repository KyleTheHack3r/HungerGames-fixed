<?php
namespace HG;
// DONE:implement money adding for when a player wins a match :D
// DONE:also create a diiffrenet function for when a player wins a match to earn $$$
// TODO: add broadcaster? with custom messages in configs leave message in comments if good idea :P
// 25% DONE: set up more matches (gonna take some time :P 2 atm 5 is gonna be the max maybe...?)
// TODO: make a video on how to setup {$this->getConfig()->get("prefix")}
// BTW this may be a lil messy :P trying to figure out a different way but when I try them they don't work
//setup my moneyranks plugin somewhere in here?

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\level\Position;
use pocketmine\level\Level;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\math\Vector3;
use pocketmine\scheduler\CallbackTask;
use pocketmine\block\Block;
use pocketmine\event\entity\EntityDeathEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\tile\Sign;
use pocketmine\tile\Tile;
use pocketmine\utils\TextFormat;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\block\BlockPlaceEvent;
use ResetChest\Main as ResetChest;
use pocketmine\event\player\PlayerRespawnEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\player\PlayerJoinEvent;
use onebone\economyapi\EconomyAPI;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerLoginEvent;
class Main extends PluginBase implements Listener
{

    private $hg;

    public function onEnable() {
		
		if(!file_exists($this->getDataFolder() . "config.yml")) {
            @mkdir($this->getDataFolder());
             file_put_contents($this->getDataFolder() . "config.yml",$this->getResource("config.yml"));
        }
		//$this->stats = new Config($this->getDataFolder()."stats.yml", Config::YAML);
		$this->config = $this->getConfig();
		$this->getServer()->getPluginManager()->registerEvents($this,$this);
		$this->getServer()->getScheduler()->scheduleRepeatingTask(new CallbackTask([$this,"time"]),20);
		 	//$this->getServer()->getScheduler()->scheduleRepeatingTask(new CallbackTask([$this,"popup"]),10);
	
		if($this->config->exists("pos25"))
		{
			$this->sign=$this->config->get("sign");
			$this->pos1=$this->config->get("pos1");
			$this->pos2=$this->config->get("pos2");
			$this->pos3=$this->config->get("pos3");
			$this->pos4=$this->config->get("pos4");
			$this->pos5=$this->config->get("pos5");
			$this->pos6=$this->config->get("pos6");
			$this->pos7=$this->config->get("pos7");
			$this->pos8=$this->config->get("pos8");
			$this->pos9=$this->config->get("pos9");
			$this->pos10=$this->config->get("pos10");
			$this->pos11=$this->config->get("pos11");
			$this->pos12=$this->config->get("pos12");
			$this->pos13=$this->config->get("pos13");
			$this->pos14=$this->config->get("pos14");
			$this->pos15=$this->config->get("pos15");
			$this->pos16=$this->config->get("pos16");
			$this->pos17=$this->config->get("pos17");
			$this->pos18=$this->config->get("pos18");
			$this->pos19=$this->config->get("pos19");
			$this->pos20=$this->config->get("pos20");
			$this->pos21=$this->config->get("pos21");
			$this->pos22=$this->config->get("pos22");
			$this->pos23=$this->config->get("pos23");
			$this->pos24=$this->config->get("pos24");
			$this->pos25=$this->config->get("pos25");
			$this->signlevel=$this->getServer()->getLevelByName($this->config->get("sign")["level"]);
			$this->sign=new Vector3($this->sign["x"],$this->sign["y"],$this->sign["z"]);
			$this->pos1=new Vector3($this->pos1["x"]+0.5,$this->pos1["y"],$this->pos1["z"]+0.5);
			$this->pos2=new Vector3($this->pos2["x"]+0.5,$this->pos2["y"],$this->pos2["z"]+0.5);
			$this->pos3=new Vector3($this->pos3["x"]+0.5,$this->pos3["y"],$this->pos3["z"]+0.5);
			$this->pos4=new Vector3($this->pos4["x"]+0.5,$this->pos4["y"],$this->pos4["z"]+0.5);
			$this->pos5=new Vector3($this->pos5["x"]+0.5,$this->pos5["y"],$this->pos5["z"]+0.5);
			$this->pos6=new Vector3($this->pos6["x"]+0.5,$this->pos6["y"],$this->pos6["z"]+0.5);
			$this->pos7=new Vector3($this->pos7["x"]+0.5,$this->pos7["y"],$this->pos7["z"]+0.5);
			$this->pos8=new Vector3($this->pos8["x"]+0.5,$this->pos8["y"],$this->pos8["z"]+0.5);
			$this->pos9=new Vector3($this->pos9["x"]+0.5,$this->pos9["y"],$this->pos9["z"]+0.5);
			$this->pos10=new Vector3($this->pos10["x"]+0.5,$this->pos10["y"],$this->pos10["z"]+0.5);
			$this->pos11=new Vector3($this->pos11["x"]+0.5,$this->pos11["y"],$this->pos11["z"]+0.5);
                        $this->pos12=new Vector3($this->pos12["x"]+0.5,$this->pos12["y"],$this->pos12["z"]+0.5);
                        $this->pos13=new Vector3($this->pos13["x"]+0.5,$this->pos13["y"],$this->pos13["z"]+0.5);
                        $this->pos14=new Vector3($this->pos14["x"]+0.5,$this->pos14["y"],$this->pos14["z"]+0.5);
                        $this->pos15=new Vector3($this->pos15["x"]+0.5,$this->pos15["y"],$this->pos15["z"]+0.5);
                        $this->pos16=new Vector3($this->pos16["x"]+0.5,$this->pos16["y"],$this->pos16["z"]+0.5);
                        $this->pos17=new Vector3($this->pos17["x"]+0.5,$this->pos17["y"],$this->pos17["z"]+0.5);
                        $this->pos18=new Vector3($this->pos18["x"]+0.5,$this->pos18["y"],$this->pos18["z"]+0.5);
                        $this->pos19=new Vector3($this->pos19["x"]+0.5,$this->pos19["y"],$this->pos19["z"]+0.5);
                        $this->pos20=new Vector3($this->pos20["x"]+0.5,$this->pos20["y"],$this->pos20["z"]+0.5);
                        $this->pos21=new Vector3($this->pos21["x"]+0.5,$this->pos21["y"],$this->pos21["z"]+0.5);
                        $this->pos22=new Vector3($this->pos22["x"]+0.5,$this->pos22["y"],$this->pos22["z"]+0.5);
                        $this->pos23=new Vector3($this->pos23["x"]+0.5,$this->pos23["y"],$this->pos23["z"]+0.5);
                        $this->pos24=new Vector3($this->pos24["x"]+0.5,$this->pos24["y"],$this->pos24["z"]+0.5);
			            $this->pos25=new Vector3($this->pos25["x"]+0.5,$this->pos25["y"],$this->pos25["z"]+0.5);
		}
		$this->endTime=(int)$this->config->get("endTime");
		$this->gameTime=(int)$this->config->get("gameTime");
		$this->waitTime=(int)$this->config->get("waitTime");
		$this->godTime=(int)$this->config->get("godTime");
		$this->gameStatus=0;
		$this->lastTime=0;
		$this->players=array();
		$this->SetStatus=array();
		$this->all=0;
		$rc = $this->getServer()->getPluginManager();
		if(!($this->rc = $rc->getPlugin("ResetChest")))
			{
			$this->getServer()->getLogger()->CRITICAL(
											 ("[{$this->getConfig()->get("prefix")}]Please Install ResetChest For {$this->getConfig()->get("prefix")} To Work Properly"));
											 } else {
			$this->getServer()->getLogger()->notice(TextFormat::AQUA.
											 ("[{$this->getConfig()->get("prefix")}]".TextFormat::BLUE."{$this->getConfig()->get("prefix")} Has Been Enabled Using ". TextFormat::GOLD. $this->rc->getName(). " v".$this->rc->getDescription()->getVersion()));
		}
		$api = $this->getServer()->getPluginManager();
		if(!($this->api = $api->getPlugin("EconomyAPI")))
			{
			$this->getServer()->getLogger()->CRITICAL(
											 ("[{$this->getConfig()->get("prefix")}]Please Install EconomyAPI For {$this->getConfig()->get("prefix")} To Work Properly"));
											 } else {
			$this->getServer()->getLogger()->notice(TextFormat::AQUA.
											 ("[{$this->getConfig()->get("prefix")}]".TextFormat::BLUE."{$this->getConfig()->get("prefix")} Has Been Enabled Using ". TextFormat::GOLD. $this->api->getName(). " v".$this->api->getDescription()->getVersion()));
											 $this->getServer()->getLogger()->info(TextFormat::AQUA."[{$this->getConfig()->get("prefix")}]".TextFormat::GOLD."Plugin Has Been Fully Enabled!");
											 $this->getServer()->getLogger()->warning(TextFormat::AQUA."[{$this->getConfig()->get("prefix")}]".TextFormat::RED."REMEMBER: report bugs on github please!");
		}
	}
	public function onCommand(CommandSender $sender, Command $command, $label, array $args)
	{
		if($command->getName()=="lobby")
		{
			if($this->gameStatus>=2)
			{
				$sender->sendMessage("[{$this->getConfig()->get("prefix")}]The game has just recently started. please wait a moment to go back to go back to lobby");
				return;
			}
			if(isset($this->players[$sender->getName()]))
			{	
				unset($this->players[$sender->getName()]);
				$sender->setLevel($this->signlevel);
				$sender->teleport($this->signlevel->getSpawnLocation());
				$sender->sendMessage(TextFormat::GREEN."[{$this->getConfig()->get("prefix")}]Teleporting to lobby.");
				Server::getInstance()->broadcastMessage(TextFormat::RED."[{$this->getConfig()->get("prefix")}]Player ".$sender->getName()." left the match.");
				$this->changeStatusSign();
			}
			else
			{
				$sender->sendMessage(TextFormat::RED . "[{$this->getConfig()->get("prefix")}]You are not in a match.");
			}
			return true;
		}
		
		if(!isset($args[0])){unset($sender,$cmd,$label,$args);return false;};
		switch ($args[0])
		{
		case "set":
			if($this->config->exists("pos25"))
			{
			$sender->sendMessage("A match is already setup");
			} 
			else{
				$name=$sender->getName();
				$this->SetStatus[$name]=0;
				$sender->sendMessage(TextFormat::DARK_BLUE. "[{$this->getConfig()->get("prefix")}]Please tap the status sign(sign 1).");
			}
			break;
			case "help":
		    $sender->sendMessage(TextFormat::LIGHT_PURPLE."=+=+=".TextFormat::YELLOW."How To Setup A {$this->getConfig()->get("prefix")} Match!".TextFormat::LIGHT_PURPLE."=+=+=");
			$sender->sendMessage(
TextFormat::LIGHT_PURPLE."
Step 1:".TextFormat::AQUA."Do /{$this->getConfig()->get("prefix")} set(1 or 2 depends if you set up a match already)"
.TextFormat::LIGHT_PURPLE."
Step 2:".TextFormat::AQUA."Place A Sign Then Tap On It"
.TextFormat::LIGHT_PURPLE."
Step 3:".TextFormat::AQUA."Go To Where You Are Setting Up Your {$this->getConfig()->get("prefix")} Map (a different world maybe)"
.TextFormat::LIGHT_PURPLE."
Step 4:".TextFormat::AQUA."Set The Spawnpoints By Taping On Them(You Have To Tap 24 Spawnpoints!)"
.TextFormat::LIGHT_PURPLE."
Step 5:".TextFormat::AQUA."Tap The Spot Where DeathMatch Will Happen (Preferably The Middle Of The DeathMatch Spot/Map!)"
.TextFormat::LIGHT_PURPLE."
Step 6:".TextFormat::AQUA."Your Done You Can Start A Match Now!");
$hg = $this->getServer()->getPluginManager();
	$this->hg = $hg->getPlugin("{$this->getConfig()->get("prefix")}");
$this->getServer()->getLogger()->info(TextFormat::GOLD."This Server Is Using ".$this->hg->getName(). TextFormat::GOLD. " v".$this->hg->getDescription()->getVersion()." By SavionLegendZzz!");
			break;
				/*case "stat":
     if($sender->hasPermission("{$this->getConfig()->get("prefix")}.command.stat")){
                                        		if(!(isset($args[1]))){
                                        			$player = $sender->getName();
								$deaths = $this->stats->get($player)[1];
								$kills = $this->stats->get($player)[2];
								$sender->sendMessage("You have ".$deaths." deaths and ".$kills." kills");
								return true;
                                        		}else{
                                        			$player = $args[1];
								$deaths = $this->stats->get($player)[1];
								$kills = $this->stats->get($player)[2];
								$sender->sendMessage($player." has ".$deaths." deaths and ".$kills." kills");
								return true;
                                        		}
                                		}else{
                               	        		$sender->sendMessage("You haven't the permission to run this command.");
							return true;
                               	        	}  
											break; */
			case "remove":
			$this->config->remove("pos1");
			$this->config->remove("pos2");
			$this->config->remove("pos3");
			$this->config->remove("pos4");
			$this->config->remove("pos5");
			$this->config->remove("pos6");
			$this->config->remove("pos7");
			$this->config->remove("pos8");
			$this->config->remove("pos9");
			$this->config->remove("pos10");
			$this->config->remove("pos11");
			$this->config->remove("pos12");
			$this->config->remove("pos13");
			$this->config->remove("pos14");
			$this->config->remove("pos15");
			$this->config->remove("pos16");
			$this->config->remove("pos17");
			$this->config->remove("pos18");
			$this->config->remove("pos19");
			$this->config->remove("pos20");
			$this->config->remove("pos21");
			$this->config->remove("pos22");
			$this->config->remove("pos23");
			$this->config->remove("pos24");
			$this->config->remove("pos25");
	        $this->config->remove("sign(2)");
			$this->config->remove("pos1(2)");
			$this->config->remove("pos2(2)");
			$this->config->remove("pos3(2)");
			$this->config->remove("pos4(2)");
			$this->config->remove("pos5(2)");
			$this->config->remove("pos6(2)");
			$this->config->remove("pos7(2)");
			$this->config->remove("pos8(2)");
			$this->config->remove("pos9(2)");
			$this->config->remove("pos10(2)");
			$this->config->remove("pos11(2)");
			$this->config->remove("pos12(2)");
			$this->config->remove("pos13(2)");
			$this->config->remove("pos14(2)");
			$this->config->remove("pos15(2)");
			$this->config->remove("pos16(2)");
			$this->config->remove("pos17(2)");
			$this->config->remove("pos18(2)");
			$this->config->remove("pos19(2)");
			$this->config->remove("pos20(2)");
			$this->config->remove("pos21(2)");
			$this->config->remove("pos22(2)");
			$this->config->remove("pos23(2)");
			$this->config->remove("pos24(2)");
			$this->config->remove("deathmatch2");			
			$this->config->save();
			//unset($this->sign,$this->pos1,$this->pos2,$this->pos3,$this->pos4,$this->pos5,$this->pos6,$this->pos7,$this->pos8,$this->pos9,$this->pos10,$this->pos11,$this->pos12,$this->pos13,$this->pos14,$this->pos15,$this->pos16,$this->pos17,$this->pos18,$this->pos19,$this->pos20,$this->pos21,$this->pos22,$this->pos23,$this->pos24,$this->pos25);
			$sender->sendMessage(TextFormat::GREEN."[{$this->getConfig()->get("prefix")}]Game'(s) settings successfully removed. please break the status sign.");
			break;
		}
		return true;
	}
	
	public function onPlace(BlockPlaceEvent $event)
	{
		if(!isset($this->sign))
		{
			return;
		}
		$block=$event->getBlock();
		if($this->PlayerIsInGame($event->getPlayer()->getName()))
		{
			if(!$event->getPlayer()->isOp())
			{
				$event->setCancelled();
			}
		}
		unset($event);
	}
	public function onMove(PlayerMoveEvent $event)
	{
		if(!isset($this->sign))
		{
			return;
		}
		if($this->PlayerIsInGame($event->getPlayer()->getName()) && $this->gameStatus<=1)
		{
			if(!$event->getPlayer()->isOp())
			{
				$event->setCancelled();
			}
		}
		unset($event);
	}
	public function onBreak(BlockBreakEvent $event)
	{
		if(!isset($this->sign))
		{
			return;
		}
		$sign=$this->config->get("sign");
		$block=$event->getBlock();
		if($this->PlayerIsInGame($event->getPlayer()->getName()) || ($block->getX()==$sign["x"] && $block->getY()==$sign["y"] && $block->getZ()==$sign["z"] && $block->getLevel()->getFolderName()==$sign["level"]) || $block->getLevel()==$this->level)
		{
			if(!$event->getPlayer()->isOp())
			{
				$event->setCancelled();
			}
		}
		unset($sign,$block,$event);
	}
	
	
	
	public function PlayerIsInGame($name)
	{
		return isset($this->players[$name]);
	} 
	public function PlayerDeath(PlayerDeathEvent $event){
		if($this->gameStatus==3 || $this->gameStatus==4)
		{
			if(isset($this->players[$event->getEntity()->getName()]))
			{
				$this->ClearInv($event->getEntity());
				unset($this->players[$event->getEntity()->getName()]);
				if(count($this->players)>1)
				{
					 $player = $event->getEntity();
                    $killer = $event->getEntity()->getLastDamageCause()->getDamager();
					$moneyd = $this->getConfig()->get("money-death");
					$this->sendMessage("[{$this->getConfig()->get("prefix")}]".$player->getName(). "was killed by" .$killer->getName()."!");
					//$this->addKill($killer->getName());
					$this->getServer()->getPluginManager()->getPlugin("EconomyAPI")->addMoney($player->getName(), $this->config->get("money-death"));
					$player-sendMessage(TextFormat::BLUE."=+=+=Match Review=+=+=");
					$player->sendMessage(TextFormat::RED."+".$moneyd." For Dieing!");
				$event->getPlayer()->sendMessage("[{$this->getConfig()->get("prefix")}]Players left:".count($this->players));
				$player->teleport($this->signlevel->getSpawnLocation());
				}
				$this->changeStatusSign();
			}
			
		}
	}
	public function sendMessage($msg){
		foreach($this->players as $pl)
		{
			$this->getServer()->getPlayer($pl["id"])->sendMessage($msg);
		}
		$this->getServer()->getLogger()->notice($msg);
		unset($pl,$msg);
	}
	
	public function time(){
		if(!isset($this->pos25) || $this->pos25==array())
		{
			return;
		}
		if(!$this->signlevel instanceof Level)
		{
			$this->level=$this->getServer()->getLevelByName($this->config->get("pos1")["level"]);
			$this->signlevel=$this->getServer()->getLevelByName($this->config->get("sign")["level"]);
			if(!$this->signlevel instanceof Level)
			{
				return;
			}
		}
		$this->changeStatusSign();
		if($this->gameStatus==0)
		{
			$i=0;
			foreach($this->players as $key=>$val)
			{
				$i++;
				$p=$this->getServer()->getPlayer($val["id"]);
				//echo($i."\n");
				eval("\$p->teleport(\$this->pos".$i.");");
				unset($p);
			}
		}
		if($this->gameStatus==1)
		{
			$this->lastTime--;
			$i=0;
			foreach($this->players as $key=>$val)
			{
				$i++;
				$p=$this->getServer()->getPlayer($val["id"]);
				//echo($i."\n");
				eval("\$p->teleport(\$this->pos".$i.");");
				unset($p);
			}
			switch($this->lastTime)
			{
			case 1:
			case 2:
			case 3:
			case 4:
			case 5:
			case 10:
			//case 20:
			case 30:
Server::getInstance()->broadcastMessage("[{$this->getConfig()->get("prefix")}]The Game Will Start In ".$this->lastTime." seconds");
				break;
			case 60:
Server::getInstance()->broadcastMessage(" [{$this->getConfig()->get("prefix")}]The Game Will Start In 1:00");
				break;
			case 90:
Server::getInstance()->broadcastMessage("[{$this->getConfig()->get("prefix")}]The Game Will Start In 1:30");
				break;
			case 120:
Server::getInstance()->broadcastMessage("[{$this->getConfig()->get("prefix")}]The Game Will Start In 2:00");
				break;
			case 150:
Server::getInstance()->broadcastMessage("[{$this->getConfig()->get("prefix")}]The Game Will Start In 2:30");
				break;
			case 0:
				$this->gameStatus=2;
Server::getInstance()->broadcastMessage("[{$this->getConfig()->get("prefix")}]The Games Have Begun!");
				$this->resetChest();
				foreach($this->players as $key=>$val)
				{
					$p=$this->getServer()->getPlayer($val["id"]);
					$p->setMaxHealth(30;
					$p->setHealth(30);
				}
				$this->all=count($this->players);
				break;
			}
		}
		if($this->gameStatus==2)
		{
			$this->lastTime--;
			if($this->lastTime<=0)
			{
				$this->gameStatus=3;
				$this->lastTime=$this->gameTime;
				$this->resetChest();
			}
		}
		 		if($this->gameStatus==3 || $this->gameStatus==4)
		{
			if(count($this->players)==1)
			 {
				foreach($this->players as &$pl)
				{
					$p=$this->getServer()->getPlayer($pl["id"]);
					$money=$this->getConfig()->get("money");
					Server::getInstance()->broadcastMessage("[{$this->getConfig()->get("prefix")}]".$p->getName()." Has Won The Match!");
					 $this->getServer()->getPluginManager()->getPlugin("EconomyAPI")->addMoney($p->getName(), $this->config->get("money"));
					 $p->sendMessage("You Earned $".$money." For Winning The Match!");
					$p->setLevel($this->signlevel);
					$p->getInventory()->clearAll();
					$p->setMaxHealth(30);
					$p->setHealth(30);
					$p->teleport($this->signlevel->getSpawnLocation());
					unset($pl,$p);
				}
				$this->clearChest();
				$this->players=array();
				$this->gameStatus=0;
				$this->lastTime=0;
				return;
			}
			else if(count($this->players)==0)
			{
				Server::getInstance()->broadcastMessage("[{$this->getConfig()->get("prefix")}]Match Has Ended All Players Died");
				$this->gameStatus=0;
				$this->lastTime=0;
				$this->clearChest();
				$this->ClearAllInv();
				return;
			}
		}
		 		if($this->gameStatus==3)
		{
			$this->lastTime--;
			switch($this->lastTime)
			{
			case 1:
			case 2:
			case 3:
			case 4:
			case 5:
			case 10:
				Server::getInstance()->broadcastMessage("[{$this->getConfig()->get("prefix")}]There Are ".$this->lastTime." Till DeathMatch");
				break;
			case 0:
				 				Server::getInstance()->broadcastMessage("[{$this->getConfig()->get("prefix")}]DeathMatch Has Begun");
				foreach($this->players as $pl)
				{
					$p=$this->getServer()->getPlayer($pl["id"]);
					$p->setLevel($this->level);
					$p->teleport($this->lastpos);
					unset($p,$pl);
				}
				$this->gameStatus=4;
				$this->lastTime=$this->endTime;
				break;
			}
		}
		
		if($this->gameStatus==4)
		{
			$this->lastTime--;
			switch($this->lastTime)
			{
			case 1:
			case 2:
			case 3:
			case 4:
			case 5:
			case 10:
			//case 20:
			case 30:
Server::getInstance()->broadcastMessage ("[{$this->getConfig()->get("prefix")}]There Are ".$this->lastTime." Seconds Till The End Of The Game!");
				break;
			case 0:
				Server::getInstance()->broadcastMessage("[{$this->getConfig()->get("prefix")}]The Match Has Ended");
				foreach($this->players as $pl)
				{
					$p=$this->getServer()->getPlayer($pl["id"]);
					$p->setLevel($this->signlevel);
					$p->teleport($this->signlevel->getSpawnLocation());
					$p->getInventory()->clearAll();
					$p->setMaxHealth(30);
					$p->setHealth(30);
					unset($p,$pl);
				}
				$this->clearChest();
				//$this->ClearAllInv();
				$this->players=array();
				$this->gameStatus=0;
				$this->lastTime=0;
				break;
			}
		}
		$this->changeStatusSign();
	}

	public function resetChest()
	{
		ResetChest::getInstance()->ResetChest();
	}
	public function clearChest()
	{
		ResetChest::getInstance()->ClearChest();
	}
	
	public function playerBlockTouch(PlayerInteractEvent $event){
		$player=$event->getPlayer();
		$username=$player->getName();
		$block=$event->getBlock();
		$levelname=$player->getLevel()->getFolderName();
		if(isset($this->SetStatus[$username]))
		{
			switch ($this->SetStatus[$username])
			{
			case 0:
				if($event->getBlock()->getID() != 63 && $event->getBlock()->getID() != 68)
				{
					$player->sendMessage(TextFormat::GREEN."[{$this->getConfig()->get("prefix")}] please choose a sign to click on");
					return;
				}
				$this->sign=array(
					"x" =>$block->getX(),
					"y" =>$block->getY(),
					"z" =>$block->getZ(),
					"level" =>$levelname);
				$this->config->set("sign",$this->sign);
				$this->config->save();
				$this->SetStatus[$username]++;
				$player->sendMessage(TextFormat::GREEN."[{$this->getConfig()->get("prefix")}] SIGN for condition has been created");
				$player->sendMessage(TextFormat::GREEN." [{$this->getConfig()->get("prefix")}] please click on the 1st spawnpoint");
				$this->signlevel=$this->getServer()->getLevelByName($this->config->get("sign")["level"]);
				$this->sign=new Vector3($this->sign["x"],$this->sign["y"],$this->sign["z"]);
				$this->changeStatusSign();
				break;
			case 1:
				$this->pos1=array(
					"x" =>$block->x,
					"y" =>$block->y,
					"z" =>$block->z,
					"level" =>$levelname);
				$this->config->set("pos1",$this->pos1);
				$this->config->save();
				$this->SetStatus[$username]++;
				$player->sendMessage(TextFormat::GREEN." [{$this->getConfig()->get("prefix")}] Spawnpoint 1 created");
				$player->sendMessage(TextFormat::GREEN."[{$this->getConfig()->get("prefix")}] Please click.on the 2nd spawnpoint");
				$this->pos1=new Vector3($this->pos1["x"]+0.5,$this->pos1["y"],$this->pos1["z"]+0.5);
				break;
			case 2:
				 $this->pos2=array(
					"x" =>$block->x,
					"y" =>$block->y,
					"z" =>$block->z,
					"level" =>$levelname);
				$this->config->set("pos2",$this->pos2);
				$this->config->save();
				$this->SetStatus[$username]++;
				$player->sendMessage(TextFormat::GREEN." [{$this->getConfig()->get("prefix")}] spawnpoint 2 created");
				$player->sendMessage(TextFormat::GREEN." [{$this->getConfig()->get("prefix")}] Please click on the 3rd spawnpoint");
				$this->pos2=new Vector3($this->pos2["x"]+0.5,$this->pos2["y"],$this->pos2["z"]+0.5);
				break;	
			case 3:
				$this->pos3=array(
					"x" =>$block->x,
					"y" =>$block->y,
					"z" =>$block->z,
					"level" =>$levelname);
				$this->config->set("pos3",$this->pos3);
				$this->config->save();
				$this->SetStatus[$username]++;
				$player->sendMessage(TextFormat::GREEN."[{$this->getConfig()->get("prefix")}] spawnpoint 3 created");
				$player->sendMessage(TextFormat::GREEN." [{$this->getConfig()->get("prefix")}] Please click on the 4th spawnpoint");
				$this->pos3=new Vector3($this->pos3["x"]+0.5,$this->pos3["y"],$this->pos3["z"]+0.5);
				break;	
			case 4:
				$this->pos4=array(
					"x" =>$block->x,
					"y" =>$block->y,
					"z" =>$block->z,
					"level" =>$levelname);
				$this->config->set("pos4",$this->pos4);
				$this->config->save();
				$this->SetStatus[$username]++;
				$player->sendMessage(TextFormat::GREEN."[{$this->getConfig()->get("prefix")}] spawnpoint 4 created");
				$player->sendMessage(TextFormat::GREEN." [{$this->getConfig()->get("prefix")}] please click on the 5th spawnpoint");
				$this->pos4=new Vector3($this->pos4["x"]+0.5,$this->pos4["y"],$this->pos4["z"]+0.5);
				break;
			case 5:
				$this->pos5=array(
					"x" =>$block->x,
					"y" =>$block->y,
					"z" =>$block->z,
					"level" =>$levelname);
				$this->config->set("pos5",$this->pos5);
				$this->config->save();
				$this->SetStatus[$username]++;
				$player->sendMessage(TextFormat::GREEN." [{$this->getConfig()->get("prefix")}] spawnpoint 5 created");
				$player->sendMessage(TextFormat::GREEN."[{$this->getConfig()->get("prefix")}] Please click on the 6th spawnpoint");
				$this->pos5=new Vector3($this->pos5["x"]+0.5,$this->pos5["y"],$this->pos5["z"]+0.5);
				break;
			case 6:
				$this->pos6=array(
					"x" =>$block->x,
					"y" =>$block->y,
					"z" =>$block->z,
					"level" =>$levelname);
				$this->config->set("pos6",$this->pos6);
				$this->config->save();
				$this->SetStatus[$username]++;
				$player->sendMessage(TextFormat::GREEN."[{$this->getConfig()->get("prefix")}] spawnpoint 6 created");
				$player->sendMessage(TextFormat::GREEN."[{$this->getConfig()->get("prefix")}] Please click on the 7th spawnpoint");
				$this->pos6=new Vector3($this->pos6["x"]+0.5,$this->pos6["y"],$this->pos6["z"]+0.5);
				break;
			case 7:
				$this->pos7=array(
					"x" =>$block->x,
					"y" =>$block->y,
					"z" =>$block->z,
					"level" =>$levelname);
				$this->config->set("pos7",$this->pos7);
				$this->config->save();
				$this->SetStatus[$username]++;
				$player->sendMessage(TextFormat::GREEN."[{$this->getConfig()->get("prefix")}] spawnpoint 7 created");
				$player->sendMessage(TextFormat::GREEN."[{$this->getConfig()->get("prefix")}] Please click on the 8th spawnpoint");
				$this->pos7=new Vector3($this->pos7["x"]+0.5,$this->pos7["y"],$this->pos7["z"]+0.5);
				break;	
			case 8:
				$this->pos8=array(
					"x" =>$block->x,
					"y" =>$block->y,
					"z" =>$block->z,
					"level" =>$levelname);
				$this->config->set("pos8",$this->pos8);
				$this->config->save();
				$this->SetStatus[$username]++;
				$player->sendMessage(TextFormat::GREEN."[{$this->getConfig()->get("prefix")}] spawnpoint 8 created");
				$player->sendMessage(TextFormat::GREEN."[{$this->getConfig()->get("prefix")}] Please click to choose a destination for the death match");
				$this->pos8=new Vector3($this->pos8["x"]+0.5,$this->pos8["y"],$this->pos8["z"]+0.5);
				break;
case 9:
				$this->pos9=array(
					"x" =>$block->x,
					"y" =>$block->y,
					"z" =>$block->z,
					"level" =>$levelname);
				$this->config->set("pos9",$this->pos9);
				$this->config->save();
				$this->SetStatus[$username]++;
				$player->sendMessage(TextFormat::GREEN."Spawnpoint 9 created!");
				$player->sendMessage(TextFormat::GREEN."Please click on the 10th spawnpoint.");
				$this->pos9=new Vector3($this->pos9["x"]+0.5,$this->pos9["y"],$this->pos9["z"]+0.5);
				break;
			case 10:
				$this->pos10=array(
					"x" =>$block->x,
					"y" =>$block->y,
					"z" =>$block->z,
					"level" =>$levelname);
				$this->config->set("pos10",$this->pos10);
				$this->config->save();
				$this->SetStatus[$username]++;
				$player->sendMessage(TextFormat::GREEN."Spawnpoint 10 created!");
				$player->sendMessage(TextFormat::GREEN."Please click on the 11th spawnpoint.");
				$this->pos10=new Vector3($this->pos10["x"]+0.5,$this->pos10["y"],$this->pos10["z"]+0.5);
				break;
			case 11:
				$this->pos11=array(
					"x" =>$block->x,
					"y" =>$block->y,
					"z" =>$block->z,
					"level" =>$levelname);
				$this->config->set("pos11",$this->pos11);
				$this->config->save();
				$this->SetStatus[$username]++;
				$player->sendMessage(TextFormat::GREEN."Spawnpoint 11 created!");
				$player->sendMessage(TextFormat::GREEN."Please click on the 12th spawnpoint.");
				$this->pos11=new Vector3($this->pos11["x"]+0.5,$this->pos11["y"],$this->pos11["z"]+0.5);
				break;
			case 12:
				$this->pos12=array(
					"x" =>$block->x,
					"y" =>$block->y,
					"z" =>$block->z,
					"level" =>$levelname);
				$this->config->set("pos12",$this->pos12);
				$this->config->save();
				$this->SetStatus[$username]++;
				$player->sendMessage(TextFormat::GREEN."Spawnpoint 12 created!");
				$player->sendMessage(TextFormat::GREEN."Please click on the 13th spawnpoint.");				
				$this->pos12=new Vector3($this->pos12["x"]+0.5,$this->pos12["y"],$this->pos12["z"]+0.5);
				break;
			case 13:
				$this->pos13=array(
					"x" =>$block->x,
					"y" =>$block->y,
					"z" =>$block->z,
					"level" =>$levelname);
				$this->config->set("pos13",$this->pos13);
				$this->config->save();
				$this->SetStatus[$username]++;
				$player->sendMessage(TextFormat::GREEN."Spawnpoint 13 created!");
				$player->sendMessage(TextFormat::GREEN."Please click on the 14th spawnpoint.");				
				$this->pos13=new Vector3($this->pos13["x"]+0.5,$this->pos13["y"],$this->pos13["z"]+0.5);
				break;
			case 14:
				$this->pos14=array(
					"x" =>$block->x,
					"y" =>$block->y,
					"z" =>$block->z,
					"level" =>$levelname);
				$this->config->set("pos14",$this->pos14);
				$this->config->save();
				$this->SetStatus[$username]++;
				$player->sendMessage(TextFormat::GREEN."Spawnpoint 14 created!");
				$player->sendMessage(TextFormat::GREEN."Please click on the 15th spawnpoint.");				
				$this->pos14=new Vector3($this->pos14["x"]+0.5,$this->pos14["y"],$this->pos14["z"]+0.5);
				break;
			case 15:
				$this->pos15=array(
					"x" =>$block->x,
					"y" =>$block->y,
					"z" =>$block->z,
					"level" =>$levelname);
				$this->config->set("pos15",$this->pos15);
				$this->config->save();
				$this->SetStatus[$username]++;
				$player->sendMessage(TextFormat::GREEN."Spawnpoint 15 created!");
				$player->sendMessage(TextFormat::GREEN."Please click on the 16th spawnpoint.");				
				$this->pos15=new Vector3($this->pos15["x"]+0.5,$this->pos15["y"],$this->pos15["z"]+0.5);
				break;
			case 16:
				$this->pos16=array(
					"x" =>$block->x,
					"y" =>$block->y,
					"z" =>$block->z,
					"level" =>$levelname);
				$this->config->set("pos16",$this->pos16);
				$this->config->save();
				$this->SetStatus[$username]++;
				$player->sendMessage(TextFormat::GREEN."Spawnpoint 16 created!");
				$player->sendMessage(TextFormat::GREEN."Please click on the 17th spawnpoint.");				
				$this->pos16=new Vector3($this->pos16["x"]+0.5,$this->pos16["y"],$this->pos16["z"]+0.5);
				break;
			case 17:
				$this->pos17=array(
					"x" =>$block->x,
					"y" =>$block->y,
					"z" =>$block->z,
					"level" =>$levelname);
				$this->config->set("pos17",$this->pos17);
				$this->config->save();
				$this->SetStatus[$username]++;
				$player->sendMessage(TextFormat::GREEN."Spawnpoint 17 created!");
				$player->sendMessage(TextFormat::GREEN."Please click on the 18th spawnpoint.");				
				$this->pos17=new Vector3($this->pos17["x"]+0.5,$this->pos17["y"],$this->pos17["z"]+0.5);
				break;
			case 18:
				$this->pos18=array(
					"x" =>$block->x,
					"y" =>$block->y,
					"z" =>$block->z,
					"level" =>$levelname);
				$this->config->set("pos18",$this->pos18);
				$this->config->save();
				$this->SetStatus[$username]++;
				$player->sendMessage(TextFormat::GREEN."Spawnpoint 18 created!");
				$player->sendMessage(TextFormat::GREEN."Please click on the 19th spawnpoint.");				
				$this->pos18=new Vector3($this->pos18["x"]+0.5,$this->pos18["y"],$this->pos18["z"]+0.5);
				break;
			case 19:
				$this->pos19=array(
					"x" =>$block->x,
					"y" =>$block->y,
					"z" =>$block->z,
					"level" =>$levelname);
				$this->config->set("pos19",$this->pos19);
				$this->config->save();
				$this->SetStatus[$username]++;
				$player->sendMessage(TextFormat::GREEN."Spawnpoint 19 created!");
				$player->sendMessage(TextFormat::GREEN."Please click on the 20th spawnpoint.");				
				$this->pos19=new Vector3($this->pos19["x"]+0.5,$this->pos19["y"],$this->pos19["z"]+0.5);
				break;
			case 20:
				$this->pos20=array(
					"x" =>$block->x,
					"y" =>$block->y,
					"z" =>$block->z,
					"level" =>$levelname);
				$this->config->set("pos20",$this->pos20);
				$this->config->save();
				$this->SetStatus[$username]++;
				$player->sendMessage(TextFormat::GREEN."Spawnpoint 20 created!");
				$player->sendMessage(TextFormat::GREEN."Please click on the 21st spawnpoint.");				
				$this->pos20=new Vector3($this->pos20["x"]+0.5,$this->pos20["y"],$this->pos20["z"]+0.5);
				break;
			case 21:
				$this->pos21=array(
					"x" =>$block->x,
					"y" =>$block->y,
					"z" =>$block->z,
					"level" =>$levelname);
				$this->config->set("pos21",$this->pos21);
				$this->config->save();
				$this->SetStatus[$username]++;
				$player->sendMessage(TextFormat::GREEN."Spawnpoint 21 created!");
				$player->sendMessage(TextFormat::GREEN."Please click on the 22nd spawnpoint.");				
				$this->pos21=new Vector3($this->pos21["x"]+0.5,$this->pos21["y"],$this->pos21["z"]+0.5);
				break;
			case 22:
				$this->pos22=array(
					"x" =>$block->x,
					"y" =>$block->y,
					"z" =>$block->z,
					"level" =>$levelname);
				$this->config->set("pos22",$this->pos22);
				$this->config->save();
				$this->SetStatus[$username]++;
				$player->sendMessage(TextFormat::GREEN."Spawnpoint 22 created!");
				$player->sendMessage(TextFormat::GREEN."Please click on the 23rd spawnpoint.");				
				$this->pos22=new Vector3($this->pos22["x"]+0.5,$this->pos22["y"],$this->pos22["z"]+0.5);
				break;
			case 23:
				$this->pos23=array(
					"x" =>$block->x,
					"y" =>$block->y,
					"z" =>$block->z,
					"level" =>$levelname);
				$this->config->set("pos23",$this->pos23);
				$this->config->save();
				$this->SetStatus[$username]++;
				$player->sendMessage(TextFormat::GREEN."Spawnpoint 23 created!");
				$player->sendMessage(TextFormat::GREEN."Please click on the 24th spawnpoint.");				
				$this->pos23=new Vector3($this->pos23["x"]+0.5,$this->pos23["y"],$this->pos23["z"]+0.5);
				break;
			case 24:
				$this->pos24=array(
					"x" =>$block->x,
					"y" =>$block->y,
					"z" =>$block->z,
					"level" =>$levelname);
				$this->config->set("pos24",$this->pos24);
				$this->config->save();
				$this->SetStatus[$username]++;
				$player->sendMessage(TextFormat::GREEN."Spawnpoint 24 created!");
				$player->sendMessage(TextFormat::GREEN."Please Tap The Spawnpoint For pos25.");				
				$this->pos24=new Vector3($this->pos24["x"]+0.5,$this->pos24["y"],$this->pos24["z"]+0.5);
				break;
			case 25:
			$this->pos25=array(
					"x" =>$block->x,
					"y" =>$block->y,
					"z" =>$block->z,
					"level" =>$levelname);
				$this->config->set("pos25",$this->pos25);
				$this->config->save();
				$this->pos25=new Vector3($this->pos25["x"]+0.5,$this->pos25["y"],$this->pos25["z"]+0.5);
				unset($this->SetStatus[$username]);
				$player->sendMessage(TextFormat::GREEN."deathmatch spawnpoint created!");
				$player->sendMessage(TextFormat::GREEN."All settings completed, you can start a game now.");
				$this->level=$this->getServer()->getLevelByName($this->config->get("pos1")["level"]);	
			}
		}
		else
		{
			$sign=$event->getPlayer()->getLevel()->getTile($event->getBlock());
			if(isset($this->pos25) && $this->pos25!=array() && $sign instanceof Sign && $sign->getX()==$this->sign->x && $sign->getY()==$this->sign->y && $sign->getZ()==$this->sign->z && $event->getPlayer()->getLevel()->getFolderName()==$this->config->get("sign")["level"])
			{
				if(!$this->config->exists("pos25"))
				{
					$event->getPlayer()->sendMessage("[{$this->getConfig()->get("prefix")}] You can not join the game for the game hasn't been set yet");
					return;
				}
				if(!$event->getPlayer()->hasPermission("hg.touch.startgame"))
				{
					$event->getPlayer()->sendMessage("[{$this->getConfig()->get("prefix")}] You don't have permission to join this game");
					return;
				}
				if(!$event->getPlayer()->isOp())
				{
					$inv=$event->getPlayer()->getInventory();
					for($i=0;$i<$inv->getSize();$i++)
    				{
    					if($inv->getItem($i)->getID()!=0)
    					{
    						$event->getPlayer()->sendMessage("[{$this->getConfig()->get("prefix")}] Before the game,pleas clear your inv");
    						return;
    					}
    				}
    				foreach($inv->getArmorContents() as $i)
    				{
    					if($i->getID()!=0)
    					{
    						$event->getPlayer()->sendMessage("[{$this->getConfig()->get("prefix")}] Please take off your equipments and put them in the case");
    						return;
    					}
    				}
    			}
				if($this->gameStatus==0 || $this->gameStatus==1)
				{
					if(!isset($this->players[$event->getPlayer()->getName()]))
					{
						if(count($this->players)>=22)
						{
							$event->getPlayer()->sendMessage("[{$this->getConfig()->get("prefix")}] the map is full,no spare place for more");
							return;
						}
						$event->getPlayer()->sendMessage("[{$this->getConfig()->get("prefix")}]Player ".$event->getPlayer()->getName()." joined the game");
						$this->players[$event->getPlayer()->getName()]=array("id"=>$event->getPlayer()->getName());
						$event->getPlayer()->sendMessage("[{$this->getConfig()->get("prefix")}] joined the game successfully");
						if($this->gameStatus==0 && count($this->players)>=1)
						{
							$this->gameStatus=1;
							$this->lastTime=$this->waitTime;
							$event->getPlayer()->sendMessage("[{$this->getConfig()->get("prefix")}]The will start shortly");
						}
						if(count($this->players)==24 && $this->gameStatus==1 && $this->lastTime>5)
						{
							$event->getPlayer()->sendMessage("[{$this->getConfig()->get("prefix")}] Already full... Starting");
							$this->lastTime=5;
						}
						$this->changeStatusSign();
					}
					else
					{
						$event->getPlayer()->sendMessage("[{$this->getConfig()->get("prefix")}] You Are Already In A Macth Type /lobby to leave");
					}
				}
				else
				{
					$event->getPlayer()->sendMessage("[{$this->getConfig()->get("prefix")}] The Game Has Already Started");
				}
			}
		}
	}
	public function changeStatusSign()
	{
		if(!isset($this->sign))
		{
			return;
		}
		$sign=$this->signlevel->getTile($this->sign);
		if($sign instanceof Sign)
		{
			switch($this->gameStatus)
			{
			case 0:
				$sign->setText(TextFormat::AQUA. "[{$this->getConfig()->get("prefix")}]","[Join]","Players: ".count($this->players),"");
				break;
			case 1:
				$sign->setText(TextFormat::AQUA. "[{$this->getConfig()->get("prefix")}]","[Join]","Players: ".count($this->players),"Time left: ".$this->lastTime." sec");
				break;
			case 2:
				$sign->setText(TextFormat::AQUA. "[{$this->getConfig()->get("prefix")}]","[Running]","Players: ".count($this->players),"Time left: ".$this->lastTime." sec");
				break;
			case 3:
				$sign->setText(TextFormat::AQUA. "[{$this->getConfig()->get("prefix")}]","[Running]","Players: ".count($this->players)."/{$this->all}","DM In:".$this->lastTime."sec");
				break;
			case 4:
				$sign->setText(TextFormat::AQUA. "[{$this->getConfig()->get("prefix")}]","[DM]","Players: ".count($this->players)."/{$this->all}","Ends in:".$this->lastTime."sec");
				break;
			}
		}
		unset($sign);
	}
	
	public function ClearInv($player)
	{
		if(!$player instanceof Player)
		{
			unset($player);
			return;
		}
		$inv=$player->getInventory();
		if(!$inv instanceof Inventory)
		{
			unset($player,$inv);
			return;
		}
		$inv->clearAll();
		unset($player,$inv);
	}
	
	public function ClearAllInv()
	{
		foreach($this->players as $pl)
		{
			$player=$this->getServer()->getPlayer($pl["id"]);
			if(!$player instanceof Player)
			{
				continue;
			}
			$this->ClearInv($player);
		}
		unset($pl,$player);
	}
	
	public function PlayerQuit(PlayerQuitEvent $event){
		if(isset($this->players[$event->getPlayer()->getName()]))
		{	
			unset($this->players[$event->getPlayer()->getName()]);
			$this->ClearInv($event->getPlayer());
			$event->getPlayer()->sendMessage(TextFormat::RED. "[{$this->getConfig()->get("prefix")}]".$event->getPlayer()->getName()." left the match due to client disconnect.");
			$this->changeStatusSign();
			if($this->gameStatus==1 && count($this->players)<2)
			{
				$this->gameStatus=0;
				$this->lastTime=0;
				$event->getPlayer()->sendMessage(TextFormat::RED. "[{$this->getConfig()->get("prefix")}]There aren't enough players. Countdown has stopped please do /lobby to leave.");
			}
		}
	}
	public function PlayerJoin(PlayerJoinEvent $event){
	$hg = $this->getServer()->getPluginManager();
	$player = $event->getPlayer();
	$player->sendPopUp("Your Money Is $".$this->getServer()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($event->getPlayer()->getName()));
	$this->hg = $hg->getPlugin("{$this->getConfig()->get("prefix")}");
	$player->sendMessage(TextFormat::GOLD."This Server Is Using ".$this->hg->getName(). TextFormat::GOLD. " v".$this->hg->getDescription()->getVersion()." By SavionLegendZzz!");
//below is something c0oL	
	}

	 /* private function addDeath($player){
		if(!$this->stats->exist($player)){ 
        		$this->stats->set($player, array(1, 0, 0)); 
       		}else{
       			$deaths = $this->stats->get($player)[0] + 1;
       			$kills = $this->stats->get($player)[1]; 
        		$this->stats->set($player, array($deaths, $kills)); 
        	}
        	return true;
	}
	
	private function addKill($player){
		if(!$this->stats->exist($player)){ 
        		$this->stats->set($player, array(0, 1)); 
       		}else{
       			$deaths = $this->stats->get($player)[0]; 
       			$kills = $this->stats->get($player)[1] + 1;
        		$this->stats->set($player, array($deaths, $kills)); 
        	}
        	return true;
	}*/
public function move(PlayerMoveEvent $event){
$p=$event->getPlayer();
$p->sendPopUp("Your Money Is $".$this->getServer()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($p->getName()));
	
}
	
		
	public function getMoney($name){
		return EconomyAPI::getInstance()->myMoney($name);
	}
	
	public function addMoney($name,$money){
		EconomyAPI::getInstance()->addMoney($name,$money);
		unset($name,$money);
	}
	
	public function setMoney($name,$money){
		EconomyAPI::getInstance()->setMoney($name,$money);
		unset($name,$money);
	}
	public function onDisable(){
		$this->config->save();
		//$this->stats->save();
			$this->getServer()->getLogger()->notice(TextFormat::GREEN."[{$this->getConfig()->get("prefix")}] Saved All Data");
			$this->getServer()->getLogger()->notice(TextFormat::RED."[{$this->getConfig()->get("prefix")}] Disabling....");
	}
}
