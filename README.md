# Proyecto CRUD de Productos en Laravel

Este proyecto es una demostración simple de un CRUD (Crear, Leer, Actualizar, Eliminar) utilizando Laravel para gestionar productos. Cada producto contiene atributos básicos como nombre, descripción, precio, stock, y las marcas de tiempo de creación y actualización.

## Instrucciones para Ejecutar el Proyecto

### Requisitos

Antes de empezar, asegúrate de tener instalados los siguientes programas:

-   **PHP** >= 8.0
-   **Composer**
-   **MySQL** o cualquier otra base de datos compatible con Laravel
-   **Laravel** >= 10.x
-   **Visual Studio Code** (opcional para una experiencia de desarrollo más rápida)

### Configuración del Entorno

1. **Clonar el Repositorio**

    Clona este repositorio en tu máquina local:

    ```bash
    git clone https://github.com/AmadorQuispe/products_laravel.git
    cd tu-repositorio
    ```

2. **Instalar Dependencias**

    Ejecuta el siguiente comando para instalar las dependencias del proyecto:

    ```bash
    composer install
    ```

3. **Configurar el Archivo `.env`**

    Copia el archivo `.env.example` y renómbralo a `.env`:

    ```bash
    cp .env.example .env
    ```

    Luego, configura las credenciales de la base de datos en el archivo `.env`:

    ```bash
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=nombre_base_datos
    DB_USERNAME=usuario_base_datos
    DB_PASSWORD=contraseña_base_datos
    ```

4. **Generar la Clave de la Aplicación**

    Ejecuta el siguiente comando para generar la clave de la aplicación:

    ```bash
    php artisan key:generate
    ```

5. **Ejecutar las Migraciones**

    Para crear las tablas necesarias en la base de datos, ejecuta:

    ```bash
    php artisan migrate
    ```

6. **Iniciar el Servidor**

    Inicia el servidor de desarrollo de Laravel con el siguiente comando:

    ```bash
    php artisan serve
    ```

    El proyecto estará disponible en [http://localhost:8000](http://localhost:8000).

## CRUD de Productos

Las siguientes operaciones CRUD están disponibles:

1. **Crear Producto**: POST `/api/products`
2. **Obtener Todos los Productos**: GET `/api/products`
3. **Obtener Producto por ID**: GET `/api/products/{id}`
4. **Actualizar Producto**: PUT `/api/products/{id}`
5. **Eliminar Producto**: DELETE `/api/products/{id}`

### Validación de Datos

Para asegurar que los datos ingresados sean válidos:

-   **Nombre**: Requerido y máximo de 150 caracteres.
-   **Descripción**: Requerido y máximo de 255 caracteres.
-   **Precio**: Requerido, numérico, mayor a 0.
-   **Cantidad en Stock**: Requerido, numérico, mayor o igual a 0.

Las validaciones están definidas dentro de los controladores para los métodos `create()` y `update()`.

## Pruebas Rápidas con Visual Studio Code y REST Client

Para facilitar las pruebas rápidas de la API, puedes utilizar la extensión **REST Client** en Visual Studio Code:

1. Instala la extensión desde el siguiente enlace: [REST Client](https://marketplace.visualstudio.com/items?itemName=humao.rest-client).

2. Ubica un archivo llamado `collection-request.http` en el directorio raíz del proyecto.

3. Para probar las diferentes operaciones CRUD, abre el archivo `collection-request.http` en Visual Studio Code y haz clic en `Send Request` sobre cualquiera de las solicitudes.

## Decisiones de Diseño

1. **Arquitectura MVC**: Para este proyecto opté por la arquitectura MVC (Modelo-Vista-Controlador), que es adecuada para aplicaciones simples como este CRUD. Esta arquitectura facilita la separación de responsabilidades y es fácil de entender y mantener en proyectos pequeños.

2. **Arquitectura Hexagonal para Proyectos Robustos**: Si bien la arquitectura MVC es suficiente para este proyecto, considero que para aplicaciones más grandes y complejas, la **arquitectura hexagonal** es una mejor opción. La arquitectura hexagonal permite desacoplar la lógica del dominio de las interfaces y facilita la creación de pruebas más robustas, al tiempo que mejora la mantenibilidad y escalabilidad de la aplicación. Esto también permite la fácil integración de diferentes interfaces de usuario (web, CLI, APIs, etc.) y bases de datos, manteniendo el núcleo de la lógica de negocio independiente.

3. **Validación de Datos**: Laravel proporciona un sistema de validación robusto que permite asegurar que los datos ingresados en los productos son correctos antes de ser almacenados o actualizados.
