<?php
require_once __DIR__ . '/../vendor/autoload.php';

$ZbarDecoder = new RobbieP\ZbarQrdecoder\ZbarDecoder();

$ZbarDecoder->setPath('/usr/local/bin');

$result = $ZbarDecoder->make('qr-code.gif');

var_dump($result);