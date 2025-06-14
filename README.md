# Nombre del Proyecto

Breve descripción del proyecto
Siempre trabajar en ramas fuera de Main y crear un Pull Request

## Requisitos Previos

- PHP [versión requerida, ej: 8.2+]
- Composer [versión requerida]
- MySQL/PostgreSQL/SQLite [según corresponda]
- Node.js [si usa frontend con herramientas como Vite]

## Configuración Inicial

Sigue estos pasos para configurar el proyecto localmente:

1. Clona el repositorio:
   ```bash
   git clone https://github.com/G3R-V/SMEDI12.git
   cd smedi12
   ```

2. Instala dependencias PHP:
   ```bash
   composer install
   ```

3. Configura el entorno:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Configura la base de datos:
   - Crea una base de datos local
   - Edita `.env` con tus credenciales:
     ```ini
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=smedi_db
     DB_USERNAME=usuario
     DB_PASSWORD=contraseña
     ```

5. Ejecuta migraciones y seeders:
   ```bash
   php artisan migrate
   ```

6. Instala dependencias frontend (si aplica):
   ```bash
   npm install
   npm run dev
   ```

7. Inicia el servidor:
   ```bash
   php artisan serve
   ```

## Flujo de Trabajo para Colaboradores

1. Sincroniza tu repositorio local:
   ```bash
   git checkout main
   git pull origin main
   ```

2. Crea una rama para tu feature/fix:
   ```bash
   git checkout -b tipo/descripcion-breve
   ```
   Ejemplos:
   - `feature/user-authentication`
   - `fix/login-validation`

3. Después de hacer cambios, crea un Pull Request a `main`
   ```bash
   # Sube tu rama al remoto (primera vez)
    git push -u origin feature/nombre-de-tu-funcionalidad
    # O en pushes posteriores:
    git push
   ```

## Problemas Comunes y Soluciones

- **Error al instalar dependencias**: Ejecuta `composer install --ignore-platform-reqs` si hay conflictos
- **Problemas con migraciones**: `php artisan migrate:fresh --seed`
- **Errores de frontend**: `npm install && npm run dev`