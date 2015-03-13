Duedil API.

Everything is set, but keep getting 
````
object(Marketing\Duedil\Transport\Response)[382]
  protected 'responseCode' => int 500
  protected 'responseTime' => float 0.000189
  protected 'responseBody' => 
    array (size=1)
      'error' => string 'No response received from API' (length=36)
````  

````
$response = $this->client->get($company_id);
````

Which is what I have in my controller the uri shows correctly, so just need to get the JSON response now, but not sure how?

Any advice?