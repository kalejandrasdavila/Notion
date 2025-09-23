<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .form-wrapper {
            padding: 40px;
        }

        .form-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .form-header h1 {
            color: #333;
            font-size: 2.5rem;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }

        .form-header p {
            color: #666;
            font-size: 1.1rem;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-label {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }

        .required {
            color: #e74c3c;
        }

        .form-input,
        .form-select,
        .form-textarea {
            padding: 12px 16px;
            border: 2px solid #e1e8ed;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-select[multiple] {
            min-height: 120px;
            padding: 8px 12px;
        }

        .form-select[multiple] option {
            padding: 8px 12px;
            margin: 2px 0;
            border-radius: 4px;
        }

        .form-select[multiple] option:checked {
            background: #667eea;
            color: white;
        }

        .form-text {
            font-size: 0.875rem;
            color: #6c757d;
            margin-top: 5px;
        }

        .form-actions {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
        }

        .btn {
            padding: 15px 30px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }

        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none !important;
        }

        .loading {
            display: none;
            align-items: center;
            gap: 8px;
            color: #667eea;
            font-size: 14px;
            margin-top: 5px;
        }

        .loading.show {
            display: flex;
        }

        .message-container {
            margin-top: 20px;
        }

        .message {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 500;
        }

        .message.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .message.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .message.info {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }

        .invalid {
            border-color: #e74c3c !important;
            background: #fdf2f2 !important;
        }

        .valid {
            border-color: #27ae60 !important;
            background: #f0fff4 !important;
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
            
            .form-header h1 {
                font-size: 2rem;
            }
            
            .form-wrapper {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-wrapper">
            <div class="form-header">
                <h1><i class="fas fa-clipboard-list"></i> Formulario de Solicitud</h1>
                <p>Complete todos los campos para enviar su solicitud</p>
            </div>
            
            <form id="solicitudForm" class="form">
                @csrf
                <div class="form-grid">
                    <!-- Status (oculto) -->
                    <input type="hidden" id="status" name="status" value="PENDIENTE">
        
                    <!-- Tipo -->
                    <div class="form-group">
                        <label for="tipo" class="form-label">
                            <i class="fas fa-tag"></i>
                            Area <span class="required">*</span>
                        </label>
                        <select id="tipo" name="tipo" class="form-select" required>
                            <option value="">Seleccione un tipo...</option>
                        </select>
                        <div class="loading" id="tipoLoading">
                            <i class="fas fa-spinner fa-spin"></i> Cargando...
                        </div>
                    </div>

                    <!-- Quien solicita -->
                    <div class="form-group">
                        <label for="solicitante" class="form-label">
                            <i class="fas fa-user"></i>
                            Quien Solicita <span class="required">*</span>
                        </label>
                        <input type="text" id="solicitante" name="solicitante" class="form-input" 
                               placeholder="Ingrese el nombre de quien solicita" required>
                    </div>

                    <!-- Indicaciones -->
                    <div class="form-group full-width">
                        <label for="indicaciones" class="form-label">
                            <i class="fas fa-list-ul"></i>
                            Indicaciones a Seguir <span class="required">*</span>
                        </label>
                        <textarea id="indicaciones" name="indicaciones" class="form-textarea" 
                                  placeholder="Describa las indicaciones detalladamente..." 
                                  rows="4" required></textarea>
                    </div>

                    <!-- Fecha planeada -->
                    <div class="form-group">
                        <label for="fecha_planeada" class="form-label">
                            <i class="fas fa-calendar-alt"></i>
                            Fecha Planeada <span class="required">*</span>
                        </label>
                        <input type="date" id="fecha_planeada" name="fecha_planeada" class="form-input" required>
                    </div>

                    <!-- Prioridad -->
                    <div class="form-group">
                        <label for="prioridad" class="form-label">
                            <i class="fas fa-exclamation-triangle"></i>
                            Prioridad <span class="required">*</span>
                        </label>
                        <select id="prioridad" name="prioridad" class="form-select" required>
                            <option value="">Seleccione prioridad...</option>
                        </select>
                        <div class="loading" id="prioridadLoading">
                            <i class="fas fa-spinner fa-spin"></i> Cargando...
                        </div>
                    </div>

                    <!-- Medio -->
                    <div class="form-group full-width">
                        <label for="medio" class="form-label">
                            <i class="fas fa-broadcast-tower"></i>
                            Medio <span class="required">*</span>
                        </label>
                        <select id="medio" name="medio[]" class="form-select" multiple required>
                            <option value="">Seleccione uno o más medios...</option>
                        </select>
                        <div class="loading" id="medioLoading">
                            <i class="fas fa-spinner fa-spin"></i> Cargando...
                        </div>
                        <small class="form-text text-muted">Mantén presionado Ctrl (Cmd en Mac) para seleccionar múltiples opciones</small>
                    </div>
                </div>

                <!-- Botones -->
                <div class="form-actions">
                    <button type="reset" class="btn btn-secondary">
                        <i class="fas fa-undo"></i>
                        Limpiar
                    </button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <i class="fas fa-paper-plane"></i>
                        Enviar Solicitud
                    </button>
                </div>
            </form>

            <!-- Mensaje de resultado -->
            <div id="messageContainer" class="message-container"></div>
        </div>
    </div>

    <script>
        // Configuración de la aplicación
        const CONFIG = {
            endpoints: {
                status: '{{ route("api.options.status") }}?type=status',
                tipo: '{{ route("api.options.tipo") }}?type=tipo',
                prioridad: '{{ route("api.options.prioridad") }}?type=prioridad',
                medio: '{{ route("api.options.medio") }}?type=medio',
                submit: '{{ route("solicitud.store") }}'
            }
        };

        // Clase principal de la aplicación
        class FormularioSolicitud {
            constructor() {
                this.form = document.getElementById('solicitudForm');
                this.submitBtn = document.getElementById('submitBtn');
                this.messageContainer = document.getElementById('messageContainer');
                this.init();
            }

            init() {
                this.setupEventListeners();
                this.loadSelectData();
                this.setupDateValidation();
            }

            setupEventListeners() {
                // Evento de envío del formulario
                this.form.addEventListener('submit', (e) => this.handleSubmit(e));
                
                // Evento de reset del formulario
                this.form.addEventListener('reset', () => this.handleReset());
                
                // Validación en tiempo real
                this.setupRealTimeValidation();
            }

            setupRealTimeValidation() {
                const inputs = this.form.querySelectorAll('input:not([type="hidden"]), select, textarea');
                inputs.forEach(input => {
                    input.addEventListener('blur', () => this.validateField(input));
                    input.addEventListener('input', () => this.clearFieldError(input));
                });
            }

            setupDateValidation() {
                const fechaInput = document.getElementById('fecha_planeada');
                const today = new Date().toISOString().split('T')[0];
                fechaInput.min = today;
            }

            // Cargar datos para los selects
            async loadSelectData() {
                const selects = [
                    { id: 'tipo', endpoint: CONFIG.endpoints.tipo },
                    { id: 'prioridad', endpoint: CONFIG.endpoints.prioridad },
                    { id: 'medio', endpoint: CONFIG.endpoints.medio }
                ];

                // Cargar todos los selects en paralelo
                const promises = selects.map(select => this.loadSelectOptions(select.id, select.endpoint));
                
                try {
                    await Promise.all(promises);
                } catch (error) {
                    console.error('Error cargando datos de los selects:', error);
                    this.showMessage('Error al cargar los datos del formulario. Por favor, recargue la página.', 'error');
                }
            }

            async loadSelectOptions(selectId, endpoint) {
                const select = document.getElementById(selectId);
                const loading = document.getElementById(`${selectId}Loading`);
                
                try {
                    this.showLoading(loading, true);
                    
                    const response = await fetch(endpoint, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                        },
                    });

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    const data = await response.json();
                    
                    if (data.success && Array.isArray(data.data)) {
                        this.populateSelect(select, data.data);
                    } else {
                        throw new Error(data.message || 'Error en la respuesta del servidor');
                    }
                } catch (error) {
                    console.error(`Error cargando ${selectId}:`, error);
                    this.addErrorOption(select, `Error cargando ${selectId}`);
                } finally {
                    this.showLoading(loading, false);
                }
            }

            populateSelect(select, options) {
                // Limpiar opciones existentes (excepto la primera)
                while (select.children.length > 1) {
                    select.removeChild(select.lastChild);
                }

                // Agregar nuevas opciones
                options.forEach(option => {
                    const optionElement = document.createElement('option');
                    optionElement.value = option.name || option.value;
                    optionElement.textContent = option.name || option.text || option.label;
                    select.appendChild(optionElement);
                });
            }

            addErrorOption(select, errorMessage) {
                const errorOption = document.createElement('option');
                errorOption.value = '';
                errorOption.textContent = errorMessage;
                errorOption.disabled = true;
                errorOption.style.color = '#ef4444';
                select.appendChild(errorOption);
            }

            showLoading(element, show) {
                if (show) {
                    element.classList.add('show');
                } else {
                    element.classList.remove('show');
                }
            }

            // Validación de campos
            validateField(field) {
                let value, isValid;
                
                if (field.type === 'select-multiple') {
                    // Para multi-select, verificar que al menos una opción esté seleccionada
                    const selectedOptions = Array.from(field.selectedOptions);
                    value = selectedOptions.map(option => option.value).join(',');
                    isValid = selectedOptions.length > 0 && !selectedOptions.some(option => option.value === '');
                } else {
                    value = field.value.trim();
                    isValid = field.checkValidity() && value !== '';
                }
                
                if (isValid) {
                    field.classList.remove('invalid');
                    field.classList.add('valid');
                } else {
                    field.classList.remove('valid');
                    field.classList.add('invalid');
                }
                
                return isValid;
            }

            clearFieldError(field) {
                field.classList.remove('invalid');
            }

            validateForm() {
                const requiredFields = this.form.querySelectorAll('[required]:not([type="hidden"])');
                let isValid = true;
                
                requiredFields.forEach(field => {
                    if (!this.validateField(field)) {
                        isValid = false;
                    }
                });
                
                return isValid;
            }

            // Manejo del envío del formulario
            async handleSubmit(e) {
                e.preventDefault();
                
                if (!this.validateForm()) {
                    this.showMessage('Por favor, complete todos los campos requeridos correctamente.', 'error');
                    return;
                }

                try {
                    this.setSubmitState(true);
                    
                    console.log('Enviando formulario...');
                    console.log('Endpoint:', CONFIG.endpoints.submit);
                    
                    const response = await fetch(CONFIG.endpoints.submit, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                        },
                        body: new FormData(this.form)
                    });

                    const result = await response.json();
                    
                    if (result.success) {
                        this.showMessage('¡Solicitud enviada exitosamente!', 'success');
                        this.form.reset();
                        this.clearAllValidations();
                    } else {
                        this.showMessage(result.message || 'Error al enviar la solicitud. Por favor, inténtelo nuevamente.', 'error');
                    }
                } catch (error) {
                    console.error('Error enviando formulario:', error);
                    this.showMessage('Error de conexión. Por favor, verifique su conexión a internet e inténtelo nuevamente.', 'error');
                } finally {
                    this.setSubmitState(false);
                }
            }

            setSubmitState(loading) {
                const submitBtn = this.submitBtn;
                const icon = submitBtn.querySelector('i');
                
                if (loading) {
                    submitBtn.disabled = true;
                    icon.className = 'fas fa-spinner fa-spin';
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enviando...';
                } else {
                    submitBtn.disabled = false;
                    icon.className = 'fas fa-paper-plane';
                    submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Enviar Solicitud';
                }
            }

            handleReset() {
                this.clearAllValidations();
                this.clearMessages();
            }

            clearAllValidations() {
                const fields = this.form.querySelectorAll('.valid, .invalid');
                fields.forEach(field => {
                    field.classList.remove('valid', 'invalid');
                });
            }

            clearMessages() {
                this.messageContainer.innerHTML = '';
            }

            // Mostrar mensajes al usuario
            showMessage(message, type = 'info') {
                this.clearMessages();
                
                const messageDiv = document.createElement('div');
                messageDiv.className = `message ${type}`;
                
                const icon = this.getMessageIcon(type);
                messageDiv.innerHTML = `
                    <i class="${icon}"></i>
                    <span>${message}</span>
                `;
                
                this.messageContainer.appendChild(messageDiv);
                
                // Auto-ocultar mensajes de éxito después de 5 segundos
                if (type === 'success') {
                    setTimeout(() => {
                        if (messageDiv.parentNode) {
                            messageDiv.remove();
                        }
                    }, 5000);
                }
                
                // Scroll hacia el mensaje
                messageDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }

            getMessageIcon(type) {
                const icons = {
                    success: 'fas fa-check-circle',
                    error: 'fas fa-exclamation-circle',
                    info: 'fas fa-info-circle'
                };
                return icons[type] || icons.info;
            }
        }

        // Inicializar la aplicación cuando el DOM esté listo
        document.addEventListener('DOMContentLoaded', () => {
            new FormularioSolicitud();
        });

        // Manejo de errores globales
        window.addEventListener('error', (e) => {
            console.error('Error global:', e.error);
        });

        window.addEventListener('unhandledrejection', (e) => {
            console.error('Promise rechazada:', e.reason);
        });
    </script>
</body>
</html>
