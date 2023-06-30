CREATE OR REPLACE FUNCTION convertir_clientes_a_usuarios()
  RETURNS VOID AS
$$
DECLARE
  cliente_id INTEGER;
  cliente_nombre VARCHAR;
  cliente_region VARCHAR;
  cliente_password VARCHAR;
BEGIN
  FOR cliente_id, cliente_nombre, cliente_region IN (SELECT id, nombre, region FROM Clientes) LOOP
    -- Verificar si el cliente ya es un usuario
    IF NOT EXISTS (SELECT * FROM Usuarios WHERE id = cliente_id) THEN
      -- Generar una contraseña aleatoria
      cliente_password := MD5(RANDOM()::TEXT);

      -- Insertar el cliente como usuario de tipo "Cliente"
      INSERT INTO Usuarios (id, nombre, region, clave, tipo) 
      VALUES (cliente_id, cliente_nombre, cliente_region, cliente_password, 'Cliente');
    END IF;
  END LOOP;
END;
$$
LANGUAGE plpgsql;
