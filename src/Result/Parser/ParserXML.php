<?php

namespace RobbieP\ZbarQrdecoder\Result\Parser;

use RobbieP\ZbarQrdecoder\Result\Result;
use RobbieP\ZbarQrdecoder\Result\ResultCollection;

class ParserXML implements ParserInterface
{
    /**
     * @param $resultString
     *
     * @return ResultCollection
     */
    public function parse($resultString)
    {
        $result = new ResultCollection();
        $xml    = simplexml_load_string($resultString, null, LIBXML_NOCDATA);
        if ($xml) {
            foreach ($xml->source->index->symbol as $item) {
                /** @var \SimpleXMLElement $item */
                $text   = (string)$item->data;
                $format = (string)$item->attributes()->type;
                $result->addResult(new Result($text, $format));
            }
        }

        return $result;
    }
}
