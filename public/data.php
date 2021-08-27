<?php
require_once '../vendor/autoload.php';

header('Content-Type: application/json');

$data = new \Timeline\Data();
echo $data->sortGamesByDate()->buildJson()->getGamesToJson();