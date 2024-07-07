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
                Restablecer contraseña
            </h2>
            <p class="my-4">
            Si olvidaste tu contraseña, utiliza esto para recuperarla.
            </p>

            <!-- Formulario -->
            <form id="restablecer_form" class="w-full max-w-lg">
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full md:w-4/5 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="email">
                            Email
                        </label>
                        <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            id="email" name="email" type="text" placeholder="jperez@gmail.com">
                    </div>
                </div>


                <div class="flex flex-wrap -mx-3 mb-2 items-center justify-between">
                    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                        <button id="btnRestablecer" class="flex-shrink-0 bg-gray-800 hover:bg-gray-600 border-gray-800 hover:border-gray-600 text-sm border-4 text-white py-2 px-4 rounded" type="submit">
                            Restablecer
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
        $('#restablecer_form').on('submit', function(event){
            event.preventDefault();

            $.ajax({
                url: "<?php echo BASE_URL . '/login/verificar_email' ?>",
                method: 'POST',
                data: $(this).serialize(), // enviamos todos los campos name del formulario
                success: function(response) {
                    if (response.success) {
                        window.location.href = "<?php echo BASE_URL . '/login/cambiar_contra' ?>";
                    }
                    else {
                        Swal.fire({
                            title: 'Error',
                            text: response.message,
                            icon: 'error',
                        });
                    }
                }
            });
        });

        // Boton regresar
        $('#btnRegresar').on('click', function(event){
            window.location.href = "<?php echo BASE_URL . '/login' ?>";
        });
    </script>
</body>

</html>