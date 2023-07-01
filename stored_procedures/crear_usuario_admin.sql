CREATE OR REPLACE FUNCTION crear_usuario_admin()
  RETURNS VOID AS $$
BEGIN

  IF NOT EXISTS (SELECT * FROM Usuarios WHERE nombre = 'ADMIN') THEN
    INSERT INTO Usuarios (id, nombre, region, clave, tipo) VALUES (0,'ADMIN', 'Renca', 'admin', 'Admin');
  END IF;
END;
$$
LANGUAGE plpgsql;