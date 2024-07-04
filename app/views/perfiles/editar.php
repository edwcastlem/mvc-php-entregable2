<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo (isset($data['titulo'])) ? $data['titulo'] : 'SISTEMA DE GESTIÓN' ?></title>
    <?php require_once APP . '/views/layouts/head.php' ?>
</head>

<body>
    <?php require_once APP . '/views/layouts/header.php' ?>
    <main class="flex-grow flex items-center justify-center p-4 w-full max-w-screen-xl mx-auto">
        <div class="bg-white p-6 rounded shadow-md w-full">
            <h2 class="text-xl mb-4">
                <?php echo isset($perfil) ? 'Editar perfil' : 'Crear perfil' ?>
            </h2>
            <p class="my-4"><?php echo isset($perfil) ? 'Editando' : 'Creando' ?> tu perfil.</p>

            <form id="perfiles_form" class="w-full max-w-sm">
                <input type="hidden" id="id" name="id" value="<?php echo isset($perfil) ? $perfil->getId() : '' ?>">
                <div class="flex items-center border-b border-gray-800 py-2">
                    <input id="nombre" name="nombre" class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none" 
                    type="text" placeholder="Nombre categoría" value="<?php echo isset($perfil) ? $perfil->getNombre() : '' ?>">
                    <button id="btnAgregar" class="flex-shrink-0 bg-gray-800 hover:bg-gray-600 border-gray-800 hover:border-gray-600 text-sm border-4 text-white py-1 px-2 rounded" type="submit">
                    <?php echo isset($perfil) ? 'Actualizar' : 'Agregar' ?>
                    </button>
                    <button id="btnRegresar" class="flex-shrink-0 border-transparent border-4 text-gray-800 hover:text-gray-800 text-sm py-1 px-2 rounded" type="button">
                        Regresar
                    </button>
                </div>
            </form>
        </div>
    </main>
    <?php require_once APP . '/views/layouts/footer.php' ?>
    <?php require_once APP . '/views/layouts/scripts.php' ?>

    <script>
        $('#perfiles_form').on("submit", function (event) {
            event.preventDefault();

            let formulario = $(this);
            let ruta = "<?php echo BASE_URL . '/perfiles/store' ?>"; // por defecto creacion
            let metodo = "POST";
            let texts = ["Registro", 'Registrado'];
            // verificamos si hay id en el campo oculto para saber si es actualizacion o creacion
            let id = $('#id').val();

            if (id) {
                ruta = "<?php echo BASE_URL . '/perfiles/update/' ?>" + id;
                metodo = "PUT";
                texts = ["Actualización", "Actualizado"];
            }

            $.ajax({
                method: metodo,
                url: ruta,
                dataType: 'json',
                //timeout: 5000,
                data: formulario.serialize(), // enviamos todos los datos del formulario (atributo name)
                success: function(response) {
                    if( response.success ){
                        Swal.fire(texts[0], texts[1] + " con éxito!!", 'success')
                            .then((result) => {
                                if (result.isConfirmed) {
                                    $('#btnRegresar').click();
                                }
                            });
                        //formulario[0].reset();
                    }
                },
                error: function(response) {
                    console.log(response);
                    Swal.fire({
                            title: 'Error',
                            text: response.responseJSON.message,
                            icon: 'error',
                        });
                }
            });
        });

        $('#btnRegresar').on('click', function(event){
            event.preventDefault();
            window.location.href = "<?php echo BASE_URL . '/perfiles' ?>";
        });
    </script>
</body>

</html>