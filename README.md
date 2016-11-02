Prototipo SIARMe  
===================================
Proyecto creado empleando Symfony 2.8 el 5 de Septiembre de 2016, 10:24 pm.

**SIARMe** es una aplicación de prueba desarrollada para la Direccion Prov. de Reconocimientoos Medicos 
empleando Symfony 2.8. Se trata de un Portotipo de un sistema de Informacion Administrativa para la mencionada Institucion.
Esta aplicación es la Propuesta en el Trabajo Final de la UNCa -Facultad de Tecnologia (https://siarme-adrianraul.c9users.io/web/app_dev.php) a cargo de Ibañez Raul Adrian


Si descubres algún error, por favor utiliza [la página de issues de
Github]( https://github.com/ira-adrian/SIARMe/issues).

Instalando la aplicación
------------------------

En el Sitio oficial ( https://symfony.com/ ) puedes encontrar infomacion
que detallada de cómo instalar bien Symfony.

Acontinuación sólo se indican los principales pasos necesarios.

En **primer lugar** debes tener Composer instalador globalmente. Si utilizas
Linux o Mac OS X, ejecuta los siguientes comandos:

```bash
$ curl -sS https://getcomposer.org/installer | php
$ sudo mv composer.phar /usr/local/bin/composer
```

Si utilizas Windows, descárgate el [instalador ejecutable de
Composer](https://getcomposer.org/download) y sigue los pasos indicados por el
instalador.

Una vez instalado **Composer**, ejecuta los siguientes comandos para descargar e
instalar la aplicación **SIARMe**:

```bash
# clona el código de la aplicación
$ cd proyectos/
$ git clone https://github.com/ira-adrian/SIARMe.git

# instala las dependencias del proyecto (incluyendo Symfony)
$ cd SIARMe/
$ composer install
```

Probando la aplicación
----------------------

La forma más sencilla de probar la aplicación, ejecuta el siguiente comando, que
arranca el servidor web interno de PHP y hace que tu aplicación se pueda
ejecutar sin necesidad de usar Apache o Nginx:

```bash
$ php app/console server:run
Server running on http://localhost:8000
```

Ahora ya puedes abrir tu navegador y acceder a `http://localhost:8000` para
probar la aplicación.

El comando anterior requiere PHP 5.4. Si utilizas una versión anterior de PHP,
tendrás que configurar un *virtual host* en tu servidor web, tal y como se
explica con detalle en el libro.

### Solución a los problemas comunes

Al empezar a programar con Symfony, es común no saber la causa exacta de algunos
de los errores que se producen. En estos casos es útil borrar la caché de la
aplicación ejecutando los siguientes comandos:

  * Entorno de desarrollo: `php app/console cache:clear`
  * Entorno de producción: `php app/console cache:clear --env=prod`

Si aún así siguen persistiendo los errores, al principio también suele ser útil
borrar completamente los directorios dentro de `app/cache/` (por ejemplo con el
comando `rm -fr app/cache/*`).

**1. Si solamente ves una página en blanco**, es posible que se trate de un
problema de permisos. En el libro se explica detalladamente cómo solucionarlo,
pero una solución rápida puede ser ejecutar el siguiente comando:

```bash
$ cd proyectos/Cupon/
$ chmod -R 777 app/cache app/logs
```

Si no te funciona esta solución, también puedes consultar el artículo [Cómo
solucionar el problema de los permisos de
Symfony](http://symfony.es/documentacion/como-solucionar-el-problema-de-los-
permisos-de-symfony2/).

**2. Si ves un error relacionado con la base de datos**, es posible que tu
instalación de PHP no tenga instalada o activada la extensión para SQLite.

**SIARME** usa por defecto una base de datos como MySQL dn la instalación de la aplicación.
Si prefieres usar SQLite, sigue estos pasos:

  1. Edita el archivo `app/config/parameters.yml` descomentando todo lo relacionado
     con SQLite y comentando todo lo relacionado con MySQL.
  2. Edita el archivo `app/config/config.yml` y en la sección `dbal`, descomenta
     todo lo relacionado con SQLite y comenta todo lo relacionado con MySQL.
  3. Ejecuta los siguientes comandos para crear la base de datos y rellenarla
     con datos de prueba:

```bash
$ php app/console doctrine:database:create
$ php app/console doctrine:schema:create
$ php app/console doctrine:fixtures:load

# si este último comando da error, ejecuta en su lugar:
$ php app/console doctrine:fixtures:load --append

```
Test unitarios y funcionales
----------------------------

La aplicación incluye varios test unitarios y funcionales de ejemplo. Para
ejecutarlos debes tener la herramienta
[PHPUnit](https://github.com/sebastianbergmann/phpunit/) instalada. Después,
ejecuta el siguiente comando en el directorio raíz del proyecto:

```bash
$ phpunit -c app
```

Frontend
--------
  * URL:
    * Entorno de desarrollo: `http://localhost/web/app_dev.php/`
    * Entorno de producción: `http://localhost/web/app.php/`
 
Extranet
--------
  * URL:
    * Entorno de desarrollo: `http://localhost/web/app_dev.php/extranet`
    * Entorno de producción: `http://localhost/web/app.php/extranet`
  * Credenciales de usuarios:
    * Nombre de usuario: `usuarioN` siendo `N` un número entre `1` y `20`
    * Contraseña: `usuarioN` siendo `N` el mismo valor que el del nombre de usuario
      * Usuarios de prueba del Departamento AUTOSEGURO: {mesaentrada, administrativo, medico, psquiatra } 
      * Constraseña: es el nombre de usuario.
      * Usuarios de prueba del Departamento DESPACHO: {mesaentrada1, administrativo1, medico1, psquiatra1 } 
      * Constraseña: es el nombre de usuario sin el `1`.
       
Backend
-------
  * URL:
    * Entorno de desarrollo: `http://localhost/web/app_dev.php/backend`
    * Entorno de producción: `http://localhost/web/app.php/backend`
  * Credenciales de usuarios:
    * Nombre de usuario: `admin`
    * Contraseña: `1234`
