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
            <h2 class="text-xl mb-4">Login</h2>
            <p class="my-4">Usa tu email y contraseña para iniciar sesión</p>

            <div class="w-full max-w-sm">
                <form id="login_form" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                            Email
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" name="email" type="text" placeholder="jperez@gmailcom">
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                            Contraseña
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" name="password" type="password" placeholder="**************">
                        <!-- <p class="text-red-500 text-xs italic">Please choose a password.</p> -->
                    </div>
                    <div class="flex items-center justify-between">
                        <button id="btnLogin" class="bg-gray-800 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                            Iniciar sesión
                        </button>
                        <a class="inline-block align-baseline font-bold text-sm text-gray-800 hover:text-blue-800" 
                            href="<?php echo BASE_URL . '/login/restablecer' ?>">
                            Restablecer contraseña
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <?php require_once APP . '/views/layouts/footer.php' ?>
    <?php require_once APP . '/views/layouts/scripts.php' ?>

    <script>
        $('#login_form').on('submit', function(event) {
            event.preventDefault();

            console.log($(this).serialize());

            $.ajax({
                url: '<?php echo BASE_URL . "/login/iniciar_sesion" ?>',
                method: 'POST',
                data: $(this).serialize(),
                success: function(data) {
                    if (data.success) {
                        window.location.href = "<?php echo BASE_URL . '/pagina/index' ?>";
                    }
                    else {
                        Swal.fire({
                            title: 'Error',
                            text: data.message,
                            icon: 'error',
                        });
                    }
                }
            });
        });
    </script>

</body>

</html>