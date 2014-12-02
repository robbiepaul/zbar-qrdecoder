<?php

require_once(__DIR__.'/../vendor/autoload.php');

use RobbieP\ZbarQrdecoder\Result\Result;

class ResultTest extends PHPUnit_Framework_TestCase {

    private $result;


    public function tearDown()
    {
        $this->result = null;
    }

    public function testQRbarcodeResult()
    {
        $this->result = new Result("QR-Code:http://robbiepaul.co");
        $this->assertEquals(Result::FORMAT_QR_CODE, $this->result->format);
        $this->assertEquals(200, $this->result->code);
        $this->assertEquals("http://robbiepaul.co", $this->result->text);
        $this->assertEquals("http://robbiepaul.co", $this->result);
    }

    public function testQRbarcodeNoResult()
    {
        $this->result = new Result("");
        $this->assertEquals("No result", $this->result);
    }

    public function testEANbarcodeResult()
    {
        $this->result = new Result("EAN-13:1234567890123");
        $this->assertEquals(Result::FORMAT_EAN_13, $this->result->format);
        $this->assertEquals(200, $this->result->code);
        $this->assertEquals("1234567890123", $this->result->text);
    }

    public function testCODE39barcodeResult()
    {
        $this->result = new Result("CODE-39:1234567890123");
        $this->assertEquals(Result::FORMAT_CODE_39, $this->result->format);
        $this->assertEquals(200, $this->result->code);
        $this->assertEquals("1234567890123", $this->result->text);
    }

}
 