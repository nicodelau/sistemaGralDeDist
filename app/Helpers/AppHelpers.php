<?php

namespace App\Helpers;
use DB;
use Illuminate\Http\Request;

class AppHelper
{
    public static function getAllClientes()
    {
        $result = DB::table('clientes')->get();
        return $result;

    }

    public static function getAllProductos()
    {
        $result = DB::table('listaDePrecios')->get();
        return $result;

    }
}
