-- ───── LIMPIEZA (sin tocar tablas de seguridad) ─────
SET FOREIGN_KEY_CHECKS = 0;

DELETE FROM DETALLEPEDIDO;
ALTER TABLE DETALLEPEDIDO AUTO_INCREMENT = 1;

DELETE FROM REPARTOPEDIDO;
ALTER TABLE REPARTOPEDIDO AUTO_INCREMENT = 1;

DELETE FROM DIRECCION;
ALTER TABLE DIRECCION AUTO_INCREMENT = 1;

DELETE FROM DATOSPRODUCTO;
ALTER TABLE DATOSPRODUCTO AUTO_INCREMENT = 1;

DELETE FROM CREDITO;
ALTER TABLE CREDITO AUTO_INCREMENT = 1;

DELETE FROM FACTURA;
ALTER TABLE FACTURA AUTO_INCREMENT = 1;

DELETE FROM PEDIDO;
ALTER TABLE PEDIDO AUTO_INCREMENT = 1;

DELETE FROM TIPOEVENTO;
ALTER TABLE TIPOEVENTO AUTO_INCREMENT = 1;

DELETE FROM REPARTIDOR;
ALTER TABLE REPARTIDOR AUTO_INCREMENT = 1;

DELETE FROM CLIENTE;
ALTER TABLE CLIENTE AUTO_INCREMENT = 1;

DELETE FROM SUCURSAL;
ALTER TABLE SUCURSAL AUTO_INCREMENT = 1;

DELETE FROM PRODUCTO;
ALTER TABLE PRODUCTO AUTO_INCREMENT = 1;

DELETE FROM CATEGORIAPRODUCTO;
ALTER TABLE CATEGORIAPRODUCTO AUTO_INCREMENT = 1;

DELETE FROM DISTRITO;
ALTER TABLE DISTRITO AUTO_INCREMENT = 1;

DELETE FROM MUNICIPIO;
ALTER TABLE MUNICIPIO AUTO_INCREMENT = 1;

DELETE FROM DEPARTAMENTO;
ALTER TABLE DEPARTAMENTO AUTO_INCREMENT = 1;

SET FOREIGN_KEY_CHECKS = 1;

-- Datos para DEPARTAMENTO
REPLACE INTO DEPARTAMENTO (ID_DEPARTAMENTO, NOMBRE_DEPARTAMENTO, ACTIVO_DEPARTAMENTO) VALUES
    (1, 'San Salvador', 1),
    (2, 'La Libertad',   1),
    (3, 'Santa Ana',      1),
    (4, 'San Miguel',     1),
    (5, 'Usulután',       1);

-- Datos para MUNICIPIO
REPLACE INTO MUNICIPIO (ID_DEPARTAMENTO, ID_MUNICIPIO, NOMBRE_MUNICIPIO, ACTIVO_MUNICIPIO) VALUES
    (1, 1, 'San Salvador',      1),
    (2, 1, 'Santa Tecla',       1),
    (3, 1, 'Metapán',           1),
    (4, 1, 'Ciudad Barrios',    1),
    (5, 1, 'Santiago de María', 1);

-- Datos para DISTRITO
REPLACE INTO DISTRITO (ID_DEPARTAMENTO, ID_MUNICIPIO, ID_DISTRITO, NOMBRE_DISTRITO, CODIGO_POSTAL) VALUES
    (1, 1, 1, 'Centro',          '1101'),
    (2, 1, 1, 'Merliot',         '1102'),
    (3, 1, 1, 'Metapán Norte',   '1103'),
    (4, 1, 1, 'Ciudad Pacífica','1104'),
    (5, 1, 1, 'Puerto Parada','  1105');

-- Datos para CATEGORIAPRODUCTO
REPLACE INTO CATEGORIAPRODUCTO (
    ID_CATEGORIAPRODUCTO,
    NOMBRE_CATEGORIA,
    DESCRIPCION_CATEGORIA,
    DISPONIBLE_CATEGORIA,
    HORA_DISPONIBLE_DESDE,
    HORA_DISPONIBLE_HASTA,
    ACTIVO_CATEGORIAPRODUCTO
) VALUES
    (1, 'Antojitos',        'Comida típica',            1, '15:00', '18:00', 1),
    (2, 'Bebidas',          'Bebidas frías',            1, '00:00', '23:59', 1),
    (3, 'Comidas rápidas',  'Hamburguesas y hotdogs',   1, '10:00', '22:00', 1),
    (4, 'Postres',          'Dulces típicos',           1, '12:00', '20:00', 1),
    (5, 'Platos fuertes',   'Almuerzos tradicionales',  1, '11:00', '15:00', 1);

