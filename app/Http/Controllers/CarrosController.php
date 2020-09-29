<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CarrosController extends Controller
{
    private function extract(array $cars, array $status): array
    {
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
        return $dados;
    }

    public function index()
    {
        $client = new Requester();
        $cars = $client->get("carros");
        $status = $client->get("status");

        $dados = $this->extract($cars, $status);

        return view('list')->with('dados', $dados);
    }

    public function getPlaca(Request $request)
    {
        $placa = $request->query('id');
        if (empty($placa)) {
            $request->session()->flash('status', 'Listando todos os veículos cadastrados.');
            return redirect('/all');
        }
        if (strlen($placa) < 8) {
            $request->session()->flash('error', 'A placa informada é inválida!');
            return redirect('/all');
        }
        $client = new Requester();
        $cars = $client->get("carros/" . $placa);
        $status = $client->get("status");

        $dados = $this->extract($cars, $status);

        return view('list')->with('dados', $dados);
    }
}
