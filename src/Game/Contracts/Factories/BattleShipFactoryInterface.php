<?php

namespace BinaryStudioAcademy\Game\Contracts\Factories;

use BinaryStudioAcademy\Game\Components\BattleShip;

interface BattleShipFactoryInterface
{
    public function createShip($type): BattleShip;
}
