<?php

namespace TrenicHD;




use pocketmine\block\Sandstone;
use pocketmine\entity\Effect;
use pocketmine\event\player\PlayerRespawnEvent;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDeathEvent;
use pocketmine\event\inventory\InventoryTransactionEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PlayerExhaustEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\item\Bread;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\IronBoots;
use pocketmine\item\IronChestplate;
use pocketmine\item\IronHelmet;
use pocketmine\item\IronLeggings;
use pocketmine\item\Item;
use pocketmine\item\ItemBlock;
use pocketmine\level\Level;
use pocketmine\level\Position;
use pocketmine\level\sound\AnvilFallSound;
use pocketmine\level\sound\ClickSound;
use pocketmine\level\sound\EndermanTeleportSound;
use pocketmine\level\sound\GhastShootSound;
use pocketmine\level\sound\PopSound;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacketV2;
use pocketmine\network\mcpe\protocol\RemoveObjectivePacket;
use pocketmine\network\mcpe\protocol\SetDisplayObjectivePacket;
use pocketmine\network\mcpe\protocol\SetScorePacket;
use pocketmine\network\mcpe\protocol\types\ScorePacketEntry;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use jojoe77777\FormAPI;
use pocketmine\entity\EffectInstance;
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\utils\TextFormat;
use pocketmine\utils\Config;
use pocketmine\level\sound\AnvilUseSound;
use TrenicHD\tasks\ScoreboardTask;
use TrenicHD\utils\Scoreboard;
use onebone\economyapi\EconomyAPI;



class Main extends PluginBase implements Listener
{

    public $prefix = "";





    public function onLoad()
    {


        $this->getLogger()->info(TextFormat::AQUA . "FFA Wird Geladen...");
        sleep(1);
        $this->getLogger()->info(TextFormat::AQUA . "Config wird geladen/erstellt...");
        sleep(1);
        $this->getLogger()->warning(TextFormat::GOLD . "0%");
        $this->getConfig();
        sleep(1);
        $this->getLogger()->warning(TextFormat::GOLD . "5%");
        sleep(1);
        $this->getLogger()->warning(TextFormat::GOLD . "10%");
        sleep(1);
        $this->getLogger()->warning(TextFormat::GOLD . "20%");
        sleep(1);
        $this->getLogger()->warning(TextFormat::GOLD . "30%");
        sleep(1);
        $this->getLogger()->warning(TextFormat::GOLD . "40%");
        sleep(1);
        $this->getLogger()->warning(TextFormat::GOLD . "50%");
        $this->saveResource("config.yml");
        sleep(1);
        $this->getLogger()->warning(TextFormat::GOLD . "60%");
        sleep(1);
        $this->getLogger()->warning(TextFormat::GOLD . "70%");
        sleep(1);
        $this->getLogger()->warning(TextFormat::GOLD . "80%");
        sleep(1);
        $this->getLogger()->warning(TextFormat::GOLD . "90%");
        sleep(2);
        $config = new Config($this->getDataFolder() . "config.yml" , Config::YAML);
        $this->getLogger()->warning(TextFormat::GOLD . "100%");
        $config->save();
        $this->getLogger()->warning(TextFormat::AQUA . "Config erstellt/geladen!");

        $this->getLogger()->info(TextFormat::GREEN ."Plugin FFA wurde Geladen!");
        $this->getLogger()->info(TextFormat::GREEN ."Das Plugin FFA ist aktiv!");
        $this->getLogger()->warning(TextFormat::GOLD . "###############################################################################################################");
        $this->getLogger()->warning(TextFormat::GOLD . "#                                                                                                             ");
        $this->getLogger()->warning(TextFormat::AQUA . "#                     ██████╗░██╗░░░██╗  ████████╗██████╗░███████╗███╗░░██╗██╗░█████╗░██╗░░██╗██████╗░       ");
        $this->getLogger()->warning(TextFormat::GREEN . "#                     ██╔══██╗╚██╗░██╔╝  ╚══██╔══╝██╔══██╗██╔════╝████╗░██║██║██╔══██╗██║░░██║██╔══██╗      ");
        $this->getLogger()->warning(TextFormat::AQUA . "#                     ██████╦╝░╚████╔╝░  ░░░██║░░░██████╔╝█████╗░░██╔██╗██║██║██║░░╚═╝███████║██║░░██║       ");
        $this->getLogger()->warning(TextFormat::GREEN . "#                     ██╔══██╗░░╚██╔╝░░  ░░░██║░░░██╔══██╗██╔══╝░░██║╚████║██║██║░░██╗██╔══██║██║░░██║       ");
        $this->getLogger()->warning(TextFormat::AQUA . "#                     ██████╦╝░░░██║░░░  ░░░██║░░░██║░░██║███████╗██║░╚███║██║╚█████╔╝██║░░██║██████╔╝       ");
        $this->getLogger()->warning(TextFormat::GREEN . "#                     ╚═════╝░░░░╚═╝░░░  ░░░╚═╝░░░╚═╝░░╚═╝╚══════╝╚═╝░░╚══╝╚═╝░╚════╝░╚═╝░░╚═╝╚═════╝░       ");
        $this->getLogger()->warning(TextFormat::GOLD . "#                                                                                                             ");
        $this->getLogger()->warning(TextFormat::GOLD . "###############################################################################################################");

    }

