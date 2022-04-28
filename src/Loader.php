<?php

declare(strict_types=1);

namespace HighestDreams\VehiclesSystem;

use HighestDreams\VehiclesSystem\vehicles\VehiclesHandler;
use pocketmine\plugin\PluginBase;

class Loader extends PluginBase
{
    private static self $Instance;

    public array $riders = array();

    protected function onEnable(): void
    {
        self::$Instance = $this;
        $this->vehiclesHandler()->registerAll();
        $this->vehiclesHandler()->saveResources();
        $this->getServer()->getPluginManager()->registerEvents(new EventsHandler(), $this);
    }

    public function vehiclesHandler(): VehiclesHandler
    {
        return new VehiclesHandler();
    }

    public static function getInstance(): self
    {
        return self::$Instance;
    }
}
