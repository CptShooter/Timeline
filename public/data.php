<?php
require_once '../vendor/autoload.php';

header('Content-Type: application/json');

$data = new \Timeline\Data();
echo $data->removeGamesOlderThan(30, 90)->sortGamesByDate()->buildJson()->getGamesToJson();