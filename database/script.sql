-- 
-- Bd gestion
--

CREATE DATABASE bdgestion;

USE bdgestion;

CREATE TABLE perfiles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(30)
);

CREATE TABLE usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    perfiles_id INT NOT NULL,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    email VARCHAR(60) UNIQUE,
    dni VARCHAR(8) UNIQUE,
    direccion VARCHAR(60),
    fecha_creacion DATETIME NOT NULL,
    password VARCHAR(255) NOT NULL,
    fecha_actualizacion DATETIME NOT NULL,
    FOREIGN KEY (perfiles_id) REFERENCES perfiles(id)
);

CREATE TABLE categorias (
    id INT PRIMARY KEY AUTO_INCREMENT, 
    nombre VARCHAR(50)
);

CREATE TABLE proveedores (
    id INT PRIMARY KEY AUTO_INCREMENT,
    ruc VARCHAR(15) NOT NULL UNIQUE,
    razon_social VARCHAR(50) UNIQUE,
    representante_legal VARCHAR(50),
    email VARCHAR(20) UNIQUE,
    telefono VARCHAR(15),
    celular VARCHAR(15),
    direccion VARCHAR(50),
    cuenta_bancaria VARCHAR(20),
    cuenta_cci VARCHAR(30),
    banco VARCHAR(45),
    fecha_creacion DATETIME NOT NULL,
    fecha_actualizacion DATETIME NOT NULL
);

CREATE TABLE productos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    categorias_id INT NOT NULL,
    proveedores_id INT NOT NULL,
    codigo VARCHAR(5) UNIQUE,
    nombre VARCHAR(50) NOT NULL,
    descripcion VARCHAR(100),
    moneda VARCHAR(3) NOT NULL,
    precio_compra DECIMAL(10,2) NOT NULL,
    precio_venta DECIMAL(10,2) NOT NULL,
    fecha_creacion DATETIME NOT NULL,
    fecha_actualizacion DATETIME NOT NULL,
    usuarios_id INT NOT NULL,
    FOREIGN KEY (usuarios_id) REFERENCES usuarios(id),
    FOREIGN KEY (categorias_id) REFERENCES categorias(id),
    FOREIGN KEY (proveedores_id) REFERENCES proveedores(id)
);

-- Inserts iniciales

INSERT INTO perfiles (nombre) 
VALUES  ('Administración'), 
        ('Usuario'), 
        ('Vendedor');

INSERT INTO categorias (nombre) 
VALUES  ('Laptops'), 
        ('Sobremesa'), 
        ('Impresoras');


-- Vistas
CREATE or REPLACE VIEW listar_usuarios
AS
    select u.id, p.nombre as perfil, u.nombre, u.apellido, u.dni, u.email, u.direccion, u.fecha_creacion, u.fecha_actualizacion
    from usuarios u
    inner join perfiles p on u.perfiles_id = p.id

CREATE OR REPLACE VIEW listar_productos
AS
    select 
        p.id as id, p.categorias_id, c.nombre as categorias_nombre, p.codigo, p.nombre, p.descripcion, p.proveedores_id, pr.razon_social,
        p.moneda, p.precio_compra, p.precio_venta, p.usuarios_id, u.email as usuarios_email, p.fecha_creacion, p.fecha_actualizacion
    from productos p 
    inner join categorias c on p.categorias_id = c.id
    inner join proveedores pr on p.proveedores_id = pr.id
    inner join usuarios u on p.usuarios_id = u.id;


                { data: 'id', visible: false },
            { data: 'categorias_id', visible: false },
            { data: 'categorias_nombre' },
            { data: 'codigo' },
            { data: 'nombre' },
            { data: 'descripcion' },
            { data: 'proveedores_id', visible: false },
            { data: 'proveedores_nombre' },
            { data: 'moneda' },
            { data: 'precio_compra' },
            { data: 'precio_venta' },
            { data: 'usuarios_id', visible: false },
            { data: 'usuarios_email' },
            { data: 'fecha_creacion' },
            { data: 'fecha_actualizacion' }