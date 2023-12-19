<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TalonarioController extends Controller
{
    public function guardarTalonario(Request $request)
    {
        $result = \DB::table('talonario');

        $result = $result->insert(['cliente' => $request->nombreDelCliente, 'datosCompra' => $request->talonario, 'fechaCompra' => $request->fecha, 'totalDeLaCompra' => $request->totalSuma, 'pago' => '0', 'cuantoPago' => '0']);

        if ($result) {
            return true;
        }

        return false;
    }

    public function getCuenta(Request $request)
    {
        $result = \DB::table('talonario')->where('cliente', '=', $request->nombre);
        $cuenta = $result->get();

        return view('cuentaDelCliente', compact('cuenta'));
    }

    public function modificarTalonario(Request $request)
    {
        $result = \DB::table('talonario')->where('id', '=', $request->id);

        $pago = $request->pago == 'ON' ? 1 : 0;

        $result = $result->update(['pago' => $pago, 'cuantoPago' => $request->totalPagado]);

        $clientes = \DB::table('clientes');

        $clientes = $clientes->orderBy('id', 'desc')->paginate(15, ['id', 'nombre', 'ubicacion', 'telefono', 'alias']);

        return view('clientes', compact('clientes'));
    }
}
