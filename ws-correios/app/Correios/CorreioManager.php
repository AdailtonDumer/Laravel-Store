<?php

namespace App\Correios;

use App\Correios\Providers\Sigep;
use App\Correios\Providers\CalcPrecoPrazo;
use Illuminate\Support\Collection;

class CorreioManager
{
    protected $avaliableProviders = [
        Sigep::class,
        CalcPrecoPrazo::class
    ];

    protected function getAvaliableProviders(): Collection
    {
        return collect($this->avaliableProviders)->mapWithKeys(function ($class){
            $instance = app($class);
            return [$instance->getName() => $instance];
        });
    }

    public function provider($name){
        return $this->getAvaliableProviders()
        ->get($name);
    }
}