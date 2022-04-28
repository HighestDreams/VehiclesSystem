<?php

declare(strict_types=1);

namespace HighestDreams\VehiclesSystem;

use HighestDreams\VehiclesSystem\vehicles\models\DirtMotor;
use JsonException;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJumpEvent;

final class EventsHandler implements Listener
{
    /**
     * @throws JsonException
     */
    public function onPlayerJumpEvent(PlayerJumpEvent $event)
    {
        $player = $event->getPlayer();
        $location = $player->getLocation();
        // Needs to be fixed... (Spawn via command)
        $camaro = new DirtMotor($location, 'geometry.dirt_motor');
        $camaro->spawnToAll();
        $player->sendMessage('Your car spawned successfully.');

    }
}