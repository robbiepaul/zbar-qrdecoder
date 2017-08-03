<?php
/**
 * Created by PhpStorm.
 * User: robbie
 * Date: 01/12/14
 * Time: 01:29
 */

namespace RobbieP\ZbarQrdecoder\Result;

class ErrorResult extends AbstractResult
{
    const NOT_FOUND = 'NOT_FOUND';

    /**
     * @param $error
     */
    public function __construct($error)
    {
        $this->text($error);
        $this->format(self::NOT_FOUND);
        $this->code = 400;
    }
}
