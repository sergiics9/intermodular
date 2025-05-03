-- Tabla principal de artículos
CREATE TABLE articulos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    tipo ENUM('camiseta', 'sudadera', 'gorra') NOT NULL
);

-- Tabla de camisetas (hereda id de articulos)
CREATE TABLE camisetas (
    id INT PRIMARY KEY,
    manga ENUM('corta', 'larga') NOT NULL,
    FOREIGN KEY (id) REFERENCES articulos(id)
);

-- Tabla de sudaderas (hereda id de articulos)
CREATE TABLE sudaderas (
    id INT PRIMARY KEY,
    capucha BOOLEAN NOT NULL,
    FOREIGN KEY (id) REFERENCES articulos(id)
);

-- Tabla de gorras (hereda id de articulos)
CREATE TABLE gorras (
    id INT PRIMARY KEY,
    tipo_ajuste VARCHAR(50) NOT NULL,
    FOREIGN KEY (id) REFERENCES articulos(id)
);

-- Tabla de tallas
CREATE TABLE tallas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(20) NOT NULL
);

-- Tabla de colores
CREATE TABLE colores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(30) NOT NULL
);

