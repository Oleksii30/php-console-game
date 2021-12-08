<?php

namespace BinaryStudioAcademy\Game\Components;

use BinaryStudioAcademy\Game\Components\BattleShip;

class PatrolShip extends BattleShip
{
    const spaceshipName = "Patrol Ship";
    const stats = [
        'strength' => 3,
        'armor' => 2,
        'luck' => 1,
        'health' => 100,
        'hold' => ['🔋']
    ];

    public function __construct()
    {
        $this->spaceshipName = self::spaceshipName;
        $this->stats = self::stats;
    }
}
