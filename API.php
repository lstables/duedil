<?php namespace Marketing\Duedil;

use Marketing\Duedil\Exceptions\BadRequestException;
use Marketing\Duedil\Transport\Curl;
use Marketing\Duedil\Transport\TransportInterface;

class API {

    protected $uri = 'http://duedil.io/v3/sandbox/uk/companies/';
    protected $version = 'v3';
    protected $transport;
    protected $key = 'XXXXXXXXXXXXX';

    private $allowedMethods = ['get'];

    /**
     * @param $method
     * @param args
     *
     * @throws BadRequestException
     */
    public function __call($method, $args)
    {
        if (! in_array($method, $this->allowedMethods)) {
            throw new BadRequestException('The method ('.$method.') is not recognised');
        }
        if (! isset($args[0]) || $args[0] == '') {
            throw new BadRequestException('No URI was set for the API call');
        }
        if (isset($args[1]) && ! is_array($args[1])) {
            throw new BadRequestException('Parameters should be an array, but '.gettype($args[1]).' was given');
        }
        // Set method
        $map = array(
            'update' => 'put',
            'create' => 'post'
        );
        $key = 'XXXXXXXXXXXXX';
        $method = strtoupper(( array_key_exists($method, $map) ? $map[$method] : $method ));
        // Set the full call URL
        $call = $this->uri. $args[0].'/credit-report?api_key='.$key;
        // Make the request
        return $this->request($call, $method, isset($args[1]) ? $args[1] : null);
    }

    /**
     * @param $key
     * @param $call
     * @param $method
     * @param $params
     */
    protected function request($key, $call, $method, $params = null)
    {
        $transport = $this->getTransport();
        $transport->setKey($key);
        $transport->setUri($call);
        $transport->setMethod($method);
        if ($params) {
            $transport->setBody($params);
        }
        return $transport->send();
    }
    /**
     * Set the method of transport used to communicate with the API
     *
     * @param TransportInterface $transport
     */
    public function setTransport(TransportInterface $transport)
    {
        $this->transport = $transport;
    }
    /**
     * Retrieve the method of Transport
     *
     * @return TransportInterface
     */
    protected function getTransport()
    {
        if (! isset($this->transport)) {
            return new Curl();
        }
        return $this->transport;
    }
}