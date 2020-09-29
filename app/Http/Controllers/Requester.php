<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class Requester extends Controller
{
    public function get(string $path){
        $client = new Client(['headers' => ['Token' => '617f09431faac7ecaa51ee5941bd43a1']]);
        $res = $client->get('http://api.atrialub.com.br/exemplo/'.$path, []);
        return json_decode($res->getBody(), true);
    }
}
