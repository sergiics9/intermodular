-- Insertamos colores
INSERT INTO colores (nombre) VALUES 
('Blanco'), 
('Negro'), 
('Gris'), 
('Rojo');

-- Insertamos tallas
INSERT INTO tallas (nombre) VALUES 
('S'), 
('M'), 
('L'), 
('XL');

-- Insertamos artículos
INSERT INTO articulos (nombre, tipo) VALUES
('Camiseta Básica', 'camiseta'),       -- id = 1
('Sudadera con Capucha', 'sudadera'),  -- id = 2
('Gorra Snapback', 'gorra');           -- id = 3

-- Insertamos datos específicos de camiseta (id = 1)
INSERT INTO camisetas (id, manga) VALUES
(1, 'corta');

-- Insertamos datos específicos de sudadera (id = 2)
INSERT INTO sudaderas (id, capucha) VALUES
(2, TRUE);

-- Insertamos datos específicos de gorra (id = 3)
INSERT INTO gorras (id, tipo_ajuste) VALUES
(3, 'snapback');

-- Combinaciones de camiseta (id = 1)
INSERT INTO camiseta_talla_color (camiseta_id, talla_id, color_id, precio, stock, referencia) VALUES
(1, 1, 1, 14.99, 20, 'CAMISA-BAS-S-BLA'),
(1, 2, 2, 14.99, 15, 'CAMISA-BAS-M-NEG'),
(1, 3, 3, 14.99, 10, 'CAMISA-BAS-L-GRI');

-- Combinaciones de sudadera (id = 2)
INSERT INTO sudadera_talla_color (sudadera_id, talla_id, color_id, precio, stock, referencia) VALUES
(2, 2, 2, 29.99, 12, 'SUDA-HOOD-M-NEG'),
(2, 3, 1, 29.99, 8,  'SUDA-HOOD-L-BLA'),
(2, 4, 3, 29.99, 6,  'SUDA-HOOD-XL-GRI');

-- Combinaciones de gorra (id = 3)
INSERT INTO gorra_color (gorra_id, color_id, precio, stock, referencia) VALUES
(3, 1, 12.99, 30, 'GORRA-SNAP-BLA'),
(3, 2, 12.99, 25, 'GORRA-SNAP-NEG'),
(3, 4, 12.99, 20, 'GORRA-SNAP-ROJ');