    public function onEnable()
    {

        $this->getConfig();
        $this->saveResource("config.yml");
        $config = new Config($this->getDataFolder() . "config.yml" , Config::YAML);
        if (empty($config->get("Prefix"))) {
            $config->set("#122", "###############################################################################################################");
            $config->set("#222", "#                                                                                                             ");
            $config->set("#3", "#                     ██████╗░██╗░░░██╗  ████████╗██████╗░███████╗███╗░░██╗██╗░█████╗░██╗░░██╗██████╗░       ");
            $config->set("#4", "#                     ██████╗░██╗░░░██╗  ████████╗██████╗░███████╗███╗░░██╗██╗░█████╗░██╗░░██╗██████╗░       ");
            $config->set("#5", "#                     ██╔══██╗╚██╗░██╔╝  ╚══██╔══╝██╔══██╗██╔════╝████╗░██║██║██╔══██╗██║░░██║██╔══██╗      ");
            $config->set("#6", "#                     ██████╦╝░╚████╔╝░  ░░░██║░░░██████╔╝█████╗░░██╔██╗██║██║██║░░╚═╝███████║██║░░██║       ");
            $config->set("#7", "#                     ██████╦╝░╚████╔╝░  ░░░██║░░░██████╔╝█████╗░░██╔██╗██║██║██║░░╚═╝███████║██║░░██║       ");
            $config->set("#8", "#                     ██╔══██╗░░╚██╔╝░░  ░░░██║░░░██╔══██╗██╔══╝░░██║╚████║██║██║░░██╗██╔══██║██║░░██║       ");
            $config->set("#9", "#                     ██████╦╝░░░██║░░░  ░░░██║░░░██║░░██║███████╗██║░╚███║██║╚█████╔╝██║░░██║██████╔╝       ");
            $config->set("#0", "#                     ╚═════╝░░░░╚═╝░░░  ░░░╚═╝░░░╚═╝░░╚═╝╚══════╝╚═╝░░╚══╝╚═╝░╚════╝░╚═╝░░╚═╝╚═════╝░       ");
            $config->set("#11", "#                                                                                                             ");
            $config->set("#12", "###############################################################################################################");
            $config->set("Prefix", "§6FFA»");
            $config->set("join", "");
            $config->set("leave", "");
            $config->set("#","###########Economy money +/n (nur zahl)##############");
            $config->set("money-","5");
            $config->set("money+", "5");
            $config->set("#1", "Money -/+ subtitle");
            $config->set("coins-", "-5 Coins");
            $config->set("coins+", "+5 Coins");
            $config->set("hub", "transferserver Plot-craft.net 19132");
            $config->set("#1111", "Abonniert TrenicHD!");
            $config->set("Werbung", "https://www.youtube.com/TrenicHD");
        }
        $this->getServer()->getPluginManager()->registerEvents($this, $this);

        $config->save();

        $this->saveResource("config.yml");
        @mkdir($this->getDataFolder());
        $this->prefix = $config->get("Prefix");
    }

