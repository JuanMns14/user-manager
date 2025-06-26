
# User Manager
## Instalacion
Verifica la guía oficial de instalación de Laravel para conocer los requisitos del servidor antes de comenzar. 


Clona el repositorio
```bash
git clone https://github.com/JuanMns14/user-manager.git
```
Cambia al directorio del repositorio
```bash
cd user-manager
```
Instala todas las dependencias usando Composer
```bash
composer install
```
Copia el archivo de entorno de ejemplo y realiza los cambios de configuración necesarios en el archivo `.env`
```bash
cp .env.example .env
```
Ejecuta las migraciones de la base de datos (establece la conexión de la base de datos en .env antes de migrar)
```bash
php artisan migrate
```
Inicia el servidor de desarrollo local
```bash
php artisan serve
```

# Rutas de la API

## Auth
- Registrar un usuario

    ```bash
    POST - /api/auth/register
    ```
    Estructura
    ```json
    {
        "name":"User",
        "email": "user@mail.com",
        "password": "userpass",
        "password_confirmation": "userpass"
    }
    ```
- Generar un token (Login)
    ```bash
    POST - /api/auth/login
    ```
    Estructura


    ```json
    {
        "email": "user@mail.com",
        "password": "userpass",
    }
    ```
- Eliminar el token (Logout)

    ```bash
    POST - /api/auth/logout
    ```

## CRUD Usuarios - Requiere Autenticacion (Token)

- Obtener la lista de los usuarios

    ```bash
    GET - /api/v1/users
    ```
- Obtener la informacion de un usuario
    ```bash
    GET - /api/v1/users/{user}
    ```
- Crear un usuario
    ```bash
    POST - /api/v1/users
    ```
    Estructura
    ```json
    {
        "name":"User",
        "email": "user@mail.com",
        "password": "userpass",
        "password_confirmation": "userpass"
    }
    ```
-  Actualizar la informacion de un usuario
    ```bash
    PUT - /api/v1/users/{user}
    ```
    Estructura
    ```json
    {
        "name":"userUpdate",
        "email": "userUpdate@mail.com",
        "password": "userupdatepass",
        "password_confirmation": "userupdatepass"
    }
    ```
- Eliminar un usuario
    ```bash
    DELETE - /api/v1/users/{user}
    ```
## OpenAI API - Requiere Autenticacion (Token)
 - Generar texto
    ```bash
    POST - /api/v1/ai/generate-text
    ```
    Estructura

    ```json
    {
        "input": "¿Qué es un Pull Request?"
    }
    ```
## Strapi API - Requiere Autenticacion (Token)
Todas las respuestas estan filtradas y formateadas con toda la informacion de las publicaciones y los comentarios incluyendo las relaciones.
### Posts
- Obtener la lista de las publicaciones

    ```bash
    GET - /api/v1/strapi/posts
    ```
- Obtener la informacion de una publicacion
    ```bash
    GET - /api/v1/strapi/posts/{post}
    ```
### Comments
- Obtener la lista de los comentarios

    ```bash
    GET - /api/v1/strapi/comments
    ```
- Obtener la informacion de un usuario
    ```bash
    GET - /api/v1/strapi/posts/{comment}
    ```