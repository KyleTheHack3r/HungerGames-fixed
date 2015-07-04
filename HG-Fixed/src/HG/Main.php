<?php
namespace HG;
// DONE:implement money adding for when a player wins a match :D
// DONE:also create a diiffrenet function for when a player wins a match to earn $$$
// TODO: add broadcaster? with custom messages in configs leave message in comments if good idea :P
// 25% DONE: set up more matches (gonna take some time :P 2 atm 5 is gonna be the max maybe...?)
// TODO: make a video on how to setup hungergames
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
		$this->gameStatus=0;
		$this->lastTime=0;
		$this->players=array();
		$this->SetStatus=array();
		$this->all=0;
		$rc = $this->getServer()->getPluginManager();
		if(!($this->rc = $rc->getPlugin("ResetChest")))
			{
			$this->getServer()->getLogger()->CRITICAL(
											 ("[HungerGames]Please Install ResetChest For HungerGames To Work Properly"));
											 } else {
			$this->getServer()->getLogger()->notice(TextFormat::AQUA.
											 ("[HungerGames]".TextFormat::BLUE."HungerGames Has Been Enabled Using ". TextFormat::GOLD. $this->rc->getName(). " v".$this->rc->getDescription()->getVersion()));
		}
		$api = $this->getServer()->getPluginManager();
		if(!($this->api = $api->getPlugin("EconomyAPI")))
			{
			$this->getServer()->getLogger()->CRITICAL(
											 ("[HungerGames]Please Install EconomyAPI For HungerGames To Work Properly"));
											 } else {
			$this->getServer()->getLogger()->notice(TextFormat::AQUA.
											 ("[HungerGames]".TextFormat::BLUE."HungerGames Has Been Enabled Using ". TextFormat::GOLD. $this->api->getName(). " v".$this->api->getDescription()->getVersion()));
											 $this->getServer()->getLogger()->info(TextFormat::AQUA."[HungerGames]".TextFormat::GOLD."Plugin Has Been Fully Enabled!");
											 $this->getServer()->getLogger()->warning(TextFormat::AQUA."[HungerGames]".TextFormat::RED."REMEMBER: report bugs on github please!");
		}
	}
	public function onCommand(CommandSender $sender, Command $command, $label, array $args)
	{
		if($command->getName()=="lobby")
		{
			if($this->gameStatus>=2 && $this->gameStatus2>=2)
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
				$name=$sender->getName();
				$this->SetStatus[$name]=0;
				$sender->sendMessage(TextFormat::DARK_BLUE. "[HungerGames]Please tap the status sign(sign 1).");
			} 
			else{
			//nothung
			}
			break;
			case "help":
		    $sender->sendMessage(TextFormat::LIGHT_PURPLE."=+=+=".TextFormat::YELLOW."How To Setup A HungerGames Match!".TextFormat::LIGHT_PURPLE."=+=+=");
			$sender->sendMessage(
TextFormat::LIGHT_PURPLE."
Step 1:".TextFormat::AQUA."Do /hungergames set(1 or 2 depends if you set up a match already)"
.TextFormat::LIGHT_PURPLE."
Step 2:".TextFormat::AQUA."Place A Sign Then Tap On It"
.TextFormat::LIGHT_PURPLE."
Step 3:".TextFormat::AQUA."Go To Where You Are Setting Up Your HungerGames Map (a different world maybe)"
.TextFormat::LIGHT_PURPLE."
Step 4:".TextFormat::AQUA."Set The Spawnpoints By Taping On Them(You Have To Tap 24 Spawnpoints!)"
.TextFormat::LIGHT_PURPLE."
Step 5:".TextFormat::AQUA."Tap The Spot Where pos25 Will Happen (Preferably The Middle Of The pos25 Spot!)"
.TextFormat::LIGHT_PURPLE."
Step 6:".TextFormat::AQUA."Your Done You Can Start A Match Now, Re-do All These Step But Use /hungergames set2");
$hg = $this->getServer()->getPluginManager();
	$this->hg = $hg->getPlugin("HungerGames");
$this->getServer()->getLogger()->info(TextFormat::GOLD."This Server Is Using ".$this->hg->getName(). TextFormat::GOLD. " v".$this->hg->getDescription()->getVersion()." By SavionLegendZzz!");
			break;
				/*case "stat":
     if($sender->hasPermission