    public function onDisable()
    {

        $this->getLogger()->info("FFA Deaktiviert!");
        $this->getConfig();
        $this->getLogger()->warning(TextFormat::AQUA . "Config wird Gespeichert.");
        $this->saveResource("config.yml");
        $this->getLogger()->error(TextFormat::DARK_RED . "####################################################################################################################################################################");
        $this->getLogger()->error(TextFormat::GOLD . "#                                                                                                             ");
        $this->getLogger()->error(TextFormat::AQUA . "#                      ▄████▄   ▒█████  ▓█████▄ ▓█████     ▄▄▄▄   ▓██   ██▓   ▄▄▄█████▓ ██▀███  ▓█████  ███▄    █  ██▓ ▄████▄   ██░ ██ ▓█████▄        ");
        $this->getLogger()->error(TextFormat::GREEN . "#                     ▒██▀ ▀█  ▒██▒  ██▒▒██▀ ██▌▓█   ▀    ▓█████▄  ▒██  ██▒   ▓  ██▒ ▓▒▓██ ▒ ██▒▓█   ▀  ██ ▀█   █ ▓██▒▒██▀ ▀█  ▓██░ ██▒▒██▀ ██▌     ");
        $this->getLogger()->error(TextFormat::AQUA . "#                     ▒▓█    ▄ ▒██░  ██▒░██   █▌▒███      ▒██▒ ▄██  ▒██ ██░   ▒ ▓██░ ▒░▓██ ░▄█ ▒▒███   ▓██  ▀█ ██▒▒██▒▒▓█    ▄ ▒██▀▀██░░██   █▌       ");
        $this->getLogger()->error(TextFormat::GREEN . "#                    ▒▓▓▄ ▄██▒▒██   ██░░▓█▄   ▌▒▓█  ▄    ▒██░█▀    ░ ▐██▓░   ░ ▓██▓ ░ ▒██▀▀█▄  ▒▓█  ▄ ▓██▒  ▐▌██▒░██░▒▓▓▄ ▄██▒░▓█ ░██ ░▓█▄   ▌       ");
        $this->getLogger()->error(TextFormat::AQUA . "#                     ▒ ▓███▀ ░░ ████▓▒░░▒████▓ ░▒████▒   ░▓█  ▀█▓  ░ ██▒▓░     ▒██▒ ░ ░██▓ ▒██▒░▒████▒▒██░   ▓██░░██░▒ ▓███▀ ░░▓█▒░██▓░▒████▓        ");
        $this->getLogger()->error(TextFormat::GREEN . "#                    ░ ░▒ ▒  ░░ ▒░▒░▒░  ▒▒▓  ▒ ░░ ▒░ ░   ░▒▓███▀▒   ██▒▒▒      ▒ ░░   ░ ▒▓ ░▒▓░░░ ▒░ ░░ ▒░   ▒ ▒ ░▓  ░ ░▒ ▒  ░ ▒ ░░▒░▒ ▒▒▓  ▒     ");
        $this->getLogger()->error(TextFormat::GOLD . "#                       ░  ▒     ░ ▒ ▒░  ░ ▒  ▒  ░ ░  ░   ▒░▒   ░  ▓██ ░▒░        ░      ░▒ ░ ▒░ ░ ░  ░░ ░░   ░ ▒░ ▒ ░  ░  ▒    ▒ ░▒░ ░ ░ ▒  ▒                                                                                         ");
        $this->getLogger()->error(TextFormat::GOLD . "#                     ░        ░ ░ ░ ▒   ░ ░  ░    ░       ░    ░  ▒ ▒ ░░       ░        ░░   ░    ░      ░   ░ ░  ▒ ░░         ░  ░░ ░ ░ ░  ░ ");
        $this->getLogger()->error(TextFormat::GOLD . "#                     ░ ░          ░ ░     ░       ░  ░    ░       ░ ░                    ░        ░  ░         ░  ░  ░ ░       ░  ░  ░   ░    ");
        $this->getLogger()->error(TextFormat::GOLD . "#                     ░                  ░                      ░  ░ ░                                                ░                 ░      ");
        $this->getLogger()->error(TextFormat::DARK_RED . "#######################################################################################################################################################################");

    }

