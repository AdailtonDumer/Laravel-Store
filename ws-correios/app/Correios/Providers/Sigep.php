<?php

namespace App\Correios\Providers;

use GuzzleHttp\Client;

Class Sigep extends Provider{

    const URL = 'https://apps.correios.com.br/SigepMasterJPA/AtendeClienteService/AtendeCliente?wsdl';
    private $response;
    private $parseXML;

    public function getName(): string
    {
        return "sigep";
    }

    public function consultaCep($cep){

        $this->buildXMLConsultaCep($cep)
        ->parseXMLResponse();
        
        if($this->hasErrorMessage()){
            return $this->fetchErrorMessage(); 
        }

        return $this->consultaCepResponse();
    }

    protected function buildXMLConsultaCep($cep){
        $this->response = $this->client->post(
            static::URL,
            [
                'http_errors' => false,
                'body' => trim(
                    '<x:Envelope
                        xmlns:x="http://schemas.xmlsoap.org/soap/envelope/"
                        xmlns:cli="http://cliente.bean.master.sigep.bsb.correios.com.br/">
                        <x:Header/>
                        <x:Body>
                            <cli:consultaCEP>
                                <cep>'.$cep.'</cep>
                            </cli:consultaCEP>
                        </x:Body>
                    </x:Envelope>'),
                'headers' => [
                    'Content-Type' => 'text/xml; charset=utf-8'
                ]
            ]
        );
        return $this;
    }

    protected function parseXMLResponse(){
        $xml = $this->response->getBody()->getContents();

        $parse = simplexml_load_string(str_replace(['soap:','ns2:'], null, $xml));

        $this->parseXML = json_decode(json_encode($parse->Body),true);

        return $this;
    }

    protected function consultaCepResponse(){
        $addres = $this->parseXML['consultaCEPResponse']['return'];

        return [
            'cep' => $addres['cep'],
            'logradouro' => empty($addres['end'])?'':$addres['end'],
            'bairro' => empty($addres['bairro'])?'':$addres['bairro'],
            'complemento' =>  empty($addres['complemento2'])?'':$addres['complemento2'],
            'cidade' => $addres['cidade'],
            'uf' => $addres['uf']
        ];
    }

    protected function hasErrorMessage(){
        return array_key_exists('Fault', $this->parseXML);
    }

    protected function fetchErrorMessage(){
        return [
            'error' => $this->parseXML['Fault']['faultstring']
        ];
    }
}