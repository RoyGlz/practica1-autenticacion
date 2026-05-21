# Práctica 1: Autenticación y Autorización con Laravel Breeze

## Objetivo
Implementar un sistema de autenticación seguro utilizando **Laravel Breeze**, incluyendo roles básicos (admin, editor, viewer) y control de acceso mediante **Middleware** y **Gates**.

## Tecnologías Utilizadas
- Laravel 10
- Laravel Breeze
- MySQL
- PHP 8.1
- Tailwind CSS

## Funcionalidades Implementadas
- Sistema completo de registro y login
- Gestión de Roles (Admin, Editor, Viewer)
- Relación Many-to-Many entre User y Role
- Middleware personalizado (`CheckRole`)
- Gates para autorización
- Dashboard protegido según rol
- Error 403 para accesos no autorizados

## Instalación

```bash
# 1. Clonar el repositorio
git clone https://github.com/TU_USUARIO/practica1-autenticacion.git

# 2. Entrar a la carpeta
cd practica1-autenticacion

# 3. Instalar dependencias
composer install
npm install && npm run dev

# 4. Configurar archivo de entorno
cp .env.example .env
php artisan key:generate

# 5. Configurar base de datos y ejecutar migraciones
php artisan migrate --seed

# 6. Ejecutar el proyecto
php artisan serve