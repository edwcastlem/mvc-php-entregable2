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



        // Configuración del datatables
        $(idTabla).DataTable( {
            ajax: rutaList,
            columns: [
                { data: 'id', visible: false },
                { data: 'nombre' },
                {
                    // Columna extra con las opciones de fila
                    data: null,
                    defaultContent: `
                        <div class="flex justify-center">
                            <a href="#" class="btn-editar mr-4">
                                <svg class="h-6 w-6 text-gray-800" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                            </a>
                            <a href="#" class="btn-eliminar mr-4">
                                <svg class="h-6 w-6 text-red-800" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m6 4.125 2.25 2.25m0 0 2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                                </svg>
                            </a>
                        </div>
                    `
                }
            ],
            language: {
                emptyTable: "No hay datos en la tabla!",
                info: "Mostrando _START_ to _END_ de _TOTAL_ registros",
                infoEmpty: "Mostrando 0 de 0 de 0 registros",
                infoFiltered: "(filtrando de _MAX_ total de registros)",
                lengthMenu: "_MENU_ registros por página",
                loadingRecords: "Cargando...",
                processing: "",
                search: "Buscar:",
                zeroRecords: "No hay registros encontrados"
            }
        });

        // Configuramos el editar y eliminar del datatables
        // los llamaremos mediante la clase 'opt-editar' y 'opt-eliminar'
        $(idTabla + ' tbody').on('click', 'a.btn-editar', function(event) {
            event.preventDefault(); // para que no se ejecute el click en el enlace

            let filaObj = $(this).closest('tr'); // primer tr encima de a.btn-editar
            let fila = $(idTabla).DataTable().row(filaObj).data(); // carga toda la fila del datatables del tr anterior

            // llamamos a la ruta pasandole la fila del datatables
            let ruta = rutaEdit.replace(':id', fila.id);
            
            window.location.href = ruta;

            console.log(fila);

            //$(campoId).val(fila.id); //cargamos el id en el campo oculto
            
            // leemos los datos del dtatables
            

            //console.log(response.data);

            
        });

        $(idTabla + ' tbody').on('click', 'a.btn-eliminar', function(event) {
            event.preventDefault();
            let filaObj = $(this).closest('tr'); // primer tr encima de a.btn-editar
            let fila = $(idTabla).DataTable().row(filaObj).data(); // carga toda la fila del datatables del tr anterior

            let ruta = rutaDestroy.replace(':id', fila.id);

            Swal.fire({
                title: '¿Estás seguro?',
                text: '¡No podrás revertir esto!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminarlo',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url:  ruta,
                        method: 'DELETE',
                        success: function (response) {
                            Swal.fire('¡Eliminado!', 'Se eliminó el registro.', 'success');
                            $(idTabla).DataTable().ajax.reload(); //recarga el datatable
                        },
                        error: function (xhr, status, error) {
                            Swal.fire('Error', 'No se pudo eliminar el registro.', 'error');
                        }
                    });
                    console.log("ID enviado: " + data.id);
                }
            });
        });
    </script>

</body>

</html>