*Archivo .haccess*

Este archivo se considera de seguridad para el sistema. Las siguientes lineas hacen lo siguiente:

{RewriteEngine On}
{*Options All -Indexes*} Bloquea los demas directorios, de tal manera que no se puedan acceder a ellos. Debemos ponerlo en un directorio que deba tener seguridad.
{*RewriteRule ^([a-zA-Z0-9/ñÑ-]+)$ index.php?views=$1*} Valor de la variable views que se pasa a traves de get

# 5
{*[CREAR CONTROLADOR Y MODELO DE VISTAS]*}

    #En la parte de modelo, creamos una funcion que nos servira para optener vistas.

# 6 Trabajar en la plantilla

    -Copiar el archivo home a nuestra plantilla.
    -crear una nueva carpeta llamada inc
    -cortamos el codigo que ya no tenga utilidad. El codigo que sea util lo pegamos en pequeños fracmentos
    en nuestra carpeta inc.

# 7 Como se crean vistas
    - Se van a crear dos vistas, estas las vamos a recuperar de la plantilla. Las vistas son error 404 y login.
    De nuestra plantilla vamos a extrar los archivos login y error 404 y los vamos añadir a nuestra caroeta de contenido.

    No añadimos login y 404 a la lista blanca. Todas las otras vistas si se vana a añadir.

# 8 Corrigiendo direccionamiento de enlaces

# 9 Creando el modelo principal.

    -Creamos un archivo en la carpeta de modelo, y lo llamamos mainModel, aseguramos que nuestro archivo 
    server.php este bien instanceado.
    -Creamos dos metodos, uno que es la coneccion a la base de datos y otro para realizar consultas.

# 10 Funciones para Encriptar y desencriptar y generacion de codigos aleatorios

    -Extraemos codigos del depositorio de git.
    -Creamos la funcion para generar codigos aleatorios

# 12 Verificar datos y fechas.

Creamos dos funciones. Una para verificar fechas y otra para validar datos de inputs

# 13, 14 Paginacion para tabla

Creamos una funcion especial para la estructura que va tener nuestra tabla.

# 15 Creamos Archivos js 