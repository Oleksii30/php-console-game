<?php

namespace BinaryStudioAcademy\Services;

class MessagesService
{
    public function start()
    {
        return 'Adventure has begun. Wish you good luck!' . PHP_EOL;
    }

    public static function stats($spaceship): string
    {
        return 'Spaceship stats:' . PHP_EOL
        . 'strength: ' . $spaceship->getStrength() . PHP_EOL
        . 'armor: ' . $spaceship->getArmor() . PHP_EOL
        . 'luck: ' . $spaceship->getLuck()  . PHP_EOL
        . 'health: ' . $spaceship->getHealth() . PHP_EOL
        . 'hold: ' . $spaceship->getHoldString() . PHP_EOL;
    }

    public static function galaxy($galaxy, $spaceship): string
    {
        return 'Galaxy:' . $galaxy . PHP_EOL
            . 'You see a ' . $spaceship->getName() . ':' . PHP_EOL
            . 'strength: ' . $spaceship->getStrength() . PHP_EOL
            . 'armor: ' . $spaceship->getArmor() . PHP_EOL
            . 'luck: ' . $spaceship->getLuck()  . PHP_EOL
            . 'health: ' . $spaceship->getHealth()   . PHP_EOL;
    }

    public static function attack(
        string $spaceshipName,
        int $playerDamage,
        int $shipHealth,
        int $shipDamage,
        int $playerHealth
    ): string {
        return "{$spaceshipName} has damaged on: {$playerDamage} points." . PHP_EOL
            . "health: {$shipHealth}" . PHP_EOL
            . "{$spaceshipName} damaged your spaceship on: {$shipDamage} points." . PHP_EOL
            . "health: {$playerHealth}" . PHP_EOL;
    }

    public static function destroyed(string $spaceshipName): string
    {
        return "{$spaceshipName} is totally destroyed. Hurry up! There is could be something useful to grab." . PHP_EOL;
    }

    public static function grabPatrolSpaceship(): string
    {
        return 'You got 🔋.' . PHP_EOL;
    }

    public static function grabBattleSpaceship(): string
    {
        return 'You got 🔋 🔮.' . PHP_EOL;
    }

    public static function homeGalaxy(): string
    {
        return 'Galaxy: Home Galaxy.' . PHP_EOL;
    }

    public static function buySkill(string $skill, int $nextValue): string
    {
        return "You\'ve got upgraded skill: {$skill}. The level is {$nextValue} now." . PHP_EOL;
    }

    public static function buyReactor(int $nextValue): string
    {
        return "You\'ve bought a magnet reactor. You have {$nextValue} reactor(s) now." . PHP_EOL;
    }

    public static function applyReactor($health): string
    {
        return "Magnet reactor have been applied. Current spaceship health level is {$health}" . PHP_EOL;;
    }

    public static function finalWin(): string
    {
        return '🎉🎉🎉 Congratulations 🎉🎉🎉' . PHP_EOL
            . '🎉🎉🎉 You are winner! 🎉🎉🎉';
    }

    public static function whereAmI(string $galaxy): string
    {
        return 'Galaxy: ' . $galaxy . PHP_EOL;
    }

    public static function help(): string
    {
        return 'List of commands:' . PHP_EOL
            . 'help - shows this list of commands' . PHP_EOL
            . 'stats - shows stats of spaceship' . PHP_EOL
            . 'set-galaxy <home|andromeda|spiral|pegasus|shiar|xeno|isop> - provides jump into specified galaxy' . PHP_EOL
            . 'attack - attacks enemy\'s spaceship' . PHP_EOL
            . 'grab - grab useful load from the spaceship' . PHP_EOL
            . 'buy <strength|armor|reactor> - buys skill or reactor (1 item)' . PHP_EOL
            . 'apply-reactor - apply magnet reactor to increase spaceship health level on 20 points' . PHP_EOL
            . 'whereami - shows current galaxy' . PHP_EOL
            . 'restart - restarts game' . PHP_EOL
            . 'exit - ends the game' . PHP_EOL;
    }

    public static function die(): string
    {
        return "Your spaceship got significant damages and eventually got exploded." . PHP_EOL
            . "You have to start from Home Galaxy." . PHP_EOL;
    }

    public static function errors(string $key): string
    {
        return [
            'undefined_galaxy' => 'Nah. No specified galaxy found.' . PHP_EOL,
            'home_galaxy_grab' => 'Hah? You don\'t want to grab any staff at Home Galaxy. Believe me.' . PHP_EOL,
            'home_galaxy_attack' => 'Calm down! No enemy spaceships detected. No one to fight with.'. PHP_EOL,
            'grab_undestroyed_spaceship' => 'LoL. Unable to grab goods. Try to destroy enemy spaceship first.' . PHP_EOL,
            'unknown_command' => "Command 'unknown_command' not found" . PHP_EOL,
            'hold_is_full' => "Your hold is full, not posible to grab more!" . PHP_EOL,
            'missing_reactor' => "You don\'t have reactor in hold!" . PHP_EOL,
            'missing_crystal' => "You don\'t have crystal in hold!" . PHP_EOL,
            'unknown_product' => "Not posible to buy this!" . PHP_EOL,
            'buy_not_in_home_galaxy' => "Not posible to buy here, only in home galaxy!" . PHP_EOL,
        ][$key];
    }
}
