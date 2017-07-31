<?php

use PHPUnit\Framework\TestCase;

class ErrorResultTest extends TestCase
{
    private $result;

    public function tearDown()
    {
        $this->result = null;
    }

    public function testErrorResult()
    {
        $this->result = new  \RobbieP\ZbarQrdecoder\Result\ErrorResult("No barcode was found");
        $this->assertEquals(\RobbieP\ZbarQrdecoder\Result\ErrorResult::NOT_FOUND, $this->result->getFormat());
        $this->assertFalse($this->result->hasResult());
        $this->assertEquals("No barcode was found", $this->result->getText());
    }
}
