-- ───── LIMPIEZA ─────
SET FOREIGN_KEY_CHECKS = 0;
DELETE FROM ACCESOUSUARIO;
DELETE FROM OPCIONCRUD;
DELETE FROM USUARIO;
SET FOREIGN_KEY_CHECKS = 1;

-- ───── USUARIOS ─────
REPLACE INTO USUARIO (ID_USUARIO, NOM_USUARIO, CLAVE) VALUES
    ('SU', 'superusuario', '12345'),
    ('CL', 'cliente',      '123'),
    ('RP', 'repartidor',   '123'),
    ('SC', 'sucursal',     '123');

-- ───── OPCIONES CRUD ─────
REPLACE INTO OPCIONCRUD (ID_OPCION, DES_OPCION, NUM_CRUD) VALUES
    /* Cliente */
    ('cliente_crear',      'Crear Cliente',           1),
    ('cliente_consultar',  'Consultar Cliente',       2),
    ('cliente_editar',     'Editar Cliente',          3),
    ('cliente_eliminar',   'Eliminar Cliente',        4),

    /* Repartidor */
    ('repartidor_consultar','Consultar Repartidor',   2),
    ('repartidor_editar',   'Editar Repartidor',      3),

    /* Sucursal */
    ('sucursal_consultar', 'Consultar Sucursal',      2),
    ('sucursal_editar',    'Editar Sucursal',         3),

    /* Producto */
    ('producto_crear',     'Crear Producto',          1),
    ('producto_consultar', 'Consultar Producto',      2),
    ('producto_editar',    'Editar Producto',         3),
    ('producto_eliminar',  'Eliminar Producto',       4),

    /* DatosProducto */
    ('datosproducto_crear',     'Crear DatosProducto',     1),
    ('datosproducto_consultar', 'Consultar DatosProducto', 2),
    ('datosproducto_editar',    'Editar DatosProducto',    3),
    ('datosproducto_eliminar',  'Eliminar DatosProducto',  4),

    /* DetallePedido */
    ('detallepedido_crear',     'Crear DetallePedido',     1),
    ('detallepedido_consultar', 'Consultar DetallePedido', 2),
    ('detallepedido_editar',    'Editar DetallePedido',    3),
    ('detallepedido_eliminar',  'Eliminar DetallePedido',  4),

    /* Pedido */
    ('pedido_consultar',   'Consultar Pedido',        2),

    /* RepartoPedido */
    ('repartopedido_crear',     'Crear RepartoPedido',     1),
    ('repartopedido_consultar', 'Consultar RepartoPedido', 2),
    ('repartopedido_editar',    'Editar RepartoPedido',    3),
    ('repartopedido_eliminar',  'Eliminar RepartoPedido',  4),
    ('reparto_consultar',       'Consultar Repartos',      2),

    /* Factura */
    ('factura_crear',      'Crear Factura',           1),
    ('factura_consultar',  'Consultar Factura',       2),
    ('factura_editar',     'Editar Factura',          3),
    ('factura_eliminar',   'Eliminar Factura',        4),

    /* Crédito */
    ('credito_crear',      'Crear Crédito',           1),
    ('credito_consultar',  'Consultar Crédito',       2),
    ('credito_editar',     'Editar Crédito',          3),
    ('credito_eliminar',   'Eliminar Crédito',        4),

    /* Dirección */
    ('direccion_crear',    'Crear Dirección',         1),

    /* TipoEvento */
    ('tipoevento_crear',        'Crear TipoEvento',        1),
    ('tipoevento_consultar',    'Consultar TipoEvento',    2),
    ('tipoevento_editar',       'Editar TipoEvento',       3),
    ('tipoevento_eliminar',     'Eliminar TipoEvento',     4),

    /* CategoríaProducto */
    ('categoriaproducto_crear',     'Crear CategoríaProducto',     1),
    ('categoriaproducto_consultar', 'Consultar CategoríaProducto', 2),
    ('categoriaproducto_editar',    'Editar CategoríaProducto',    3),
    ('categoriaproducto_eliminar',  'Eliminar CategoríaProducto',  4),

    /* Geografía */
    ('departamento_consultar', 'Consultar Departamento', 2),
    ('municipio_consultar',    'Consultar Municipio',    2),
    ('distrito_consultar',     'Consultar Distrito',     2),

    /* Comodín */
    ('todo_admin',            'Acceso total',             0);

-- ───── ACCESOS POR USUARIO ─────

-- Superusuario
REPLACE INTO ACCESOUSUARIO (ID_OPCION, ID_USUARIO) VALUES
    ('todo_admin','SU');

-- Cliente
REPLACE INTO ACCESOUSUARIO (ID_OPCION, ID_USUARIO) VALUES
    ('cliente_consultar','CL'),
    ('cliente_editar',   'CL'),
    ('direccion_crear',  'CL'),
    ('producto_consultar','CL'),
    ('detallepedido_crear','CL'),
    ('detallepedido_consultar','CL'),
    ('detallepedido_editar','CL'),
    ('detallepedido_eliminar','CL'),
    ('pedido_consultar','CL'),
    ('factura_consultar','CL'),
    ('credito_consultar','CL'),
    ('departamento_consultar','CL'),
    ('municipio_consultar','CL'),
    ('distrito_consultar','CL'),
    ('sucursal_consultar','CL');

-- Repartidor
REPLACE INTO ACCESOUSUARIO (ID_OPCION, ID_USUARIO) VALUES
    ('repartidor_consultar','RP'),
    ('repartidor_editar',   'RP'),
    ('reparto_consultar',   'RP'),
    ('repartopedido_consultar','RP'),
    ('pedido_consultar',    'RP'),
    ('departamento_consultar','RP'),
    ('municipio_consultar',   'RP'),
    ('distrito_consultar',    'RP');

-- Sucursal
REPLACE INTO ACCESOUSUARIO (ID_OPCION, ID_USUARIO) VALUES
    ('sucursal_consultar','SC'),
    ('sucursal_editar',   'SC'),
    ('producto_crear',    'SC'),
    ('producto_consultar','SC'),
    ('producto_editar',   'SC'),
    ('producto_eliminar', 'SC'),
    ('datosproducto_crear',    'SC'),
    ('datosproducto_consultar','SC'),
    ('datosproducto_editar',   'SC'),
    ('datosproducto_eliminar', 'SC'),
    ('tipoevento_crear',       'SC'),
    ('tipoevento_consultar',   'SC'),
    ('tipoevento_editar',      'SC'),
    ('tipoevento_eliminar',    'SC');
