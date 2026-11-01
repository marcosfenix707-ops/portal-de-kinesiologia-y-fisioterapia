# Sistema de gestión documental web y portal institucional
**Carrera de Kinesiología y Fisioterapia – Universidad Nacional “Siglo XX”**
Laravel 13 · PHP 8.3+ · MySQL · Bootstrap 5

Esta carpeta contiene **solo los archivos propios del sistema**. Se copian sobre un proyecto Laravel nuevo.

## 1. Requisitos
- PHP 8.3 o superior con extensiones: pdo_mysql, mbstring, openssl, fileinfo, ctype, json, tokenizer, xml, curl.
- Composer 2 y MySQL 8 (o MariaDB). Con XAMPP, agregue `C:\xampp\mysql\bin` y `C:\xampp\php` al PATH (la carpeta mysql\bin contiene `mysqldump`, que se usa para los respaldos).
- Conexión a internet (Bootstrap y los íconos se cargan desde CDN, y el mapa es de Google Maps).

## 2. Instalación paso a paso
```bash
# 1) Crear el proyecto Laravel base
composer create-project laravel/laravel kinesiologia
cd kinesiologia

# 2) Copiar encima TODO el contenido de esta carpeta (acepte reemplazar los archivos existentes:
#    bootstrap/app.php, routes/web.php, routes/console.php, app/Providers/AppServiceProvider.php,
#    app/Models/User.php y database/seeders/DatabaseSeeder.php)
```
3) Cree la base de datos en MySQL:
```sql
CREATE DATABASE kinesiologia CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```
4) Edite el archivo `.env`:
```
APP_NAME="Kinesiología y Fisioterapia"
APP_LOCALE=es
APP_FALLBACK_LOCALE=es
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kinesiologia
DB_USERNAME=root
DB_PASSWORD=

# Opcionales (datos de la carrera)
SIA_URL=http://siaa.unsxx.edu.bo/
MOODLE_URL=
CARRERA_CORREO=
CARRERA_TELEFONO=
MAPA_BUSQUEDA="Universidad Nacional Siglo XX, Llallagua, Potosí, Bolivia"
```
En `config/app.php` cambie la zona horaria a `'America/La_Paz'`.

5) Cree las tablas, cargue los datos iniciales y arranque:
```bash
php artisan migrate --seed
php artisan storage:link
php artisan serve
```
- Portal público: http://127.0.0.1:8000
- Panel: http://127.0.0.1:8000/acceso
- Usuario inicial: `admin@carrera.local` / contraseña `Admin2026!` → **cámbiela de inmediato** en “Usuarios y roles”.

## 3. Respaldos automáticos
- Manual: `php artisan respaldo:generar` (o el botón en el panel, sección Respaldos). Los archivos quedan en `storage/app/private/respaldos`.
- Automático (diario 02:00): programe cada minuto `php artisan schedule:run`
  - Linux: `* * * * * cd /ruta/proyecto && php artisan schedule:run >> /dev/null 2>&1`
  - Windows: Programador de tareas → ejecutar `php artisan schedule:run` cada minuto.

## 4. Publicación en un hosting
1. En `.env`: `APP_ENV=production`, `APP_DEBUG=false`, y la URL real con **HTTPS**.
2. La carpeta pública del dominio debe apuntar a `public/`.
3. Ejecute `composer install --no-dev --optimize-autoloader`, `php artisan migrate --force --seed`, `php artisan storage:link` y `php artisan config:cache route:cache view:cache`.

## 5. Guía del código (para explicar en la defensa)
| Carpeta / archivo | Qué contiene |
|---|---|
| `routes/web.php` | Todas las direcciones del sistema: portal público, acceso y panel `/admin`. |
| `app/Http/Controllers/PublicController.php` | Lógica del portal: inicio, la carrera, noticias, documentos, buscador, preinscripción y contacto. |
| `app/Http/Controllers/LoginController.php` | Inicio y cierre de sesión con límite de intentos. |
| `app/Http/Controllers/Admin/*` | Gestión de documentos, categorías, noticias, contenidos, preinscripciones, consultas, usuarios y respaldos. |
| `app/Http/Middleware/RolMiddleware.php` | Control de acceso por rol (administrador / personal). |
| `app/Models/*` | Las 8 tablas como clases (Eloquent ORM) y sus relaciones. |
| `database/migrations/*` | Estructura de la base de datos con control de versiones. |
| `database/seeders/DatabaseSeeder.php` | Roles, usuario inicial, categorías y contenidos reales de la carrera. |
| `resources/views/public`, `auth` | Pantallas del portal (Blade + Bootstrap). |
| `resources/views/admin` | Pantallas del panel de administración. |
| `app/Console/Commands/GenerarRespaldo.php` | Comando de respaldo con `mysqldump`. |
| `app/Support/Texto.php` | Convierte texto del panel en HTML seguro (escapa todo). |
| `config/carrera.php` | Datos de la carrera y enlaces (SIA, Moodle, mapa). |
| `public/css/app.css`, `public/js/app.js` | Estilos y animaciones propias. |

## 6. Seguridad implementada
- Contraseñas cifradas con *hash*; límite de 5 intentos de inicio de sesión por correo e IP.
- Control de acceso por roles en el servidor (administrador / personal) y usuarios que se pueden desactivar.
- Consultas con Eloquent (parametrizadas, previenen inyección SQL) y plantillas Blade que escapan el contenido (previenen XSS).
- Token CSRF en todos los formularios; campo trampa y límite de envíos en preinscripción y contacto.
- Documentos subidos con validación de tipo y tamaño (máx. 20 MB), guardados **fuera de la carpeta pública** y servidos solo por el sistema; los documentos “internos” exigen sesión iniciada.
- Respaldos automáticos de la base de datos (últimos 14).

## 7. Estado de verificación
Este código se escribió y revisó sin poder ejecutar Laravel completo (el entorno de desarrollo no tenía PHP con Composer). Se verificó: sintaxis de los 36 archivos PHP; compilación de las 28 plantillas Blade con el compilador de Laravel 13; existencia en Laravel 13 de todas las funciones usadas; y coherencia de las 54 rutas, vistas y métodos. **La primera ejecución puede requerir pequeños ajustes**; anote cualquier mensaje de error y corríjalo antes de las pruebas.

## 8. Datos que debe completar
- Plantel docente y horarios (secciones editables desde el panel → “Contenidos de la carrera”).
- Correo, teléfono y enlace exacto de Moodle del Área Salud (`.env`).
- Ubicación exacta para el mapa (`MAPA_BUSQUEDA`).
- Logo oficial de la carrera (agregarlo en `public/` y mostrarlo en `resources/views/layouts/public.blade.php`).
