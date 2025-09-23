# Sistema de Solicitudes con Integración a Notion

Este es un sistema de solicitudes desarrollado en Laravel que se integra con la API de Notion para gestionar solicitudes de manera eficiente.

## Características

- ✅ **Arquitectura MVC**: Implementación completa del patrón Modelo-Vista-Controlador
- ✅ **Integración con Notion API**: Conexión directa con la base de datos de Notion
- ✅ **Formulario dinámico**: Los campos se cargan automáticamente desde Notion
- ✅ **Validación en tiempo real**: Validación del lado del cliente y servidor
- ✅ **Interfaz moderna**: Diseño responsive y atractivo
- ✅ **Base de datos local**: Almacenamiento local de las solicitudes
- ✅ **API RESTful**: Endpoints para integración con otros sistemas

## Requisitos del Sistema

- PHP 8.1 o superior
- Composer
- SQLite (incluido por defecto)
- Conexión a internet para la API de Notion

## 🚀 Cómo Ejecutar el Proyecto

### Requisitos Previos

Antes de comenzar, asegúrate de tener instalado:

- **PHP 8.2 o superior** (recomendado PHP 8.4)
- **Composer** (gestor de dependencias de PHP)
- **Git** (control de versiones)
- **Conexión a internet** (para la API de Notion)

### Verificar Requisitos

```bash
# Verificar versión de PHP
php --version

# Verificar Composer
composer --version

# Verificar Git
git --version
```

### Instalación Paso a Paso

#### 1. **Clonar el Repositorio**
```bash
git clone <repository-url>
cd laravel-app
```

#### 2. **Instalar Dependencias de PHP**
```bash
composer install
```

#### 3. **Configurar Variables de Entorno**
```bash
# Copiar archivo de configuración
cp .env.example .env

# Generar clave de aplicación
php artisan key:generate
```

#### 4. **Configurar Credenciales de Notion**

Edita el archivo `.env` y configura las siguientes variables:

```env
# Configuración de Notion
NOTION_API_TOKEN=tu_token_de_notion_aqui
NOTION_DATABASE_ID=tu_database_id_aqui
NOTION_VERSION=2022-06-28

# Configuración de la aplicación
APP_NAME="Sistema de Solicitudes Notion"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Base de datos (SQLite por defecto)
DB_CONNECTION=sqlite
```

#### 5. **Configurar Base de Datos**
```bash
# Crear archivo de base de datos SQLite
touch database/database.sqlite

# Ejecutar migraciones
php artisan migrate
```

#### 6. **Iniciar el Servidor de Desarrollo**
```bash
php artisan serve
```

### ✅ Verificación de la Instalación

Una vez completados todos los pasos, deberías ver:

```
INFO  Server running on [http://127.0.0.1:8000].
Press Ctrl+C to stop the server
```

### 🌐 Acceder a la Aplicación

Abre tu navegador y ve a:
```
http://localhost:8000
```

Deberías ver el formulario de solicitudes funcionando correctamente.

## 📋 Instalación Rápida (Script Automatizado)

Si prefieres una instalación más rápida, puedes usar este script:

```bash
#!/bin/bash
# Script de instalación automática

echo "🚀 Instalando Sistema de Solicitudes Notion..."

# Instalar dependencias
echo "📦 Instalando dependencias..."
composer install

# Configurar entorno
echo "⚙️ Configurando entorno..."
cp .env.example .env
php artisan key:generate

# Configurar base de datos
echo "🗄️ Configurando base de datos..."
touch database/database.sqlite
php artisan migrate

echo "✅ Instalación completada!"
echo "🌐 Inicia el servidor con: php artisan serve"
echo "🔗 Luego ve a: http://localhost:8000"
```

## 🔧 Comandos Útiles

### Desarrollo
```bash
# Iniciar servidor
php artisan serve

# Limpiar cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Ver rutas disponibles
php artisan route:list

# Ver logs en tiempo real
php artisan pail
```

### Base de Datos
```bash
# Ejecutar migraciones
php artisan migrate

# Revertir migraciones
php artisan migrate:rollback

# Recrear base de datos
php artisan migrate:fresh

# Ver estado de migraciones
php artisan migrate:status
```

### Testing
```bash
# Ejecutar tests
php artisan test

# Ejecutar tests con coverage
php artisan test --coverage
```

## Uso

### Acceso a la Aplicación

Una vez iniciado el servidor, accede a:
```
http://localhost:8000
```

### Formulario de Solicitud

El formulario incluye los siguientes campos:

