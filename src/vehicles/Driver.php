<?php

declare(strict_types=1);

namespace HighestDreams\VehiclesSystem\vehicles;

use pocketmine\player\Player;

interface Driver
{

    public function getRiders(): array;

    public function getOwner(): ?Player;

    public function getSeatPositions(): array;

    public function getDriver(): ?Player;
}