<?php

require __DIR__ . '/vendor/autoload.php';

$reader = new BinaryStudioAcademy\Game\Io\CliReader;
$writer = new BinaryStudioAcademy\Game\Io\CliWriter;
$random = new BinaryStudioAcademy\Game\Helpers\Random;
$math = new BinaryStudioAcademy\Game\Helpers\Math;
$messagesService = new BinaryStudioAcademy\Services\MessagesService();
$battleShipFactory = new BinaryStudioAcademy\Game\Factories\BattleShipFactory;
$commands = new BinaryStudioAcademy\Game\GameCommands($battleShipFactory, $math, $messagesService);

$game = new BinaryStudioAcademy\Game\Game($random, $commands);

$game->start($reader, $writer);
