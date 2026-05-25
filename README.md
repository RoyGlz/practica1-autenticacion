# Prácticas Laravel - Autenticación, Validaciones y Relaciones

## Descripción
Proyecto Laravel 12 con Breeze que implementa autenticación, roles, validaciones avanzadas y relaciones Eloquent.

## Requisitos
- PHP 8.2+
- Composer
- Node.js y npm
- MySQL

## Instalación

1. Clonar el repositorio:
   git clone <url-del-repo>
   cd practica1-autenticacion

2. Instalar dependencias:
   composer install
   npm install && npm run dev

3. Configurar el entorno:
   cp .env.example .env
   php artisan key:generate

4. Configurar la base de datos en .env y luego:
   php artisan migrate
   php artisan db:seed --class=RoleSeeder

5. Iniciar el servidor:
   php artisan serve

## Credenciales de prueba
- Admin: admin@example.com / password123

## Práctica 1 - Autenticación y Roles
- Autenticación con Laravel Breeze
- Roles: admin, editor, viewer
- Middleware CheckRole para proteger rutas
- Gates para control de acceso

## Práctica 2 - Validaciones y Relaciones Eloquent
- CRUD completo de posts
- Validaciones con Form Requests y mensajes personalizados
- Relaciones: Post → Category, Post ↔ Tags, Post → Comments
- Autorización con Policies (editar/eliminar solo el autor o admin)