-- Datos para PRODUCTO
REPLACE INTO PRODUCTO (
    ID_PRODUCTO,
    ID_CATEGORIAPRODUCTO,
    NOMBRE_PRODUCTO,
    DESCRIPCION_PRODUCTO,
    ACTIVO_PRODUCTO
) VALUES
    (1, 1, 'Pupusa de Queso',     'Clásica pupusa salvadoreña',              1),
    (2, 1, 'Pupusa Revueltas',    'Con chicharrón, queso y frijoles',       1),
    (3, 2, 'Horchata',            'Bebida tradicional salvadoreña',         1),
    (4, 3, 'Hamburguesa',         'Con papas y bebida',                     1),
    (5, 4, 'Empanada de Plátano', 'Rellena de leche',                       1);

-- Datos para SUCURSAL
REPLACE INTO SUCURSAL (
    ID_SUCURSAL,
    ID_DEPARTAMENTO,
    ID_MUNICIPIO,
    ID_DISTRITO,
    NOMBRE_SUCURSAL,
    DIRECCION_SUCURSAL,
    TELEFONO_SUCURSAL,
    HORARIO_APERTURA_SUCURSAL,
    HORARIO_CIERRE_SUCURSAL,
    ACTIVO_SUCURSAL
) VALUES
    (1, 1, 1, 1, 'Sucursal Centro',        'Calle El Progreso',    '2200-1111', '08:00', '20:00', 1),
    (2, 2, 1, 1, 'Sucursal Merliot',       'Blvd. Merliot',        '2200-2222', '09:00', '21:00', 1),
    (3, 3, 1, 1, 'Sucursal Metapán',       'Av. Central',          '2200-3333', '07:00', '19:00', 1),
    (4, 4, 1, 1, 'Sucursal San Miguel',    'Col. Ciudad Pacífica', '2200-4444', '08:30', '19:30', 1),
    (5, 5, 1, 1, 'Sucursal Usulután',      'Centro Usulután',      '2200-5555', '08:00', '18:00', 1);

-- Datos para CLIENTE
REPLACE INTO CLIENTE (
    ID_CLIENTE,
    TELEFONO_CLIENTE,
    NOMBRE_CLIENTE,
    APELLIDO_CLIENTE,
    ACTIVO_CLIENTE
) VALUES
    (1, '7010-1111', 'Carlos',    'Ramírez',    1),
    (2, '7010-2222', 'Ana',       'González',   1),
    (3, '7010-3333', 'Luis',      'Martínez',   1),
    (4, '7010-4444', 'Diana',     'López',      1),
    (5, '7010-5555', 'José',      'Hernández',  1),
    (6, '7010-6666', 'Elena',     'Fuentes',    1),
    (7, '7010-7777', 'Mario',     'Paz',        1), 
    (8, '7010-8888', 'Sofia',     'Vargas',     1);

-- Datos para REPARTIDOR
REPLACE INTO REPARTIDOR (
    ID_DEPARTAMENTO,
    ID_MUNICIPIO,
    ID_DISTRITO,
    TIPO_VEHICULO,
    DISPONIBLE,
    TELEFONO_REPARTIDOR,
    NOMBRE_REPARTIDOR,
    APELLIDO_REPARTIDOR,
    ACTIVO_REPARTIDOR
) VALUES
    (1, 1, 1, 'Moto',      1, '7200-0001', 'Luis',    'Gómez',     1),
    (2, 1, 1, 'Bicicleta', 1, '7200-0002', 'Mario',   'Ruiz',      1),
    (3, 1, 1, 'Carro',     1, '7200-0003', 'Tatiana', 'Martínez',  1),
    (4, 1, 1, 'Moto',      1, '7200-0004', 'Kevin',   'Morales',   1),
    (5, 1, 1, 'Camioneta', 1, '7200-0005', 'Sofía',   'Aguilar',   1);

-- Datos para TIPOEVENTO
REPLACE INTO TIPOEVENTO (
    ID_TIPO_EVENTO,
    NOMBRE_TIPO_EVENTO,
    DESCRIPCION_TIPO_EVENTO,
    MONTO_MINIMO,
    MONTO_MAXIMO,
    ACTIVO_TIPOEVENTO
) VALUES
    (1, 'Fiesta Infantil',           'Evento privado',    30.00, 300.00, 1),
    (2, 'Reunión Empresarial',       'Coffee break',      50.00, 400.00, 1),
    (3, 'Cumpleaños',                'Celebración familiar', 25.00, 250.00, 1),
    (4, 'Boda Civil',                'Recepción sencilla', 100.00, 800.00, 1),
    (5, 'Cena de Fin de Año',        'Convivio navideño', 60.00, 600.00, 1);


