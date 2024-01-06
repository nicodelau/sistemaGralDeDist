<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function getCliente(Request $request)
    {
        $result = \DB::table('clientes')->where('alias', 'LIKE', '%'.$request->nombre.'%');
        $client = $result->get();
        if (count($client) > 0) {
            $clientes = $result->orderBy('id', 'desc')->paginate(15, ['id', 'nombre', 'ubicacion', 'telefono', 'alias']);

            return view('clientes', compact('clientes'));
        }
        $clientes = $result->orderBy('id', 'desc')->paginate(15, ['id', 'nombre', 'ubicacion', 'telefono', 'alias']);

        return view('clientes', compact('clientes'));
    }

    public function getClientes()
    {
        $result = \DB::table('clientes');
        $clientes = $result->orderBy('id', 'desc')->paginate(15, ['id', 'nombre', 'ubicacion', 'telefono', 'alias']);

        return view('clientes', compact('clientes'));
    }

    public function addCliente(Request $request)
    {
        $result = \DB::table('clientes');

        $result = $result->insert(['id' => $request->id, 'nombre' => $request->nombre, 'ubicacion' => $request->ubicacion, 'telefono' => $request->telefono, 'alias' => $request->alias]);

        $result2 = \DB::table('clientes');
        $clientes = $result2->orderBy('id', 'desc')->paginate(15, ['id', 'nombre', 'ubicacion', 'telefono', 'alias']);

        return view('clientes', compact('clientes'));
    }

    public function modifCliente(Request $request)
    {
        $result = \DB::table('clientes');

        $result = $result->where('id', '=', $request->id)->update(['id' => $request->id, 'nombre' => $request->nombre, 'ubicacion' => $request->ubicacion, 'telefono' => $request->telefono, 'alias' => $request->alias]);

        $result2 = \DB::table('clientes');
        $clientes = $result2->orderBy('id', 'desc')->paginate(15, ['id', 'nombre', 'ubicacion', 'telefono', 'alias']);

        return view('clientes', compact('clientes'));
    }

    public function deleteCliente(Request $request)
    {
        $result = \DB::table('clientes');

        $result = $result->where('id', '=', $request->id)->delete();

        $result2 = \DB::table('clientes');
        $clientes = $result2->orderBy('id', 'desc')->paginate(15, ['id', 'nombre', 'ubicacion', 'telefono', 'alias']);

        return view('clientes', compact('clientes'));
    }

    public static function cuantoDebe(Request $request)
    {
        $cliente = $request->cliente;
        $total = \DB::table('talonario')->where('cliente', '=', $cliente)->sum('totalDeLaCompra');

        $compras = \DB::table('talonario')->where('cliente', '=', $cliente)->get('datosCompra');

        $pagoTotal = 0;

        foreach ($compras as $compra) {
            $value = \DB::table('datosdelacompra')->where('id', '=', $compra->datosCompra);
            $pago = $value->get('cuantoPago');
            for ($i = 0; $i < count($pago); ++$i) {
                $pagoTotal += $pago[$i]->cuantoPago;
            }
        }

        return $total - $pagoTotal;
    }
}
