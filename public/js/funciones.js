function configDatatables(idTabla, rutaList, columns, botonesExtras = false, opcionesColumnas = [])
{
    // Configuración del datatables
    $(idTabla).DataTable( {
        ajax: rutaList,
        columns: columns.concat(
            {
                // Columna extra con las opciones de fila
                data: null,
                defaultContent: `
                    <div class="flex justify-center">
                        <a href="#" class="btn-ver mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 text-gray-800 size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v16.5c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Zm3.75 11.625a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                            </svg>
                        </a>
                        <a href="#" class="btn-editar mr-4">
                            <svg class="h-6 w-6 text-gray-800 size-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                            </svg>
                        </a>
                        <a href="#" class="btn-eliminar mr-4">
                            <svg class="h-6 w-6 text-red-800 size-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m6 4.125 2.25 2.25m0 0 2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                            </svg>
                        </a>
                        ${ botonesExtras ? botonesExtras : '' }
                    </div>`
            }
        ),
        columnDefs: opcionesColumnas,
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
}

/**
 * 
 * @param {*} idTabla Selector con el id de la tabla a aplicar la configuracion para editar
 * @param {*} rutaEdit La ruta a llamar al momento de darle click al editar
 * @param {*} selectorAplicado El selector a cual se aplicara la acción
 */
function configEditar(idTabla, rutaEdit, selectorAplicado = 'a.btn-editar')
{
    // Configuramos el editar y eliminar del datatables
    // los llamaremos mediante la clase 'opt-editar' y 'opt-eliminar'
    $(idTabla + ' tbody').on('click', selectorAplicado, function(event) {
        event.preventDefault(); // para que no se ejecute el click en el enlace

        let filaObj = $(this).closest('tr'); // primer tr encima de a.btn-editar
        let fila = $(idTabla).DataTable().row(filaObj).data(); // carga toda la fila del datatables del tr anterior

        // llamamos a la ruta pasandole la fila del datatables
        let ruta = rutaEdit.replace(':id', fila.id);
        
        window.location.href = ruta;

        console.log(fila);
    });
}

/**
 * 
 * @param {*} idTabla Selector con el id de la tabla a aplicar la configuracion para editar, debe tener el #
 * @param {*} rutaDestroy La ruta a llamar al momento de darle click en eliminar
 * @param {*} selectorAplicado El selector a cual se aplicara la acción
 */
function configEliminar(idTabla, rutaDestroy, selectorAplicado = 'a.btn-eliminar')
{
    $(idTabla + ' tbody').on('click', selectorAplicado, function(event) {
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
                        if (response.success) {
                            Swal.fire('¡Eliminado!', response.message, 'success');
                            $(idTabla).DataTable().ajax.reload(); //recarga el datatable
                        } 
                        else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    }
                });
                console.log("ID enviado: " + fila.id);
            }
        });
    });
}

function configShow(idTabla, rutaShow, selectorAplicado = 'a.btn-ver')
{
    $(idTabla + ' tbody').on('click', selectorAplicado, function(event) {
        event.preventDefault();
        let filaObj = $(this).closest('tr'); // primer tr encima de a.btn-editar
        let fila = $(idTabla).DataTable().row(filaObj).data(); // carga toda la fila del datatables del tr anterior

        let ruta = rutaShow.replace(':id', fila.id);

        window.location.href = ruta;
    });
}

/**
 * 
 * @param {*} idSelect id del select html al que se aplicara la funcion (debe tener el #)
 * @param {*} ruta la ruta de donde se cargaran las opciones
 * @param {*} idSeleccionado Id que deberá seleccionarse despues de cargar los datos...
 * @returns Carga el select mediante ajax con la ruta especificada, siempre carga clave, valor, el select debe estar vacio
 */
function cargarSelect(idSelect, ruta, idSeleccionado = "") {
    let select = $(idSelect)[0];
    
    $.ajax({
        url: ruta,
        method: 'GET',
        success: function (response) {
            if (response.success) {
                select.innerHTML = '<option value="">Seleccionar</option>';
                
                for (const item of response.data) { // of para iterar un array
                    select.innerHTML += `<option value="${item.id}">${item.nombre}</option>`;
                    console.log(`Clave: ${item.id}  valor: ${item.nombre}`);
                }
    
                select.value = idSeleccionado;
                console.log(idSeleccionado);
            }
            else {
                console.log(response);
            }
        }
    });
}

/**
 * Configura la creacion y actualización en un formulario, toma por defecto todos los campos
 * que tienen el atributo name asignado. Para enviar el id al actualizar, se debe tener en
 * el formulario un campo hidden llamado id, si tiene algún valor, considera que se hará
 * una creación, en caso contrario considera que se hace una actualización.
 * @param {*} idFormulario Id del formulario en forma de selector (con el #) 
 * @param {*} rutaStore ruta a donde se hara el guardado
 * @param {*} rutaUpdate ruta a donde se hara la actualización
 * @param {*} accionesOkCallback Despues del mensaje de confirmacion, se puede configurar 
 * alguna acción mediante este callback.
 *  
 */
function configFormulario(idFormulario, rutaStore, rutaUpdate, accionesOkCallback = () => {})
{
    $(idFormulario).on("submit", function(event) {
        event.preventDefault();

        let formulario = $(this);
        let ruta = rutaStore; // por defecto creacion
        let metodo = "POST";
        let texts = ["Registro", 'Registrado'];
        // verificamos si hay id en el campo oculto para saber si es actualizacion o creacion
        let id = $('#id').val();

        if (id) {
            ruta = rutaUpdate.replace(':id', id);
            metodo = "PUT";
            texts = ["Actualización", "Actualizado"];
        }

        $.ajax({
            method: metodo,
            url: ruta,
            dataType: 'json',
            data: formulario.serialize(), // enviamos todos los datos del formulario (atributo name)
            success: function(response) {
                if (response.success) {
                    Swal.fire(texts[0], texts[1] + " con éxito!!", 'success')
                        .then((result) => {
                            if (result.isConfirmed) {
                                accionesOkCallback();
                            }
                        });
                }
                else {
                    console.log(response);
                    Swal.fire({
                        title: 'Error',
                        text: response.message,
                        icon: 'error',
                    });
                }
            }
        });
    });
}