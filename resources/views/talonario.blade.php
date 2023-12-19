<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" id="printableArea">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg" style="display: flex; align-items: center; justify-content: space-between;">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex flex-row items-center">
                        {{ __("Talonario") }}

                    </div>
                </div>
            </div>
            <?php
                $total = 0;
            ?>
            <div class="p-4" style="display: flex; align-items: center; justify-content: space-between;">
                <div class="text-gray-500" id="non-printable">
                    <label class="text-gray-300" for="cliente">Cliente: </label>
                    <select name="cliente" id="cliente" onchange="clienteChange(this)" class="allUnset" style="border: 2px solid white; border-radius: 15px; padding: 0 15px 0 15px;" required>
                        {{$clientes = AppHelper::getAllClientes()}}
                            <option value='' disabled selected>Elija el cliente...</option>
                            @foreach ($clientes as $cliente)
                                <option value='{{$cliente->nombre}}'">{{$cliente->nombre}}</option>
                            @endforeach
                    </select>
                </div>

                <script>
                    function clienteChange(select) {
                        let clienteSpan = document.getElementById('clienteSpan');
                        clienteSpan.innerText = select.value
                    }
                </script>

                <div class="text-gray-500" class="escondido" id="printable">
                    Cliente: <span id="clienteSpan"></span>
                </div>

            </div>

            <div class="text-gray-500 p-4" style="display: flex; align-items: center; justify-content: space-between;">
                <div id="non-printable">
                    <label class="text-gray-300" for="productos">Productos: </label>
                    <select name="productos" id="productos" class="allUnset" style="border: 2px solid white; border-radius: 15px; padding: 0 15px 0 15px;" required>
                        {{$productos = AppHelper::getAllProductos()}}
                            <option value='' disabled selected>Elija el producto...</option>
                            @foreach ($productos as $producto)
                                <option value='{{json_encode($producto)}}'>{{$producto->nombre}}</option>
                            @endforeach
                    </select>

                    <label for="cantidad">cantidad: </label>
                    <input type="number" id="cantidad" name="cantidad" class="allUnset" style="border: 2px solid white; border-radius: 15px; padding: 0 0 0 4px;" required>
                </div>

                <div id="non-printable">
                    <x-primary-button onclick="agregarProducto()">Agregar Producto</x-primary-button>
                    <x-primary-button onclick="return printDiv('printableArea')">Imprimir</x-primary-button>
                </div>

            </div>
            <script>
                let cantidadDeProductos = 0;

                function agregarProducto() {
                    cantidadDeProductos++;
                    let productos = JSON.parse($("#productos").val());
                    let cantidad = $("#cantidad").val();
                    if(productos == null || cantidad == ''){
                        Swal.fire({
                            text: "Tiene que completar ambos campos para poder agregar un producto a la lista!",
                            icon: "error"
                        });
                        return;
                    }

                    let tableBody = document.getElementById('tableBody');

                    let tr = document.createElement('tr');
                    tr.setAttribute('class', 'bg-white border-b dark:bg-gray-800 dark:border-gray-700');
                    tr.setAttribute('id', 'tableRow' + cantidadDeProductos.toString());

                    for (const key in productos) {
                        if (Object.hasOwnProperty.call(productos, key)) {
                            if(key != 'unidad') {
                                const element = productos[key];
                                let th = document.createElement('th');
                                th.setAttribute('class', 'dark:text-gray-100');
                                th.setAttribute('scope', 'row');
                                th.innerText = element;
                                tr.appendChild(th)
                            } else {
                                let th = document.createElement('th');
                                th.setAttribute('class', 'dark:text-gray-100');
                                th.setAttribute('scope', 'row');
                                th.innerText = cantidad;
                                tr.appendChild(th)
                            }
                        }
                    }

                    let precioPorProd = cantidad * productos.precio

                    let precioTh = document.createElement('th');
                    let precioTh2 = document.createElement('input');
                    precioTh2.setAttribute('class', 'text-white allUnset');
                    precioTh2.setAttribute('scope', 'row');
                    precioTh2.setAttribute('id', 'precios');
                    precioTh2.setAttribute('onkeyup', 'setTotal(); newPrice('+ cantidadDeProductos.toString() + ')');
                    precioTh2.value = precioPorProd;

                    let precioTh3 = document.createElement('span');
                    precioTh3.setAttribute('class', 'escondido');
                    precioTh3.setAttribute('scope', 'row');
                    precioTh3.setAttribute('id', 'printable');
                    precioTh3.innerText = precioPorProd;
                    precioTh3.setAttribute('name', 'precioPrint' + cantidadDeProductos.toString());

                    precioTh.appendChild(precioTh2)
                    precioTh.appendChild(precioTh3)
                    tr.appendChild(precioTh)

                    let th = document.createElement('th');
                    th.setAttribute('class', 'dark:text-gray-100');
                    th.setAttribute('scope', 'row');
                    th.setAttribute('value', productos.id);
                    th.innerText = productos.nombre;

                    let input = document.createElement('input');
                    input.setAttribute('class', 'escondido');
                    input.setAttribute('name', 'id');
                    input.setAttribute('value', productos.id);

                    let buttonTh = document.createElement('th');
                    buttonTh.setAttribute('class', 'dark:text-gray-100');
                    buttonTh.setAttribute('id', 'non-printable');
                    buttonTh.setAttribute('scope', 'row');

                    let button = document.createElement('button');
                    button.setAttribute('onclick', 'eliminar(' + cantidadDeProductos + ')');
                    button.setAttribute('name', 'id');

                    let i = document.createElement('i');
                    i.setAttribute('class', 'fa-solid fa-trash')
                    button.appendChild(i)
                    buttonTh.appendChild(button)
                    tr.appendChild(buttonTh)

                    tableBody.appendChild(tr)
                    setTotal();

                    let mySelect = document.getElementById('productos');
                    mySelect.selectedIndex = 0;
                    let cantidadId = document.getElementById('cantidad');
                    cantidadId.value = ''
                }

                function eliminar(num) {
                    let productos = document.getElementById('tableRow' + num);
                    productos.remove()
                    setTotal()

                }

                function setTotal() {
                    let total = 0;
                    let precios = document.querySelectorAll('#precios');
                    let totalSuma = document.getElementById('totalSuma');
                    precios.forEach(precio => {
                        total += parseInt(precio.value);
                    });
                    totalSuma.innerText = total;
                }

                function newPrice(num) {
                    var precios = document.querySelectorAll('#precios');
                    let precio = $('span[name="precioPrint' + cantidadDeProductos.toString() + '"]');
                    precio.text(precios[num - 1].value);
                }

                function printDiv(divId) {
                    var precios = document.querySelectorAll('#precios');
                    let savePrecios = [];
                    precios.forEach(precio => {
                        savePrecios.push(precio.value)
                    });
                    var printContents = document.getElementById(divId).innerHTML;
                    var originalContents = document.body.innerHTML;
                    document.body.innerHTML = printContents;
                    window.print();
                    document.body.innerHTML = originalContents;
                    for (let i = 0; i < savePrecios.length; i++) {
                        document.querySelectorAll('#precios')[i].value = savePrecios[i];
                    }
                }

            </script>

            <table class="w-full text-md text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-sm text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="dark:text-gray-100">Id del producto</th>
                        <th scope="col" class="dark:text-gray-100">Precio</th>
                        <th scope="col" class="dark:text-gray-100">Nombre</th>
                        <th scope="col" class="dark:text-gray-100">Unidad</th>
                        <th scope="col" class="dark:text-gray-100">Total</th>
                        <th scope="col" class="dark:text-gray-100" id="non-printable">Eliminar</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    </tr>
                </tbody>
            </table>
            <div class="text-white p-4">
                Total: <span id='totalSuma'></span>
            </div>
            <div id="non-printable">
                <x-primary-button onclick="guardarTalonario()">Guardar Talonario</x-primary-button>
            </div>

            <script>
                function guardarTalonario() {
                    let datosParaGuardar = [];
                    let clienteSpan = document.getElementById('clienteSpan');
                    let nombreDelCliente = clienteSpan.innerText;
                    if(nombreDelCliente == ''){
                        Swal.fire({
                            text: "Tiene que elegir un cliente!",
                            icon: "error"
                        });
                        return;
                    }

                    let totalSuma = document.getElementById('totalSuma').innerText;
                    let cantidadDeProductos = document.querySelectorAll('#precios').length;
                    let datosTal = [];
                    for (let i = 1; i < cantidadDeProductos + 1; i++) {
                        let out = {};
                        let productos = document.getElementById('tableRow' + i.toString());
                        let producto = productos.innerHTML;
                        producto.replace(/escondido/g, "");
                        producto.replace('<th class="dark:text-gray-100" id="non-printable" scope="row"><button onclick="eliminar(1)" name="id"><i class="fa-solid fa-trash"></i></button></th>', "");
                        producto.replace(/class="text-white allUnset"/g, "class='escondido'");
                        producto.replace(/id="printable" name="precioPrint1"/g, "id='precioPrint'");
                        out.id = i;
                        out.talonario = producto;
                        datosTal.push(out);
                    }

                    // datosParaGuardar.push(datosTal);
                    // datosParaGuardar.push(nombreDelCliente);
                    // datosParaGuardar.push(totalSuma);
                    let objectDate = new Date();
                    let day = objectDate.getDate();
                    let month = objectDate.getMonth();
                    let year = objectDate.getFullYear();

                    $.ajax({
                        url : " /guardarTalonario",
                        type : 'GET',
                        data: {
                            talonario: JSON.stringify(datosTal),
                            nombreDelCliente: nombreDelCliente,
                            totalSuma: totalSuma,
                            fecha: day + '/' + (month + 1) + '/' + year,
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
                        error : function (resutl){
                            Swal.fire({
                                text: "Ah ocurrido un error!",
                                icon: "error"
                            });
                            return;
                        }
                    });
                }
            </script>
        </div>
    </div>
</x-app-layout>
