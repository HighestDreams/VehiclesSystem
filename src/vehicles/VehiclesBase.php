<?php

declare(strict_types=1);

namespace HighestDreams\VehiclesSystem\vehicles;

use pocketmine\entity\Human;
use pocketmine\entity\Location;
use pocketmine\entity\Skin;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\player\Player;

class VehiclesBase extends Human
{
    public function __construct(Location $location, Skin $skin, ?CompoundTag $nbt = null)
    {
        parent::__construct($location, $skin, $nbt);
    }

    public function initEntity(CompoundTag $nbt): void
    {
        parent::initEntity($nbt);
        $this->setNameTag('');
        $this->setNameTagAlwaysVisible(false);
    }

    public function attack(EntityDamageEvent $source): void
    {
        if ($source instanceof EntityDamageByEntityEvent) {
            $damager = $source->getDamager();
            $vehicle = $source->getEntity();
            if ($damager instanceof Player and $vehicle instanceof Vehicle) {
                $vehicle->ride($damager);
            }
        }
        $source->cancel();
    }
}