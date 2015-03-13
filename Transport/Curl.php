<?php namespace Marketing\Duedil\Transport;

class Curl implements TransportInterface
{
    protected $user;
    protected $pass;
    protected $uri;
    protected $method;
    protected $body;
    protected $key = 'XXXXXXXXXXXXX';
    protected $curl;

    /**
     * Initialise cURL
     */
    public function __construct()
    {
        $this->curl = curl_init();
    }

    /**
     * @param string $uri
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
    }

    /**
     * @param string $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * @param array $body
     */
    public function setBody(Array $body)
    {
        $this->body = $body;
    }


    /**
     * Set API key provided by DueDil
     * @param $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    public function send()
    {
        // Add request settings
        curl_setopt_array($this->curl, array(
            CURLOPT_URL            => $this->uri,
            CURLOPT_CUSTOMREQUEST  => $this->method,
            CURLOPT_HEADER         => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSLVERSION     => 3,
            CURLOPT_TIMEOUT        => 30,
            CURLINFO_HEADER_OUT    => true
        ));

        if (! empty($this->body)) {
            //curl_setopt($this->curl, CURLOPT_POST, true);
            curl_setopt($this->curl, CURLOPT_POSTFIELDS, json_encode($this->body));
        }

        $headers = array(
            'Content-Type:application/json'
        );

        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($this->curl);
        $code   = curl_getinfo($this->curl, CURLINFO_HTTP_CODE);
        $time   = curl_getinfo($this->curl, CURLINFO_TOTAL_TIME);

        if (! $result) {
            return new Response(500, $time, array('error' => 'No response received from API ('.$this->method.' '.$this->uri.')'));
        }

        if ($code == 404) {
            return new Response(404, $time, array('error' => 'Resource was not found ('.$this->method.' '.$this->uri.')'));
        }

        if ($code == 405) {
            return new Response(404, $time, array('error' => 'Method ('.$this->method.') not allowed'));
        }

        $message = json_decode($result, true);

        return new Response($code, $time, $message);
    }

}