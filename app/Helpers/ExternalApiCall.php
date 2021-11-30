<?php 



namespace App\Helpers;

use Exception;
use GuzzleHttp\Client;

class ExternalApiCall 
{
   
    function __construct()
    {
        $this->httpClient = new Client();
    }

    public function call($endpoint, $method = 'get', $headers = null , $body = null , $body_key = 'json' , $outputDebug = false)
    {

        if (!isset($body_key)) {
            $body_key = 'json';
        }
        try{
            if($body)
            {

                $main_data = [
                    'headers' => $headers,
                    $body_key => $body,
                ];
            }else{
                $main_data = [
                    'headers' => $headers,
                ];
            }
            try{
         

                $response = $this->httpClient->$method($endpoint , $main_data);

                $responseHeaders = $response->getHeaders();
                $responseBody = $response->getBody();   
                $responseStatusCode = $response->getStatusCode();
            }catch(Exception $e)
            {
                dd($e->getMessage());
            }
      

            return collect(json_decode($responseBody->getContents(), true));

        } catch (\Throwable $e)
        {
            try{
                $response = null;
                $responseHeaders = $e->getResponse()->getHeaders();
                $responseBody = $e->getResponse()->getBody()->getContents();
                $responseStatusCode = null;

            } catch (\Throwable $e)
            {
                $response = null;
                $responseHeaders = null;
                $responseBody = $e->getMessage();
                $responseStatusCode = null;
            }

        }

    }
}

