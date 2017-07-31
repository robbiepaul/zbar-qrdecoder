<?php
/**
 * Created by PhpStorm.
 * User: robbie
 * Date: 01/12/14
 * Time: 01:36
 */

namespace RobbieP\ZbarQrdecoder\Result;

use RobbieP\ZbarQrdecoder\Result\Parser\ParserInterface;

class Result extends AbstractResult
{
    const FORMAT_QR_CODE         = 'QR_CODE';
    const FORMAT_EAN_13          = 'EAN_13';
    const FORMAT_CODE_39         = 'CODE_39';
    const FORMAT_CODE_128        = 'CODE_128';
    const FORMAT_INTERLEAVED_2_5 = 'INTERLEAVED_2_5';

    private static $prefix = [
        self::FORMAT_QR_CODE         => 'QR-Code',
        self::FORMAT_EAN_13          => 'EAN-13',
        self::FORMAT_CODE_39         => 'CODE-39',
        self::FORMAT_CODE_128        => 'CODE-128',
        self::FORMAT_INTERLEAVED_2_5 => 'I2/5',
    ];

    /**
     * Pass in the raw result from the process
     *
     * @param string          $result
     * @param ParserInterface $parser
     */
    public function __construct($result, ParserInterface $parser)
    {
        if (!empty($result)) {
            $parsed = $parser->parse($result);
            // TODO: Tidy/Refactor this bit of code
            $this->text($parsed['text']);
            $this->format($parsed['format']);
        }
    }

    /**
     * Format of the bar code
     *
     * @param $format
     */
    protected function format($format)
    {
        parent::format(array_search($format, self::$prefix, true));
        if ($this->format) {
            $this->code = 200;
        }
    }

    /**
     * Just returns the text output
     *
     * @return string
     */
    public function __toString()
    {
        if (!empty($this->text)) {
            return $this->text;
        }

        return 'No result';
    }
}
