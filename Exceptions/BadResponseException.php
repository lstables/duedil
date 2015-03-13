<?php namespace Marketing\Duedil\Exceptions;

class BadResponseException extends \Exception
{
    public function __toString()
    {
        return $this->getMessage();
    }
}