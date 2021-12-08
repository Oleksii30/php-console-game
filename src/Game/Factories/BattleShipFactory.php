<?php

namespace BinaryStudioAcademy\Game\Factories;

use BinaryStudioAcademy\Game\Components\BattleShip;
use BinaryStudioAcademy\Game\Components\{UserShip, PatrolShip, BattleSpaceShip, Executor};
use BinaryStudioAcademy\Game\Contracts\Factories\BattleShipFactoryInterface;

class BattleShipFactory implements BattleShipFactoryInterface
{
    public function createShip($type): BattleShip
    {
        switch($type) {
            case 'user':
                return new UserShip();
            case 'patrol':
                return new PatrolShip();
            case 'space':
                return new BattleSpaceShip();
            case 'executor':
                return new Executor();
        }
    }
}
