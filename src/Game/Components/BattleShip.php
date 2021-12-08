<?php

namespace BinaryStudioAcademy\Game\Components;

use BinaryStudioAcademy\Game\Contracts\Components\BattleShipInterface;

class BattleShip implements BattleShipInterface
{

    protected $spaceshipName;
    protected $stats;

    public function getName()
    {
        return $this->spaceshipName;
    }

    public function getStrength()
    {
        return $this->stats['strength'];
    }

    public function getArmor()
    {
        return $this->stats['armor'];
    }

    public function getLuck()
    {
        return $this->stats['luck'];
    }

    public function getHealth()
    {
        return $this->stats['health'];
    }

    public function getHoldString()
    {
        return '['.' '.($this->stats['hold'][0] ?? '_').' '.($this->stats['hold'][1] ?? '_').' '.($this->stats['hold'][2] ?? '_').' '.']';
    }

    public function getHold()
    {
        return $this->stats['hold'];
    }

    public function setHealth(int $health)
    {
        $this->stats['health'] = $health;
        return $this->stats['health'];
    }

    public function setHold(array $hold)
    {
        $this->stats['hold'] = $hold;
        return $this->stats['hold'];
    }

    public function setSrength(int $strength)
    {
        $this->stats['strength'] = $strength;
        return $this->stats['strength'];
    }

    public function setArmor(int $armor)
    {
        $this->stats['armor'] = $armor;
        return $this->stats['armor'];
    }
}
