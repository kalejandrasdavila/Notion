# Configuración de Variables de Entorno

Para que la aplicación funcione correctamente, necesitas configurar las siguientes variables de entorno:

## Crear archivo .env

Copia el archivo `.env.example` (si existe) o crea un nuevo archivo `.env` en la raíz del proyecto Laravel.

## Variables requeridas para Notion

Agrega las siguientes variables a tu archivo `.env`:

```env
# Notion API Configuration
NOTION_API_TOKEN=tu_token_de_notion_aqui
NOTION_DATABASE_ID=tu_database_id_aqui
NOTION_VERSION=2022-06-28
```

## Obtener el token de Notion

1. Ve a https://www.notion.so/my-integrations
2. Crea una nueva integración
3. Copia el token generado
4. Pégalo en la variable `NOTION_API_TOKEN`

## Obtener el Database ID

1. Abre tu base de datos de Notion
2. Copia el ID de la URL (la parte después de la última barra diagonal)
3. Pégalo en la variable `NOTION_DATABASE_ID`

## Importante

- **NUNCA** subas el archivo `.env` al repositorio
- El archivo `.env` debe estar en `.gitignore`
- Usa `.env.example` como plantilla para otros desarrolladores