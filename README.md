# 📋 Formulario de Solicitudes

Un proyecto web completo y responsivo para gestionar solicitudes con formulario dinámico que obtiene datos mediante APIs PHP.

## 🚀 Características

- **Formulario Responsivo**: Diseño adaptable para móviles, tablets y escritorio
- **Campos Dinámicos**: Los selects se cargan mediante llamadas AJAX a endpoints PHP
- **Validación en Tiempo Real**: Validación de campos mientras el usuario escribe
- **Interfaz Moderna**: Diseño atractivo con animaciones y efectos visuales
- **Manejo de Errores**: Sistema robusto de manejo de errores y mensajes al usuario
- **API REST**: Endpoints PHP bien estructurados para datos y envío de formularios

## 📁 Estructura del Proyecto

```
proyecto/
├── index.html              # Página principal con el formulario
├── styles.css              # Estilos CSS responsivos
├── script.js               # JavaScript para funcionalidad del formulario
├── .htaccess               # Configuración del servidor Apache
├── README.md               # Documentación del proyecto
├── api/                    # Directorio de la API PHP
│   ├── config.php          # Configuración general de la API
│   ├── get_status.php      # Endpoint para obtener status
│   ├── get_tipos.php       # Endpoint para obtener tipos
│   ├── get_prioridades.php # Endpoint para obtener prioridades
│   ├── get_medios.php      # Endpoint para obtener medios
│   └── submit_form.php     # Endpoint para procesar el formulario
└── data/                   # Directorio para almacenar datos (se crea automáticamente)
    ├── solicitudes.json    # Archivo con las solicitudes enviadas
    └── notifications.log   # Log de notificaciones
```

## 🛠️ Instalación y Configuración

### Requisitos
- Servidor web con PHP 7.4 o superior
- Apache con mod_rewrite habilitado
- Navegador web moderno

### Pasos de Instalación

1. **Clonar o descargar** los archivos del proyecto en el directorio web del servidor

2. **Configurar el servidor web**:
   - Asegúrate de que PHP esté habilitado
   - Verifica que mod_rewrite esté activo en Apache
   - El archivo `.htaccess` ya incluye la configuración necesaria

3. **Permisos de archivos**:
   ```bash
   chmod 755 api/
   chmod 644 api/*.php
   chmod 755 data/ (se creará automáticamente)
   ```

4. **Abrir en el navegador**:
   - Accede a `http://tu-servidor/ruta-del-proyecto/`
   - El formulario debería cargar automáticamente

## 📝 Campos del Formulario

| Campo | Tipo | Descripción | Requerido |
|-------|------|-------------|-----------|
| **Status** | Select | Estado de la solicitud (cargado vía PHP) | ✅ |
| **Tipo** | Select | Tipo de solicitud (cargado vía PHP) | ✅ |
| **Quien Solicita** | Texto | Nombre de la persona que solicita | ✅ |
| **Indicaciones** | Textarea | Descripción detallada de la solicitud | ✅ |
| **Fecha Planeada** | Date | Fecha programada con selector de calendario | ✅ |
| **Prioridad** | Select | Nivel de prioridad (cargado vía PHP) | ✅ |
| **Medio** | Select | Medio de comunicación preferido (cargado vía PHP) | ✅ |

## 🔧 API Endpoints

### GET Endpoints (Obtener Datos)

- **GET** `/api/get_status.php` - Obtiene los status disponibles
- **GET** `/api/get_tipos.php` - Obtiene los tipos de solicitud
- **GET** `/api/get_prioridades.php` - Obtiene los niveles de prioridad
- **GET** `/api/get_medios.php` - Obtiene los medios de comunicación

### POST Endpoints (Envío de Datos)

- **POST** `/api/submit_form.php` - Procesa y guarda la solicitud del formulario

### Formato de Respuesta

Todos los endpoints devuelven JSON con el siguiente formato:

```json
{
  "success": true,
  "message": "Mensaje descriptivo",
  "data": [...],
  "timestamp": "2024-01-01 12:00:00"
}
```

## 🎨 Características del Diseño

### Responsivo
- **Desktop**: Diseño en grid de 2 columnas
- **Tablet**: Adaptación para pantallas medianas
- **Mobile**: Layout de una columna con botones apilados

### Elementos Visuales
- Gradientes modernos en header y botones
- Iconos de FontAwesome para mejor UX
- Animaciones suaves en hover y focus
- Indicadores de carga durante las peticiones AJAX
- Validación visual con colores (verde/rojo)

