<?php

// Conexión a la base de datos MySQL
$servername = HOST;
$username = USER;
$password = PASSWORD;
$dbname = BD;

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Función para hashear la contraseña
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

// Insertar datos en la tabla perfiles
$conn->query("INSERT INTO perfiles (nombre) VALUES ('Administrador'), ('Vendedor'), ('Usuario')");

// Insertar datos en la tabla usuarios
$usuarios = [
    [1, 'Admin', 'Admin', 'admin@gmail.com', '12345678', 'Av. Siempre Viva 742', hashPassword('123456789')],
    [2, 'María', 'García', 'maria.garcia@gmail.com', '87654321', 'Calle Falsa 123', hashPassword('123456789')],
    [2, 'Carlos', 'Martínez', 'carlos.martinez@outlook.com', '11223344', 'Av. Las Palmeras 456', hashPassword('123456789')],
    [3, 'Ana', 'Fernández', 'ana.fernandez@gmail.com', '44332211', 'Jr. Los Robles 789', hashPassword('123456789')],
    [3, 'Luis', 'Rodríguez', 'luis.rodriguez@outlook.com', '99887766', 'Pasaje Los Olivos 321', hashPassword('123456789')]
];

$stmt = $conn->prepare("INSERT INTO usuarios (perfiles_id, nombre, apellido, email, dni, direccion, fecha_creacion, password, fecha_actualizacion) VALUES (?, ?, ?, ?, ?, ?, NOW(), ?, NOW())");
foreach ($usuarios as $usuario) {
    $stmt->bind_param("issssss", $usuario[0], $usuario[1], $usuario[2], $usuario[3], $usuario[4], $usuario[5], $usuario[6]);
    $stmt->execute();
}

// Insertar datos en la tabla categorias
$conn->query("INSERT INTO categorias (nombre) VALUES ('Computadoras'), ('Accesorios'), ('Monitores'), ('Impresoras'), ('Software')");

// Insertar datos en la tabla proveedores
$proveedores = [
    ['20100000001', 'Tecnología S.A.', 'Jorge Mendoza', 'info@tecnologia.com', '012345678', '987654321', 'Av. La Marina 1001', '1234567890', '00212345678901234567', 'Banco de Crédito'],
    ['20100000002', 'Innova Perú', 'Rosa Ramírez', 'contacto@innova.com', '012345679', '987654322', 'Calle Comercio 202', '1234567891', '00212345678901234568', 'BBVA'],
    ['20100000003', 'Distribuciones SAC', 'Carlos López', 'ventas@distribuciones.com', '012345680', '987654323', 'Jr. Industrial 303', '1234567892', '00212345678901234569', 'Interbank'],
    ['20100000004', 'Suministros EIRL', 'Ana Torres', 'contacto@suministros.com', '012345681', '987654324', 'Av. Progreso 404', '1234567893', '00212345678901234570', 'Scotiabank'],
    ['20100000005', 'CompuGlobal', 'Luis Díaz', 'info@compuglobal.com', '012345682', '987654325', 'Av. Innovación 505', '1234567894', '00212345678901234571', 'Banco Continental']
];

$stmt = $conn->prepare("INSERT INTO proveedores (ruc, razon_social, representante_legal, email, telefono, celular, direccion, cuenta_bancaria, cuenta_cci, banco, fecha_creacion, fecha_actualizacion) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())");
foreach ($proveedores as $proveedor) {
    $stmt->bind_param("ssssssssss", $proveedor[0], $proveedor[1], $proveedor[2], $proveedor[3], $proveedor[4], $proveedor[5], $proveedor[6], $proveedor[7], $proveedor[8], $proveedor[9]);
    $stmt->execute();
}

// Insertar datos en la tabla productos
$productos = [
    [1, 1, 'PC001', 'Laptop Acer', 'Laptop Acer Aspire 5', 'USD', 500.00, 700.00, 1],
    [2, 2, 'ACC001', 'Teclado Logitech', 'Teclado inalámbrico Logitech', 'PEN', 30.00, 50.00, 2],
    [3, 3, 'MON001', 'Monitor LG', 'Monitor LG 24 pulgadas', 'PEN', 100.00, 150.00, 3],
    [4, 4, 'IMP001', 'Impresora HP', 'Impresora multifuncional HP', 'USD', 200.00, 250.00, 4],
    [5, 5, 'SW001', 'Microsoft Office', 'Licencia Microsoft Office 365', 'USD', 80.00, 120.00, 5]
];

$stmt = $conn->prepare("INSERT INTO productos (categorias_id, proveedores_id, codigo, nombre, descripcion, moneda, precio_compra, precio_venta, fecha_creacion, fecha_actualizacion, usuarios_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW(), ?)");
foreach ($productos as $producto) {
    $stmt->bind_param("iissssddi", $producto[0], $producto[1], $producto[2], $producto[3], $producto[4], $producto[5], $producto[6], $producto[7], $producto[8]);
    $stmt->execute();
}

// Cerrar la conexión
$conn->close();

echo "Datos insertados correctamente.";
?>