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
                <?php echo isset($categoria) ? 'Editar categoria' : 'Crear categoria' ?>
            </h2>
            <p class="my-4"><?php echo isset($categoria) ? 'Editando' : 'Creando' ?> la categoria.</p>

            <form id="categorias_form" class="w-full max-w-sm">
                <input type="hidden" id="id" name="id" value="<?php echo isset($categoria) ? $categoria->getId() : '' ?>">
                <div class="flex items-center border-b border-gray-800 py-2">
                    <input id="nombre" name="nombre" class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none" 
                    type="text" placeholder="Nombre categoría" value="<?php echo isset($categoria) ? $categoria->getNombre() : '' ?>">
                    <button id="btnAgregar" class="flex-shrink-0 bg-gray-800 hover:bg-gray-600 border-gray-800 hover:border-gray-600 text-sm border-4 text-white py-1 px-2 rounded" type="submit">
                        <?php echo isset($categoria) ? 'Actualizar' : 'Agregar' ?>
                    </button>
                    <button id="btnRegresar" class="flex-shrink-0 border-transparent border-4 text-gray-800 hover:text-gray-800 text-sm py-1 px-2 rounded" type="button">
                        Regresar
                    </button>
                </div>
                <p class="text-red-500 text-xs italic"></p>
            </form>
        </div>
    </main>
    <?php require_once APP . '/views/layouts/footer.php' ?>
    <?php require_once APP . '/views/layouts/scripts.php' ?>

    <script>
        // Variables
        let idFormulario = "#categorias_form";
        let rutaStore = "<?php echo BASE_URL . '/categorias/store' ?>";
        let rutaUpdate = "<?php echo BASE_URL . '/categorias/update/:id' ?>"; // marcador :id para reemplazarlo despues con js


        // Configuramos el formulario con el crear y actualizar
        configFormulario(idFormulario, rutaStore, rutaUpdate, function() {
            $('#btnRegresar').click();
        });

        $('#btnRegresar').on('click', function(event) {
            event.preventDefault();
            window.location.href = "<?php echo BASE_URL . '/categorias' ?>";
        });
    </script>
</body>

</html>