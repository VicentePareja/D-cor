CREATE OR REPLACE FUNCTION update_discount(
    nuevoDescuento INT,
    idProducto INT,
    idTienda INT
)
RETURNS TEXT AS
$$
DECLARE
    rowCount INT;
    mensaje TEXT;
BEGIN
    UPDATE stock_oferta SET porcentaje_descuento = nuevoDescuento WHERE id_producto = idProducto AND id_tienda = idTienda;
    
    SELECT COUNT(*) INTO rowCount FROM stock_oferta WHERE id_producto = idProducto AND id_tienda = idTienda;
    
    IF rowCount > 0 THEN
        mensaje := 'Stock actualizado correctamente.';
    ELSE
        mensaje := 'No se pudo actualizar el stock.';
    END IF; 
    
    RETURN mensaje;
END;
$$
LANGUAGE plpgsql;