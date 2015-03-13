<?php namespace Marketing\Duedil\Exceptions;

class BadRequestException extends \Exception
{
    public function __toString()
    {
        return $this->getMessage();
    }

}