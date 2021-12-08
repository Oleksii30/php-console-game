<?php

namespace BinaryStudioAcademy\Game\Components;

use BinaryStudioAcademy\Game\Components\BattleShip;

class BattleSpaceShip extends BattleShip
{
    const spaceshipName = "Battle Space Ship";
    const stats = [
        'strength' => 8,
        'armor' => 7,
        'luck' => 6,
        'health' => 100,
        'hold' => ['🔋', '🔮']
    ];

    public function __construct()
    {
        $this->spaceshipName = self::spaceshipName;
        $this->stats = self::stats;
    }
}
