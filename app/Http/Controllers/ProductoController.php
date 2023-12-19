<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class ProductoController extends Controller
{

    public function getProduct(Request $request) {
        $result = DB::table('listaDePrecios')->where('nombre', 'LIKE', '%' . $request->nombre . "%");
        $prods = $result->get();
        if(count($prods) > 0) {
            $productos = $result->orderBy("id", 'desc')->paginate(15, ['id', 'nombre', 'precio', 'unidad']);

            return view('listaDePrecios', compact('productos'));

        }
        $productos = $result->orderBy("id", 'desc')->paginate(15, ['id', 'nombre', 'precio', 'unidad']);
        return view('listaDePrecios', compact('productos'));

    }

    public function getProducts() {
        $result = DB::table('listaDePrecios');
        $productos = $result->orderBy("id", 'desc')->paginate(15, ['id', 'nombre', 'precio', 'unidad']);

        return view('listaDePrecios', compact('productos'));
    }

    public function addProduct(Request $request) {
        $result = DB::table('listaDePrecios');

        $result = $result->insert(['id' => $request->id, 'nombre' => $request->nombre, 'precio' => $request->precio, 'unidad' => $request->unidad]);

        $result2 = DB::table('listaDePrecios');
        $productos = $result2->orderBy("id", 'desc')->paginate(15, ['id', 'nombre', 'precio', 'unidad']);

        return view('listaDePrecios', compact('productos'));
    }

    public function modifProduct(Request $request) {
        $result = DB::table('listaDePrecios');

        $result = $result->where('id', '=', $request->idViejo)->update(['id' => $request->id, 'nombre' => $request->nombre, 'precio' => $request->precio, 'unidad' => $request->unidad]);

        $result2 = DB::table('listaDePrecios');
        $productos = $result2->orderBy("id", 'desc')->paginate(15, ['id', 'nombre', 'precio', 'unidad']);

        return view('listaDePrecios', compact('productos'));
    }

    public function deleteProducto(Request $request) {
        $result = DB::table('listaDePrecios');

        $result = $result->where('id', '=', $request->id)->delete();

        $result2 = DB::table('listaDePrecios');

        $productos = $result2->orderBy("id", 'desc')->paginate(15, ['id', 'nombre', 'precio', 'unidad']);

        return view('listaDePrecios', compact('productos'));
    }

}

