<?php

namespace BinaryStudioAcademy\Game\Contracts\Components;

interface BattleShipInterface
{
    public function getName();

    public function getStrength();

    public function getArmor();

    public function getLuck();

    public function getHealth();

    public function getHold();

    public function getHoldString();

    public function setHold(array $hold);

    public function setSrength(int $strength);

    public function setArmor(int $armor);

}
