<?php

use PHPUnit\Framework\TestCase;
use RobbieP\ZbarQrdecoder\Result\Parser\ParserXML;

class ResultTest extends TestCase
{
    private $result;

    public function tearDown()
    {
        $result = null;
    }

    public function testQRbarcodeResult()
    {
        $result = (new ParserXML())->parse("<barcodes xmlns='http://zbar.sourceforge.net/2008/barcode'>
<source href='/home/vagrant/code/laravel/public/newdoc.png'>
<index num='0'>
<symbol type='QR-Code' quality='1'><data><![CDATA[http://robbiepaul.co]]></data></symbol>
</index>
</source>
</barcodes>")->getResults()[0];

        $this->assertEquals(\RobbieP\ZbarQrdecoder\Result\Result::FORMAT_QR_CODE, $result->getFormat());
        $this->assertTrue($result->hasResult());
        $this->assertEquals('http://robbiepaul.co', $result->getText());
        $this->assertEquals('http://robbiepaul.co', $result);
    }

    public function testQRbarcodeNoResult()
    {
        $result = (new ParserXML())->parse('');
        $this->assertTrue($result->isEmpty());
    }

    public function testEANbarcodeResult()
    {
        $result = (new ParserXML())->parse("<barcodes xmlns='http://zbar.sourceforge.net/2008/barcode'>
<source href='/home/vagrant/code/laravel/public/newdoc.png'>
<index num='0'>
<symbol type='EAN-13' quality='1'><data><![CDATA[1234567890123]]></data></symbol>
</index>
</source>
</barcodes>")->getResults()[0];
        $this->assertEquals(\RobbieP\ZbarQrdecoder\Result\Result::FORMAT_EAN_13, $result->getFormat());
        $this->assertTrue($result->hasResult());
        $this->assertEquals('1234567890123', $result->getText());
    }

    public function testCODE39barcodeResult()
    {
        $result = (new ParserXML())->parse("<barcodes xmlns='http://zbar.sourceforge.net/2008/barcode'>
<source href='/home/vagrant/code/laravel/public/newdoc.png'>
<index num='0'>
<symbol type='CODE-39' quality='1'><data><![CDATA[1234567890123]]></data></symbol>
</index>
</source>
</barcodes>")->getResults()[0];
        $this->assertEquals(\RobbieP\ZbarQrdecoder\Result\Result::FORMAT_CODE_39, $result->getFormat());
        $this->assertTrue($result->hasResult());
        $this->assertEquals('1234567890123', $result->getText());
    }
}
