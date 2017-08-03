<?php
require_once __DIR__ . '/../vendor/autoload.php';

$ZbarDecoder = new RobbieP\ZbarQrdecoder\ZbarDecoder();

$ZbarDecoder->setPath('/usr/bin');

$result = $ZbarDecoder->make($argv[1]);

var_dump($result);