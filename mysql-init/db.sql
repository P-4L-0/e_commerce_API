CREATE USER 'user'@'%' IDENTIFIED BY 'secret';

CREATE DATABASE IF NOT EXISTS e_commerce;

GRANT ALL PRIVILEGES ON e_commerce.* TO 'user'@'%';
FLUSH PRIVILEGES;

USE e_commerce;

CREATE TABLE IF NOT EXISTS usuarios (
    id int AUTO_INCREMENT PRIMARY KEY,
    nombre varchar(30) NOT NULL,
    email varchar(100) UNIQUE NOT NULL,
    direccion varchar(100) NOT NULL,
    telefono char(15) NOT NULL,
    contrasenia varchar(255) NOT NULL,
    rol varchar(10) DEFAULT 'user'
);

CREATE TABLE IF NOT EXISTS categoria(
    codigo int AUTO_INCREMENT PRIMARY KEY,
    nombre varchar(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS productos(
    id int AUTO_INCREMENT PRIMARY KEY,
    nombre varchar(50) NOT NULL,
    descripcion LONGTEXT NOT NULL,
    precio decimal(18,2) NOT NULL,
    stock int NOT NULL,
    CodigoCategoria int,
    FOREIGN KEY (CodigoCategoria) REFERENCES categoria(codigo) ON DELETE CASCADE
    ON UPDATE CASCADE 
);

CREATE TABLE IF NOT EXISTS carrito(
    id int AUTO_INCREMENT PRIMARY KEY,
    usuario_id int NOT NULL,
    producto_id int NOT NULL,
    cantidad_producto iNT NOT NULL CHECK (cantidad_producto > 0),
    precio decimal(10,2),
    total decimal(18,2) GENERATED ALWAYS AS (cantidad_producto * precio) STORED,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (producto_id) REFERENCES productos(id) ON UPDATE CASCADE
);

INSERT INTO categoria (nombre) VALUES
('Electrónica'),
('Ropa'),
('Hogar'),
('Juguetes'),
('Deportes'),
('Salud y Belleza'),
('Libros'),
('Automotriz'),
('Mascotas'),
('Alimentos y Bebidas');

INSERT INTO productos (nombre, descripcion, precio, stock, CodigoCategoria) VALUES
('Laptop ASUS', 'Laptop ASUS con procesador Intel Core i5, 8GB RAM y 512GB SSD.', 4500, 15, 1),
('Camiseta Negra', 'Camiseta de algodón color negro, talla M.', 100, 50, 2),
('Sofá de 3 Plazas', 'Sofá de tela gris con cojines cómodos, ideal para sala.', 2500, 10, 3),
('LEGO Star Wars', 'Set de construcción LEGO de la Estrella de la Muerte.', 700, 20, 4),
('Bicicleta de Montaña', 'Bicicleta todo terreno con frenos de disco y suspensión.', 2500, 8, 5),
('Crema Hidratante', 'Crema facial hidratante con ácido hialurónico.', 90, 30, 6),
('El Principito', 'Libro clásico de Antoine de Saint-Exupéry.', 50, 100, 7),
('Aceite para Motor 5W-30', 'Aceite sintético premium para motores de gasolina.', 250, 25, 8),
('Comida para Perro 10kg', 'Alimento balanceado para perros adultos.', 200, 40, 9),
('Café Orgánico 500g', 'Café de grano 100% orgánico, tostado medio.', 120, 35, 10);



