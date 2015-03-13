<?php namespace Marketing\Duedil\Transport;

class Response {

    protected $responseCode;
    protected $responseTime;
    protected $responseBody;

    /**
     * @param $responseCode
     * @param $responseTime
     * @param array $responseBody
     */
//    public function __construct($responseCode, $responseTime, Array $responseBody)
//    {
//        $this->responseCode = $responseCode;
//        $this->responseTime = $responseTime;
//        $this->responseBody = $responseBody;
//    }
    /**
     * The HTTP status code returned by the API
     *
     * @return integer
     */
    public function getCode()
    {
        return (int)$this->responseCode;
    }
    /**
     * The amount of time the request took
     *
     * @return integer
     */
    public function getResponseTime()
    {
        return $this->responseTime;
    }
    /**
     * Content of the request
     *
     * @return array
     */
    public function getBody()
    {
        return $this->responseBody;
    }
    /**
     * Determine if the request was successful
     *
     * @return bool
     */
    public function isSuccessful()
    {
        if ($this->responseCode == 200 || $this->responseCode == 201) {
            return true;
        }
        return false;
    }

}