<?php

namespace RobbieP\ZbarQrdecoder\Result;

class ResultCollection implements \IteratorAggregate
{
    /**
     * @var AbstractResult[]
     */
    public $results = [];

    /**
     * @return AbstractResult[]
     */
    public function getResults()
    {
        return $this->results;
    }

    public function addResult(AbstractResult $result)
    {
        $this->results[] = $result;
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return count($this->results) === 0;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->results);
    }
}
