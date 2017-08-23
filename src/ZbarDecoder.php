<?php

namespace RobbieP\ZbarQrdecoder;

use RobbieP\ZbarQrdecoder\Result\AbstractResult;
use RobbieP\ZbarQrdecoder\Result\ErrorResult;
use RobbieP\ZbarQrdecoder\Result\Parser\ParserXML;
use RobbieP\ZbarQrdecoder\Result\ResultCollection;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\ProcessBuilder;

class ZbarDecoder
{
    const EXECUTABLE = 'zbarimg';

    private $path;
    private $filePath;

    /**
     * @var AbstractResult|ResultCollection
     */
    private $result;
    /**
     * @var ProcessBuilder
     */
    private $processBuilder;

    /**
     * @param array          $config
     * @param ProcessBuilder $processBuilder
     */
    public function __construct(array $config = [], $processBuilder = null)
    {
        if (isset($config['path'])) {
            $this->setPath($config['path']);
        }
        $this->processBuilder = null === $processBuilder ? new ProcessBuilder() : $processBuilder;
    }

    /**
     * Main constructor - builds the process, runs it then returns the Result object
     *
     * @param $filename
     *
     * @return AbstractResult|ResultCollection
     * @throws \Exception
     */
    public function make($filename)
    {
        $this->setFilePath($filename);
        $this->buildProcess();
        $this->runProcess();

        return $this->output();
    }

    /**
     * Returns the path to the executable zbarimg
     * Defaults to /usr/bin
     *
     * @throws \Exception
     * @return mixed
     */
    public function getPath()
    {
        if (!$this->path) {
            $this->setPath('/usr/bin');
        }

        return $this->path;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path)
    {
        $this->path = rtrim($path, '/');
    }

    /**
     * @return mixed
     */
    public function getFilePath()
    {
        return $this->filePath;
    }

    /**
     * @param mixed $filePath
     *
     * @throws \Exception
     */
    public function setFilePath($filePath)
    {
        if (!is_file($filePath)) {
            throw new \RuntimeException('Invalid filepath given');
        }
        $this->filePath = $filePath;
    }

    /**
     * Builds the process
     * TODO: Configurable arguments
     *
     * @throws \Exception
     */
    private function buildProcess()
    {
        $path = $this->getPath();
        $this->processBuilder->setPrefix($path . DIRECTORY_SEPARATOR . static::EXECUTABLE);
        $this->processBuilder->setArguments(['-D', '--xml', '-q', $this->getFilePath()])->enableOutput();
    }

    /**
     * Runs the process
     *
     * @throws \RuntimeException
     */
    private function runProcess()
    {
        $process = $this->processBuilder->getProcess();
        try {
            $process->mustRun();
            $parser = new ParserXML();
            $result = $parser->parse(preg_replace_callback(
                '/<data><\!\[CDATA\[(.*?)\]\]><\/data>/s',
                function ($matches) {
                    return '<data><![CDATA[' . base64_encode($matches[1]) . ']]></data>';
                },
                $process->getOutput()
            ));
            if (count($result) === 1) {
                $result = $result->getResults()[0];
            }
            $this->result = $result;
        } catch (ProcessFailedException $e) {
            switch ($e->getProcess()->getExitCode()) {
                case 1:
                    throw new \RuntimeException('An error occurred while processing the image. It could be bad arguments, I/O errors and image handling errors from ImageMagick');
                case 2:
                    throw new \RuntimeException('ImageMagick fatal error');
                case 4:
                    $this->result = new ErrorResult('No barcode detected');
                    break;
                default:
                    throw new \RuntimeException('Problem with decode - check you have zbar-tools installed');
            }
        }

    }

    /**
     * Only return the output class to the end user
     *
     * @return AbstractResult|ResultCollection
     */
    private function output()
    {
        return $this->result;
    }
}
