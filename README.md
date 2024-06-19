
#  Laravel: Migraciones, Eloquent, Autenticación y Git

### 1. ¿Cómo configuras y usas migraciones en Laravel?

Configuración:

- Crear directorio `database/migrations`
- Ejecutar `php artisan make:migration create_users_table` para crear una migración
- Editar la migración para definir la estructura de la tabla

Uso:
- Ejecutar `php artisan migrate` para ejecutar todas las migraciones pendientes
- Ejecutar `php artisan migrate:status` para ver el estado de las migraciones
- Ejecutar `php artisan migrate:rollback` para deshacer la última migración

### 2. Explica cómo usar Eloquent para manejar relaciones entre modelos.
Eloquent soporta diversos tipos de relaciones comunes, cada una con su propio método de definición y comportamiento
- Definir relaciones en los modelos: `hasOne()`, `belongsTo()`, `hasMany()`, `belongsToMany()`
- Acceder a relaciones:
```bash
$user->posts
$post->author
```
- Consultar relaciones:
```bash
$user->posts()->where('published', true)->get()
```

### 3. Describe cómo implementar autenticación usando middleware en Laravel.
Estos son pasos básicos para implementar
- Crear controladores de autenticación (`RegisterController`, `LoginController`) o puedes hacerlo en un solo controlador llamado `AuthController`.
- Definir rutas para registro e inicio de sesión
- Crear middleware de autenticación (`AuthMiddleware`)
- Proteger rutas con middleware (`middleware:auth`)

### 4. ¿Cómo manejarías el control de versiones de tu proyecto Laravel usando git?
- Inicializar repositorio: `git init`
- Crear nueva rama: `git branch nombre-rama`
- Cambiar de rama: `git checkout nombre-rama`
- Subir cambios a la rama local: `git add .` y `git commit -m "Mensaje de commit"`
- Enviar cambios al repositorio remoto: `git push origin nombre-rama`

Y asi trabajar en una rama paralela a el proyecto principal.

### 5. ¿Qué comando usarías para inicializar un repositorio git?
El comando para inicializar un repositorio git es: `git init`

### 6. ¿Cómo crearías una nueva rama y la cambiarías?
- Crear nueva rama: `git branch nombre-rama`
- Cambiar de rama: `git checkout nombre-rama`

### ¿Qué es un Pull Request y cómo lo manejarías en un flujo de trabajo colaborativo?
Un Pull Request es una solicitud en Git para fusionar cambios de una rama a otra. Permite a los colaboradores revisar y discutir los cambios antes de que se integren en la rama principal.

- Crear un Pull Request en GitHub
- Revisar y aprobar el Pull Request
- Fusionar el Pull Request en la rama principal

Los Pull Requests son esenciales para la colaboración en proyectos de software, permitiendo revisiones, resolución de conflictos y despliegue seguro de cambios. 
