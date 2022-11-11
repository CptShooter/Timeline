<?php

use Timeline\Data;

require_once '../vendor/autoload.php';

header('Content-Type: application/json');

$data = new Data();
echo $data->removeGamesOlderThan(15, 120)->sortGamesByDate()->buildJson()->getGamesToJson();