    public function onJoinPlayer(PlayerJoinEvent $event){
        $config = new Config($this->getDataFolder() . "config.yml" , Config::YAML);

        $player = $event->getPlayer();
        $player->getInventory()->clearAll();
        $event->setJoinMessage($config->get("join"));
        $player->getInventory()->setItem(0, Item::get(267)->setCustomName("§b»EISENSCHWERT"));
        $player->getArmorInventory()->setChestplate(IronChestplate::get(307));
        $player->getArmorInventory()->setBoots(IronBoots::get(309));
        $player->getArmorInventory()->setLeggings(IronLeggings::get(308));
        $player->getArmorInventory()->setHelmet(IronHelmet::get(306));
        $player->getInventory()->setItem(8, Item::get(322, 0, 5)->setCustomName("§c»GOLDAPFEL"));
        $player->teleport($player->getLevel()->getSafeSpawn());

    }

    public function onQuitPlayer(PlayerQuitEvent $event) {
        $config = new Config($this->getDataFolder() . "config.yml" , Config::YAML);
        $player = $event->getPlayer();
        $event->setQuitMessage($config->get("leave"));
        $player->getInventory()->clearAll();
    }

    public function onDrop(PlayerDropItemEvent $event){

        $event->setCancelled(true);
    }

    public function BlockBreakEvent(BlockBreakEvent $event){

        $event->setCancelled(true);
    }

    public function BlockPlaceEvent(BlockPlaceEvent $event){

        $event->setCancelled(true);
    }

    public function PlayerRespawnEvent(PlayerRespawnEvent $event){
        $config = new Config($this->getDataFolder() . "config.yml" , Config::YAML);
        $player = $event->getPlayer();
        $player->getInventory()->clearAll();
        $player->getInventory()->setItem(0, Item::get(267)->setCustomName("§b»EISENSCHWERT"));
        $player->getInventory()->setItem(8, Item::get(322, 0, 5)->setCustomName("§c»GOLDAPFEL"));
        $event->getPlayer()->addTitle("§c✘");
        $player->getArmorInventory()->setChestplate(IronChestplate::get(307));
        $player->getArmorInventory()->setBoots(IronBoots::get(309));
        $player->getArmorInventory()->setLeggings(IronLeggings::get(308));
        $player->getArmorInventory()->setHelmet(IronHelmet::get(306));
        $event->getPlayer()->addSubTitle("§cDu bist Gestorben! \n" . $config->get("coins-"));
    }

