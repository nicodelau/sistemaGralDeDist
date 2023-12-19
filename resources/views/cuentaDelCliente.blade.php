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

                            let precio = document.querySelectorAll('#precioPrint');

                            for (let i = 0; i < cantidadDeRows; i++) {
                                totalAPagar += parseInt(precio[i].textContent);

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
                            <th scope="col" class="dark:text-gray-100">Id</th>
                            <th scope="col" class="dark:text-gray-100">Precio</th>
                            <th scope="col" class="dark:text-gray-100">Nombre</th>
                            <th scope="col" class="dark:text-gray-100">Cantidad</th>
                            <th scope="col" class="dark:text-gray-100">Precio final</th>
                            <th scope="col" class="dark:text-gray-100">Pago</th>
                            <th scope="col" class="dark:text-gray-100">Monto pagado</th>
                            <th scope="col" class="dark:text-gray-100">Guardar</th>
                        </tr>
                    </thead>
                <tbody>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <?php
                                $total = '';

                                foreach ($cuenta as $key => $value) {
                                    $total .= '<form action="/modificarTalonario"><tr>';
                                    $total .= '<th scope="row" class="dark:text-gray-100">
                                            <input type="text" name="id" class="escondido" style="border:1px solid white; border-radius: 5px;" value="' . $value->id . '">
                                            </th>';
                                    echo $total;
                                    $total='';

                                    $datosCompra = json_decode($value->datosCompra);

                                    foreach ($datosCompra as $key => $value) {
                                        echo $key;
                                    }

                                    $total .= '<th scope="row" class="dark:text-gray-100">
                                            <input type="checkbox" name="pago" id="yaPago" ';
                                            if($value->cuantoPago){$total .= 'checked';};
                                    $total .='>
                                            </th>
                                            <th scope="row" class="dark:text-gray-100">
                                            <input type="text" id="totalPagado" name="totalPagado" class="allUnset" style="border:1px solid white; border-radius: 5px;" value="' . $value->cuantoPago . '">
                                            </th>';
                                    $total .= '<th scope="row" class="dark:text-gray-100">
                                                <button type="submit"><i class="fa-solid fa-pencil"></i></button>
                                            </th>';
                                    $total .= '</tr></form>';
                                    echo $total;
                                    $total='';
                                }
                            ?>

                    </tr>
                </tbody>
                </table>
        </div>
        </div>
    </div>
</x-app-layout>
