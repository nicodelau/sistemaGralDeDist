<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg" style="display: flex; align-items: center; justify-content: space-between;">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex flex-row items-center">
                        {{ __("Agregar nuevo producto a la lista de precios") }}
                        <div class="botonAgregar">
                            <a onclick="mostrarCargaDeProducto()">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" height="25" fill="currentColor" aria-hidden="true"><path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z"></path></svg>
                            </a>
                        </div>
                        <script>
                            function mostrarCargaDeProducto() {
                                let div = document.getElementById('cargaDeProducto');
                                div.classList.toggle("escondido");
                            }
                        </script>

                    </div>
                </div>
                <div style="display: flex; align-items: center; gap: 10px; margin: 15px 15px; color: lightgrey;">
                    <form action="/buscarProducto">
                        <input placeholder="Nombre del producto..." type="text" id="search" class="allUnset" style="padding: 0 15px; border: 1px solid white; border-radius: 15px;" name="nombre">
                        <button type="submit"><i class="fa-solid fa-magnifying-glass text-white"></i></button>
                    </form>
                </div>
            </div>

            <div>
                <div id="cargaDeProducto" class="escondido">
                    <form action="cargarProducto">
                        <div class="p-6">

                            <div>
                                <div class="flex rounded-lg shadow-sm">
                                    <span class="px-4 inline-flex items-center min-w-fit rounded-s-md border border-e-0 border-gray-200 bg-gray-50 text-sm text-gray-500 dark:bg-gray-700 dark:border-gray-700 dark:text-gray-400">Numero de Id</span>
                                    <input type="text" class="py-3 px-4 pe-11 block w-full border-gray-200 shadow-sm rounded-e-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" type="number" name="id">
                                </div>
                            </div>

                              <div>
                                <div class="flex rounded-lg shadow-sm">
                                  <span class="px-4 inline-flex items-center min-w-fit rounded-s-md border border-e-0 border-gray-200 bg-gray-50 text-sm text-gray-500 dark:bg-gray-700 dark:border-gray-700 dark:text-gray-400">Precio</span>
                                  <input type="number" class="py-3 px-4 pe-11 block w-full border-gray-200 shadow-sm rounded-e-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" name="precio">
                                </div>
                              </div>

                              <div>
                                <div class="flex rounded-lg shadow-sm">
                                  <span class="px-4 inline-flex items-center min-w-fit rounded-s-md border border-e-0 border-gray-200 bg-gray-50 text-sm text-gray-500 dark:bg-gray-700 dark:border-gray-700 dark:text-gray-400">Nombre</span>
                                  <input type="text" class="py-3 px-4 pe-11 block w-full border-gray-200 shadow-sm rounded-e-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" name="nombre">
                                </div>
                              </div>

                              <div>
                                <div class="flex rounded-lg shadow-sm">
                                  <span class="px-4 inline-flex items-center min-w-fit rounded-s-md border border-e-0 border-gray-200 bg-gray-50 text-sm text-gray-500 dark:bg-gray-700 dark:border-gray-700 dark:text-gray-400">Unidad</span>
                                  <input type="number" min="1" step="any" class="py-3 px-4 pe-11 block w-full border-gray-200 shadow-sm rounded-e-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" name="unidad">
                                </div>
                              </div>
                            </div>

                            <x-primary-button type="submit">Añadir Productos</x-primary-button>
                    </form>

                </div>

                <table class="w-full text-md text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-sm text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="dark:text-gray-100">Id del producto</th>
                            <th scope="col" class="dark:text-gray-100">Nombre</th>
                            <th scope="col" class="dark:text-gray-100">Precio</th>
                            <th scope="col" class="dark:text-gray-100">Unidad</th>
                            <th scope="col" class="dark:text-gray-100">Modificar</th>
                            <th scope="col" class="dark:text-gray-100">Eliminar</th>
                        </tr>
                    </thead>
                <tbody>
                    @foreach ($productos as $key => $producto)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <form action="/modificarProducto">
                            @foreach ($producto as $key => $producto)
                                <th scope="row" class="dark:text-gray-100">
                                    @if($key == 'id')
                                        <input class='allUnset' name="{{$key}}" value="{{$producto}}">
                                        <input class='escondido' name="idViejo" value="{{$producto}}">
                                        <?php
                                            $id = $producto;
                                        ?>
                                    @else
                                        <input class='allUnset' name="{{$key}}" value="{{$producto}}">
                                    @endif
                                </th>
                            @endforeach
                            <th scope="row" class="dark:text-gray-100">
                                <button type="submit"><i class="fa-solid fa-pencil"></i></button>
                            </th>
                        </form>
                        <form action="/deleteProducto">
                            <th scope="row" class="dark:text-gray-100">
                                <input class='escondido' name="id" value="{{$id}}">
                                <button type="submit"><i class="fa-solid fa-trash"></i></button>
                            </th>
                        </form>
                    </tr>
                    @endforeach
                </tbody>
        </div>
        </div>
    </div>
    <div style="margin: 10px; border-radius: 5px">
        {{ $productos->appends(request()->input())->links('pagination::tailwind') }}
    </div>
</x-app-layout>
