<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF token disabled for iframe embedding -->
    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Configuracion base para permitir scroll interno */
        html {
            height: 100%;
        }

        body::-webkit-scrollbar {
            display: none;
        }

        body {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #000000 0%, #1a1a1a 50%, #2d2d2d 100%);
            min-height: 100vh;
            padding: 40px 10px;
            margin: 0;
            overflow: hidden;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: visible !important;
            position: relative;
            min-height: 700px;
            height: auto;
            padding-bottom: 50px;
        }
        .logo-notion {
            width: 80px;
            height: 80px;
            object-fit: contain;
        }

        /* ===== SISTEMA RESPONSIVO COMPLETO ===== */

        /* Pantallas extra grandes (1920px+) - Monitores 4K */
        @media (min-width: 1920px) {
            .container {
                max-width: 1200px;
            }

            .form-wrapper {
                padding: 60px;
            }

            .form-grid {
                gap: 30px;
            }

            .form-input, .form-select, .form-textarea {
                font-size: 1.1rem;
                padding: 15px 20px;
            }
        }

        /* Pantallas muy grandes (1400px - 1919px) - Monitores grandes */
        @media (min-width: 1400px) and (max-width: 1919px) {
            .container {
                max-width: 1100px;
            }

            .form-wrapper {
                padding: 55px;
            }
        }

        /* Pantallas grandes (1200px - 1399px) - Laptops grandes */
        @media (min-width: 1200px) and (max-width: 1399px) {
            .container {
                max-width: 1000px;
            }

            .form-wrapper {
                padding: 50px;
            }
        }

        /* Pantallas medianas-grandes (992px - 1199px) - Laptops estandar */
        @media (min-width: 992px) and (max-width: 1199px) {
            .container {
                max-width: 900px;
            }

            .form-wrapper {
                padding: 45px;
            }

            .form-grid {
                gap: 25px;
            }
        }

        .form {
            max-height: calc(100vh - 240px);
            overflow-y: auto;
            overflow-x: visible;
            padding-right: 10px;
            padding-bottom: 30px;
        }

        /* Estilo personalizado para el scrollbar del formulario */
        .form::-webkit-scrollbar {
            width: 8px;
        }

        .form::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .form::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 4px;
        }

        .form::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        .form-wrapper {
            padding: 30px 50px 0 50px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }

        .form-actions {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
            flex-wrap: nowrap;
            align-items: center;
        }

        /* Asegurar que los campos de fecha no corten el picker */
        .form-group {
            position: relative;
            overflow: visible !important;
        }

        .form-group input[type="text"] {
            overflow: visible !important;
        }

        .form-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: nowrap;
            max-width: 100%;
        }

        .notion-logo {
            width: 60px;
            height: 60px;
            object-fit: contain;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
            flex-shrink: 0;
            order: 2;
        }

        .header-text {
            text-align: left;
            flex: 1;
            order: 1;
            display: flex;
            align-items: baseline;
            gap: 15px;
            flex-wrap: wrap;
        }

        .form-header h1 {
            color: #333;
            font-size: 2.5rem;
            margin: 0;
            flex-shrink: 0;
        }

        .subtitle {
            color: #666;
            font-size: 1.1rem;
            margin: 0;
            font-weight: 300;
            white-space: nowrap;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            min-width: 0;
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
            width: 100%;
            min-width: 0;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-input:focus-visible,
        .form-select:focus-visible,
        .form-textarea:focus-visible {
            outline: 2px solid #667eea;
            outline-offset: 2px;
        }

        .form-textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-text {
            font-size: 0.875rem;
            color: #6c757d;
            margin-top: 5px;
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
            min-width: 140px;
            justify-content: center;
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

        .btn:focus-visible {
            outline: 2px solid #667eea;
            outline-offset: 2px;
        }

        .btn:active {
            transform: translateY(1px);
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
            box-shadow: 0 0 0 3px rgba(231, 76, 60, 0.1) !important;
        }

        .valid {
            border-color: #27ae60 !important;
            background: #f0fff4 !important;
            box-shadow: 0 0 0 3px rgba(39, 174, 96, 0.1) !important;
        }

        .required {
            color: #e74c3c;
            font-weight: bold;
        }

        .field-error {
            color: #e74c3c;
            font-size: 0.875rem;
            margin-top: 5px;
            display: none;
        }

        .field-error.show {
            display: block;
        }

        .form-input[readonly],
        .form-select:disabled {
            background-color: #e9ecef !important;
            cursor: not-allowed !important;
            color: #6c757d !important;
            border-color: #dee2e6 !important;
            opacity: 0.7;
        }

        .form-text.text-muted {
            color: #6c757d;
            font-size: 0.875rem;
            margin-top: 5px;
        }

        /* Estilos para el grupo de pills de Medio */
        .checkbox-group {
            border: none;
            background-color: #d1d5db;
            border-radius: 30px;
            padding: 6px;
            min-height: 50px;
        }

        .checkbox-options {
            display: flex;
            gap: 4px;
        }

        .checkbox-option {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px 16px;
            background: transparent;
            border: none;
            border-radius: 24px;
            cursor: pointer;
            transition: all 0.2s ease;
            flex: 1;
        }

        .checkbox-option:hover {
            background-color: rgba(255, 255, 255, 0.6);
        }

        .checkbox-option input[type="checkbox"] {
            display: none;
        }

        .checkbox-option label {
            cursor: pointer;
            margin: 0;
            font-size: 14px;
            font-weight: 700;
            color: #374151;
            text-align: center;
            user-select: none;
        }

        .checkbox-option.checked {
            background-color: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .checkbox-group.valid {
            border-color: transparent !important;
            background-color: #d1d5db !important;
            box-shadow: none !important;
        }

        .checkbox-group.invalid {
            background-color: #d1d5db !important;
        }

        /* Mejoras adicionales para compatibilidad */
        .form-input,
        .form-select,
        .form-textarea {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            -webkit-border-radius: 12px;
            border-radius: 12px;
        }

        .form-select {
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6,9 12,15 18,9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 16px;
            padding-right: 40px;
        }

        /* Widget de fecha y hora - texto simple */
        .datetime-widget {
            position: fixed !important;
            top: 10px !important;
            right: 20px !important;
            z-index: 9999 !important;
            text-align: right;
            color: rgba(255, 255, 255, 0.9);
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            max-width: 180px;
            word-wrap: break-word;
            transform: translateZ(0);
            -webkit-transform: translateZ(0);
        }

        .datetime-widget .location {
            font-size: 0.8rem;
            margin-bottom: 3px;
            font-weight: 400;
            opacity: 0.8;
        }

        .datetime-widget .date {
            font-size: 1rem;
            font-weight: 500;
            margin-bottom: 2px;
        }

        .datetime-widget .time {
            font-size: 1.1rem;
            font-weight: 600;
            font-family: 'Courier New', monospace;
        }

        /* Ajuste adicional para evitar solapamiento con scrollbar */
        @media (min-width: 769px) {
            .datetime-widget {
                right: 30px !important;
            }
        }

        /* Scrollbars mas delgados para todos los elementos */
        *::-webkit-scrollbar {
            width: 4px;
            height: 4px;
        }

        *::-webkit-scrollbar-track {
            background: transparent;
        }

        *::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 2px;
        }

        *::-webkit-scrollbar-thumb:hover {
            background: rgba(0, 0, 0, 0.3);
        }

        /* Responsive para el widget */
        @media (max-width: 768px) {
            .datetime-widget {
                position: relative;
                top: auto;
                right: auto;
                text-align: center;
                margin: 0 auto 15px auto;
                color: #333;
                text-shadow: none;
            }
        }

        /* File list styling */
        #fileList li {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 8px;
        }

        #fileList .btn-danger {
            padding: 2px 8px;
            font-size: 0.875rem;
        }

        /* Tablets grandes (768px - 991px) - iPads Pro */
        @media (min-width: 768px) and (max-width: 991px) {
            .container {
                max-width: 850px;
                margin: 0 auto;
            }

            .form-wrapper {
                padding: 40px;
            }

            .form-grid {
                gap: 20px;
            }

            .form-header h1 {
                font-size: 2.2rem;
            }

            .form-actions {
                gap: 15px;
                flex-wrap: nowrap;
            }
        }

        /* Tablets pequenos y moviles grandes (576px - 767px) */
        @media (min-width: 576px) and (max-width: 767px) {
            body {
                padding: 30px 10px;
            }

            .container {
                max-width: 95%;
                margin: 0 auto;
                border-radius: 18px;
            }

            .form-wrapper {
                padding: 35px 30px 0 30px;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 18px;
            }

            .form-header h1 {
                font-size: 2rem;
            }

            .subtitle {
                font-size: 1rem;
            }

            .form-actions {
                gap: 12px;
                flex-wrap: nowrap;
            }
        }

        /* Moviles estandar (400px - 575px) */
        @media (min-width: 400px) and (max-width: 575px) {
            body {
                padding: 25px 8px;
            }

            .container {
                max-width: 98%;
                margin: 0 auto;
                border-radius: 16px;
                min-height: auto;
            }

            .form-wrapper {
                padding: 25px 20px 0 20px;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .form-header h1 {
                font-size: 1.8rem;
                line-height: 1.3;
            }

            .subtitle {
                font-size: 0.95rem;
            }

            .form-input, .form-select, .form-textarea {
                font-size: 16px;
                padding: 12px 15px;
            }

            .form-textarea {
                min-height: 100px;
            }

            .btn {
                padding: 12px 20px;
                font-size: 0.95rem;
            }

            .form-actions {
                gap: 10px;
                flex-wrap: nowrap;
            }
        }

        /* Moviles pequenos (320px - 399px) */
        @media (min-width: 320px) and (max-width: 399px) {
            body {
                padding: 20px 5px;
            }

            .container {
                max-width: 100%;
                margin: 0 auto;
                border-radius: 12px;
                min-height: auto;
            }

            .form-wrapper {
                padding: 20px 15px 0 15px;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 14px;
            }

            .form-header h1 {
                font-size: 1.6rem;
                line-height: 1.2;
                margin-bottom: 8px;
            }

            .subtitle {
                font-size: 0.9rem;
            }

            .header-content {
                flex-direction: row;
                gap: 10px;
                justify-content: space-between;
                align-items: center;
            }

            .header-text {
                text-align: left;
                flex: 1;
                gap: 10px;
            }

            .form-input, .form-select, .form-textarea {
                font-size: 16px;
                padding: 10px 12px;
            }

            .form-textarea {
                min-height: 80px;
            }

            .btn {
                padding: 12px 20px;
                font-size: 14px;
                min-width: 120px;
            }

            .form-actions {
                flex-direction: row;
                gap: 10px;
                flex-wrap: nowrap;
                justify-content: center;
            }
        }

        /* Moviles ultra pequenos (menos de 320px) */
        @media (max-width: 319px) {
            body {
                padding: 15px 3px;
            }

            .container {
                max-width: 100%;
                border-radius: 8px;
            }

            .form-wrapper {
                padding: 15px 10px 0 10px;
            }

            .form-grid {
                gap: 12px;
            }

            .form-header h1 {
                font-size: 1.4rem;
            }

            .subtitle {
                font-size: 0.85rem;
            }

            .header-content {
                flex-direction: row;
                gap: 8px;
                justify-content: space-between;
                align-items: center;
            }

            .header-text {
                text-align: left;
                flex: 1;
                gap: 8px;
            }

            .form-input, .form-select, .form-textarea {
                font-size: 16px;
                padding: 8px 10px;
            }

            .btn {
                padding: 8px 12px;
                font-size: 0.85rem;
            }

            .form-actions {
                gap: 8px;
                flex-wrap: nowrap;
                flex-direction: row;
            }
        }

        /* Moviles en landscape */
        @media (max-height: 500px) and (orientation: landscape) {
            body {
                padding: 10px 10px;
            }

            .container {
                min-height: auto;
            }

            .form-wrapper {
                padding: 20px;
            }

            .form-header h1 {
                font-size: 1.5rem;
                margin-bottom: 5px;
            }

            .subtitle {
                font-size: 0.9rem;
            }

            .form-grid {
                gap: 12px;
            }

            .form-input, .form-select, .form-textarea {
                padding: 8px 12px;
            }

            .form-textarea {
                min-height: 60px;
            }
        }

        .label-hint {
            font-weight: 400;
            font-size: 0.85rem;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <!-- Widget de fecha y hora -->
    <div class="datetime-widget">
        <div class="location">Monterrey, NL, Mexico</div>
        <div class="date" id="currentDate"></div>
        <div class="time" id="currentTime"></div>
    </div>

    <div class="container">
        <div class="form-wrapper">
            <div class="form-header">
            <div style="flex: 1;" id="welcomeMessage">Bienvenido</div>
                <div class="header-content" style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                <div style="flex: 1;"></div>
                    <div style="flex: 2;">
                        <p id="welcome-message" class="text-center mb-2" style="font-size: 1.2rem; color: #333; font-weight: 500; display: none;"></p>
                        <h1 class="mb-0" style="text-align: center;">Peticion para asignacion de mesa de Informacion</h1>
                    </div>
                    <div style="flex: 1; text-align: right;">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e9/Notion-logo.svg/2048px-Notion-logo.svg.png" alt="Notion" class="logo-notion">
                    </div>
                </div>
            </div>

            <form id="solicitudForm" class="form" enctype="multipart/form-data">
                <div class="form-grid">
                    <!-- Status (oculto) -->
                    <input type="hidden" id="status" name="status" value="PENDIENTE">

                    <!-- Quien solicita (hidden but functional) -->
                    <input type="hidden" id="solicitante" name="solicitante" value="">

                    <!-- Email (hidden but functional) -->
                    <input type="hidden" id="email" name="email" value="">

                    <!-- Estado (dropdown) -->
                    <div class="form-group">
                        <label for="estado" class="form-label">
                            <span>&#127474;&#127485;</span>
                            Estado <span class="required">*</span>
                        </label>
                        <select id="estado" name="estado" class="form-select" required>
                            <option value="">Seleccione un estado...</option>
                        </select>
                        <div class="loading" id="estadoLoading">
                            <i class="fas fa-spinner fa-spin"></i> Cargando...
                        </div>
                    </div>

                    <!-- Municipio (dropdown - loads from ENTIDAD based on Estado) -->
                    <div class="form-group">
                        <label for="municipio" class="form-label">
                            <span>&#127474;&#127485;</span>
                            Municipio
                        </label>
                        <select id="municipio" name="municipio" class="form-select" disabled>
                            <option value="">Seleccione un estado primero...</option>
                        </select>
                        <div class="loading" id="municipioLoading">
                            <i class="fas fa-spinner fa-spin"></i> Cargando...
                        </div>
                    </div>

                    <!-- Tipo de Cobertura (dropdown) -->
                    <div class="form-group">
                        <label for="tipo_cobertura" class="form-label">
                            <i class="fas fa-tag"></i>
                            Tipo de Cobertura <span class="required">*</span>
                        </label>
                        <select id="tipo_cobertura" name="tipo_cobertura" class="form-select" required>
                            <option value="">Seleccione tipo...</option>
                        </select>
                        <div class="loading" id="tipo_coberturaLoading">
                            <i class="fas fa-spinner fa-spin"></i> Cargando...
                        </div>
                    </div>

                    <!-- Relevancia (dropdown) -->
                    <div class="form-group">
                        <label for="relevancia" class="form-label">
                            <i class="fas fa-exclamation-circle"></i>
                            Relevancia <span class="required">*</span>
                        </label>
                        <select id="relevancia" name="relevancia" class="form-select" required>
                            <option value="">Seleccione relevancia...</option>
                        </select>
                        <div class="loading" id="relevanciaLoading">
                            <i class="fas fa-spinner fa-spin"></i> Cargando...
                        </div>
                    </div>

                    <!-- Actor principal (textarea - rich_text in Notion) -->
                    <div class="form-group">
                        <label for="actor_principal" class="form-label">
                            <i class="fas fa-users"></i>
                            Actor principal <span class="label-hint">(Persona o Empresa)</span>
                        </label>
                        <textarea id="actor_principal" name="actor_principal" class="form-textarea"
                                  placeholder="Nombre de la persona o empresa..."
                                  rows="2" maxlength="1990"></textarea>
                    </div>

                    <!-- Tono editorial (dropdown) -->
                    <div class="form-group">
                        <label for="tono_editorial" class="form-label">
                            <i class="fas fa-user-edit"></i>
                            Tono editorial <span class="required">*</span> <span class="label-hint">(Sentimiento)</span>
                        </label>
                        <select id="tono_editorial" name="tono_editorial" class="form-select" required>
                            <option value="">Seleccione tono...</option>
                        </select>
                        <div class="loading" id="tono_editorialLoading">
                            <i class="fas fa-spinner fa-spin"></i> Cargando...
                        </div>
                    </div>

                    <!-- Indicaciones a seguir (textarea) -->
                    <div class="form-group full-width">
                        <label for="indicaciones" class="form-label">
                            <i class="fas fa-list-ul"></i>
                            Indicaciones a seguir <span class="required">*</span> <span class="label-hint">( Titulo corto.... Que?, Como? y Donde? *</span>
                        </label>
                        <textarea id="indicaciones" name="indicaciones" class="form-textarea"
                                  placeholder="Describa las indicaciones detalladamente..."
                                  rows="4" maxlength="1990" required></textarea>
                        <div class="character-counter text-muted small mt-1">
                            <span id="indicaciones-counter">0</span> / 1990 caracteres
                        </div>
                    </div>

                    <!-- Redaccion complementaria (textarea) -->
                    <div class="form-group full-width">
                        <label for="redaccion_complementaria" class="form-label">
                            <i class="fas fa-comment-dots"></i>
                            Redaccion complementaria
                        </label>
                        <textarea id="redaccion_complementaria" name="redaccion_complementaria" class="form-textarea"
                                  placeholder="Informacion adicional o comentarios..."
                                  rows="4" maxlength="5000"></textarea>
                        <div class="character-counter text-muted small mt-1">
                            <span id="redaccion-counter">0</span> / 5000 caracteres
                        </div>
                        <div class="field-error" id="redaccionComplementariaError"></div>
                    </div>

                    <!-- Fecha de Inicio -->
                    <div class="form-group">
                        <label for="fecha_inicio" class="form-label">
                            <i class="fas fa-calendar-alt"></i>
                            Fecha de Inicio <span class="required">*</span>
                        </label>
                        <input type="datetime-local" id="fecha_inicio" name="fecha_inicio" class="form-input"
                               required>
                    </div>

                    <!-- Medio (checkboxes) -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-globe"></i>
                            Medio <span class="required">*</span>
                        </label>
                        <div class="checkbox-group" id="medioCheckboxGroup">
                            <div class="loading" id="medioLoading">
                                <i class="fas fa-spinner fa-spin"></i> Cargando...
                            </div>
                            <div class="checkbox-options" id="medioOptions">
                                <!-- Las opciones se cargaran aqui dinamicamente -->
                            </div>
                        </div>
                        <input type="hidden" id="medio" name="medio" required>
                        <div class="field-error" id="medioError"></div>
                    </div>

                    <!-- Link de descarga (textarea) -->
                    <div class="form-group full-width">
                        <label for="link_descarga" class="form-label">
                            <i class="fas fa-link"></i>
                            Link de descarga
                        </label>
                        <textarea id="link_descarga" name="link_descarga" class="form-textarea"
                                  placeholder="https://ejemplo.com/archivo&#10;https://ejemplo.com/otro-archivo&#10;(Puede ingresar multiples URLs, una por linea)"
                                  rows="3" maxlength="1990"></textarea>
                        <div class="character-counter text-muted small mt-1">
                            <span id="link-counter">0</span> / 1990 caracteres
                        </div>
                        <small class="text-muted">Puede ingresar multiples URLs separadas por lineas</small>
                        <div class="field-error" id="linkDescargaError"></div>
                    </div>

                    <!-- Adjuntar archivo -->
                    <div class="form-group full-width">
                        <label class="form-label">
                            <i class="fas fa-paperclip"></i>
                            Adjuntar Archivo
                        </label>
                        <input type="file" id="archivo" class="form-control" multiple accept=".pdf,.doc,.docx,.xls,.xlsx,.png,.jpg,.jpeg,.gif">
                        <small class="text-muted">Puede seleccionar multiples archivos. Formatos permitidos: PDF, DOC, DOCX, XLS, XLSX, PNG, JPG, JPEG, GIF (Max: 10MB cada uno)</small>
                        <div id="fileList" class="mt-2"></div>
                    </div>
                </div>

                <p class="mb-3"><span class="required">*</span> Campos obligatorios</p>

                <!-- Botones -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <i class="fas fa-paper-plane"></i>
                        ENVIAR PETICION
                    </button>
                    <button type="reset" class="btn btn-secondary">
                        <i class="fas fa-undo"></i>
                        LIMPIAR
                    </button>
                </div>
            </form>

            <!-- Mensaje de resultado -->
            <div id="messageContainer" class="message-container"></div>
        </div>
    </div>

    <script>
        // Character counter for textareas
        function setupCharacterCounter(textareaId, counterId) {
            const textarea = document.getElementById(textareaId);
            const counter = document.getElementById(counterId);

            if (textarea && counter) {
                textarea.addEventListener('input', function() {
                    const currentLength = this.value.length;
                    counter.textContent = currentLength;

                    const maxLength = parseInt(this.getAttribute('maxlength'));
                    if (currentLength > maxLength * 0.9) {
                        counter.parentElement.classList.add('text-danger');
                        counter.parentElement.classList.remove('text-warning', 'text-muted');
                    } else if (currentLength > maxLength * 0.75) {
                        counter.parentElement.classList.add('text-warning');
                        counter.parentElement.classList.remove('text-danger', 'text-muted');
                    } else {
                        counter.parentElement.classList.add('text-muted');
                        counter.parentElement.classList.remove('text-danger', 'text-warning');
                    }
                });

                counter.textContent = textarea.value.length;
            }
        }

        // Initialize character counters
        document.addEventListener('DOMContentLoaded', function() {
            setupCharacterCounter('indicaciones', 'indicaciones-counter');
            setupCharacterCounter('redaccion_complementaria', 'redaccion-counter');
            setupCharacterCounter('link_descarga', 'link-counter');
        });

        // Advanced file management system
        class FileManager {
            constructor() {
                this.files = new Map();
                this.fileCounter = 0;
                this.fileInput = document.getElementById('archivo');
                this.fileList = document.getElementById('fileList');
                this.init();
            }

            init() {
                this.fileInput.addEventListener('change', (e) => {
                    this.addFiles(e.target.files);
                    e.target.value = '';
                });
            }

            addFiles(fileList) {
                const files = Array.from(fileList);
                files.forEach(file => {
                    const fileId = `file_${this.fileCounter++}`;
                    let isDuplicate = false;
                    for (let [id, existingFile] of this.files) {
                        if (existingFile.name === file.name && existingFile.size === file.size) {
                            isDuplicate = true;
                            break;
                        }
                    }
                    if (!isDuplicate) {
                        this.files.set(fileId, file);
                    }
                });
                this.updateFileDisplay();
            }

            removeFile(fileId) {
                this.files.delete(fileId);
                this.updateFileDisplay();
            }

            updateFileDisplay() {
                if (this.files.size === 0) {
                    this.fileList.innerHTML = '';
                    return;
                }

                let html = '<strong>Archivos seleccionados:</strong><ul class="list-unstyled mt-2">';
                for (let [fileId, file] of this.files) {
                    const fileSize = (file.size / 1024 / 1024).toFixed(2);
                    html += `
                        <li class="mb-2 d-flex align-items-center justify-content-between">
                            <span>
                                <i class="fas fa-file"></i> ${file.name}
                                <span class="text-muted">(${fileSize} MB)</span>
                            </span>
                            <button type="button" class="btn btn-sm btn-danger" onclick="fileManager.removeFile('${fileId}')">
                                <i class="fas fa-times"></i> Eliminar
                            </button>
                        </li>
                    `;
                }
                html += '</ul>';
                this.fileList.innerHTML = html;
            }

            clearAll() {
                this.files.clear();
                this.updateFileDisplay();
            }

            getFiles() {
                return Array.from(this.files.values());
            }
        }

        // Initialize file manager globally
        let fileManager;
        document.addEventListener('DOMContentLoaded', function() {
            fileManager = new FileManager();
        });

        // Widget de fecha y hora para Monterrey, NL, Mexico
        function updateDateTime() {
            const now = new Date();
            const options = {
                timeZone: 'America/Monterrey',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                weekday: 'long'
            };
            const timeOptions = {
                timeZone: 'America/Monterrey',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: true
            };
            const dateElement = document.getElementById('currentDate');
            const timeElement = document.getElementById('currentTime');
            if (dateElement) {
                dateElement.textContent = now.toLocaleDateString('es-MX', options);
            }
            if (timeElement) {
                timeElement.textContent = now.toLocaleTimeString('es-MX', timeOptions);
            }
        }

        updateDateTime();
        setInterval(updateDateTime, 1000);

        // Configuracion de la aplicacion
        const CONFIG = {
            endpoints: {
                allOptions: '{{ route("api.options.all") }}',
                submit: '{{ route("solicitud.store") }}'
            }
        };

        // Clase principal de la aplicacion
        class FormularioSolicitudV2 {
            constructor() {
                this.form = document.getElementById('solicitudForm');
                this.submitBtn = document.getElementById('submitBtn');
                this.messageContainer = document.getElementById('messageContainer');
                this.cachedOptions = {};
                this.init();
            }

            init() {
                this.setupEventListeners();
                this.setupMedioDropdown();
                this.loadSelectData();
            }

            setupEventListeners() {
                this.form.addEventListener('submit', (e) => this.handleSubmit(e));
                this.form.addEventListener('reset', () => this.handleReset());
                this.setupRealTimeValidation();
            }

            setupRealTimeValidation() {
                const inputs = this.form.querySelectorAll('input:not([type="hidden"]), select, textarea');
                inputs.forEach(input => {
                    input.addEventListener('blur', () => this.validateField(input));
                    input.addEventListener('input', () => this.clearFieldError(input));
                });
            }

            // Cargar datos para los selects (una sola llamada API)
            async loadSelectData() {
                try {
                    const response = await fetch(CONFIG.endpoints.allOptions, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                    });

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    const data = await response.json();

                    if (!data.success || !data.data) {
                        throw new Error(data.message || 'Error en la respuesta del servidor');
                    }

                    this.cachedOptions = data.data;

                    // Populate the dropdowns that come from the API
                    // Estado
                    const estadoSelect = document.getElementById('estado');
                    const estadoLoading = document.getElementById('estadoLoading');
                    if (estadoSelect && data.data.estado) {
                        this.showLoading(estadoLoading, true);
                        this.populateSelect(estadoSelect, data.data.estado);
                        this.showLoading(estadoLoading, false);
                    }

                    // Municipio - populated based on Estado selection using ENTIDAD data
                    this.setupMunicipioLogic();

                    // Tipo de Cobertura (from TIPO DE SOLICITUD)
                    if (data.data.tipo_cobertura) {
                        const tipoCoberturaSelect = document.getElementById('tipo_cobertura');
                        const tipoCoberturaLoading = document.getElementById('tipo_coberturaLoading');
                        this.showLoading(tipoCoberturaLoading, true);
                        this.populateSelect(tipoCoberturaSelect, data.data.tipo_cobertura);
                        this.showLoading(tipoCoberturaLoading, false);
                    }

                    // Relevancia (from RELEVANCIA)
                    if (data.data.relevancia) {
                        const relevanciaSelect = document.getElementById('relevancia');
                        const relevanciaLoading = document.getElementById('relevanciaLoading');
                        this.showLoading(relevanciaLoading, true);
                        this.populateSelect(relevanciaSelect, data.data.relevancia);
                        this.showLoading(relevanciaLoading, false);
                    }

                    // Tono editorial (from TONO EDITORIAL)
                    if (data.data.tono_editorial) {
                        const tonoSelect = document.getElementById('tono_editorial');
                        const tonoLoading = document.getElementById('tono_editorialLoading');
                        this.showLoading(tonoLoading, true);
                        this.populateSelect(tonoSelect, data.data.tono_editorial);
                        this.showLoading(tonoLoading, false);
                    }

                    // Populate medio checkboxes
                    if (data.data.medio) {
                        this.showLoading(this.medioLoading, true);
                        this.populateMedioOptions(data.data.medio);
                        this.showLoading(this.medioLoading, false);
                    }
                } catch (error) {
                    console.error('Error cargando datos de los selects:', error);
                    this.showMessage('Error al cargar los datos del formulario. Por favor, recargue la pagina.', 'error');
                }
            }

            // Configurar checkboxes para medios
            setupMedioDropdown() {
                this.medioCheckboxGroup = document.getElementById('medioCheckboxGroup');
                this.medioOptions = document.getElementById('medioOptions');
                this.medioLoading = document.getElementById('medioLoading');
                this.medioHiddenInput = document.getElementById('medio');
                this.medioError = document.getElementById('medioError');
                this.selectedMediosList = [];
            }

            // Setup Municipio logic - loads ENTIDAD options based on selected Estado
            setupMunicipioLogic() {
                const estadoSelect = document.getElementById('estado');
                const municipioSelect = document.getElementById('municipio');
                const municipioLoading = document.getElementById('municipioLoading');

                const getEntidadOptionsKey = (estadoText) => {
                    const estadoUpper = estadoText.toUpperCase();
                    if (estadoUpper.includes('NUEVO LEON') || estadoUpper.includes('NUEVO LEÓN')) {
                        return 'entidad';
                    } else if (estadoUpper.includes('COAHUILA')) {
                        return 'ent_coahuila';
                    } else if (estadoUpper.includes('TAMAULIPAS')) {
                        return 'ent_tamaulipas';
                    }
                    return null;
                };

                const updateMunicipios = () => {
                    const estadoValue = estadoSelect.value;
                    const estadoText = estadoSelect.options[estadoSelect.selectedIndex]?.text || '';

                    // Clear current municipio options
                    while (municipioSelect.options.length > 1) {
                        municipioSelect.remove(1);
                    }
                    municipioSelect.value = '';

                    if (!estadoValue) {
                        // No estado selected - disable municipio
                        municipioSelect.disabled = true;
                        municipioSelect.options[0].text = 'Seleccione un estado primero...';
                        return;
                    }

                    const optionsKey = getEntidadOptionsKey(estadoText);
                    if (optionsKey && this.cachedOptions[optionsKey] && this.cachedOptions[optionsKey].length > 0) {
                        // Estado has municipio/entidad data - enable and populate
                        municipioSelect.disabled = false;
                        municipioSelect.options[0].text = 'Seleccione un municipio...';
                        this.showLoading(municipioLoading, true);
                        this.populateSelect(municipioSelect, this.cachedOptions[optionsKey]);
                        this.showLoading(municipioLoading, false);
                    } else {
                        // Estado has no municipio data - disable and grey out
                        municipioSelect.disabled = true;
                        municipioSelect.options[0].text = 'No disponible para este estado';
                    }
                };

                estadoSelect.addEventListener('change', updateMunicipios);
            }

            populateMedioOptions(options) {
                this.medioOptions.innerHTML = '';

                options.forEach(option => {
                    const optionDiv = document.createElement('div');
                    optionDiv.className = 'checkbox-option';

                    const checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.id = `medio_${option.name || option.value}`;
                    checkbox.value = option.name || option.value;

                    const label = document.createElement('label');
                    label.htmlFor = `medio_${option.name || option.value}`;
                    label.textContent = option.name || option.text || option.label;

                    optionDiv.appendChild(checkbox);
                    optionDiv.appendChild(label);

                    // Click on the whole pill to toggle
                    optionDiv.addEventListener('click', (e) => {
                        e.preventDefault();
                        checkbox.checked = !checkbox.checked;
                        this.handleMedioSelection(option.name || option.value, checkbox.checked);
                        this.updateCheckboxVisualState(optionDiv, checkbox.checked);
                    });

                    this.medioOptions.appendChild(optionDiv);
                });
            }

            handleMedioSelection(value, isChecked) {
                if (isChecked) {
                    if (!this.selectedMediosList.includes(value)) {
                        this.selectedMediosList.push(value);
                    }
                } else {
                    this.selectedMediosList = this.selectedMediosList.filter(item => item !== value);
                }
                this.updateMedioHiddenInput();
                this.validateMedioField();
            }

            updateCheckboxVisualState(optionDiv, isChecked) {
                if (isChecked) {
                    optionDiv.classList.add('checked');
                } else {
                    optionDiv.classList.remove('checked');
                }
            }

            updateMedioHiddenInput() {
                this.medioHiddenInput.value = JSON.stringify(this.selectedMediosList);
            }

            validateMedioField() {
                const isValid = this.selectedMediosList.length > 0;
                if (isValid) {
                    this.medioCheckboxGroup.classList.remove('invalid');
                    this.medioCheckboxGroup.classList.add('valid');
                    this.hideFieldError(this.medioError);
                } else {
                    this.medioCheckboxGroup.classList.remove('valid');
                    this.medioCheckboxGroup.classList.add('invalid');
                    this.showFieldError(this.medioError, 'Debe seleccionar al menos un medio.');
                }
                return isValid;
            }

            populateSelect(select, options) {
                while (select.children.length > 1) {
                    select.removeChild(select.lastChild);
                }
                options.forEach(option => {
                    const optionElement = document.createElement('option');
                    optionElement.value = option.name || option.value;
                    optionElement.textContent = option.name || option.text || option.label;
                    select.appendChild(optionElement);
                });
            }

            showLoading(element, show) {
                if (!element) return;
                if (show) {
                    element.classList.add('show');
                } else {
                    element.classList.remove('show');
                }
            }

            // Validacion de campos
            validateField(field) {
                let value, isValid, errorMessage = '';

                if (field.disabled) {
                    isValid = true;
                } else if (field.type === 'select-one') {
                    value = field.value.trim();
                    isValid = value !== '' && value !== null && value !== undefined;
                    if (!isValid) {
                        errorMessage = 'Debe seleccionar una opcion.';
                    }
                } else if (field.type === 'datetime-local') {
                    value = field.value.trim();
                    isValid = value !== '' && !isNaN(Date.parse(value));
                    if (!isValid) {
                        errorMessage = 'Debe seleccionar una fecha y hora valida.';
                    }
                } else if (field.tagName === 'TEXTAREA') {
                    value = field.value.trim();
                    if (field.hasAttribute('required')) {
                        isValid = value !== '' && value.length >= 3;
                        if (!isValid) {
                            errorMessage = value === '' ? 'Este campo es obligatorio.' : 'Debe escribir al menos 3 caracteres.';
                        }
                    } else {
                        isValid = true;
                    }
                } else {
                    value = field.value.trim();
                    if (field.hasAttribute('required')) {
                        isValid = value !== '' && value.length >= 2;
                        if (!isValid) {
                            errorMessage = value === '' ? 'Este campo es obligatorio.' : 'Debe escribir al menos 2 caracteres.';
                        }
                    } else {
                        isValid = true;
                    }
                }

                if (isValid) {
                    field.classList.remove('invalid');
                    field.classList.add('valid');
                    this.hideFieldError(field);
                } else {
                    field.classList.remove('valid');
                    field.classList.add('invalid');
                    this.showFieldError(field, errorMessage);
                }

                return isValid;
            }

            showFieldError(field, message) {
                let errorDiv = field.parentNode.querySelector('.field-error');
                if (!errorDiv) {
                    errorDiv = document.createElement('div');
                    errorDiv.className = 'field-error';
                    field.parentNode.appendChild(errorDiv);
                }
                errorDiv.textContent = message;
                errorDiv.classList.add('show');
            }

            hideFieldError(field) {
                const errorDiv = field.parentNode.querySelector('.field-error');
                if (errorDiv) {
                    errorDiv.classList.remove('show');
                }
            }

            clearFieldError(field) {
                field.classList.remove('invalid');
                this.hideFieldError(field);
            }

            validateForm() {
                const requiredFields = this.form.querySelectorAll('[required]:not([type="hidden"])');
                let isValid = true;
                let emptyFields = [];

                requiredFields.forEach(field => {
                    if (!this.validateField(field)) {
                        isValid = false;
                        const fieldName = this.getFieldDisplayName(field);
                        if (fieldName && !emptyFields.includes(fieldName)) {
                            emptyFields.push(fieldName);
                        }
                    }
                });

                if (!this.validateMedioField()) {
                    isValid = false;
                    if (!emptyFields.includes('Medio')) {
                        emptyFields.push('Medio');
                    }
                }

                if (!isValid && emptyFields.length > 0) {
                    const message = emptyFields.length === 1
                        ? `El campo "${emptyFields[0]}" es obligatorio.`
                        : `Los siguientes campos son obligatorios: ${emptyFields.join(', ')}.`;
                    this.showMessage(message, 'error');
                }

                return isValid;
            }

            getFieldDisplayName(field) {
                const fieldNames = {
                    'estado': 'Estado',
                    'municipio': 'Municipio',
                    'tipo_cobertura': 'Tipo de Cobertura',
                    'relevancia': 'Relevancia',
                    'actor_principal': 'Actor principal',
                    'tono_editorial': 'Tono editorial',
                    'indicaciones': 'Indicaciones a seguir',
                    'fecha_inicio': 'Fecha de Inicio',
                    'medio': 'Medio'
                };
                return fieldNames[field.name] || field.name;
            }

            async handleSubmit(e) {
                e.preventDefault();

                if (!this.validateForm()) {
                    return;
                }

                try {
                    this.setSubmitState(true);

                    const formData = new FormData(this.form);

                    formData.delete('archivo[]');
                    formData.delete('archivo');

                    if (fileManager && fileManager.getFiles().length > 0) {
                        const files = fileManager.getFiles();
                        let validFilesCount = 0;
                        files.forEach((file, index) => {
                            if (file && file instanceof File) {
                                formData.append('archivo[]', file, file.name);
                                validFilesCount++;
                            }
                        });
                    }

                    // Get datetime values and convert to ISO format with GMT-6
                    const fechaInicioValue = document.getElementById('fecha_inicio').value;
                    if (fechaInicioValue) {
                        const fechaInicio = fechaInicioValue + ':00-06:00';
                        formData.set('fecha_inicio', fechaInicio);
                    }

                    const response = await fetch(CONFIG.endpoints.submit, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: formData
                    });

                    const result = await response.json();

                    if (result.success) {
                        this.showSuccessPopup();

                        const solicitanteField = document.getElementById('solicitante');
                        const solicitanteValue = solicitanteField ? solicitanteField.value : null;

                        this.form.reset();
                        this.handleReset();

                        if (typeof fileManager !== 'undefined') {
                            fileManager.clearAll();
                        }

                        if (solicitanteField && solicitanteValue) {
                            solicitanteField.value = solicitanteValue;
                        }
                    } else {
                        if (result.errors) {
                            let errorMessage = result.message || 'Error de validacion:\n';
                            for (const [field, errors] of Object.entries(result.errors)) {
                                errorMessage += `- ${field}: ${errors.join(', ')}\n`;
                            }
                            this.showMessage(errorMessage, 'error');
                        } else {
                            this.showMessage(result.message || 'Error al enviar la solicitud. Por favor, intentelo nuevamente.', 'error');
                        }
                    }
                } catch (error) {
                    console.error('Error enviando formulario:', error);
                    this.showMessage('Error de conexion. Por favor, verifique su conexion a internet e intentelo nuevamente.', 'error');
                } finally {
                    this.setSubmitState(false);
                }
            }

            setSubmitState(loading) {
                const submitBtn = this.submitBtn;
                if (loading) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enviando...';
                } else {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> ENVIAR PETICION';
                }
            }

            handleReset() {
                this.clearAllValidations();
                this.clearMessages();

                if (typeof fileManager !== 'undefined') {
                    fileManager.clearAll();
                }

                if (this.selectedMediosList) {
                    this.selectedMediosList = [];
                    this.updateMedioHiddenInput();
                    const checkboxes = this.medioOptions.querySelectorAll('input[type="checkbox"]');
                    checkboxes.forEach(checkbox => {
                        checkbox.checked = false;
                        const optionDiv = checkbox.closest('.checkbox-option');
                        if (optionDiv) {
                            optionDiv.classList.remove('checked');
                        }
                    });
                }

                document.getElementById('fecha_inicio').value = '';

                // Reset municipio to disabled state
                const municipioSelect = document.getElementById('municipio');
                while (municipioSelect.options.length > 1) {
                    municipioSelect.remove(1);
                }
                municipioSelect.value = '';
                municipioSelect.disabled = true;
                municipioSelect.options[0].text = 'Seleccione un estado primero...';
            }

            clearAllValidations() {
                const fields = this.form.querySelectorAll('.valid, .invalid');
                fields.forEach(field => {
                    field.classList.remove('valid', 'invalid');
                    this.hideFieldError(field);
                });

                if (this.medioCheckboxGroup) {
                    this.medioCheckboxGroup.classList.remove('valid', 'invalid');
                    this.hideFieldError(this.medioError);
                }
            }

            clearMessages() {
                this.messageContainer.innerHTML = '';
            }

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

                if (type === 'success') {
                    setTimeout(() => {
                        if (messageDiv.parentNode) {
                            messageDiv.remove();
                        }
                    }, 5000);
                }

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

            showSuccessPopup() {
                const overlay = document.createElement('div');
                overlay.style.cssText = `
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: rgba(0, 0, 0, 0.8);
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    z-index: 10000;
                    animation: fadeIn 0.3s ease-out;
                `;

                const popup = document.createElement('div');
                popup.style.cssText = `
                    background: white;
                    border-radius: 20px;
                    padding: 40px;
                    max-width: 500px;
                    width: 90%;
                    text-align: center;
                    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
                    animation: slideUp 0.4s ease-out;
                `;

                popup.innerHTML = `
                    <div style="margin-bottom: 20px;">
                        <i class="fas fa-check-circle" style="font-size: 4rem; color: #22c55e; margin-bottom: 15px;"></i>
                    </div>
                    <h2 style="color: #1f2937; margin-bottom: 15px; font-size: 1.5rem;">Peticion Enviada!</h2>
                    <p style="color: #6b7280; font-size: 1.1rem; line-height: 1.6; margin-bottom: 25px;">
                        Su peticion ya fue enviada al area de mesa, en breve le llegara un correo con datos de dicha peticion
                    </p>
                    <button onclick="this.closest('.popup-overlay').remove()"
                            style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                                   color: white;
                                   border: none;
                                   padding: 12px 30px;
                                   border-radius: 12px;
                                   font-size: 1rem;
                                   font-weight: 600;
                                   cursor: pointer;
                                   transition: all 0.3s ease;">
                        Entendido
                    </button>
                `;

                overlay.appendChild(popup);
                overlay.className = 'popup-overlay';
                document.body.appendChild(overlay);

                overlay.addEventListener('click', (e) => {
                    if (e.target === overlay) {
                        overlay.remove();
                    }
                });

                const handleEscape = (e) => {
                    if (e.key === 'Escape') {
                        overlay.remove();
                        document.removeEventListener('keydown', handleEscape);
                    }
                };
                document.addEventListener('keydown', handleEscape);
            }
        }

        // Funcion para obtener parametros de la URL
        function getUrlParameter(name) {
            name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
            var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
            var results = regex.exec(location.search);
            return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
        }

        // Inicializar la aplicacion cuando el DOM este listo
        $(document).ready(function() {
            console.log('Inicializando FormularioSolicitudV2...');

            // Check for 'solicitante' parameter in URL
            const solicitanteParam = getUrlParameter('solicitante');
            if (solicitanteParam) {
                const welcomeMessage = document.getElementById('welcomeMessage');
                if (welcomeMessage) {
                    welcomeMessage.textContent = 'Bienvenid@: ' + solicitanteParam;
                }
                const solicitanteField = document.getElementById('solicitante');
                if (solicitanteField) {
                    solicitanteField.value = solicitanteParam;
                }
            }

            // Check for 'departamento' parameter in URL
            const departamentoParam = getUrlParameter('departamento');
            if (departamentoParam) {
                const welcomeMessage = document.getElementById('welcomeMessage');
                if (welcomeMessage) {
                    const solicitanteText = welcomeMessage.textContent;
                    welcomeMessage.innerHTML = solicitanteText + '<br><strong>Departamento:</strong> ' + departamentoParam;
                }
            }

            // Check for 'email' parameter in URL
            const emailParam = getUrlParameter('email');
            if (emailParam) {
                const emailField = document.getElementById('email');
                if (emailField) {
                    emailField.value = emailParam;
                }
            }

            // Set minimum date/time to current local time
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const minDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;

            document.getElementById('fecha_inicio').min = minDateTime;
            document.getElementById('fecha_inicio').value = minDateTime;

            // Initialize the form application
            const app = new FormularioSolicitudV2();
        });
    </script>
</body>
</html>
