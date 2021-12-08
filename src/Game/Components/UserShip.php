<?php

namespace BinaryStudioAcademy\Game\Components;

use BinaryStudioAcademy\Game\Components\BattleShip;

class UserShip extends BattleShip
{
    const spaceshipName = "User Ship";
    const stats = [
        'strength' => 5,
        'armor' => 5,
        'luck' => 5,
        'health' => 100,
        'hold' => []
    ];

    public function __construct()
    {
        $this->spaceshipName = self::spaceshipName;
        $this->stats = self::stats;
    }
}
