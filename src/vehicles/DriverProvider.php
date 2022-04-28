<?php

declare(strict_types=1);

namespace HighestDreams\VehiclesSystem\vehicles;

use Exception;
use HighestDreams\VehiclesSystem\Loader;
use JsonException;
use pocketmine\entity\Entity;
use pocketmine\entity\Skin;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\SetActorLinkPacket;
use pocketmine\network\mcpe\protocol\types\entity\EntityLink;
use pocketmine\network\mcpe\protocol\types\entity\EntityMetadataFlags;
use pocketmine\player\Player;
use pocketmine\Server;

trait DriverProvider
{
    public function haveDriver(): bool
    {
        return !is_null($this->getDriver());
    }

    public function haveOwner(): bool
    {
        return !is_null($this->getOwner());
    }

    public function canAddRiders(): bool
    {
        return count($this->getRiders()) < count($this->getSeatPositions());
    }

    public function seat(Player $player, int $seat): void
    {
        /* Link player to the vehicle */
        $pk = new SetActorLinkPacket();
        $pk->link = new EntityLink($this->getId(), $player->getId(), EntityLink::TYPE_RIDER, true, true);
        $players = Server::getInstance()->getOnlinePlayers();
        Server::getInstance()->broadcastPackets($players, [$pk]);
        /* Change player position to the seat's position */
        $seatPosition = $this->getSeatPositions()[$seat];
        $player->getNetworkProperties()->setVector3(EntityMetadataFlags::RIDING, $seatPosition);
        $this->riders[] = $player;
    }

    private function addPassenger(Player $player): void
    {
        $availableSeat = count($this->getRiders());
        $this->seat($player, $availableSeat);
    }

    private function setDriver(Player $player)
    {
        if ($this->haveOwner()) {
            if ($player->getName() != $this->getOwner()->getName()) {
                $player->sendMessage('You cannot drive other\'s car.');
                return;
            }
        }
        $this->driver = $player;
        $this->seat($player, 0);
    }

    public function ride(Player $player): void
    {
        if ($this->canAddRiders()) {
            $this->haveDriver() ? $this->addPassenger($player) : $this->setDriver($player);
            return;
        }
        $player->sendMessage('This vehicle is full of riders.');
    }
}