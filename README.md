# Hornero Repositories


Es una estructura de desarrollo basada en MVC, muy cómodo para trabajar basado en Programación Orientada a Objeto al 100%, posee varios estándares de desarrollo en PHP en el cual tenemos las siguientes implementaciones:
	
	PSR-3  Estandar de Registro de Logs
	PSR-4  Estándar de carga automática
	PSR-7  Interfaz de mensajes HTTP.
	PSR-16 Caché Simple.

Así mismo te permite desarrollar aplicaciones de forma más simple ordenada y sin tanta capa de abstracción de datos, se adapta a todo tipo de desarrollo por más compleja que sea, hasta puedes incluir componentes de tercero sin restricciones.

Desarrollo rápido, simple, sin tener que aprender tantas cosas adicionales solo saber las buenas prácticas de desarrollo y patrones de arquitectura de Software en MVC.
[![Autor](@gbolivarb)](https://twitter.com/gbolivarb)
[![Desarrollo](Tag pre-alpha-02)](https://github.com/CaribesTIC/hornero/tree/pre-alpha-02)
[![Plantilla Plates](https://img.shields.io/badge/source-league/plates-blue.svg?style=flat-square)](http://platesphp.com/)


## Table of Contents

- <a href="#installation">Installation</a>
    - <a href="#clonar">Clonar proyecto</a>
    - <a href="#composer">Composer</a>
    - <a href="#hornero">Hornero</a>
    - <a href="#config">Configurar Base de Datos</a>

## Installation

### Clonar Proyecto

Debes descargar el proyecto desde el repositorio 
```terminal
git clone https://github.com/CaribesTIC/hornero.git 
```

### Composer
Debes descargar todos los paquetes de compases

```terminal
composer install 
```


### Hornero
Hornero es una solución tecnológica basada en simplicidad de 
estructuras de trabajos, la idea de esta arquitectura es simplificar el tiempo de desarrollo y hacer aplicaciones en tiempo record, sin ser un programador de alta gama.

Te permite hacer integraciones modular dentro de la arquitectura podes crear un módulo para ser usado en otros sistema desarrollados con hornero, todo está basado en PHP igual que las plantillas. 

Puedes ver todas las opciones de la siguiente forma:

```terminal
php hornero 
```
Deberia aparecer algo como lo siguiente:
```terminal
horneroHornero - 1.0

Variebles comandos:
 App
   app:list, Permite listar las aplicacion dentro de tu proyecto
   app nombre, Permite crear una aplicacion dentro de tu proyecto
   app nombre public, Permite publicar tus css, js, e img en la parte web
   app:model nombre-app nombre-modelo, Permite generar el modelo dentro de una aplicacion
 Cache
   cache:clean, permite limpiar el cache de las aplicaciones
```

### Configuracion a Base de Datos
Esta permite tener varias base de datos configuradas hasta el momento, por ahora solo funciona para mariadb y sqlserver, `config/databases.ini`
```php
[default]
    motor = 'sql'
    host = 'localhost'
    port = '3306'
    db  = 'miBaseDatos'
    user = 'miUsuario'
    pass = 'miClave'
    encoding = 'UTF-8'
```
Si necesitas otro puedes agregar mas cambiando el indice ejemplo:

```php
[default]
    motor = 'sql'
    host = 'servidor1.localhost'
    port = '3306'
    db  = 'miBaseDatos'
    user = 'miUsuario'
    pass = 'miClave'
    encoding = 'UTF-8'
[base2]
    motor = 'sql'
    host = 'servidor2.localhost'
    port = '3306'
    db  = 'miBaseDatos'
    user = 'miUsuario'
    pass = 'miClave'
    encoding = 'UTF-8'
[base3]
    motor = 'sql'
    host = 'servidor3.localhost'
    port = '3306'
    db  = 'miBaseDatos'
    user = 'miUsuario'
    pass = 'miClave'
    encoding = 'UTF-8'
```
El sistema siempre se conecta a default, parocuando creas mas bases diferente a la defaul debes conectarte a elle pasando el indice de conexion.