<?php

declare(strict_types=1);

namespace HighestDreams\VehiclesSystem\vehicles;

use Exception;
use JsonException;
use pocketmine\entity\Skin;

trait VehiclesProvider
{
    public function increaseSpeed(int|float $amount): void
    {
        if ($this->getSpeed() < self::MAXIMUM_SPEED) {
            $this->speed += $amount;
        } else if ($this->speed > self::MAXIMUM_SPEED) {
            $this->speed = self::MAXIMUM_SPEED;
        }
    }

    public function decreaseSpeed(int|float $amount): void
    {
        if ($this->getSpeed() > 0) {
            $this->speed -= $amount;
        } else if ($this->speed < 0) {
            $this->speed = 0;
        }
    }

    /**
     * @throws JsonException
     * @throws Exception
     */
    private function getVehicleSkin(): Skin
    {
        return new Skin('Standard_Custom', $this->getSkinData(), '', $this->geometryName, $this->getGeometryData());
    }

    /**
     * @throws Exception
     */
    private function getGeometryData(): bool|string
    {
        $path = $this->getSkinPath() . '.json';
        if (is_file($path)) {
            return file_get_contents($path);
        }
        throw new Exception("Error: Geometry $path not found.");
    }

    /**
     * @throws Exception
     */
    private function getSkinData(): string
    {
        $path = $this->getSkinPath() . '.png';
        if (is_file($path)) {
            $img = @imagecreatefrompng($path);
            $s = (int)@getimagesize($path)[1];
            $skinBytes = '';
            for ($y = 0; $y < $s; $y++) {
                for ($x = 0; $x < 64; $x++) {
                    $colorAt = @imagecolorat($img, $x, $y);
                    $a = ((~($colorAt >> 24)) << 1) & 0xff;
                    $r = ($colorAt >> 16) & 0xff;
                    $g = ($colorAt >> 8) & 0xff;
                    $b = $colorAt & 0xff;
                    $skinBytes .= chr($r) . chr($g) . chr($b) . chr($a);
                }
            }
            @imagedestroy($img);
            return $skinBytes;
        }
        throw new Exception("Error: Image $path not found.");
    }
}