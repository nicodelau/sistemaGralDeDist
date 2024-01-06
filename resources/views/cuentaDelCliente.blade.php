<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg" style="display: flex; align-items: center; justify-content: center;">
                <div class="p-6 text-gray-900 dark:text-gray-100" style="display: flex; justify-content: space-between; gap: 100px;">
                    <div class="flex flex-row items-center">
                        Cliente: <input id="nombreDelCliente" class="allUnset" value=" {{$nombreDelCliente}}">
                    </div>
                    <div class="flex flex-row items-center">
                        Total a pagar: <span id="totalAPagar"></span>
                    </div>
                    <div class="flex flex-row items-center">
                        Total Pago: <span id="totalPago"></span>
                    </div>
                    <div class="flex flex-row items-center">
                        Debe: <span id="totalDebe"></span>
                    </div>

                    <script>
                        $(window).on('load', function() {
                            let cantidadDeRows = document.querySelectorAll('#precios').length;
                            let totalAPagar = 0;
                            let montoPago = 0;

                            for (let i = 0; i < cantidadDeRows; i++) {
                                let precio = document.getElementsByName('total');
                                console.log(parseInt(precio[i].value))
                                totalAPagar += parseInt(precio[i].value);

                            }

                            let total = document.querySelectorAll('#totalPagado');
                            for (let i = 0; i < total.length; i++) {
                                montoPago += parseInt(total[i].value);
                            }

                            let totalDebe = totalAPagar - montoPago;

                            document.getElementById('totalAPagar').innerText = totalAPagar;
                            document.getElementById('totalPago').innerText = montoPago;
                            document.getElementById('totalDebe').innerText = totalDebe;
                        })
                    </script>
                </div>
            </div>
            <div class="mt-4">
                <table class="w-full text-md text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-sm text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="dark:text-gray-100"></th>
                            <th scope="col" class="dark:text-gray-100">Fecha de la compra</th>
                            <th scope="col" class="dark:text-gray-100">Id</th>
                            <th scope="col" class="dark:text-gray-100">Precio</th>
                            <th scope="col" class="dark:text-gray-100">Nombre</th>
                            <th scope="col" class="dark:text-gray-100">Cantidad</th>
                            <th scope="col" class="dark:text-gray-100">Precio final</th>
                            <th scope="col" class="dark:text-gray-100">Monto pagado</th>
                            <th scope="col" class="dark:text-gray-100">Guardar</th>
                        </tr>
                    </thead>
                <tbody>
                    <?php
                        $i = 0;
                    ?>
                    @foreach ($datosCompra as $compra)
                        @foreach ($compra as $comp)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <form action="/modificarTalonario">
                                <th scope="row" class="dark:text-gray-100 escondido">
                                    <input type="text" name="idCompra" value="{{$cuenta[0]->datosCompra}}">
                                </th>
                                <th scope="row" class="dark:text-gray-100 escondido">
                                    <input type="text" name="idRow" value="{{$comp->idRow}}">
                                </th>
                                <th scope="row" class="dark:text-gray-100 escondido">
                                    <input type="text" name="nombre" value="{{$nombreDelCliente}}">
                                </th>
                                <th scope="row" class="dark:text-gray-100"></th>
                                <th scope="row" class="dark:text-gray-100">
                                    <input type="text" id="fechaCompra" name="fechaCompra" class="allUnset" value="{{$fechasCompra[$i]->fechaCompra}}">
                                </th>
                                <th scope="row" class="dark:text-gray-100">
                                    <input type="text" id="idDelProducto" name="idDelProducto" class="allUnset" value="{{$comp->idDelProducto}}">
                                </th>
                                <th scope="row" class="dark:text-gray-100">
                                    <input type="text" id="precios" name="precio" class="allUnset" value="{{$comp->precio}}">
                                </th>
                                <th scope="row" class="dark:text-gray-100">
                                    <input type="text" id="nombre" name="nombre" class="allUnset" value="{{$comp->nombre}}">
                                </th>
                                <th scope="row" class="dark:text-gray-100">
                                    <input type="text" id="cantidad" name="cantidad" class="allUnset" value="{{$comp->cantidad}}">
                                </th>
                                <th scope="row" class="dark:text-gray-100">
                                    <input type="text" id="total" name="total" class="allUnset" value="{{$comp->total}}">
                                </th>
                                <th scope="row" class="dark:text-gray-100">
                                    <input type="text" id="totalPagado" name="cuantoPago" max="{{$comp->total}}" class="allUnset" value="{{$comp->cuantoPago}}">
                                </th>
                                <th scope="row" class="dark:text-gray-100">
                                    <a onclick="guardarTalonario()">
                                        <button ><i class="fa-solid fa-pencil"></i></button>
                                    </a>
                                </th>
                            </form>
                        </tr>
                        @endforeach
                        <?php
                        $i++;
                    ?>
                    @endforeach
                </tbody>
            </table>
            <script>
                function guardarTalonario() {
                    let valueSave;
                    let totalSuma = document.getElementById('totalAPagar').innerText;
                    let cantidadDeProductos = document.querySelectorAll('#precios').length;
                    let datosTal = [];
                    for (let i = 0; i < cantidadDeProductos; i++) {
                        let out = {};
                        let productos = document.querySelectorAll('#tableRow' + i.toString());
                        productos = productos[1];
                        valueSave = $('#tableRow' + i.toString())['0'];
                        valueSave = valueSave.outerHTML
                        var priceRegex = /value="([0-9]+)"/
                        valueSave = valueSave.match(priceRegex);
                        let producto = productos.innerHTML;
                        producto = producto.replace(/escondido/g, "");
                        producto = producto.replace(`<th class="dark:text-gray-100" id="non-printable" scope="row"><button onclick="eliminar(` + i + `)" name="id"><i class="fa-solid fa-trash"></i></button></th>`, "");
                        producto = producto.replace(/class="text-white allUnset"/g, "class='escondido'");
                        producto = producto.replace(/id="printable" name="precioPrint1"/g, "id='precioPrint'");
                        out.id = i;
                        out.talonario = producto;
                        datosTal.push(out);
                    }

                    let objectDate = new Date();
                    let day = objectDate.getDate();
                    let month = objectDate.getMonth();
                    let year = objectDate.getFullYear();

                    let totalPagado = [];
                    totalPagados = document.querySelectorAll('#totalPagado');
                    totalPagados.forEach(total => {
                        totalPagado.push(total.value)
                    });

                    let nombreDelCliente = document.getElementById('nombreDelCliente').value;

                    $.ajax({
                        url : " /modificarTalonarioFromCuentas",
                        type : 'GET',
                        data: {
                            value: valueSave,
                            talonario: JSON.stringify(datosTal),
                            nombreDelCliente: nombreDelCliente,
                            totalSuma: totalSuma,
                            fecha: day + '/' + (month + 1) + '/' + year,
                            totalPagado: JSON.stringify(totalPagado),
                        },
                        success : function(result){
                            if(result = 1){
                                Swal.fire({
                                    text: "El talonario se guardo con exito!",
                                    icon: "success"
                                });
                                return;
                            }
                            Swal.fire({
                                text: "Ah ocurrido un error!",
                                icon: "error"
                            });
                            return;
                        },
                        error : function (result){
                            Swal.fire({
                                text: "Ah ocurrido un error!",
                                icon: "error"
                            });
                            console.log(result)
                            return;
                        }
                    });
                }
            </script>
        </div>
        </div>
    </div>
</x-app-layout>
