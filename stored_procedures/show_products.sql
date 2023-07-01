CREATE OR REPLACE FUNCTION show_products(
    nombre_producto VARCHAR,
    )
WITH ofertas AS (
    SELECT 
        producto.id_producto, 
        producto.nombre, 
        producto.precio AS precio_original,
        stock_oferta.porcentaje_descuento AS oferta_aplicada,
        producto.precio - producto.precio * stock_oferta.porcentaje_descuento / 100 AS precio_con_oferta,
        stock_oferta.id_tienda
    FROM 
        producto 
    LEFT JOIN 
        stock_oferta ON producto.id_producto = stock_oferta.id_producto
)
SELECT 
    nombre, 
    id_producto,
    precio_original,
    oferta_aplicada,
    precio_con_oferta,
    id_tienda
FROM 
    ofertas
WHERE 
    LOWER(nombre) LIKE LOWER(nombre_producto)
LIMIT 10;
