<?php 
namespace App\Http\Services;
use App\Helpers\ExternalApiCall;

class AddressService

{
    private $url;
    private $format;

    function __construct()
    {
        $this->url = 'https://viacep.com.br/ws/';
        $this->format = 'json';
        $this->api = new ExternalApiCall();

    }

    public function verifyCep($cep)
    {
        $url = $this->url . '/' . $cep . '/' . $this->format;
        $response = $this->api->call($url);

        $address = [
            "street" => $response["logradouro"],
            "neighborhood" => $response["bairro"],
            "city" => $response["localidade"],
            "state" => $response["uf"],
            "postal_code" => $response["cep"]
        ];
        return $address;
    }
}