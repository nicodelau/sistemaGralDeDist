<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TalonarioController extends Controller
{
    public function guardarTalonario(Request $request)
    {
        $result = \DB::table('datosdelacompra');
        $resMax = $result->max('id');
        $talonario = $request->talonario;
        $talonario = json_decode($talonario);
        $uniqId = uniqid();

        foreach ($talonario as $key => $value) {
            $result = \DB::table('datosdelacompra');

            $result = $result->insert(['id' => $uniqId, 'idDelProducto' => $value->idProd, 'precio' => $value->precio, 'nombre' => $value->nombre, 'cantidad' => $value->unidad, 'total' => $value->total, 'cuantoPago' => '0']);
        }

        $result = \DB::table('talonario');

        $result = $result->insert(['cliente' => $request->nombreDelCliente, 'datosCompra' => $uniqId, 'fechaCompra' => $request->fecha, 'totalDeLaCompra' => $request->totalSuma]);

        if ($result) {
            return true;
        }

        return false;
    }

    public function getCuenta(Request $request)
    {
        $result = \DB::table('talonario')->where('cliente', 'like', '%'.$request->nombre.'%');

        $cuenta = $result->get(['id', 'cliente', 'datosCompra', 'totalDeLaCompra']);
        $idCompra = $result->get(['datosCompra']);
        $fechasCompra = $result->get(['fechaCompra']);
        $arrCompra = [];

        foreach ($idCompra as $compra) {
            $resCompra = \DB::table('datosdelacompra')->where('id', '=', $compra->datosCompra);
            $resCompra = $resCompra->get(['idRow', 'idDelProducto', 'precio', 'nombre', 'cantidad', 'total', 'cuantoPago']);
            array_push($arrCompra, $resCompra);
        }

        return view('cuentaDelCliente')->with(['cuenta' => $cuenta, 'nombreDelCliente' => $request->nombre, 'datosCompra' => $arrCompra, 'fechasCompra' => $fechasCompra]);
    }

    public function modificarTalonario(Request $request)
    {
        $result = \DB::table('datosdelacompra')->where('idRow', '=', $request->idRow);

        $result = $result->update(['idDelProducto' => $request->idDelProducto, 'precio' => $request->precio, 'nombre' => $request->nombre, 'cantidad' => $request->cantidad, 'total' => $request->total, 'cuantoPago' => $request->cuantoPago]);

        $clientes = \DB::table('clientes');

        $clientes = $clientes->orderBy('id', 'desc')->paginate(15, ['id', 'nombre', 'ubicacion', 'telefono', 'alias']);

        return view('clientes', compact('clientes'));
    }

    private static function getCuentaFromCliente($nombre)
    {
        $result = \DB::table('talonario')->where('cliente', '=', $nombre);
        $cuenta = $result->get(['id', 'cliente', 'datosCompra', 'fechaCompra', 'totalDeLaCompra']);
        $idCompra = $result->get('datosCompra');

        $resCompra = \DB::table('datosdelacompra')->where('id', '=', $idCompra[0]->datosCompra);
        $resCompra = $resCompra->get(['idRow', 'idDelProducto', 'precio', 'nombre', 'cantidad', 'total', 'cuantoPago']);

        return view('cuentaDelCliente')->with(['cuenta' => $cuenta, 'nombreDelCliente' => $nombre, 'datosCompra' => $resCompra]);
    }
}
