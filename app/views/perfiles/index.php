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
            <h2 class="text-xl mb-4">Perfiles</h2>
            <p class="my-4">Administra los perfiles de usuario.</p>

            <form method="GET" action="<?php echo BASE_URL . '/perfiles/create' ?>">
                <button type="submit" class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded-lg bg-gray-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-2 -ml-1" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z" />
                    </svg>
                    Agregar perfil
                </button>
            </form>

            <div class="my-4 w-1/2">
                <table id="tabla">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Perfil</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <?php require_once APP . '/views/layouts/footer.php' ?>
    <?php require_once APP . '/views/layouts/scripts.php' ?>

    <script>
        // Variables
        let idTabla = "#tabla"; // con selector #
        let rutaList = '<?php echo BASE_URL . "/perfiles/list/" ?>';
        let rutaEdit = ruta = '<?php echo BASE_URL . "/perfiles/edit/:id" ?>';
        let rutaDestroy = "<?php echo BASE_URL . '/perfiles/destroy/:id' ?>";


        // Configuramos el datatables, el parametro Columns contiene las columnas del datatable
        configDatatables(idTabla, rutaList, [
            { data: 'id', visible: false },
            { data: 'nombre' },
        ]);

        // Configuramos la accion de editar dentro de datatables
        configEditar(idTabla, rutaEdit);

        // Configuramos la acción de eliminar dentro del datatables
        configEliminar(idTabla, rutaDestroy);
    </script>

</body>

</html>