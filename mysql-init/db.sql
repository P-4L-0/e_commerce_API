CREATE USER IF NOT EXISTS 'user'@'%' IDENTIFIED BY 'secret';

CREATE DATABASE e_commerce;

GRANT ALL PRIVILEGES ON e_commerce.* TO 'user'@'%';
FLUSH PRIVILEGES;

USE e_commerce;

CREATE TABLE usuarios (
    id int AUTO_INCREMENT PRIMARY KEY,
    nombre varchar(30) NOT NULL,
    email varchar(100) UNIQUE NOT NULL,
    direccion varchar(100) NOT NULL,
    telefono char(15) NOT NULL,
    contrasenia varchar(255) NOT NULL,
    rol varchar(10) DEFAULT 'user'
);

CREATE TABLE categoria(
    codigo int AUTO_INCREMENT PRIMARY KEY,
    nombre varchar(50) NOT NULL
);

CREATE TABLE productos(
    id int AUTO_INCREMENT PRIMARY KEY,
    nombre varchar(50) NOT NULL,
    descripcion LONGTEXT NOT NULL,
    precio decimal(18,2) NOT NULL,
    stock int NOT NULL,
    CodigoCategoria int,
    FOREIGN KEY (CodigoCategoria) REFERENCES categoria(codigo) ON DELETE CASCADE
    ON UPDATE CASCADE 
);

CREATE TABLE carrito(
    id int AUTO_INCREMENT PRIMARY KEY,
    usuario_id int,
    producto_id int,
    total decimal(18,2),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (producto_id) REFERENCES productos(id) ON UPDATE CASCADE
);

CREATE TABLE envios(
    id int AUTO_INCREMENT PRIMARY KEY,
    cliente_id int,
    empresa_envio varchar(100) NOT NULL,
    estado varchar(30) NOT NULL,
    FOREIGN KEY (cliente_id) REFERENCES usuarios(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE resenias(
    id int AUTO_INCREMENT PRIMARY KEY,
    usuario_id int,
    producto_id int,
    comentario LONGTEXT NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
    ON UPDATE CASCADE,
    FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE CASCADE 
    ON UPDATE CASCADE
);