- **Status**: Estado de la solicitud (PENDIENTE, APROBADA, DENEGADA)
- **Tipo**: Tipo de solicitud (COMERCIAL, COBERTURA, etc.)
- **Quien Solicita**: Nombre de la persona que solicita
- **Indicaciones**: Descripción detallada de la solicitud
- **Fecha Planeada**: Fecha en que se planea ejecutar
- **Prioridad**: Nivel de prioridad (Alta, Media, Baja)
- **Medio**: Medio de comunicación (TV, WEB, RRSS, PRINT)

### API Endpoints

#### Obtener Opciones de Campos

```bash
# Status
GET /api/notion/status

# Tipos
GET /api/notion/tipo

# Prioridades
GET /api/notion/prioridad

# Medios
GET /api/notion/medio
```

#### Crear Solicitud

```bash
POST /solicitud
Content-Type: application/json

{
    "status": "PENDIENTE",
    "tipo": "COMERCIAL",
    "solicitante": "Juan Pérez",
    "indicaciones": "Solicitud de cobertura para evento",
    "fecha_planeada": "2025-09-25",
    "prioridad": "Alta",
    "medio": "TV"
}
```

#### Listar Solicitudes

```bash
GET /solicitud/list
```

## Estructura del Proyecto

```
laravel-app/
├── app/
│   ├── Http/Controllers/
│   │   ├── SolicitudController.php
│   │   └── Api/NotionController.php
│   ├── Models/
│   │   ├── Solicitud.php
│   │   ├── Status.php
│   │   ├── Tipo.php
│   │   ├── Prioridad.php
│   │   └── Medio.php
│   └── Services/
│       └── NotionService.php
├── config/
│   └── notion.php
├── database/migrations/
├── resources/views/
│   └── solicitud/
│       └── index.blade.php
└── routes/
    └── web.php
```

## Configuración de Notion

### 1. Crear una Integración en Notion

1. Ve a [Notion Developers](https://www.notion.so/my-integrations)
2. Crea una nueva integración
3. Copia el "Internal Integration Token"

### 2. Configurar la Base de Datos

La base de datos en Notion debe tener las siguientes propiedades:

- **title** (Title): Título de la solicitud
- **STATUS** (Select): Estado de la solicitud
- **FECHA PLANEADA** (Date): Fecha planeada
- **TIPO** (Select): Tipo de solicitud
- **QUIEN SOLICITA** (Rich Text): Nombre del solicitante
- **PRIORIDAD** (Select): Prioridad de la solicitud
- **MEDIO** (Multi-select): Medios de comunicación
- **INDICACIONES** (Rich Text): Descripción detallada

### 3. Compartir la Base de Datos

1. En la página de la base de datos, haz clic en "Share"
2. Invita a tu integración
3. Copia el ID de la base de datos de la URL

## Características Técnicas

### Servicios

- **NotionService**: Maneja toda la comunicación con la API de Notion
- **Validación**: Validación robusta tanto en frontend como backend
- **Manejo de Errores**: Logging detallado y mensajes de error amigables

### Base de Datos

- **SQLite**: Base de datos ligera para desarrollo
- **Migraciones**: Control de versiones de la base de datos
- **Relaciones**: Modelos relacionados para mejor organización

### Frontend

- **JavaScript Vanilla**: Sin dependencias externas pesadas
- **Responsive Design**: Adaptable a diferentes dispositivos
- **Validación en Tiempo Real**: Feedback inmediato al usuario

## Desarrollo

### Ejecutar Tests

```bash
php artisan test
```

### Generar Documentación

```bash
php artisan route:list
```

### Limpiar Cache

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

## Solución de Problemas

### Error de Conexión con Notion

1. Verifica que el token de API sea correcto
2. Asegúrate de que la integración tenga acceso a la base de datos
3. Verifica que el ID de la base de datos sea correcto

### Error de Validación

1. Revisa que todos los campos requeridos estén completos
2. Verifica que las fechas sean futuras
3. Asegúrate de que los valores de los selects sean válidos

### Error de Base de Datos

1. Ejecuta las migraciones: `php artisan migrate`
2. Verifica que SQLite esté habilitado
3. Revisa los permisos de escritura en la carpeta `database/`

## Contribución

1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

## Licencia

Este proyecto está bajo la Licencia MIT. Ver el archivo `LICENSE` para más detalles.

## Soporte

Para soporte técnico o preguntas, contacta al equipo de desarrollo.

---

**Desarrollado con ❤️ usando Laravel y Notion API**