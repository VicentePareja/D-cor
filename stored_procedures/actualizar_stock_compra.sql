-- ojito, esta función se creará en $db

CREATE OR REPLACE FUNCTION actualizar_stock_compra(
    p_id_tienda INT,
    p_id_producto INT
)
RETURNS VOID AS
$$
BEGIN
    UPDATE stock_oferta
    SET cantidad_producto = cantidad_producto - 1
    WHERE id_tienda = p_id_tienda
      AND id_producto = p_id_producto;
END;
$$ LANGUAGE plpgsql;
