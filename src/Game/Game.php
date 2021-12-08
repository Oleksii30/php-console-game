<?php

namespace BinaryStudioAcademy\Game;

use BinaryStudioAcademy\Game\Contracts\Io\Reader;
use BinaryStudioAcademy\Game\Contracts\Io\Writer;
use BinaryStudioAcademy\Game\Contracts\Helpers\Random;
use BinaryStudioAcademy\Enums\Commands;


class Game
{
    private $random;
    private $commands;

    public function __construct(Random $random, $commands)
    {
        $this->random = $random;
        $this->commands = $commands;
    }

    private function executeCommand($input){
        $command = explode(' ', $input)[0];

            switch($command) {
                case Commands::START:
                    return $this->commands->startGame();
                case Commands::HELP:
                    return $this->commands->help();
                case Commands::WHEREAMI:
                    return $this->commands->whereami();
                case Commands::SET_GALAXY:
                    return $this->commands->setGalaxy($input);
                case Commands::STATS:
                    return $this->commands->stats();
                case Commands::ATTACK:
                    return $this->commands->attack($this->random);
                case Commands::GRAB:
                    return $this->commands->grab();
                case Commands::APPLY_REACTOR:
                    return $this->commands->applyReactor();
                case Commands::BUY:
                    return $this->commands->buy($input);
                case Commands::RESTART:
                    return $this->commands->startGame();
                default:
                    return $this->commands->unknown();
            }
        }

    public function start(Reader $reader, Writer $writer)
    {
        $this->executeCommand(Commands::START);

        while(true){
            $input = trim($reader->read());
            if($input === Commands::EXIT) {
                break;
            }
            $output = $this->executeCommand($input);
            $writer->writeln($output);
        }
    }

    public function run(Reader $reader, Writer $writer)
    {
        $this->executeCommand(Commands::START);
        $input = trim($reader->read());
        $output = $this->executeCommand($input);
        $writer->writeln($output);
    }
}
