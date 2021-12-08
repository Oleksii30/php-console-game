<?php

namespace BinaryStudioAcademy\Game;

use BinaryStudioAcademy\Enums\Commands;
use BinaryStudioAcademy\Enums\Galaxies;
use BinaryStudioAcademy\Game\Contracts\Helpers\Math;
use BinaryStudioAcademy\Game\Contracts\Factories\BattleShipFactoryInterface;

class GameCommands
{
    private $battleShipFactory;
    private $messagesService;
    private $galaxy;
    private $userShip;
    private $enemyShip;
    private $math;
    const PRODUCTS = ['strength', 'armor', 'reactor'];
    const KNOWN_UNIVERSE = [Galaxies::HOME, Galaxies::ANDROMEDA, Galaxies::SPIRAL, Galaxies::PEGASUS, Galaxies::SHIAR, Galaxies::XENO, Galaxies::ISOP];


    public function __construct(BattleShipFactoryInterface $battleShipFactory, Math $math, $messagesService)
    {
        $this->battleShipFactory = $battleShipFactory;
        $this->math = $math;
        $this->messagesService = $messagesService;
    }

    public function startGame()
    {
        $this->galaxy = Galaxies::HOME;
        $this->userShip = $this->battleShipFactory->createShip('user');
        echo $this->messagesService->start();
    }

    public function help()
    {
        return $this->messagesService->help();
    }

    public function whereami()
    {
        return $this->messagesService->whereAmI($this->galaxy);
    }

    public function setGalaxy($input)
    {
        $galaxyName = ucfirst(explode(' ', $input)[1]);

        if(!in_array($galaxyName, self::KNOWN_UNIVERSE)){
            return $this->messagesService->errors('undefined_galaxy');
        }

        switch($galaxyName) {
            case Galaxies::HOME:
                $this->galaxy = Galaxies::HOME;
                break;
            case Galaxies::ANDROMEDA:
                $this->galaxy = Galaxies::ANDROMEDA;
                $this->enemyShip = $this->battleShipFactory->createShip('patrol');
                break;
            case Galaxies::SPIRAL:
                $this->galaxy = Galaxies::SPIRAL;
                $this->enemyShip = $this->battleShipFactory->createShip('patrol');
                break;
            case Galaxies::PEGASUS:
                $this->galaxy = Galaxies::PEGASUS;
                $this->enemyShip = $this->battleShipFactory->createShip('patrol');
                break;
            case Galaxies::SHIAR:
                $this->galaxy = Galaxies::SHIAR;
                $this->enemyShip = $this->battleShipFactory->createShip('space');
                break;
            case Galaxies::XENO:
                $this->galaxy = Galaxies::XENO;
                $this->enemyShip = $this->battleShipFactory->createShip('space');
                break;
            case Galaxies::ISOP:
                $this->galaxy = Galaxies::ISOP;
                $this->enemyShip = $this->battleShipFactory->createShip('executor');
                break;
        }

        if($this->galaxy === Galaxies::HOME) {
            return $this->messagesService->homeGalaxy();
        }

        return $this->messagesService->galaxy($this->galaxy, $this->enemyShip);
    }

    public function stats()
    {
        return $this->messagesService->stats($this->userShip);
    }

    public function attack($random)
    {
        if ($this->galaxy === Galaxies::HOME) {
            return $this->messagesService->errors('home_galaxy_attack');
        }

        $message;
        $enemyName = $this->enemyShip->getName();

        $enemyDamage = $this->attackProcess($random, $this->userShip, $this->enemyShip);
        $isUserVictory = $this->enemyShip->getHealth() <= 0;

        if ($isUserVictory){
            $message = $this->messagesService->destroyed($enemyName);
        }

        if ($isUserVictory && $enemyName === 'Executor'){
            $message = $this->messagesService->finalWin();
        }

        if (!$isUserVictory) {
            $userDamage = $this->attackProcess($random, $this->enemyShip, $this->userShip);
            $isEnemyVictory = $this->userShip->getHealth() <= 0;
        }

        if (isset($isEnemyVictory) && $isEnemyVictory) {
            $message = $this->messagesService->die();
        }

        if (!$isUserVictory && !$isEnemyVictory) {
            $message = $this->messagesService->attack(
                $enemyName,
                $enemyDamage,
                $this->enemyShip->getHealth(),
                $userDamage,
                $this->userShip->getHealth()
            );
        }
        return $message;

        if (isset($isEnemyVictory) && $isEnemyVictory) {
            $this->startGame();
        }
    }

