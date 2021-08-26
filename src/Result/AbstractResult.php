<?php

namespace RobbieP\ZbarQrdecoder\Result;

abstract class AbstractResult
{
    /**
     * @var int
     */
    protected $code = 0;

    /**
     * @var string
     */
    protected $text;

    /**
     * @var string
     */
    protected $format;

    /**
     * @return bool
     */
    public function hasResult()
    {
        return $this->code === 200;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * Will determine what type of barcode and set the correct text response
     *
     * @param string $text
     */
    protected function text($text)
    {
        $this->text = $text;
    }

    protected function format($format)
    {
        $this->format = $format;
    }

    public function __toString()
    {
        return $this->text;
    }
}
