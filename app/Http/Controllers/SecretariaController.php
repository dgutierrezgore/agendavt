<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;
use DB;
use Illuminate\Support\Facades\Auth;

class SecretariaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function crear()
    {

        $clientes = DB::table('vtagenda_cliente')
            ->where('estadoCliente', '=', 1)
            ->get();

        return view('Secretaria.Crear', [
            'clientes' => $clientes,
        ]);
    }

}