-- Datos para PEDIDO (expandidos a 8 para cubrir facturas)
REPLACE INTO PEDIDO (
    ID_PEDIDO,
    ID_CLIENTE,
    ID_TIPO_EVENTO,
    ID_SUCURSAL,
    ID_REPARTIDOR,
    FECHA_HORA_PEDIDO,
    ESTADO_PEDIDO,
    ACTIVO_PEDIDO
) VALUES
    (1, 1, 1, 1, 1, '2025-05-01 10:00', 'Entregado', 1),
    (2, 2, 2, 2, 2, '2025-05-02 11:00', 'Enviado',   1),
    (3, 3, 3, 3, 3, '2025-05-03 12:00', 'Entregado', 1),
    (4, 4, 4, 4, 4, '2025-05-04 13:00', 'Entregado', 1),
    (5, 5, 5, 5, 5, '2025-05-05 14:00', 'Enviado',   1),
    (6, 6, 1, 1, 1, '2025-05-06 09:00', 'Cancelado', 1),
    (7, 7, 2, 2, 2, '2025-05-07 15:00', 'Pendiente', 1),
    (8, 8, 3, 3, 3, '2025-05-08 16:00', 'Enviado',   1);

-- Datos para FACTURA (Modificados y Expandidos)
REPLACE INTO FACTURA (
    ID_FACTURA,
    ID_PEDIDO,
    FECHA_EMISION,
    MONTO_TOTAL,
    TIPO_PAGO,
    ESTADO_FACTURA,
    ES_CREDITO
) VALUES
    (1, 1, '2025-05-01', 35.50, 'Efectivo',     'Pagada',     0),
    (2, 2, '2025-05-02', 70.00, 'Tarjeta',      'Pendiente',  0),
    (3, 3, '2025-05-03', 120.00,'Crédito',      'En Crédito', 1),
    (4, 4, '2025-05-04', 65.75, 'Crédito',      'Pagada',     1),
    (5, 5, '2025-05-05', 40.00, 'Crédito',      'En Crédito', 1),
    (6, 6, '2025-05-06', 25.00, 'Efectivo',     'Anulada',    0),
    (7, 7, '2025-05-07', 88.20, 'Transferencia','Pendiente',  0);


-- Datos para CREDITO (Modificados y Congruentes)
REPLACE INTO CREDITO (
    ID_CREDITO,
    ID_FACTURA,
    MONTO_AUTORIZADO_CREDITO,
    MONTO_PAGADO,
    SALDO_PENDIENTE,
    FECHA_LIMITE_PAGO,
    ESTADO_CREDITO
) VALUES
    (1, 3, 120.00, 50.00, 70.00, '2025-06-15', 'Activo'),
    (2, 4,  65.75, 65.75,  0.00, '2025-05-20', 'Pagado'),
    (3, 5,  40.00,  0.00, 40.00, '2025-06-25', 'Activo');

-- Datos para DIRECCION
REPLACE INTO DIRECCION (
    ID_CLIENTE,
    ID_DIRECCION,
    ID_DEPARTAMENTO,
    ID_MUNICIPIO,
    ID_DISTRITO,
    DIRECCION_ESPECIFICA,
    DESCRIPCION_DIRECCION,
    ACTIVO_DIRECCION
) VALUES
    (1, 1, 1, 1, 1, 'Col. Escalón #123',   'Casa esquina azul',    1),
    (5, 5, 5, 1, 1, 'Usulután centro',      'Casa colonial',        1),
    (6, 6, 1, 1, 1, 'Avenida Olímpica',     'Edificio gris, Apt 5', 1),
    (7, 7, 2, 1, 1, 'Residencial Las Palmas','Calle Los Almendros #7D',1),
    (8, 8, 3, 1, 1, 'Barrio El Calvario',   'Frente a parque',      1);

-- Datos para REPARTOPEDIDO
REPLACE INTO REPARTOPEDIDO (
    ID_PEDIDO,
    ID_REPARTO_PEDIDO,
    HORA_ASIGNACION,
    UBICACION_ENTREGA,
    FECHA_HORA_ENTREGA
) VALUES
    (1, 1, '2025-05-01 10:30', 'Escalón',    '2025-05-01 11:00'),
    (2, 1, '2025-05-01 11:30', 'Merliot',    '2025-05-01 12:00'),
    (3, 1, '2025-05-01 12:30', 'Metapán',    '2025-05-01 13:00'),
    (4, 1, '2025-05-01 13:30', 'San Miguel', '2025-05-01 14:00'),
    (5, 1, '2025-05-01 14:30', 'Usulután',   '2025-05-01 15:00');

-- Datos para DETALLEPEDIDO
REPLACE INTO DETALLEPEDIDO (
    ID_PRODUCTO,
    ID_PEDIDO,
    CANTIDAD,
    SUBTOTAL
) VALUES
    (1, 1,  2,  2.00),
    (5, 5,  3,  5.25),
    (1, 6,  5,  5.00),
    (3, 6,  5,  3.75),
    (2, 7, 10, 12.50),
    (3, 7,  4,  3.00),
    (4, 8,  3, 10.50),
    (5, 8,  2,  3.50),
    (1, 8,  2,  2.00);
