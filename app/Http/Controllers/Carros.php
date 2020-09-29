<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Carros extends Controller
{
    private function extract()
    {
    }

    public function index()
    {
        $client = new Requester();
        $cars = $client->get("carros");
        $status = $client->get("status");

        $dados = array();
        $i = 0;
        foreach ($cars as $car) {
            $i++;
            foreach ($status as $st) {
                if ($car["status"] == $st["status"]) {
                    $dados[$i] = array("carros" => $car, "status" => $st);
                }
            }
        }

        return view('list')->with('dados', $dados);
    }

    public function getPlaca(Request $request)
    {
        $placa = $request->query('id');
        if (empty($placa) || strlen($placa) < 8) {
            return redirect('/all');
        }
        $client = new Requester();
        $cars = $client->get("carros/" . $placa);
        $status = $client->get("status");

        $dados = array();
        $i = 0;
        foreach ($cars as $car) {
            $i++;
            foreach ($status as $st) {
                if ($car["status"] == $st["status"]) {
                    $dados[$i] = array("carros" => $car, "status" => $st);
                }
            }
        }

        return view('list')->with('dados', $dados);
    }
}
