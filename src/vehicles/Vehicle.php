<?php

declare(strict_types=1);

namespace HighestDreams\VehiclesSystem\vehicles;

interface Vehicle
{
    public function getModel(): string;

    public function getSkinPath(): string;

    public function getSpeed(): int|float;

    public function getMaximumSpeed(): int|float;
}