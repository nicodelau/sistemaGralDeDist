<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class ClienteController extends Controller
{


    public function getCliente(Request $request)
    {
        $result = DB::table('clientes')->where('alias', 'LIKE', '%' . $request->nombre . "%");
        $client = $result->get();
        if(count($client) > 0) {
            $clientes = $result->orderBy("id", 'desc')->paginate(15, ['id', 'nombre', 'ubicacion', 'telefono', 'alias']);

            return view('clientes', compact('clientes'));

        }
        $clientes = $result->orderBy("id", 'desc')->paginate(15, ['id', 'nombre', 'ubicacion', 'telefono', 'alias']);
        return view('clientes', compact('clientes'));

    }


    public function getClientes()
    {
        $result = DB::table('clientes');
        $clientes = $result->orderBy("id", 'desc')->paginate(15, ['id', 'nombre', 'ubicacion', 'telefono', 'alias']);

        return view('clientes', compact('clientes'));
    }

    public function addCliente(Request $request)
    {
        $result = DB::table('clientes');

        $result = $result->insert(['id' => $request->id, 'nombre' => $request->nombre, 'ubicacion' => $request->ubicacion, 'telefono' => $request->telefono, 'alias' => $request->alias]);

        $result2 = DB::table('clientes');
        $clientes = $result2->orderBy("id", 'desc')->paginate(15, ['id', 'nombre', 'ubicacion', 'telefono', 'alias']);

        return view('clientes', compact('clientes'));
    }

    public function modifCliente(Request $request)
    {
        $result = DB::table('clientes');

        $result = $result->where('id', '=', $request->id)->update(['id' => $request->id, 'nombre' => $request->nombre, 'ubicacion' => $request->ubicacion, 'telefono' => $request->telefono, 'alias' => $request->alias]);

        $result2 = DB::table('clientes');
        $clientes = $result2->orderBy("id", 'desc')->paginate(15, ['id', 'nombre', 'ubicacion', 'telefono', 'alias']);

        return view('clientes', compact('clientes'));
    }

    public function deleteCliente(Request $request)
    {
        $result = DB::table('clientes');

        $result = $result->where('id', '=', $request->id)->delete();

        $result2 = DB::table('clientes');
        $clientes = $result2->orderBy("id", 'desc')->paginate(15, ['id', 'nombre', 'ubicacion', 'telefono', 'alias']);

        return view('clientes', compact('clientes'));
    }

    // public function search(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $output = "";
    //         $products = DB::table('products')->where('title', 'LIKE', '%' . $request->search . "%")->get();
    //         if ($products) {
    //             foreach ($products as $key => $product) {
    //                 $output .= '<tr>' .
    //                     '<td>' . $product->id . '</td>' .
    //                     '<td>' . $product->title . '</td>' .
    //                     '<td>' . $product->description . '</td>' .
    //                     '<td>' . $product->price . '</td>' .
    //                     '</tr>';
    //             }
    //             return Response($output);
    //         }
    //     }
    // }

}

