-- ojito, esta función se creará en $db2

CREATE OR REPLACE FUNCTION nueva_compra(
    p_id_producto INT,
    p_id_tienda INT,
    p_id_cliente INT
)
RETURNS VOID AS
$$
DECLARE
    v_id_compra INT;
BEGIN
    -- Obtener el mayor id de la tabla compras
    SELECT COALESCE(MAX(id), 0) + 1 INTO v_id_compra FROM compras;

    -- Insertar en la tabla compras
    INSERT INTO compras (id, fecha)
    VALUES (v_id_compra, CURRENT_DATE);

    -- Insertar en la tabla compra_producto
    INSERT INTO compraproducto (id_compra, id_producto, cantidad)
    VALUES (v_id_compra, p_id_producto, 1);

    -- Insertar en la tabla compra_cliente
    INSERT INTO compracliente (id_compra, id_cliente)
    VALUES (v_id_compra, p_id_cliente);

    -- Insertar en la tabla compra_tienda
    INSERT INTO compratienda (id_compra, id_tienda)
    VALUES (v_id_compra, p_id_tienda);

    -- Insertar en la tabla despachos
    INSERT INTO despachos (id, fecha_entrega)
    VALUES (v_id_compra, CURRENT_DATE);

    -- Insertar en la tabla compra_despacho
    INSERT INTO compradespacho (id_compra, id_despacho)
    VALUES (v_id_compra, v_id_compra);
END;
$$ LANGUAGE plpgsql;
