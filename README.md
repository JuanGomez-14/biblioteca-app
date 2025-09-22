# 📚 Sistema de Gestión de Biblioteca - API REST

Una aplicación completa de gestión de biblioteca desarrollada con **Laravel 12** que permite administrar libros, autores, usuarios y préstamos a través de una API REST con autenticación por tokens.

## 🚀 Características Principales

-   **Gestión de Libros**: CRUD completo con filtros avanzados
-   **Gestión de Autores**: Eliminación con validación de integridad
-   **Sistema de Préstamos**: Control de stock y límites por usuario
-   **Autenticación API**: Laravel Sanctum para tokens seguros
-   **Base de Datos**: PostgreSQL para producción y desarrollo
-   **Validaciones Robustas**: Request classes personalizadas
-   **Datos de Prueba**: Seeders con información realista

## 🛠️ Tecnologías Utilizadas

-   **Backend**: Laravel 12 (PHP 8.2+)
-   **Autenticación**: Laravel Sanctum
-   **Base de Datos**: PostgreSQL
-   **Frontend Assets**: Vite + TailwindCSS
-   **Testing**: PHPUnit
-   **Linting**: Laravel Pint

## 📋 Requisitos del Sistema

-   **PHP** >= 8.2
-   **Composer** >= 2.0
-   **Node.js** >= 18.0
-   **npm** o **yarn**
-   **PostgreSQL** >= 12.0
-   **Git**

## ⚡ Instalación Rápida

### 1. Clonar el Repositorio

```bash
git clone <URL_DEL_REPOSITORIO>
cd biblioteca-app
```

### 2. Instalar Dependencias PHP

```bash
composer install
```

### 3. Instalar Dependencias JavaScript

```bash
npm install
```

### 4. Configurar el Entorno

```bash
# Copiar archivo de configuración
cp .env.example .env

# Generar clave de aplicación
php artisan key:generate
```

### 5. Configurar Base de Datos

```bash
# Configurar variables de entorno para PostgreSQL en .env
# Edita el archivo .env con la configuración de tu base de datos:
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=biblioteca_db
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña

# Crear la base de datos (ejecutar en psql o pgAdmin)
# CREATE DATABASE biblioteca_db;

# Ejecutar migraciones
php artisan migrate

# Ejecutar seeders para datos de prueba
php artisan db:seed
```

### 6. Publicar Configuración de Sanctum

```bash
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
```

### 7. Iniciar el Servidor

```bash
# Servidor Laravel
php artisan serve

# En otra terminal: Compilar assets (opcional para API)
npm run dev
```

🎉 **¡Listo!** La aplicación estará disponible en `http://localhost:8000`

## 🔧 Configuración de PostgreSQL

### Configuración del archivo .env

Asegúrate de que tu archivo `.env` tenga la configuración correcta para PostgreSQL:

```bash
# Configuración de la aplicación
APP_NAME="Biblioteca API"
APP_ENV=local
APP_KEY=base64:XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
APP_DEBUG=true
APP_URL=http://localhost:8000

# Base de datos PostgreSQL
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=biblioteca_db
DB_USERNAME=tu_usuario_postgres
DB_PASSWORD=tu_contraseña_postgres

# Configuración de Sanctum
SANCTUM_STATEFUL_DOMAINS=localhost:3000,127.0.0.1:8000
```

### Instalación de PostgreSQL

#### En Ubuntu/Debian:

```bash
sudo apt update
sudo apt install postgresql postgresql-contrib
sudo systemctl start postgresql
sudo systemctl enable postgresql
```

#### En macOS:

```bash
# Con Homebrew
brew install postgresql
brew services start postgresql

# Crear usuario y base de datos
createuser --interactive --pwprompt
createdb biblioteca_db
```

#### En Windows:

