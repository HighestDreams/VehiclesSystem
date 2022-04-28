<?php

declare(strict_types=1);

namespace HighestDreams\VehiclesSystem\vehicles\models;

use HighestDreams\VehiclesSystem\vehicles\Driver;
use HighestDreams\VehiclesSystem\vehicles\DriverProvider;
use JsonException;
use pocketmine\entity\Location;
use HighestDreams\VehiclesSystem\Loader;
use HighestDreams\VehiclesSystem\vehicles\Vehicle;
use HighestDreams\VehiclesSystem\vehicles\VehiclesBase;
use HighestDreams\VehiclesSystem\vehicles\VehiclesProvider;
use pocketmine\math\Vector3;
use pocketmine\player\Player;

class DirtMotor extends VehiclesBase implements Vehicle, Driver
{
    use VehiclesProvider, DriverProvider;

    private array $riders = array();

    private Player $driver;

    public const MODEL = 'dirt_motor';

    public const MAXIMUM_SPEED = 130;

    private float|int $speed;

    /**
     * @throws JsonException
     */
    public function __construct(Location $location, private string $geometryName, private ?Player $owner = null)
    {
        parent::__construct($location, $this->getVehicleSkin());
    }

    public function getModel(): string
    {
        return self::MODEL;
    }

    public function getSkinPath(): string
    {
        return Loader::getInstance()->getDataFolder() . self::MODEL;
    }

    public function getSpeed(): int|float
    {
        return $this->speed;
    }

    public function getMaximumSpeed(): int|float
    {
        return self::MAXIMUM_SPEED;
    }

    public function getRiders(): array
    {
        return $this->riders;
    }

    public function getOwner(): ?Player
    {
        return $this->owner;
    }

    public function getSeatPositions(): array
    {
        return [
            new Vector3(0, 1, -0.5)
        ];
    }

    public function getDriver(): ?Player
    {
        return $this->driver ?? null;
    }
}