# Décor - Sistema de Gestión de Compras

Este sistema permite gestionar compras de productos de decoración.

## Características

- Inicio de sesión y cierre de sesión de usuarios.
- Importación de usuarios.
- Registro de nuevas compras.
- Visualización de detalles de las compras.

## Consideraciones para la corrección
- *Para importar usuarios* el botón para realizar esta acción se encuentra en index.php
- *Para iniciar sesión en la aplicación*, hay dos opciones, se puede ingresar como administrador con las credenciales 'Username': ADMIN y 'password': admin; también se puede ingresar como cliente. Para esto, se puede ingresar a la tabla usuarios de la base de datos grupo30e3 y obtener el nombre del usuario y su password.
- *La asignación de contraseñas* a clientes se realizó dentro del procedimiento almacenado 'convertir_clientes_a_usuarios.sql' mediante la función MD5(RANDOM()::TEXT) de sql, que genera un decimal aleatorio entre 0 y 1, luego lo convierte a texto y luego calcula un hash de 32 caracteres hexadecimales. Para asignar las contraseñas a administradores, solo utilizamos la palabra ‘admin’ como pedía el enunciado.
- *Para registrar clientes como usuarios* en primer lugar, creamos la tabla  usuarios (id int PRIMARY KEY, nombre varchar(30), region varchar(50), clave varchar(32), tipo varchar(10)) en la base de datos del grupo 30. Luego utilizamos el procedimiento almacenado convertir_clientes_a_usuarios(), con el que iteramos sobre la tabla clientes de la base de datos del grupo 30 para obtener los datos de clientes, en cada iteración se buscó en la tabla usuarios una entrada con esos datos y si es que no existía se insertó una fila adicional en la tabla usuarios. El código exacto del procedimiento almacenado para importar usuarios está en el archivo convertir_clientes_a_usuarios.sql ubicado en grupo29/Entrega3
- *Sobre vistas* al iniciar sesión en index.php como cliente o administrador, se redirige a la vista client_index.php o admin_index.php respectivamente, las que tienen botones para todas las funciones. Por esta razón si en algún momento se quiere acceder a estas se puede cerrar sesión e iniciar de nuevo o acceder desde la url con /client_index.php o /admin_index.php.
- *Para realizar una nueva compra como cliente*, el cliente puede buscar productos con key insensitive, los cuales se muestran en orden ascendente según su precio con descuento, pudiendo agregar varios productos al carrito de compra. Al ingresar en 'ver carrito', se muestran todos los productos seleccionados con el id de la tienda de la cual fue reservada. 



## Estructura del proyecto

- `index.php`: Página de inicio. Incluye funcionalidad de inicio y la opción para importar usuarios.
- `new_purchase.php`: Permite registrar nuevas compras.
- `view_purchase.php`: Permite visualizar los detalles de las compras
- `/queries`: Contiene archivos PHP que realizan diversas consultas a la base de datos, como `login.php`, `logout.php`, `importar_usuarios.php`.
- `config/conexion.php`: Configura la conexión a la base de datos.
- `/templates`: Contiene `header.html` que se incluye en cada archivo PHP.

# De forma equivalente, la estructura incluye:
.
├── index.php               # Página de inicio. Funcionalidad de inicio y cierre de sesión.
├── new_purchase.php        # Permite registrar nuevas compras y agregarlas al carrito.
├── view_purchase.php       # Permite visualizar los detalles de las compras.
├── ver_carrito.php         # Muestra los productos del carrito. Permite eliminar o vaciar el carrito.
├── config
│   └── conexion.php        # Configura la conexión a la base de datos.
├── queries
│   ├── login.php           # Realiza la consulta de inicio de sesión.
│   ├── logout.php          # Realiza la consulta de cierre de sesión.
│   └── importar_usuarios.php # Realiza la importación de usuarios.
├── templates
│   └── header.html         # Se incluye en cada archivo PHP.
└── styles
    └── style.css           # Archivo CSS para los estilos de la aplicación.


## Requisitos

- PHP 7 o superior.
- Servidor de base de datos MySQL o MariaDB.
- Servidor web Apache o Nginx.

## Instrucciones de instalación

1. Clonar o descargar este repositorio.
2. Configurar el servidor web para que la carpeta del proyecto sea accesible.
3. Importar la estructura de la base de datos proporcionada.
4. Configurar las credenciales de la base de datos en `config/conexion.php`.
5. Abrir el navegador web y navegar hasta la dirección del proyecto.