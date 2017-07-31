<?php

use PHPUnit\Framework\TestCase;
use RobbieP\ZbarQrdecoder\Result\Parser\ParserXML;

class ResultTest extends TestCase
{
    private $result;

    public function tearDown()
    {
        $this->result = null;
    }

    public function testQRbarcodeResult()
    {
        $this->result = new \RobbieP\ZbarQrdecoder\Result\Result("<barcodes xmlns='http://zbar.sourceforge.net/2008/barcode'>
<source href='/home/vagrant/code/laravel/public/newdoc.png'>
<index num='0'>
<symbol type='QR-Code' quality='1'><data><![CDATA[http://robbiepaul.co]]></data></symbol>
</index>
</source>
</barcodes>", new ParserXML());
        $this->assertEquals(\RobbieP\ZbarQrdecoder\Result\Result::FORMAT_QR_CODE, $this->result->getFormat());
        $this->assertTrue($this->result->hasResult());
        $this->assertEquals('http://robbiepaul.co', $this->result->getText());
        $this->assertEquals('http://robbiepaul.co', $this->result);
    }

    public function testQRbarcodeNoResult()
    {
        $this->result = new \RobbieP\ZbarQrdecoder\Result\Result('', new ParserXML());
        $this->assertEquals('No result', $this->result);
    }

    public function testEANbarcodeResult()
    {
        $this->result = new \RobbieP\ZbarQrdecoder\Result\Result("<barcodes xmlns='http://zbar.sourceforge.net/2008/barcode'>
<source href='/home/vagrant/code/laravel/public/newdoc.png'>
<index num='0'>
<symbol type='EAN-13' quality='1'><data><![CDATA[1234567890123]]></data></symbol>
</index>
</source>
</barcodes>", new ParserXML());
        $this->assertEquals(\RobbieP\ZbarQrdecoder\Result\Result::FORMAT_EAN_13, $this->result->getFormat());
        $this->assertTrue($this->result->hasResult());
        $this->assertEquals('1234567890123', $this->result->getText());
    }

    public function testCODE39barcodeResult()
    {
        $this->result = new \RobbieP\ZbarQrdecoder\Result\Result("<barcodes xmlns='http://zbar.sourceforge.net/2008/barcode'>
<source href='/home/vagrant/code/laravel/public/newdoc.png'>
<index num='0'>
<symbol type='CODE-39' quality='1'><data><![CDATA[1234567890123]]></data></symbol>
</index>
</source>
</barcodes>", new ParserXML());
        $this->assertEquals(\RobbieP\ZbarQrdecoder\Result\Result::FORMAT_CODE_39, $this->result->getFormat());
        $this->assertTrue($this->result->hasResult());
        $this->assertEquals('1234567890123', $this->result->getText());
    }
}
