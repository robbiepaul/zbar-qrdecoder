<?php

use PHPUnit\Framework\TestCase;

class ZbarDecoderTest extends TestCase
{

    /**
     * @var \RobbieP\ZbarQrdecoder\ZbarDecoder
     */
    protected $ZbarDecoder;
    protected $processBuilder;

    public function setUp()
    {
        $this->processBuilder = $this->getMockBuilder(\Symfony\Component\Process\Process::class)->disableOriginalConstructor()->getMock();
        $this->ZbarDecoder = new \RobbieP\ZbarQrdecoder\ZbarDecoder([], $this->processBuilder);
    }

    public function tearDown()
    {
        $this->processBuilder = null;
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
        $this->ZbarDecoder->setFilePath(__DIR__ . '/stubs/tc.jpg');
        $this->assertEquals(__DIR__ . '/stubs/tc.jpg', $this->ZbarDecoder->getFilePath());
    }

    public function testConfigWorksIfPassedAsArrayInConstructor()
    {
        $ZbarDecoder = new \RobbieP\ZbarQrdecoder\ZbarDecoder(['path' => '/new/bin/']);
        $this->assertEquals('/new/bin', $ZbarDecoder->getPath());
    }

    public function testDefaultPathWorks()
    {
        $ZbarDecoder = new \RobbieP\ZbarQrdecoder\ZbarDecoder([]);
        $this->assertEquals('/usr/bin', $ZbarDecoder->getPath());
    }

    public function testMakeWorks()
    {
        $process = $this->getMockBuilder('\Symfony\Component\Process\Process')->disableOriginalConstructor()->getMock();

        $process->expects($this->any())
            ->method('mustRun')
            ->will($this->returnSelf());
        $process->expects($this->any())
            ->method('setCommandLine')
            ->will($this->returnSelf());
        $process->expects($this->any())
            ->method('enableOutput')
            ->will($this->returnSelf());

        $this->ZbarDecoder = new \RobbieP\ZbarQrdecoder\ZbarDecoder([], $process);
        $this->ZbarDecoder->make(__DIR__ . '/stubs/tc.jpg');
        $this->assertEquals(__DIR__ . '/stubs/tc.jpg', $this->ZbarDecoder->getFilePath());

        unset($process);
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage An error occurred while processing the image. It could be bad arguments, I/O errors and image handling errors from ImageMagick
     */
    public function testRunProcessThrowsErrorBadArgs()
    {
        $process = $this->getMockBuilder('\Symfony\Component\Process\Process')->disableOriginalConstructor()->getMock();
        $exception = $this->getMockBuilder('\Symfony\Component\Process\Exception\ProcessFailedException')->disableOriginalConstructor()->getMock();

        $exception->expects($this->any())
            ->method('getProcess')
            ->will($this->returnValue($process));

        $process->expects($this->any())
            ->method('mustRun')
            ->will($this->throwException($exception));

        $process->expects($this->any())
            ->method('getExitCode')
            ->will($this->returnValue(1));
        $process->expects($this->any())
            ->method('setCommandLine')
            ->will($this->returnSelf());
        $process->expects($this->any())
            ->method('enableOutput')
            ->will($this->returnSelf());

        $this->ZbarDecoder = new \RobbieP\ZbarQrdecoder\ZbarDecoder([], $process);
        $this->ZbarDecoder->make(__DIR__ . '/stubs/tc.jpg');
        $this->assertEquals(__DIR__ . '/stubs/tc.jpg', $this->ZbarDecoder->getFilePath());

        unset($process);
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage ImageMagick fatal error
     */
    public function testRunProcessThrowsErrorImageMagick()
    {
        $process = $this->getMockBuilder('\Symfony\Component\Process\Process')->disableOriginalConstructor()->getMock();
        $exception = $this->getMockBuilder('\Symfony\Component\Process\Exception\ProcessFailedException')->disableOriginalConstructor()->getMock();

        $exception->expects($this->any())
            ->method('getProcess')
            ->will($this->returnValue($process));

        $process->expects($this->any())
            ->method('mustRun')
            ->will($this->throwException($exception));

        $process->expects($this->any())
            ->method('getExitCode')
            ->will($this->returnValue(2));
        $process->expects($this->any())
            ->method('setCommandLine')
            ->will($this->returnSelf());
        $process->expects($this->any())
            ->method('enableOutput')
            ->will($this->returnSelf());

        $this->ZbarDecoder = new \RobbieP\ZbarQrdecoder\ZbarDecoder([], $process);
        $this->ZbarDecoder->make(__DIR__ . '/stubs/tc.jpg');
        $this->assertEquals(__DIR__ . '/stubs/tc.jpg', $this->ZbarDecoder->getFilePath());

        unset($process);
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage Problem with decode - check you have zbar-tools installed
     */
    public function testRunProcessThrowsErrorProblemWithCode()
    {
        $process = $this->getMockBuilder('\Symfony\Component\Process\Process')->disableOriginalConstructor()->getMock();
        $exception = $this->getMockBuilder('\Symfony\Component\Process\Exception\ProcessFailedException')->disableOriginalConstructor()->getMock();

        $exception->expects($this->any())
            ->method('getProcess')
            ->will($this->returnValue($process));

        $process->expects($this->any())
            ->method('mustRun')
            ->will($this->throwException($exception));

        $process->expects($this->any())
            ->method('getExitCode')
            ->will($this->returnValue(3));
        $process->expects($this->any())
            ->method('setCommandLine')
            ->will($this->returnSelf());
        $process->expects($this->any())
            ->method('enableOutput')
            ->will($this->returnSelf());

        $this->ZbarDecoder = new \RobbieP\ZbarQrdecoder\ZbarDecoder([], $process);
        $this->ZbarDecoder->make(__DIR__ . '/stubs/tc.jpg');
        $this->assertEquals(__DIR__ . '/stubs/tc.jpg', $this->ZbarDecoder->getFilePath());

        unset($process);
    }

    public function testRunProcessThrowsErrorResultWhenNoCodeDetected()
    {
        $process = $this->getMockBuilder('\Symfony\Component\Process\Process')->disableOriginalConstructor()->getMock();
        $exception = $this->getMockBuilder('\Symfony\Component\Process\Exception\ProcessFailedException')->disableOriginalConstructor()->getMock();

        $exception->expects($this->any())
            ->method('getProcess')
            ->will($this->returnValue($process));

        $process->expects($this->any())
            ->method('mustRun')
            ->will($this->throwException($exception));

        $process->expects($this->any())
            ->method('getExitCode')
            ->will($this->returnValue(4));
        $process->expects($this->any())
            ->method('setCommandLine')
            ->will($this->returnSelf());
        $process->expects($this->any())
            ->method('enableOutput')
            ->will($this->returnSelf());

        $this->ZbarDecoder = new \RobbieP\ZbarQrdecoder\ZbarDecoder([], $process);
        $result = $this->ZbarDecoder->make(__DIR__ . '/stubs/tc.jpg');
        $this->assertEquals(__DIR__ . '/stubs/tc.jpg', $this->ZbarDecoder->getFilePath());
        $this->assertInstanceOf('RobbieP\ZbarQrdecoder\Result\ErrorResult', $result);
        $this->assertFalse($result->hasResult());
        $this->assertEquals('NOT_FOUND', $result->getFormat());
        $this->assertEquals('No barcode detected', $result->getText());

        unset($process);
    }
}
