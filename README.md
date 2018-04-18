# GluePHP #

Bienvenido a GluePHP, un *framework* para el desarrollo de [aplicaciones web de una sola página](https://es.wikipedia.org/wiki/Single-page_application) empleando el [paradigma de la programación dirigida por eventos](https://es.wikipedia.org/wiki/Programaci%C3%B3n_dirigida_por_eventos).

### Requerimientos ###
- PHP 7.1

### Licencia ###
- MIT

## Instalación ##

>Tenga en cuenta que el proyecto se encuentra en una fase inestable.

La instalación de GluePHP se realiza mediante composer. Para esto es necesario declarar las siguientes dependencias en el archivo *composer.json*.

    {
        "require": {
            "glueapps/composed-views": "dev-0.1a",
            "glueapps/glue-php": "dev-0.1a"
        }
    }

Seguidamente se debe ejecutar el comando:

    $ composer update

## Contribuyendo. ##

El desarrollo de GluePHP está basado en la metodología de [desarrollo guiado por pruebas(TDD)](https://es.wikipedia.org/wiki/Desarrollo_guiado_por_pruebas), por lo que cada funcionalidad del *framework* se encuentra cubierta por al menos una prueba. Para las pruebas al código PHP se emplea [PHPUnit](https://phpunit.de/) mientras que para el código JavaScript se emplea [MochaJS](https://mochajs.org/), [Chai](http://chaijs.com/) y [SinonJS](http://sinonjs.org/). Para las pruebas a las funcionalidades *full-stack* se emplean las tecnologías [PHPUnit](https://phpunit.de/), [Selenium Server](http://www.seleniumhq.org/) con [Chrome Driver](https://sites.google.com/a/chromium.org/chromedriver/).

El código JavaScript está basado mayormente en ES5 con el objetivo de lograr compatibilidad con la mayoría de navegadores posibles, no obstante, también se han empleado algunas funcionalidades de ES6 pero que se encuentran ampliamente soportadas.

Para el código JavaScript existen algunas tareas automatizadas con [GulpJS](https://gulpjs.com/) por lo que antes de hacer alguna modificación debe ejecutar el comando:

    $ gulp

### Pasos para contribuir en el proyecto. ###

1. Hacer un *fork* de este repositorio.
2. Clonar en local el nuevo repositorio que se ha creado en su cuenta de GitHub.
3. Realizar las modificaciones **con sus respectivas pruebas**.
4. Hacer *push* al origen.
5. Crear un *pull request*.

### Ejecutando las pruebas. ###

Una vez que ha clonado localmente el repositorio debe realizar la instalación de las siguientes aplicaciones:

- [Composer](https://getcomposer.org/)
- [NPM](https://www.npmjs.com/)
- [Selenium Server](http://www.seleniumhq.org/)
- [Chrome Driver](https://sites.google.com/a/chromium.org/chromedriver/)
- [Java](https://www.java.com/es/download/)
- [Bower](https://bower.io/)

#### 1. Instale las dependencias de Composer.

    $ composer update

#### 2. Instale las dependencias de NPM.

    $ npm update

#### 3. Instale las dependencias de Bower

    $ bower install

#### 4. Ejecute el siguiente comando.

    $ php -S localhost:8085

#### 5. Ejecute Selenium Server.

    $ java -jar <ruta_al_archivo>/selenium-server-standalone-x.x.x.jar

#### 6. Ejecute PHPUnit.

    $ php vendor/phpunit/phpunit/phpunit

Tenga en cuenta que algunos antivirus pueden hacen fallar ciertas pruebas por lo que puede ser necesario que añada alguna excepción al respecto.
