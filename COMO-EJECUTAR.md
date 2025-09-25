# 🚀 Cómo Ejecutar el Proyecto - Guía Paso a Paso

## 📋 Resumen Rápido

Este es un **Sistema de Solicitudes con Integración a Notion** desarrollado en Laravel. La aplicación principal está en la carpeta `laravel-app/`.

## ⚡ Ejecución Rápida (3 minutos)

```bash
# 1. Navegar al proyecto
cd laravel-app

# 2. Instalar dependencias
composer install

# 3. Configurar entorno
cp .env.example .env
php artisan key:generate

# 4. Configurar base de datos
touch database/database.sqlite
php artisan migrate

# 5. Iniciar servidor
php artisan serve

# 6. Abrir navegador
# http://localhost:8000
```

## 🔍 Verificación de Requisitos

Antes de comenzar, verifica que tengas:

```bash
# Verificar PHP (necesario 8.2+)
php --version

# Verificar Composer
composer --version

# Verificar Git
git --version
```

**Requisitos mínimos:**
- PHP 8.2 o superior
- Composer
- SQLite (incluido con PHP)
- Conexión a internet

## 📝 Configuración Detallada

### 1. **Configurar Notion (Opcional pero Recomendado)**

Si quieres usar la integración con Notion:

1. Ve a [Notion Developers](https://www.notion.so/my-integrations)
2. Crea una nueva integración
3. Copia el "Internal Integration Token"
4. Edita el archivo `.env` en `laravel-app/`:

```env
NOTION_API_TOKEN=tu_token_de_notion_aqui
NOTION_DATABASE_ID=tu_database_id_aqui
NOTION_VERSION=2022-06-28
```

### 2. **Configuración de Base de Datos**

El proyecto usa SQLite por defecto (no requiere instalación adicional):

```bash
cd laravel-app
touch database/database.sqlite
php artisan migrate
```

### 3. **Configuración de la Aplicación**

```bash
# Generar clave de aplicación
php artisan key:generate

# Limpiar cache (si es necesario)
php artisan config:clear
php artisan cache:clear
```

## 🌐 Acceso a la Aplicación

Una vez iniciado el servidor:

```
http://localhost:8000
```

**Deberías ver:**
- Formulario de solicitudes con diseño moderno
- Campos que se cargan dinámicamente
- Validación en tiempo real
- Multi-select para medios

## 🧪 Pruebas del Sistema

### Prueba Básica
1. Llena el formulario con datos de prueba
2. En el campo "Medio", selecciona múltiples opciones (Ctrl+clic)
3. Haz clic en "Enviar Solicitud"
4. Deberías ver: "¡Solicitud enviada exitosamente!"

### Prueba de API
```bash
# Probar endpoint de opciones
curl http://localhost:8000/api/options/tipo

# Probar envío de formulario
curl -X POST http://localhost:8000/solicitud \
  -F "tipo=test" \
  -F "solicitante=test" \
  -F "indicaciones=test" \
  -F "fecha_planeada=2025-09-25" \
  -F "prioridad=test" \
  -F "medio[]=test1" \
  -F "medio[]=test2"
```

## 🔧 Comandos de Desarrollo

### Servidor
```bash
# Iniciar servidor
php artisan serve

# Iniciar en puerto específico
php artisan serve --port=8080

# Iniciar con host específico
php artisan serve --host=0.0.0.0
```

### Base de Datos
```bash
# Ver estado de migraciones
php artisan migrate:status

# Revertir última migración
php artisan migrate:rollback

# Recrear base de datos
php artisan migrate:fresh

# Ver logs de base de datos
php artisan pail
```

### Debugging
```bash
# Ver logs en tiempo real
php artisan pail

# Limpiar todos los caches
php artisan optimize:clear

# Ver rutas disponibles
php artisan route:list

# Ver configuración
php artisan config:show
```

## 🐛 Solución de Problemas

### Error: "Class not found"
```bash
composer install
composer dump-autoload
```

### Error: "Table doesn't exist"
```bash
php artisan migrate
```

### Error: "Permission denied"
```bash
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
```

### Error: "CSRF token mismatch"
- Verifica que el meta tag CSRF esté en el HTML
- Revisa la configuración de sesiones

### Error: "Notion API error"
- Verifica el token en `.env`
- Confirma que la integración tenga acceso a la base de datos
- Revisa los logs: `php artisan pail`

## 📊 Estructura de Archivos Importantes

```
laravel-app/
├── .env                          # Variables de entorno
├── artisan                       # CLI de Laravel
├── composer.json                 # Dependencias
├── database/
│   ├── database.sqlite          # Base de datos SQLite
│   └── migrations/              # Migraciones
├── app/
│   ├── Http/Controllers/        # Controladores
│   ├── Models/                  # Modelos
│   └── Services/                # Servicios (Notion)
├── resources/views/
│   └── solicitud/
│       └── index.blade.php      # Vista principal
├── routes/
│   └── web.php                  # Rutas web
└── storage/logs/
    └── laravel.log              # Logs de la aplicación
```

## 🎯 Funcionalidades Principales

### Formulario de Solicitudes
- **Area**: Select con opciones de Notion
- **Quien Solicita**: Campo de texto
- **Indicaciones**: Textarea para descripción
- **Fecha Planeada**: Selector de fecha
- **Prioridad**: Select con opciones de Notion
- **Medio**: Multi-select con opciones de Notion

### Características Técnicas
- **Validación en Tiempo Real**: Feedback inmediato
- **Carga Asíncrona**: Los selects se cargan vía AJAX
- **Multi-Select**: Selección múltiple de medios
- **Responsive**: Adaptable a móviles y tablets
- **Integración Notion**: Sincronización automática

## 📱 Compatibilidad

### Navegadores
- ✅ Chrome 80+
- ✅ Firefox 75+
- ✅ Safari 13+
- ✅ Edge 80+

### Dispositivos
- ✅ Desktop (1200px+)
- ✅ Laptop (992px - 1199px)
- ✅ Tablet (768px - 991px)
- ✅ Mobile (320px - 767px)

## 🆘 Obtener Ayuda

1. **Revisa los logs**: `php artisan pail`
2. **Consulta la consola del navegador** (F12)
3. **Verifica la configuración** en `.env`
4. **Revisa la documentación** en `laravel-app/README.md`

## ✅ Verificación Final

Si todo está funcionando correctamente, deberías ver:

1. ✅ Servidor iniciado: `INFO Server running on [http://127.0.0.1:8000]`
2. ✅ Formulario cargado en el navegador
3. ✅ Selects cargando opciones automáticamente
4. ✅ Validación funcionando en tiempo real
5. ✅ Envío exitoso del formulario
6. ✅ Mensaje de éxito: "¡Solicitud enviada exitosamente!"

---

**🎉 ¡El sistema está listo para usar! Si tienes algún problema, revisa la sección de solución de problemas o consulta los logs.**
