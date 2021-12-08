<?php

namespace BinaryStudioAcademy\Game\Components;

use BinaryStudioAcademy\Game\Components\BattleShip;

class Executor extends BattleShip
{
    const spaceshipName = "Executor";
    const stats = [
        'strength' => 10,
        'armor' => 10,
        'luck' => 10,
        'health' => 100,
        'hold' => ['🔋', '🔮' ,'🔮']
    ];

    public function __construct()
    {
        $this->spaceshipName = self::spaceshipName;
        $this->stats = self::stats;
    }
}
