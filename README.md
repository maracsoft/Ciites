# Sistema Web de gestión - CIITES

## Instalación

1. Configurar el archivo .env basandose en el .env.example

2. Configurar el archivo phinx.php basandose en el phinx.example.php
    - Para entorno de producción, tener en cuenta que se deben modificar las rutas de las migraciones y seeds en ese archivo (en caso de que la carpeta public esté separada de lo demás)
    - Para verificar correcta instalacion, usar   
          ```
            $ vendor/bin/phinx test
          ```
      
    
3. Correr migraciones para crear la Base de datos (la bd ya debe estar creada)
    ``` bash
      $ vendor/bin/phinx migrate
    ```
4. Correr seeder para poblar la BD de datos iniciales
    ``` bash
      $ vendor/bin/phinx seed:run
    ```

5. Ejecutar laravel :D
    ``` bash
      $ php artisan serve
    ```






## Comandos utiles

- Crear migracion diferencial en base a un cambio realizado directamente en la bd (lee el esquema actual y la compara con el anterior)
    ``` bash
      $ vendor/bin/phinx-migrations generate
    ```

- Correr migraciones pendientes 
    ``` bash
      $ vendor/bin/phinx migrate
    ```

- Ver comandos disponibles del phinx 
    ``` bash
      $ vendor/bin/phinx 
    ```


- Actualizar el composer autoload (a veces se generan errores random xd) 
    ``` bash
      $ composer dump-autoload
    ```





## Lógica del Negocio:

### Módulos y abreviaturas:
- Solicitud de Fondos (SOF)
- Rendición de Gastos (REN)
- Reposición de Gastos (REP)
- Requerimientos de bienes y servicios (REQ) 
- Contratos (CON)
- Declaraciones juradas (DEC)
- Cite (CITE)
- Ordenes de Compra (ORD)
- Gestión de Proyectos (PROY)

### Módulos administrativos
- Gestión de Errores
- Gestión de Logeos
- Historial de Operaciones
- Buscador Maestro
- Jobs
- CRUDs del sistema

### Roles:
- Empleado
- Gerente
- Administrador
- Contador
- Observador
- UGE
- EquipoCITE
- ArticuladorCITE



## Links útiles de documentación

Sistema de migraciones para PHP y MYSQL que estoy usando   https://github.com/cakephp/phinx
    
    $ composer require robmorgan/phinx
    
Plugin para generar migraciones diferenciales en base al actual DB 
https://github.com/odan/phinx-migrations-generator

    $ composer require odan/phinx-migrations-generator --dev


## CONFIGURACION TÉCNICA
- Este proyecto usa Laravel 7
- PHP VERSION 7.4
- MySQL O MariaDB

