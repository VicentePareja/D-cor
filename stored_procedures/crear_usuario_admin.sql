CREATE OR REPLACE FUNCTION crear_usuario_admin()
  RETURNS VOID AS $$
BEGIN
  -- Verificar si el usuario ADMIN ya existe
  IF NOT EXISTS (SELECT * FROM Usuarios WHERE nombre = 'ADMIN') THEN
    -- Crear el usuario ADMIN
    INSERT INTO Usuarios (id, nombre, region, clave, tipo) VALUES (0,'ADMIN', 'Renca', 'admin', 'Admin');
  END IF;
  IF NOT EXISTS (SELECT * FROM Usuarios WHERE nombre = 'ADMIN2000') THEN
    -- Crear el usuario ADMIN
    INSERT INTO Usuarios (id, nombre, region, clave, tipo) VALUES (1,'ADMIN20000', 'mipua', 'admin', 'Admin');
  END IF;
END;
$$
LANGUAGE plpgsql;