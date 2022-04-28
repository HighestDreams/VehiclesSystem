<?php

declare(strict_types=1);

namespace HighestDreams\VehiclesSystem\vehicles;

use HighestDreams\VehiclesSystem\Loader;
use HighestDreams\VehiclesSystem\vehicles\models\DirtMotor;
use pocketmine\entity\EntityDataHelper;
use pocketmine\entity\EntityFactory;
use pocketmine\entity\Human;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\world\World;

final class VehiclesHandler
{
    public function registerAll(): void
    {
        $vehicleClasses = array(
            VehiclesBase::class,
            DirtMotor::class
        );
        foreach ($vehicleClasses as $vehicleClass) {
            $this->register($vehicleClass);
        }
    }

    private function register(string $vehicleClass): void
    {
        EntityFactory::getInstance()->register($vehicleClass, static function (World $world, CompoundTag $nbt): VehiclesBase {
            return new VehiclesBase(EntityDataHelper::parseLocation($nbt, $world), Human::parseSkinNBT($nbt), $nbt);
        }, ['Human']);
    }

    public function saveResources(): void
    {
        $resources = Loader::getInstance()->getResources();
        foreach ($resources as $file => $components) {
            Loader::getInstance()->saveResource($file);
        }
    }
}