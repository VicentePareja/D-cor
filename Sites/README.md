# Décor - Sistema de Gestión de Compras

Este sistema permite gestionar compras de productos de decoración.

## Características

- Inicio de sesión y cierre de sesión de usuarios.
- Importación de usuarios.
- Registro de nuevas compras.
- Visualización de detalles de las compras.

## Estructura del proyecto

- `index.php`: Página de inicio. Incluye funcionalidad de inicio y cierre de sesión y la opción para importar usuarios.
- `new_purchase.php`: Permite registrar nuevas compras.
- `view_purchase.php`: Permite visualizar los detalles de las compras incluyendo el nombre de cada producto comprado, el precio de cada producto, el número de cajas para cada producto, el precio total y la fecha de despacho programada si corresponde.
- `/queries`: Contiene archivos PHP que realizan diversas consultas a la base de datos, como `login.php`, `logout.php`, `importar_usuarios.php`.
- `config/conexion.php`: Configura la conexión a la base de datos.
- `/templates`: Contiene `header.html` que se incluye en cada archivo PHP.

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