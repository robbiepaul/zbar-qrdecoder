<?php
/**
 * Created by PhpStorm.
 * User: robbie
 * Date: 01/12/14
 * Time: 23:04
 */

class ZbarDecoderTest extends PHPUnit_Framework_TestCase {

    protected $ZbarDecoder;
    protected $processBuilder;

    public function setUp()
    {
        $this->processBuilder = Mockery::mock('\Symfony\Component\Process\ProcessBuilder');
        $this->ZbarDecoder = new \RobbieP\ZbarQrdecoder\ZbarDecoder([], $this->processBuilder);
    }

    public function tearDown()
    {
        $this->ZbarDecoder = null;
    }

    public function testSetPathWorks()
    {
        $this->ZbarDecoder->setPath('/usr/local/bin/');
        $this->assertEquals('/usr/local/bin', $this->ZbarDecoder->getPath());
    }

    /**
     * Expect exception because file doesnt exist
     * @expectedException Exception
     */
    public function testSetFilePathWorksOnInvalidFileGiven()
    {
        $this->ZbarDecoder->setFilePath('a/path/image.jpg');
    }

    public function testSetFilePathWorks()
    {
        $this->ZbarDecoder->setFilePath(__DIR__.'/stubs/tc.jpg');
        $this->assertEquals(__DIR__.'/stubs/tc.jpg', $this->ZbarDecoder->getFilePath());
    }


}
 