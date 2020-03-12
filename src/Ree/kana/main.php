<?php

declare(strict_types=1);

namespace Ree\kana;

use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\LoginPacket;
use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\event\player\PlayerChatEvent;

/**
 * Class Main
 * @package Ree\kana
 */
class Main extends PluginBase implements Listener {

    private const DEVICE_WINDOWS = 7;

    private $translateFlag = [];

    private function hasTranslateFlag(Player $player): bool {
        return isset($this->translateFlag[$player->getLowerCaseName()]);
    }

	public function onEnable() {
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}

	public function onLogin(DataPacketReceiveEvent $ev) {
	    $pk = $ev->getPacket();
	    if ($pk->pid() === LoginPacket::NETWORK_ID) {
	        /** @var LoginPacket $pk */
	        $deviceOS = $pk->clientData["DeviceOS"];
	        if ($deviceOS === self::DEVICE_WINDOWS) {
	            $this->translateFlag[strtolower($pk->username)] = true;
            }
        }
    }

    public function onQuit(PlayerQuitEvent $ev) {
        $player = $ev->getPlayer();
        if ($this->hasTranslateFlag($player)) {
            unset($this->translateFlag[$player->getLowerCaseName()]);
        }
    }

	public function onChat(PlayerChatEvent $ev) {
        $player = $ev->getPlayer();
		if ($this->hasTranslateFlag($player)) {
			$this->getServer()->getAsyncPool()->submitTask(new TranslateTask($player->getDisplayName(), $ev->getMessage(), $player->isOp()));
			$ev->setCancelled();
		}
	}
}