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
                Producto: <?php echo $producto->getNombre() ?>
            </h2>

            <!-- Formulario -->
            <form id="productos_form" class="w-full max-w-lg">
                <input id="id" name="id" type="hidden" value="<?php echo $producto->getId() ?>">
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="categoria_id">
                            Categoría
                        </label>
                        <div class="relative">
                            <select disabled class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="categorias_id" name="categorias_id">
                                <option><?php echo $producto->getCategoria()->getNombre() ?></option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="w-full md:w-1/2 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="codigo">
                            Código
                        </label>
                        <input disabled class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="codigo" name="codigo" type="text" placeholder="Tiendas ACME" value="<?php echo isset($producto) ? $producto->getCodigo() : '' ?>">
                    </div>
                </div>

                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full w px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="representante_legal">
                            Nombre
                        </label>
                        <input disabled class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="representante_legal" name="representante_legal" type="text" placeholder="Juan Perez" value="<?php echo isset($producto) ? $producto->getNombre() : '' ?>">
                    </div>
                </div>

                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="email">
                            Descripción
                        </label>
                        <textarea disabled id="descripcion" name="descripcion" rows="2" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Escribe una descripción..."><?php echo $producto->getDescripcion() ?></textarea>
                    </div>
                </div>

                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="proveedores_id">
                            Proveedor
                        </label>
                        <div class="relative">
                            <select disabled class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="proveedores_id" name="proveedores_id">
                                <option><?php echo $producto->getProveedor()->getRazonSocial() ?></option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="moneda">
                            Moneda
                        </label>
                        <div class="relative">
                            <select disabled class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="moneda" name="moneda">
                                <option value=""><?php echo $producto->getMoneda() ?></option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="precio_compra">
                            Precio Compra
                        </label>
                        <input disabled class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="precio_compra" name="precio_compra" type="text" placeholder="125.00" value="<?php echo isset($producto) ? $producto->getPrecioCompra() : '' ?>">
                    </div>
                    <div class="w-full px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="precio_venta">
                            Precio Venta
                        </label>
                        <input disabled class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="precio_venta" name="precio_venta" type="text" placeholder="130.00" value="<?php echo isset($producto) ? $producto->getPrecioVenta() : '' ?>">
                    </div>
                </div>

                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="email">
                            Modificado por ultima vez
                        </label>
                        <input disabled class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            id="email" name="email" type="text" value="<?php echo $producto->getUsuario()->getNombre() . " " . $producto->getUsuario()->getApellido() . " - " . $producto->getUsuario()->getEmail() ?>">
                    </div>
                </div>

                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="fecha_creacion">
                            Fecha de Creación
                        </label>
                        <input disabled class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                            id="fecha_creacion" type="text" value="<?php echo $producto->getFechaCreacion()->format('d/m/Y H:i') ?>">
                    </div>
                    <div class="w-full px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="fecha_actualizacion">
                            Fecha de Actualización
                        </label>
                        <input disabled class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            id="fecha_actualizacion" type="text" value="<?php echo $producto->getFechaActualizacion()->format('d/m/Y H:i') ?>">
                    </div>
                </div>

                <div class="flex flex-wrap -mx-3 mb-2 items-center justify-between">
                    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                        <button id="btnRegresar" class="flex-shrink-0 border-transparent border-4 bg-green-500 text-gray-800 hover:text-gray-800 text-sm py-2 px-4 rounded" type="button">
                            Regresar
                        </button>
                    </div>

                    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                        <button id="btnModificar" class="flex-shrink-0 bg-gray-800 hover:bg-gray-600 border-gray-800 hover:border-gray-600 text-sm border-4 text-white py-2 px-4 rounded" type="submit">
                            Modificar
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
        $('#btnRegresar').on('click', function(event) {
            event.preventDefault();
            window.location.href = "<?php echo BASE_URL . '/productos' ?>";
        });

        $('#btnModificar').on('click', function(event) {
            event.preventDefault();
            window.location.href = "<?php echo BASE_URL . '/productos/edit/' ?>" + $('#id').val();;
        });
    </script>
</body>

</html>