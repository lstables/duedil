<?php namespace Marketing\Duedil\Transport;

interface TransportInterface {

    public function setKey($key);
    public function setUri($uri);
    public function setMethod($method);
    public function setBody(Array $body);
    public function send();

}