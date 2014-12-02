<?php
/**
 * Created by PhpStorm.
 * User: robbie
 * Date: 01/12/14
 * Time: 01:36
 */

namespace RobbieP\ZbarQrdecoder\Result;


class Result {

    const FORMAT_QR_CODE            = 'QR_CODE';
    const FORMAT_EAN_13             = 'EAN_13';
    const FORMAT_CODE_39            = 'CODE_39';
    const FORMAT_CODE_128           = 'CODE_128';
    const FORMAT_INTERLEAVED_2_5    = 'INTERLEAVED_2_5';

    public  $code;
    public  $text;
    public  $format;

    private static  $prefix = [
        self::FORMAT_QR_CODE            => "QR-Code:",
        self::FORMAT_EAN_13             => "EAN-13:",
        self::FORMAT_CODE_39            => "CODE-39:",
        self::FORMAT_CODE_128           => "CODE-128:",
        self::FORMAT_INTERLEAVED_2_5    => "I2/5:",
    ];

    /**
     * Pass in the raw result from the process
     * @param $result
     */
    function __construct($result) {
        $this->text($result);
    }

    /**
     * Will determine what type of barcode and set the correct text response
     * @param $text
     */
    public function text($text)
    {
        foreach(self::$prefix as $k => $prefix) {
            if (stripos(trim($text), $prefix) === 0) {
                $this->format($k);
                $prefix = str_replace('/', '\/',  $prefix);
                $this->text = preg_replace("/^{$prefix}/i", '', $text);
            }
        }
        if($this->format) {
            $this->code = 200;
        }
    }

    /**
     * Format of the bar code
     * @param $format
     */
    public function format($format)
    {
        $this->format = $format;
    }

    /**
     * Just returns the text output
     * @return string
     */
    public function __toString()
    {
        if(!empty($this->text)) {
            return $this->text;
        }
        return 'No result';
    }

} 