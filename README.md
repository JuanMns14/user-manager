
# User Manager
## Instalacion
Verifica la guía oficial de instalación de Laravel para conocer los requisitos del servidor antes de comenzar. 


Clona el repositorio
```bash
git clone git@github.com:JuanMns14/user-manager.git
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
    ```bash
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


    ```bash
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
    ```bash
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
    ```bash
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
#  Prueba de Programación para Desarrollador - Laravel - Git

## 1. ¿Cómo configuras y usas migraciones en Laravel?

Configuración:

- Crear directorio `database/migrations`
- Ejecutar `php artisan make:migration create_users_table` para crear una migración
- Editar la migración para definir la estructura de la tabla

Uso:
- Ejecutar `php artisan migrate` para ejecutar todas las migraciones pendientes
- Ejecutar `php artisan migrate:status` para ver el estado de las migraciones
- Ejecutar `php artisan migrate:rollback` para deshacer la última migración

## 2. Explica cómo usar Eloquent para manejar relaciones entre modelos.
Eloquent soporta diversos tipos de relaciones comunes, cada una con su propio método de definición y comportamiento
- Definir relaciones en los modelos: `hasOne()`, `belongsTo()`, `hasMany()`, `belongsToMany()`
- Acceder a relaciones:
```php
$user->posts
$post->author
```
- Consultar relaciones:
```bash
$user->posts()->where('published', true)->get()
```

## 3. Describe cómo implementar autenticación usando middleware en Laravel.
Estos son pasos básicos para implementar la autenticación:
- Crear controladores de autenticación (`RegisterController`, `LoginController`) o puedes hacerlo en un solo controlador llamado `AuthController`.
- Definir rutas para registro e inicio de sesión
- Crear middleware de autenticación (`AuthMiddleware`)
    
    Este seria el ejemplo de la funcion `handle` en `AuthMiddleware`:
    ```php
        public function handle($request, $next)
        {
            if (!auth()->user()) {
                return redirect()->route('login');
            }
            return $next($request);
        }
    ```
- Proteger rutas con middleware (`middleware:auth`)

## 4. ¿Cómo manejarías el control de versiones de tu proyecto Laravel usando git?
- Inicializar repositorio: `git init`
- Crear nueva rama: `git branch <branch-name>`
- Cambiar de rama: `git checkout <branch-name>`
- Subir cambios a la rama local: `git add .` y `git commit -m "Mensaje de commit"`
- Enviar cambios al repositorio remoto: `git push origin <branch-name>`

Y asi trabajar en una rama paralela a el proyecto principal.

## 5. ¿Qué comando usarías para inicializar un repositorio git?
El comando para inicializar un repositorio git es: `git init`

## 6. ¿Cómo crearías una nueva rama y la cambiarías?
- Crear nueva rama: `git branch <branch-name>`
- Cambiar de rama: `git checkout <branch-name>`

## 7. ¿Qué es un Pull Request y cómo lo manejarías en un flujo de trabajo colaborativo?
Un Pull Request es una solicitud en Git para fusionar cambios de una rama a otra. Permite a los colaboradores revisar y discutir los cambios antes de que se integren en la rama principal.

- Crear un Pull Request en GitHub
- Revisar y aprobar el Pull Request
- Fusionar el Pull Request en la rama principal

Los Pull Requests son esenciales para la colaboración en proyectos de software, permitiendo revisiones, resolución de conflictos y despliegue seguro de cambios. 

## 8. ¿Cómo usarías GuzzleHep para consumir una API externa en Laravel?
GuzzleHTTP es una biblioteca HTTP de alto rendimiento para PHP que facilita la realización de solicitudes HTTP a APIs externas.


Para empezar a usar GuzzleHep, primero hay que instalar la biblioteca:

```
composer require guzzlehttp/guzzle
```
### Consumir una API con GuzzleHep

Considere una API externa que proporciona información sobre el clima. La API tiene endpoint `GET` en `/weather/{ciudad}` que devuelve la temperatura actual para la ciudad especificada.

En su controlador u otra clase donde desee consumir la API, haga la importacion necesaria y cree una instancia del cliente HTTP de Guzzle:

```php
use GuzzleHttp\Client;

$client = new Client();
```
Para enviar una solicitud a la API, utilice el método `request()` del cliente HTTP. Especifique el método HTTP (GET, POST, PUT, DELETE, etc.), la URL de la API y cualquier dato de solicitud necesario:

```php
$url = "https://example.com/api"
$endpoint = "/weather/" . $ciudad;

$response = $client->request('GET', $url . $endpoint);
```
El método request() devuelve un objeto de respuesta. Puede acceder al código de estado de la respuesta, a los encabezados y al cuerpo de la respuesta utilizando los siguientes métodos:
```php
$statusCode = $response->getStatusCode();
$headers = $response->getHeaders();
$body = $response->getBody();
```
Si la solicitud falla, la excepción `GuzzleHttp\Exception\ClientException` se lanzará. 
Puede atrapar esta excepción para manejar el error:
```php
try {
    $response = $client->request('GET', $url . $endpoint);
} catch (GuzzleHttp\Exception\ClientException $e) {
    $statusCode = $e->getCode();
    $errorMessage = $e->getMessage();
}
```
## 9. ¿Qué métodos de autenticación se pueden usar al consumir APIs externas?

1. **Autenticación básica:**
Este método simple envía el nombre de usuario y la contraseña del usuario en cada solicitud HTTP.

    - Pros: Simple, fácil de implementar.
    - Contras: Insegura, no recomendable para datos sensibles.

2. **Autenticación basada en token:**
El usuario se autentica en el servidor de la API y recibe un token temporal, el token se incluye en el encabezado de autorización de cada solicitud posterior.

    - Pros: Más segura que la autenticación básica, no transmite la contraseña en cada solicitud.
    - Contras: Requiere gestión de tokens.

3. **Autenticación basada en clave API:**
El desarrollador recibe una clave API única del proveedor de la API, la clave API se incluye en cada solicitud para acceder a los recursos de la API.

    - Pros: Simple, relativamente segura.
    - Contras: Requiere gestión segura de las claves API.

4. **OAuth 2.0:**
Permite a los usuarios otorgar acceso a sus datos a aplicaciones de terceros sin revelar contraseñas.

    - Pros: Seguro, flexible, ampliamente utilizado en APIs modernas.
    - Contras: Implementación más compleja.

5. **Certificados X.509:**
Utiliza certificados digitales para verificar la identidad tanto del usuario como del servidor.

    - Pros: Muy seguro.
    - Contras: Complejo de implementar y gestionar.

6. **Autenticación de dos factores (2FA):**
Agrega un paso de verificación adicional al proceso de autenticación, como un código generado por una aplicación móvil.

    - Pros: Mayor seguridad al requerir dos pasos de verificación.
    - Contras: Agrega complejidad a la experiencia del usuario.
