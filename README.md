# url-shortener-backend

REST API para acortar URL's

## Tecnologías principales

-   PHP v8.2.12
-   Laravel Framework v11.31
-   Composer v2.8.3
-   MySQL 5.x o superior

## Ejecución local

-   Crear un archivo `.env.local`. Luego, copiar el contenido del archivo `.env.example` y pegarlo en el nuevo archivo creado.

-   Cambiar las variables de entorno de la base de datos

    -   DB_CONNECTION
    -   DB_HOST
    -   DB_PORT
    -   DB_DATABASE
    -   DB_USERNAME
    -   DB_PASSWORD

-   Instalar las dependencias con el comando `composer install`
-   Ejecutar el comando `composer run migrate:local` para crear la base de datos y tablas.

*   Ejecutar el comando `php artisan serve --env=local` para empezar a usar el API con algún cliente (Ejm: Postman).

*   Nota: Asimismo, se puede entrar a la documentación del API en Swagger a través de la ruta:

## Ejecución de pruebas locales

-   Ejecutar el comando `composer run test:local`

## Despliegue

-   Crear un archivo `.env.{entorno}` para el entorno que se desee: `(testing | production)`

-   Editar las variables de entorno de la BD mencionadas en la sección de _Ejecución local_. Recordar utilizar el comando `php artisan migrate` para crear las tablas respectivas en la BD del entorno.
-   Actualmente, se está usando _Bref_ (https://bref.sh/) para permitir el despliegue del API en un Lambda de AWS (Se ha configurado un archivo `serverless.yml`)

*   Se tiene que configurar el entorno de AWS CLI, por lo que primero se debe instalar y configurar de acuerdo a su documentación oficial (https://docs.aws.amazon.com/es_es/cli/latest/userguide/getting-started-install.html).

-   Ejecutar el comando `serverless deploy --stage=testing` para el entorno de _testing_ o `serverless deploy --stage=production` para _production_.
