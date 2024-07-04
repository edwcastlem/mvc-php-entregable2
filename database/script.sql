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
    email VARCHAR(20) UNIQUE,
    dni VARCHAR(8) UNIQUE,
    direccion VARCHAR(60),
    fecha_creacion DATETIME NOT NULL,
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