### Accesibilidad
- Etiquetas semánticamente correctas
- Soporte para lectores de pantalla
- Navegación por teclado
- Contraste adecuado de colores

## 💻 Funcionalidades JavaScript

### Características Principales
- **Carga Asíncrona**: Los selects se cargan sin bloquear la UI
- **Validación en Tiempo Real**: Feedback inmediato al usuario
- **Manejo de Errores**: Mensajes claros en caso de problemas
- **Estados de Carga**: Indicadores visuales durante las operaciones
- **Sanitización**: Los datos se limpian antes del envío

### Eventos Principales
```javascript
// Carga inicial de datos
document.addEventListener('DOMContentLoaded', () => {
    new FormularioSolicitud();
});

// Validación en tiempo real
input.addEventListener('blur', () => this.validateField(input));

// Envío del formulario
form.addEventListener('submit', (e) => this.handleSubmit(e));
```

## 🔒 Seguridad

### Medidas Implementadas
- **Sanitización de Datos**: Todos los inputs se limpian
- **Validación del Servidor**: Validación dual (cliente y servidor)
- **Headers de Seguridad**: Configurados en .htaccess
- **Manejo de Errores**: No exposición de información sensible
- **CORS**: Configuración apropiada para APIs

## 📊 Datos de Ejemplo

Los endpoints PHP incluyen datos de ejemplo realistas:

### Status Disponibles
- Pendiente, En Proceso, En Espera, Completado, Cancelado, Rechazado

### Tipos de Solicitud
- Soporte Técnico, Mantenimiento, Instalación, Configuración, Capacitación, Consulta, Desarrollo, Emergencia

### Niveles de Prioridad
- Baja (48-72h), Normal (24-48h), Alta (4-8h), Crítica (1-2h), Emergencia (Inmediato)

### Medios de Comunicación
- Email, Teléfono, WhatsApp, Teams, Slack, Presencial, Videoconferencia, Sistema de Tickets, Portal Web

## 🚀 Personalización

### Modificar Datos de los Selects
Edita los archivos en `/api/` para cambiar las opciones:
- `get_status.php` - Para modificar los status
- `get_tipos.php` - Para cambiar los tipos
- `get_prioridades.php` - Para ajustar prioridades
- `get_medios.php` - Para actualizar medios

### Cambiar Estilos
Modifica `styles.css` para personalizar:
- Colores del tema
- Tipografías
- Espaciados
- Animaciones
- Breakpoints responsive

### Agregar Funcionalidades
Extiende `script.js` para añadir:
- Nuevas validaciones
- Campos adicionales
- Integraciones con APIs externas
- Funcionalidades avanzadas

## 🐛 Solución de Problemas

### Problemas Comunes

1. **Los selects no cargan**:
   - Verifica que PHP esté funcionando
   - Revisa los logs del servidor web
   - Confirma que los archivos PHP tienen permisos correctos

2. **Error de CORS**:
   - Asegúrate de que `.htaccess` esté funcionando
   - Verifica la configuración de headers en `config.php`

3. **El formulario no se envía**:
   - Revisa la consola del navegador para errores JavaScript
   - Confirma que el endpoint `submit_form.php` sea accesible

4. **Estilos no se ven correctamente**:
   - Verifica que `styles.css` se esté cargando
   - Revisa la consola para errores de CSS

## 📱 Compatibilidad

### Navegadores Soportados
- Chrome 80+
- Firefox 75+
- Safari 13+
- Edge 80+

### Dispositivos
- ✅ Desktop (1200px+)
- ✅ Laptop (992px - 1199px)
- ✅ Tablet (768px - 991px)
- ✅ Mobile (320px - 767px)

## 🤝 Contribuciones

Para contribuir al proyecto:

1. Fork el repositorio
2. Crea una rama para tu feature (`git checkout -b feature/nueva-funcionalidad`)
3. Commit tus cambios (`git commit -am 'Agregar nueva funcionalidad'`)
4. Push a la rama (`git push origin feature/nueva-funcionalidad`)
5. Crea un Pull Request

## 📄 Licencia

Este proyecto está bajo la Licencia MIT. Consulta el archivo `LICENSE` para más detalles.

## 🆘 Soporte

Si necesitas ayuda o tienes preguntas:

1. Revisa la documentación completa
2. Consulta la sección de solución de problemas
3. Verifica los logs del servidor
4. Contacta al desarrollador

---

**¡Disfruta usando el Formulario de Solicitudes! 🎉**