    public function grab()
    {
        if ($this->galaxy === Galaxies::HOME) {
            return $this->messagesService->errors('home_galaxy_grab');
        }

        if ($this->enemyShip->getHealth() > 0) {
            return $this->messagesService->errors('grab_undestroyed_spaceship');
        }

        $userHold = $this->userShip->getHold();
        if (count($userHold) === 3) {
            return $this->messagesService->errors('hold_is_full');
        }

        $enemyHold = $this->enemyShip->getHold();
        $newHold = array_merge($userHold, $enemyHold);

        $this->userShip->setHold(array_slice($newHold, 0, 3));

        if ($this->enemyShip->getName() === 'Patrol Spaceship') {
            return $this->messagesService->grabPatrolSpaceship();
        }

        if ($this->enemyShip->getName() === 'Battle Spaceship') {
            return $this->messagesService->grabBattleSpaceship();
        }
    }

    public function applyReactor()
    {
        $userHold = $this->userShip->getHold();
        if (!in_array('🔋', $userHold)) {
            return $this->messagesService->errors('missing_reactor');
        }

        $this->removeItemFromHold('🔋', $userHold);

        $health = $this->userShip->getHealth();
        $calculatedHealth = $health + 20 > 100 ? 100 : $health + 20;
        $this->userShip->setHealth($calculatedHealth);

        return $this->messagesService->applyReactor($calculatedHealth);
    }

    public function buy($input)
    {
        $product = explode(' ', $input)[1];
        $userHold = $this->userShip->getHold();
        if (!in_array($product, self::PRODUCTS)) {
            return $this->messagesService->errors('unknown_product');
        }

        if ($this->galaxy !== Galaxies::HOME) {
            return $this->messagesService->errors('buy_not_in_home_galaxy');
        }

        if (!in_array('🔮', $userHold)) {
            return $this->messagesService->errors('missing_crystal');
        }

        $this->removeItemFromHold('🔮', $userHold);

        switch($product) {
            case 'strength':
                $strength = $this->userShip->getStrength();
                $newStrength = $this->userShip->setSrength($strength+1);
                return $this->messagesService->buySkill('strength', $newStrength);
            case 'armor':
                $armor = $this->userShip->getArmor();
                $newArmor = $this->userShip->setArmor($armor+1);
                return $this->messagesService->buySkill('armor', $newArmor);
            case 'reactor':
               $hold = $this->userShip->getHold();
               $newHold = $this->userShip->setHold(array_merge($hold, ['🔋']));
                $reactorCount = array_reduce($newHold, function($carry, $item){
                    if($item === '🔋') {
                        return $carry + 1;
                    }
                }, 0);
               return $this->messagesService->buyReactor($reactorCount);
        }

    }

    public function unknown()
    {
        return $this->messagesService->errors('unknown_command');
    }

    private function attackProcess($random, $attacker, $defender)
    {
        $isDamaged = $this->math->luck($random, $attacker->getLuck());
        $damage = 0;
        if ($isDamaged) {
            $damage = $this->math->damage($attacker->getStrength(), $defender->getArmor());
            $newHealth = $defender->getHealth() - $damage;
            $defender->setHealth($newHealth);
        }

        return $damage;
    }

    private function removeItemFromHold($item, $userHold)
    {
        $index = array_search($item, $userHold);
        $start = array_slice($userHold, 0, $index);
        $end = array_slice($userHold, $index+1);
        $this->userShip->setHold(array_merge($start, $end));
    }
}
