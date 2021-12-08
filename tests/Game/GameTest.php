<?php

namespace BinaryStudioAcademyTests\Game;

use PHPUnit\Framework\TestCase;
use BinaryStudioAcademy\Game\Game;
use BinaryStudioAcademyTests\Stubs\StableRandom;
use BinaryStudioAcademy\Game\Helpers\Math;
use BinaryStudioAcademy\Services\MessagesService;
use BinaryStudioAcademy\Game\Factories\BattleShipFactory;
use BinaryStudioAcademy\Game\GameCommands;

final class GameTest extends TestCase
{
    /**
     * @dataProvider gameFlowProvider
     */
    public function test_game(array $commands): void
    {
        $math = new Math();
        $messagesService = new MessagesService();
        $battleShipFactory = new BattleShipFactory();
        $gameCommands = new GameCommands($battleShipFactory, $math, $messagesService);

        $game = new Game(
            new StableRandom(1.0),
            $gameCommands
        );

        $gameTester = new GameTester($game);

        foreach ($commands as [ $command, $expectedOutput]) {
            $output = $gameTester->run($command);
            $this->assertEquals(trim($expectedOutput), trim($output));
        }
    }

    public function gameFlowProvider(): array
    {
        return [
            'basic commands' => [
                [
                    [
                        'help',
                        Messages::help()
                    ],
                    [
                        'stats', Messages::stats([
                            'strength' => 5,
                            'armor' => 5,
                            'luck' => 5,
                            'health' => 100,
                            'hold' => '[ _ _ _ ]'
                        ])
                    ]
                ]
            ],

            'walk through map' => [
                [
                    [
                        'set-galaxy andromeda', Messages::galaxy('andromeda')
                    ],
                    [
                        'whereami', Messages::whereAmI('andromeda')
                    ],
                    [
                        'set-galaxy pegasus', Messages::galaxy('pegasus')
                    ],
                    [
                        'whereami', Messages::whereAmI('pegasus')
                    ],
                    [
                        'set-galaxy spiral', Messages::galaxy('spiral')
                    ],
                    [
                        'whereami', Messages::whereAmI('spiral')
                    ],
                    [
                        'set-galaxy shiar', Messages::galaxy('shiar')
                    ],
                    [
                        'whereami', Messages::whereAmI('shiar')
                    ],
                    [
                        'set-galaxy xeno', Messages::galaxy('xeno')
                    ],
                    [
                        'whereami', Messages::whereAmI('xeno')
                    ],
                    [
                        'set-galaxy isop', Messages::galaxy('isop')
                    ],
                    [
                        'whereami', Messages::whereAmI('isop')
                    ],
                    [
                        'set-galaxy home', Messages::homeGalaxy()
                    ],
                    [
                        'whereami', Messages::whereAmI('home')
                    ],
                ],
            ],

            'exceptional cases' => [
                [
                    [
                        'set-galaxy blah', Messages::errors('undefined_galaxy')
                    ],
                    [
                        'grab', Messages::errors('home_galaxy_grab')
                    ],
                    [
                        'attack', Messages::errors('home_galaxy_attack')
                    ],
                    [
                        'set-galaxy spiral', Messages::galaxy('spiral')
                    ],
                    [
                        'grab', Messages::errors('grab_undestroyed_spaceship')
                    ],
                    [
                        'unknown_command', Messages::errors('unknown_command')
                    ],
                ]
            ],

            'battle imitation' => [
                [
                    [
                        'set-galaxy andromeda', Messages::galaxy('andromeda')
                    ],
                    [
                        'attack', Messages::attack(
                            'Patrol Spaceship',
                            13, 87, 8, 92
                        )
                    ],
                    [
                        'attack', Messages::attack(
                            'Patrol Spaceship',
                            13, 74, 8, 84
                        )
                    ],
                    [
                        'attack', Messages::attack(
                            'Patrol Spaceship',
                            13, 61, 8, 76
                        )
                    ],
                    [
                        'attack', Messages::attack(
                            'Patrol Spaceship',
                            13, 48, 8, 68
                        )
                    ],
                    [
                        'attack', Messages::attack(
                            'Patrol Spaceship',
                            13, 35, 8, 60
                        )
                    ],
                    [
                        'attack', Messages::attack(
                            'Patrol Spaceship',
                            13, 22, 8, 52
                        )
                    ],
                    [
                        'attack', Messages::attack(
                            'Patrol Spaceship',
                            13, 9, 8, 44
                        )
                    ],
                    [
                        'attack', Messages::destroyed('Patrol Spaceship')
                    ],
                    [
                        'grab', Messages::grabPatrolSpaceship()
                    ],
                    [
                        'set-galaxy isop', Messages::galaxy('isop')
                    ],
                    [
                        'attack', Messages::attack(
                            'Executor',
                            5, 95, 20, 24
                        )
                    ],
                    [
                        'attack', Messages::attack(
                            'Executor',
                            5, 90, 20, 4
                        )
                    ],
                    [
                        'attack', Messages::die()
                    ],
                    [
                        'whereami', Messages::whereAmI('home')
                    ],
                    [
                        'stats', Messages::stats([
                            'strength' => 5,
                            'armor' => 5,
                            'luck' => 5,
                            'health' => 100,
                            'hold' => '[ _ _ _ ]'
                        ])
                    ]
                ]
            ]
        ];
    }

}
