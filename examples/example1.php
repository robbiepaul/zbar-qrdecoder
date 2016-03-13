<?php
require_once('../vendor/autoload.php');

$ZbarDecoder = new RobbieP\ZbarQrdecoder\ZbarDecoder();

$ZbarDecoder->setPath('/usr/local/bin');

$result = $ZbarDecoder->make('qr-code.gif');

echo var_dump($result);