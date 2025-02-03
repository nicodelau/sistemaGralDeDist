<?php

namespace App\Helpers;

class AppHelpers
{
    public static function getAllClientes()
    {
        $result = \DB::table('clientes')->get();

        return $result;
    }

    public static function getAllProductos()
    {
        $result = \DB::table('listaDePrecios')->get();

        return $result;
    }
}
