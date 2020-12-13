<?php

namespace App\Shipping;

use GuzzleHttp\Client;

class CorreioApi{
    protected $client = null;

    protected $query =[];
    
    public function __construct(){
        $this->client = new Client([
            'base_uri' => 'http://localhost:8000'
        ]);
    }

    public function makeRequestShipping($cepDestination, $products){
        $this->query['cep_origem'] = '29780000';
        $this->query['cep_destino'] = $cepDestination;
        $this->query['altura']= $products->sum('width');
        $this->query['comprimento']= $products->sum('length'); 
        $this->query['largura'] = $products->sum('height');
        $this->query['peso'] = $products->sum('weight');

        return $this;
    }

    public function prices(){
        return $this->request('ws/frete');
    }

    public function request($uri){
        $response = $this->client->request('GET', "/{$uri}",[
            'query' => $this->query
        ]);

        return json_decode($response->getBody(),true)??null;
    }
}