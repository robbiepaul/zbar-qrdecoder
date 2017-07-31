<?php

namespace RobbieP\ZbarQrdecoder\Result;

class ResultCollection extends AbstractResult implements \IteratorAggregate, \Countable
{
    public function hasResult()
    {
        return !$this->isEmpty();
    }

    public function getText()
    {
        if ($this->isEmpty()) {
            throw new \LogicException('Empty result set.');
        }

        return $this->results[0]->getText();
    }

    public function getFormat()
    {
        if ($this->isEmpty()) {
            throw new \LogicException('Empty result set.');
        }

        return $this->results[0]->getFormat();
    }

    public function __toString()
    {
        if ($this->isEmpty()) {
            return 'No result';
        }

        return (string)$this->results[0];
    }


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

    public function count()
    {
        return count($this->results);
    }
}