    public function onDeath(PlayerDeathEvent $event){
        $config = new Config($this->getDataFolder() . "config.yml" , Config::YAML);

        if ($event->getEntity() instanceof Player) {
            $event->setDrops([]);

            $event->getPlayer()->addTitle("§c ✘");
            $player = $event->getPlayer();
            $player->getLevel()->addSound(new AnvilFallSound($player));
            $cause = $player->getLastDamageCause();
            if ($cause instanceof EntityDamageByEntityEvent) {
                $damager = $cause->getDamager();
                $damager->getLastDamageCause();
                if ($damager instanceof Player) {
                    $damager->getPlayer()->addTitle("§a ✔ \n " . $player->getName());
                    $damager->getPlayer()->addSubTitle($config->get("coins+"));
                    $damager->getInventory()->clearAll();
                    $damager->getInventory()->setItem(0, Item::get(267)->setCustomName("§b»EISENSCHWERT"));
                    $damager->getInventory()->setItem(8, Item::get(322, 0, 5)->setCustomName("§c»GOLDAPFEL"));
                    $damager->getArmorInventory()->setChestplate(IronChestplate::get(307));
                    $damager->getArmorInventory()->setBoots(IronBoots::get(309));
                    $damager->getArmorInventory()->setLeggings(IronLeggings::get(308));
                    $damager->getArmorInventory()->setHelmet(IronHelmet::get(306));
                    $event->setDeathMessage("§c Der Spieler §b" . $player->getName() . "§c wurde von §b" . $damager->getName() . "§c Getötet!");
                    $config = new Config($this->getDataFolder() . "config.yml" , Config::YAML);
                    EconomyAPI::getInstance()->reduceMoney($player, $config->get("money-"));
                    $this->getServer()->broadcastMessage("");
                    $effect = new EffectInstance(Effect::getEffect(10), 150, 30, false);
                    $damager->addEffect($effect);
                    $damager->getLevel()->addSound(new PopSound($damager));
                    EconomyAPI::getInstance()->addMoney($damager, $config->get("money+"));
                    $player = $event->getPlayer();
                    $entity = $event->getEntity();
                    if ($entity instanceof Player) {
                        $event->setDrops([]);
                    }

                }
            }
        }
    }

    public function Hunger(PlayerExhaustEvent $event){
        $event->setCancelled(true);
    }

    public function setAttackCooldown(int $attackCooldown) : void{
        $this->attackCooldown = $attackCooldown;
    }

    public function onDamage(EntityDamageEvent $event) {

        $player = $event->getEntity();
        $level = $player->getLevel();
        $r = $this->getServer()->getSpawnRadius();
        if(($player instanceof Player) && ($player->getPosition()->distance($level->getSafeSpawn()) <= $r)) {
            $event->setCancelled(true);
        }
        else
        {
            $event->setCancelled(false);
        }

    }

    public function onPlayerDamage(EntityDamageEvent $event){

    }

    public function onPlayerMove(PlayerMoveEvent $event) {
        $player = $event->getPlayer();
        $v = new Vector3($player->getLevel()->getSpawnLocation()->getX(),$player->getPosition()->getY(),$player->getLevel()->getSpawnLocation()->getZ());
        $r = $this->getServer()->getSpawnRadius();
        if(($player instanceof Player) && ($player->getPosition()->distance($v) <= $r)) {
        }else{


        }

    }

    public function onCommand(CommandSender $player, Command $cmd, string $label, array $args): bool
    {
        $config = new Config($this->getDataFolder() . "config.yml" , Config::YAML);
        switch ($cmd->getName()) {
            case "hub":
                if ($player instanceof Player){
                    if ($player->hasPermission("hub.use")){
                        $this->getServer()->dispatchCommand($player,($config->get("hub")));
                    }
                }
                break;
        }

        switch ($cmd->getName()){
            case "spectate":
                if ($player instanceof Player){
                    $player->setGamemode(3);
                    $player->sendMessage("$this->prefix um denn Spectator modus zu verlassen, Benutze §b/leave");
                }
                break;
        }
        switch ($cmd->getName()){
            case "leave":
                if ($player instanceof Player){
                    $player->setGamemode(0);
                    $player->teleport($player->getLevel()->getSafeSpawn());
                    $player->sendMessage("$this->prefix §b Du hast denn Spectator Mode verlassen!");
                }
                break;
        }
        return true;

    }


}