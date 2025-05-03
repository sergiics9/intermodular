-- Combinaciones camiseta + talla + color
CREATE TABLE camiseta_talla_color (
    id INT AUTO_INCREMENT PRIMARY KEY,
    camiseta_id INT,
    talla_id INT,
    color_id INT,
    precio DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL,
    referencia VARCHAR(50),
    UNIQUE (camiseta_id, talla_id, color_id),
    FOREIGN KEY (camiseta_id) REFERENCES camisetas(id),
    FOREIGN KEY (talla_id) REFERENCES tallas(id),
    FOREIGN KEY (color_id) REFERENCES colores(id)
);

-- Combinaciones sudadera + talla + color
CREATE TABLE sudadera_talla_color (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sudadera_id INT,
    talla_id INT,
    color_id INT,
    precio DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL,
    referencia VARCHAR(50),
    UNIQUE (sudadera_id, talla_id, color_id),
    FOREIGN KEY (sudadera_id) REFERENCES sudaderas(id),
    FOREIGN KEY (talla_id) REFERENCES tallas(id),
    FOREIGN KEY (color_id) REFERENCES colores(id)
);

-- Combinaciones gorra + color (gorras no tienen talla)
CREATE TABLE gorra_color (
    id INT AUTO_INCREMENT PRIMARY KEY,
    gorra_id INT,
    color_id INT,
    precio DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL,
    referencia VARCHAR(50),
    UNIQUE (gorra_id, color_id),
    FOREIGN KEY (gorra_id) REFERENCES gorras(id),
    FOREIGN KEY (color_id) REFERENCES colores(id)
);
