<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo ?? 'SISTEMA DE GESTIÓN' ?></title>
    <?php require_once APP . '/views/layouts/head.php' ?>
</head>

<body class="bg-gray-100">
    <?php require_once APP . '/views/layouts/header.php' ?>
    <main class="flex-grow flex items-center justify-center p-4 w-full max-w-screen-xl mx-auto">
        <div class="bg-white p-6 rounded shadow-md w-full">
            <h2 class="text-xl mb-4">
                <?php echo isset($proveedor) ? 'Editar proveedor' : 'Crear proveedor' ?>
            </h2>

            <!-- Formulario -->
            <form id="proveedores_form" class="w-full max-w-lg">
                <input id="id" name="id" type="hidden" value="<?php echo isset($proveedor) ? $proveedor->getId() : '' ?>">
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="ruc">
                            RUC
                        </label>
                        <input class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            id="ruc" name="ruc" type="text" placeholder="234234234210" value="<?php echo isset($proveedor) ? $proveedor->getRuc() : '' ?>">
                        <p class="text-red-500 text-xs italic"></p>
                    </div>
                    <div class="w-full md:w-1/2 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="razon_social">
                            Razon Social
                        </label>
                        <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" 
                            id="razon_social" name="razon_social" type="text" placeholder="Tiendas ACME" value="<?php echo isset($proveedor) ? $proveedor->getRazonSocial() : '' ?>">
                        <p class="text-red-500 text-xs italic"></p>
                    </div>
                </div>

                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="representante_legal">
                            Representante Legal
                        </label>
                        <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            id="representante_legal" name="representante_legal" type="text" placeholder="Juan Perez" value="<?php echo isset($proveedor) ? $proveedor->getRepresentanteLegal() : '' ?>">
                        <p class="text-red-500 text-xs italic"></p>
                    </div>
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="email">
                            Email
                        </label>
                        <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            id="email" name="email" type="text" placeholder="juan_perez@gmail.com" value="<?php echo isset($proveedor) ? $proveedor->getEmail() : '' ?>">
                        <p class="text-red-500 text-xs italic"></p>
                    </div>
                </div>

                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="telefono">
                            Teléfono
                        </label>
                        <input class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            id="telefono" name="telefono" type="text" placeholder="01 432 1500" value="<?php echo isset($proveedor) ? $proveedor->getTelefono() : '' ?>">
                        <p class="text-red-500 text-xs italic"></p>
                    </div>
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="celular">
                            Celular
                        </label>
                        <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            id="celular" name="celular" type="text" placeholder="999 200 400" value="<?php echo isset($proveedor) ? $proveedor->getCelular() : '' ?>">
                        <p class="text-red-500 text-xs italic"></p>
                    </div>
                </div>

                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="direccion">
                            Dirección
                        </label>
                        <input class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            id="direccion" name="direccion" type="text" placeholder="Av. Perez 689" value="<?php echo isset($proveedor) ? $proveedor->getDireccion() : '' ?>">
                        <p class="text-red-500 text-xs italic"></p>
                    </div>
                    <div class="w-full px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="cuenta_bancaria">
                            Cuenta Bancaria
                        </label>
                        <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            id="cuenta_bancaria" name="cuenta_bancaria" type="text" placeholder="0011-34953495-13" value="<?php echo isset($proveedor) ? $proveedor->getCuentaBancaria() : '' ?>">
                        <p class="text-red-500 text-xs italic"></p>
                    </div>
                </div>

                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full  px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="cuenta_cci">
                            Cuenta CCI
                        </label>
                        <input class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            id="cuenta_cci" name="cuenta_cci" type="text" placeholder="0011-34953495-13-2834" value="<?php echo isset($proveedor) ? $proveedor->getCuentaCci() : '' ?>">
                        <p class="text-red-500 text-xs italic"></p>
                    </div>
                    <div class="w-full px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="banco">
                            Banco
                        </label>
                        <div class="relative">
                            <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="banco" name="banco">
                                <option value="">Seleccionar</option>
                                <option value="BCP">BCP</option>
                                <option value="Interbank">Interbank</option>
                                <option value="Scotiabank">Scotiabank</option>
                                <option value="BBVA">BBVA</option>
                            </select>
                            <p class="text-red-500 text-xs italic"></p>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap -mx-3 mb-2 items-center justify-between">
                    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                        <button id="btnAgregar" class="flex-shrink-0 bg-gray-800 hover:bg-gray-600 border-gray-800 hover:border-gray-600 text-sm border-4 text-white py-2 px-4 rounded" type="submit">
                            <?php echo isset($proveedor) ? 'Actualizar' : 'Crear' ?>
                        </button>
                    </div>

                    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                        <button id="btnRegresar" class="flex-shrink-0 border-transparent border-4 bg-green-500 text-gray-800 hover:text-gray-800 text-sm py-2 px-4 rounded" type="button">
                            Regresar
                        </button>
                    </div>
                </div>
            </form>
            <!-- Fin formulario -->

        </div>
    </main>
    <?php require_once APP . '/views/layouts/footer.php' ?>
    <?php require_once APP . '/views/layouts/scripts.php' ?>

    <script>
        // Variables
        let idFormulario = "#proveedores_form";
        let rutaStore = "<?php echo BASE_URL . '/proveedores/store/' ?>";
        let rutaUpdate = "<?php echo BASE_URL . '/proveedores/update/:id' ?>"; // marcador :id para reemplazarlo despues con js

        // Cargamos el select del banco
        let banco = "<?php echo isset($proveedor) ? $proveedor->getBanco(): '' ?>";
        $('#banco').val(banco);

        // Configuramos el formulario con el crear y actualizar
        configFormulario(idFormulario, rutaStore, rutaUpdate, function() {
            $('#btnRegresar').click();
        }, mostrarMsjes);

        $('#btnRegresar').on('click', function(event) {
            event.preventDefault();
            window.location.href = "<?php echo BASE_URL . '/proveedores' ?>";
        });

        // Validaciones

        // ruc
        $('#ruc').on('input', function (e) {
            if (this.value.length > 11) {
                this.value = this.value.slice(0, 11); // Limitar a 8 caracteres
            }
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        // telefono
        $('#telefono').on('input', function (e) {
            if (this.value.length > 15) {
                this.value = this.value.slice(0, 15); // Limitar a 8 caracteres
            }
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        // celular
        $('#celular').on('input', function (e) {
            if (this.value.length > 15) {
                this.value = this.value.slice(0, 15); // Limitar a 8 caracteres
            }
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    </script>
</body>

</html>