1. Descargar PostgreSQL desde [postgresql.org](https://www.postgresql.org/download/windows/)
2. Ejecutar el instalador y seguir las instrucciones
3. Usar pgAdmin para crear la base de datos

### Estructura de Base de Datos

El sistema incluye las siguientes tablas principales:

-   **usuarios**: Información de usuarios de la biblioteca
-   **autores**: Datos de autores de libros
-   **libros**: Catálogo de libros con stock
-   **autor_libro**: Relación many-to-many entre autores y libros
-   **prestamos**: Registro de préstamos con estados y fechas
-   **personal_access_tokens**: Tokens de Sanctum para autenticación

## 📊 Datos de Prueba (Seeders)

Los seeders incluyen:

### UsuariosTableSeeder

-   10 usuarios ficticios con datos realistas
-   Nombres, apellidos, emails y fechas de nacimiento

### AutoresTableSeeder

-   15 autores famosos (García Márquez, Borges, Cervantes, etc.)
-   Datos biográficos completos

### LibrosTableSeeder

-   20 libros clásicos y contemporáneos
-   ISBNs únicos, stock variable, descripciones detalladas

### PrestamosTableSeeder

-   Préstamos aleatorios entre usuarios y libros
-   Estados variados (activo/devuelto)
-   Fechas realistas

## 🔐 Autenticación API

### Obtener Token de Autenticación

**Importante**: Esta aplicación no incluye endpoints de registro/login. Para testing, debes crear tokens manualmente:

#### Opción 1: Crear usuario nuevo

```bash
# Acceder a Tinker (consola interactiva de Laravel)
php artisan tinker

# Crear un usuario de prueba (si no existe)
$user = \App\Models\User::factory()->create([
    'name' => 'Usuario Test',
    'email' => 'test@biblioteca.com'
]);

# Generar token
$token = $user->createToken('api-token')->plainTextToken;
echo $token;
```

#### Opción 2: Usar usuario existente de los seeders

```bash
# Acceder a Tinker (consola interactiva de Laravel)
php artisan tinker

# Importar el modelo Usuario
use App\Models\Usuario;

# Obtener el primer usuario de los seeders
$user = Usuario::find(1);

# Generar token para el frontend
$token = $user->createToken('api-token');
echo $token->plainTextToken;
```

> **💡 Nota para desarrolladores Frontend**: Si el token expira durante el desarrollo, simplemente ejecuta los comandos de la "Opción 2" para generar un nuevo token y reemplaza la variable `API_TOKEN` en tu aplicación frontend.

### Usar el Token en Requests

Incluye el token en el header `Authorization` de todas las peticiones API:

```bash
Authorization: Bearer tu_token_aqui
```

Ejemplo con cURL:

```bash
curl -H "Authorization: Bearer 1|xxxxxxxxxxxxxxxxxxxxx" \
     -H "Content-Type: application/json" \
     http://localhost:8000/api/libros
```

## 📚 Documentación de la API

### Base URL

```
http://localhost:8000/api
```

### Endpoints Disponibles

#### 🔐 Autenticación

-   `GET /user` - Información del usuario autenticado

#### 📖 Libros

-   `GET /libros` - Listar libros (con filtros)
-   `GET /libros/{id}` - Obtener libro específico
-   `POST /libros` - Crear nuevo libro
-   `PUT /libros/{id}` - Actualizar libro
-   `DELETE /libros/{id}` - Eliminar libro

#### 📋 Préstamos

-   `GET /prestamos` - Listar préstamos
-   `POST /prestamos` - Crear préstamo
-   `PUT /prestamos/{id}/devolver` - Devolver préstamo

#### 👤 Autores

-   `DELETE /autores/{id}` - Eliminar autor

### Ejemplos de Uso

#### Listar Libros con Filtros

```bash
# Todos los libros
GET /api/libros

# Filtrar por título
GET /api/libros?titulo=quijote

# Filtrar por autor
GET /api/libros?autor=cervantes

# Filtrar por año
GET /api/libros?año=1605

# Combinar filtros
GET /api/libros?titulo=cien&autor=garcia
```

#### Crear un Libro

```bash
POST /api/libros
Content-Type: application/json

{
    "titulo": "Nuevo Libro",
    "isbn": "978-84-376-0494-7",
    "año_publicacion": 2023,
    "numero_paginas": 350,
    "descripcion": "Descripción del libro",
    "stock_disponible": 5,
    "autores": [1, 2]
}
```

#### Crear un Préstamo

```bash
POST /api/prestamos
Content-Type: application/json

{
    "usuario_id": 1,
    "libro_id": 1
}
```

### Validaciones y Reglas de Negocio

#### Libros

-   Título: requerido, máximo 255 caracteres
-   ISBN: requerido, único, máximo 255 caracteres
-   Año: entre 1900 y año actual
-   Páginas: mínimo 1
-   Stock: mínimo 0
-   Autores: al menos uno debe existir

#### Préstamos

-   Usuario no puede tener más de 3 préstamos activos
-   Libro debe tener stock disponible (> 0)
-   Duración automática: 15 días

#### Autores

-   No se puede eliminar si tiene libros asociados

## 🧪 Testing

### Ejecutar Tests

```bash
# Todos los tests
php artisan test

# Tests específicos
php artisan test --filter LibroTest
```

### Linting del Código

```bash
# Aplicar estilo de código Laravel
./vendor/bin/pint
```

## 📁 Estructura del Proyecto

```
biblioteca-app/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── Api/
│   │   │       ├── AutorController.php
│   │   │       ├── LibroController.php
│   │   │       └── PrestamoController.php
│   │   └── Requests/
│   │       ├── StoreLibroRequest.php
│   │       ├── UpdateLibroRequest.php
│   │       ├── StorePrestamoRequest.php
│   │       └── DevolverPrestamoRequest.php
│   └── Models/
│       ├── Autor.php
│       ├── AutorLibro.php
│       ├── Libro.php
│       ├── Prestamo.php
│       └── Usuario.php
├── database/
│   ├── migrations/
│   │   ├── 2025_09_22_140505_create_autores_table.php
│   │   ├── 2025_09_22_140506_create_libros_table.php
│   │   ├── 2025_09_22_140507_create_usuarios_table.php
│   │   ├── 2025_09_22_140508_create_autor_libro_table.php
│   │   └── 2025_09_22_140509_create_prestamos_table.php
│   └── seeders/
│       ├── AutoresTableSeeder.php
│       ├── LibrosTableSeeder.php
│       ├── UsuariosTableSeeder.php
│       └── PrestamosTableSeeder.php
├── routes/
│   ├── api.php
│   └── web.php
└── tests/
    ├── Feature/
    └── Unit/
```

## 🚀 Scripts de Desarrollo

### Comandos Composer Personalizados

```bash
# Desarrollo completo (servidor + cola + logs + vite)
composer run dev

# Tests
composer run test
```

### Comandos Artisan Útiles

```bash
# Ver rutas API
php artisan route:list --path=api

# Limpiar caché
php artisan config:clear
php artisan cache:clear

# Recrear base de datos completa
php artisan migrate:fresh --seed

# Generar nuevo token para usuario
php artisan tinker
>>> User::find(1)->createToken('api')->plainTextToken
```

## 🔒 Seguridad

-   **Autenticación requerida**: Todos los endpoints API protegidos con Sanctum
-   **Validación de entrada**: Request classes con reglas estrictas
-   **Soft Deletes**: Los libros se eliminan de forma segura
-   **Transacciones**: Operaciones críticas con rollback automático
-   **Rate Limiting**: Configurado en rutas API

## 📈 Rendimiento

-   **Paginación**: Listados limitados a 10 elementos
-   **Eager Loading**: Relaciones cargadas eficientemente
-   **Índices de Base de Datos**: En campos de búsqueda frecuente
-   **Cache**: Configurado para sessiones y queries

## 🐛 Troubleshooting

### Problemas Comunes

#### Error de conexión a PostgreSQL

```bash
# Verificar que PostgreSQL esté ejecutándose
sudo systemctl status postgresql

# En macOS con Homebrew
brew services start postgresql

# Verificar conexión desde la terminal
psql -h 127.0.0.1 -p 5432 -U tu_usuario -d biblioteca_db
```

#### Base de datos no existe

```bash
# Crear la base de datos manualmente
createdb biblioteca_db

# O desde psql
psql -U postgres
CREATE DATABASE biblioteca_db;
```

#### Token no válido

-   Verificar que el token esté en el header correcto
-   Regenerar token si es necesario

#### Migraciones fallan

```bash
php artisan migrate:fresh
php artisan db:seed
```

#### Composer dependencies

```bash
composer dump-autoload
php artisan config:clear
```

## 🤝 Contribución

1. Fork del proyecto
2. Crear rama para feature (`git checkout -b feature/AmazingFeature`)
3. Commit cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abrir Pull Request

## 📄 Licencia

Este proyecto está bajo la Licencia MIT. Ver `LICENSE` para más detalles.

## 🔮 Próximas Mejoras

-   [ ] Frontend con Vue.js/React
-   [ ] Sistema de notificaciones
-   [ ] Reportes de préstamos
-   [ ] API de búsqueda avanzada
-   [ ] Integración con servicios externos
-   [ ] Sistema de multas
-   [ ] Dashboard administrativo
-   [ ] Exportación de datos

---

**Desarrollado con ❤️ usando Laravel 12**

Para soporte o preguntas, contacta al equipo de desarrollo.
