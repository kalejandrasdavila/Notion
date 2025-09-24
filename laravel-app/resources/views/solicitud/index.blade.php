<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF token disabled for iframe embedding -->
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
            background: linear-gradient(135deg, #000000 0%, #1a1a1a 50%, #2d2d2d 100%);
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
            padding: 80px;
        }

        .form-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .notion-logo {
            width: 60px;
            height: 60px;
            object-fit: contain;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
        }

        .header-text {
            text-align: center;
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

        .form-input[readonly] {
            background-color: #f8f9fa !important;
            cursor: not-allowed !important;
            color: #6c757d !important;
            border-color: #e9ecef !important;
        }

        .form-text.text-muted {
            color: #6c757d;
            font-size: 0.875rem;
            margin-top: 5px;
        }

        /* Estilos para el dropdown personalizado */
        .dropdown-container {
            position: relative;
            width: 100%;
        }

        .dropdown-toggle {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            background-color: #fafafa;
            font-size: 1rem;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s ease;
        }

        .dropdown-toggle:hover {
            border-color: #667eea;
            background-color: white;
        }

        .dropdown-toggle:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .dropdown-toggle.active {
            border-color: #667eea;
            background-color: white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .dropdown-text {
            flex: 1;
            text-align: left;
            color: #374151;
        }

        .dropdown-toggle i {
            color: #6b7280;
            transition: transform 0.3s ease;
        }

        .dropdown-toggle.active i {
            transform: rotate(180deg);
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            max-height: 200px;
            overflow-y: auto;
            display: none;
            margin-top: 5px;
        }

        .dropdown-menu.show {
            display: block;
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dropdown-options {
            padding: 8px 0;
        }

        .dropdown-option {
            padding: 10px 16px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: background-color 0.2s ease;
        }

        .dropdown-option:hover {
            background-color: #f3f4f6;
        }

        .dropdown-option input[type="checkbox"] {
            margin: 0;
            width: 16px;
            height: 16px;
            accent-color: #667eea;
        }

        .dropdown-option label {
            cursor: pointer;
            flex: 1;
            margin: 0;
            font-size: 0.95rem;
            color: #374151;
        }

        .selected-items {
            margin-top: 10px;
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .selected-item {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 8px;
            animation: fadeIn 0.3s ease-out;
        }

        .selected-item .remove-btn {
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            padding: 0;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            transition: background-color 0.2s ease;
        }

        .selected-item .remove-btn:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        @media (max-width: 850px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
            
            .form-header h1 {
                font-size: 2rem;
            }
            
            .form-wrapper {
                padding: 60px;
            }

            .header-content {
                flex-direction: column;
                gap: 15px;
            }

            .notion-logo {
                width: 50px;
                height: 50px;
            }
        }

        @media (max-width: 480px) {
            .notion-logo {
                width: 45px;
                height: 45px;
            }

            .form-header h1 {
                font-size: 1.8rem;
            }

            .form-header p {
                font-size: 1rem;
            }
        }

        /* Estilos para el selector de fecha personalizado */
        .date-time-picker {
            position: relative;
            width: 100%;
        }

        .date-time-inputs {
            display: flex;
            gap: 8px;
            margin-bottom: 12px;
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 8px;
            transition: all 0.3s ease;
        }

        .date-time-inputs:focus-within {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .date-input-container,
        .time-input-container {
            position: relative;
            flex: 1;
        }

        .date-display,
        .time-display {
            width: 100%;
            padding: 12px 16px;
            border: none;
            background: transparent;
            font-size: 16px;
            color: #374151;
            cursor: pointer;
            outline: none;
        }

        .date-display::placeholder,
        .time-display::placeholder {
            color: #9ca3af;
        }

        .date-picker-toggle,
        .time-picker-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #667eea;
            cursor: pointer;
            padding: 4px;
            border-radius: 4px;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .date-picker-toggle:hover,
        .time-picker-toggle:hover {
            background: #e2e8f0;
            color: #4f46e5;
        }

        /* Calendario */
        .calendar-container {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            z-index: 1000;
            padding: 16px;
            display: none;
            margin-top: 8px;
            min-width: 280px;
        }

        .calendar-container.show {
            display: block;
            animation: slideDown 0.2s ease-out;
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        .calendar-nav {
            background: none;
            border: none;
            color: #6b7280;
            cursor: pointer;
            padding: 6px;
            border-radius: 8px;
            transition: all 0.2s ease;
            font-size: 16px;
        }

        .calendar-nav:hover {
            background: #f1f5f9;
            color: #374151;
        }

        .calendar-month-year {
            font-weight: 600;
            font-size: 1rem;
            color: #1f2937;
        }

        .calendar-weekdays {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 4px;
            margin-bottom: 8px;
        }

        .weekday {
            text-align: center;
            font-size: 0.75rem;
            font-weight: 500;
            color: #6b7280;
            padding: 8px 4px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .calendar-days {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 4px;
        }

        .calendar-day {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.15s ease;
            color: #374151;
            min-height: 32px;
        }

        .calendar-day:hover {
            background: #f1f5f9;
            color: #1f2937;
        }

        .calendar-day.other-month {
            color: #d1d5db;
        }

        .calendar-day.today {
            background: #dbeafe;
            color: #1d4ed8;
            font-weight: 600;
        }

        .calendar-day.selected {
            background: #667eea;
            color: white;
            font-weight: 600;
            box-shadow: 0 2px 4px rgba(102, 126, 234, 0.3);
        }

        .calendar-day.disabled {
            color: #d1d5db;
            cursor: not-allowed;
        }

        .calendar-day.disabled:hover {
            background: none;
            color: #d1d5db;
        }

        /* Selector de hora */
        .time-picker-container {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            z-index: 1000;
            padding: 16px;
            display: none;
            margin-top: 8px;
            min-width: 200px;
        }

        .time-picker-container.show {
            display: block;
            animation: slideDown 0.2s ease-out;
        }

        .time-picker {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }

        .time-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
        }

        .time-section label {
            font-size: 0.75rem;
            font-weight: 500;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .time-select {
            padding: 8px 12px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            background: #f8fafc;
            cursor: pointer;
            min-width: 70px;
            transition: all 0.2s ease;
        }

        .time-select:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .time-separator {
            font-size: 1.25rem;
            font-weight: 600;
            color: #6b7280;
            margin-top: 16px;
        }

        /* Opciones adicionales */
        .date-options {
            margin-top: 12px;
            padding: 12px;
            background: #f8fafc;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
        }

        .option-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
            padding: 10px 12px;
            background: white;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            transition: all 0.2s ease;
        }

        .option-row:hover {
            border-color: #cbd5e1;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .option-row:last-child {
            margin-bottom: 0;
        }

        .option-label {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            font-size: 0.9rem;
            font-weight: 500;
            color: #374151;
            flex: 1;
        }

        .option-checkbox {
            width: 20px;
            height: 20px;
            margin: 0;
            cursor: pointer;
            accent-color: #667eea;
            transform: scale(1.3);
            border-radius: 4px;
            border: 2px solid #d1d5db;
            background: white;
            transition: all 0.2s ease;
        }

        .option-checkbox:hover {
            border-color: #667eea;
            box-shadow: 0 2px 4px rgba(102, 126, 234, 0.2);
        }

        .option-checkbox:checked {
            background: #667eea;
            border-color: #667eea;
            box-shadow: 0 2px 4px rgba(102, 126, 234, 0.3);
        }

        .checkmark {
            display: none;
        }

        .option-text {
            font-weight: 500;
        }

        .option-select {
            padding: 6px 10px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 0.875rem;
            background: white;
            cursor: pointer;
            min-width: 120px;
            transition: all 0.2s ease;
        }

        .option-select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.1);
        }

        .clear-date-btn {
            background: #ef4444;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 4px;
            transition: all 0.2s ease;
        }

        .clear-date-btn:hover {
            background: #dc2626;
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(239, 68, 68, 0.3);
        }

        /* Fecha de finalización */
        .end-date-section {
            margin-top: 12px;
            padding: 12px;
            background: #f0f9ff;
            border-radius: 12px;
            border: 1px solid #bae6fd;
        }

        .end-date-section .form-label {
            margin-bottom: 8px;
            color: #0369a1;
            font-size: 0.875rem;
            font-weight: 500;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .date-time-inputs {
                flex-direction: column;
                gap: 6px;
            }
            
            .time-picker {
                flex-direction: column;
                gap: 8px;
            }
            
            .time-separator {
                display: none;
            }
            
            .calendar-container,
            .time-picker-container {
                left: -5px;
                right: -5px;
                min-width: calc(100% + 10px);
            }
            
            .calendar-days {
                gap: 2px;
            }
            
            .calendar-day {
                min-height: 28px;
                font-size: 0.8rem;
            }
            
            .option-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }
            
            .clear-date-btn {
                align-self: flex-start;
            }
        }

        @media (max-width: 480px) {
            .date-time-inputs {
                padding: 6px;
            }
            
            .date-display,
            .time-display {
                padding: 10px 12px;
                font-size: 14px;
            }
            
            .calendar-container {
                padding: 12px;
            }
            
            .time-picker-container {
                padding: 12px;
            }
            
            .date-options {
                padding: 10px;
            }
            
            .end-date-section {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-wrapper">
            <div class="form-header">
                <div class="header-content">
                    
                    <div class="header-text">
                        <h1>Formulario de Peticiones</h1>
                        <p>Asignación de servicio mesa</p>
                    </div>
                    <img src="https://www.notion.so/images/logo-ios.png" alt="Notion Logo" class="notion-logo">
                </div>
            </div>
            
            <form id="solicitudForm" class="form">
                <!-- CSRF disabled for iframe embedding -->
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
                        <div class="date-time-picker">
                            <div class="date-time-inputs">
                                <div class="date-input-container">
                                    <input type="text" id="fecha_planeada_display" class="form-input date-display" readonly placeholder="Seleccionar fecha">
                                    <button type="button" class="date-picker-toggle" id="datePickerToggle">
                                        <i class="fas fa-calendar-alt"></i>
                                    </button>
                                </div>
                                <div class="time-input-container" id="timeInputContainer" style="display: none;">
                                    <input type="text" id="hora_planeada_display" class="form-input time-display" readonly placeholder="11:00">
                                    <button type="button" class="time-picker-toggle" id="timePickerToggle">
                                        <i class="fas fa-clock"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Calendario -->
                            <div class="calendar-container" id="calendarContainer">
                                <div class="calendar-header">
                                    <button type="button" class="calendar-nav" id="prevMonth">
                                        <i class="fas fa-chevron-left"></i>
                                    </button>
                                    <div class="calendar-month-year" id="calendarMonthYear">Sept 2025</div>
                                    <button type="button" class="calendar-nav" id="nextMonth">
                                        <i class="fas fa-chevron-right"></i>
                                    </button>
                                </div>
                                <div class="calendar-weekdays">
                                    <div class="weekday">Do</div>
                                    <div class="weekday">Lu</div>
                                    <div class="weekday">Ma</div>
                                    <div class="weekday">Mi</div>
                                    <div class="weekday">Ju</div>
                                    <div class="weekday">Vi</div>
                                    <div class="weekday">Sá</div>
                                </div>
                                <div class="calendar-days" id="calendarDays">
                                    <!-- Los días se generarán dinámicamente -->
                                </div>
                            </div>

                            <!-- Selector de hora -->
                            <div class="time-picker-container" id="timePickerContainer">
                                <div class="time-picker">
                                    <div class="time-section">
                                        <label>Hora</label>
                                        <select id="hourSelect" class="time-select">
                                            <!-- Las horas se generarán dinámicamente -->
                                        </select>
                                    </div>
                                    <div class="time-separator">:</div>
                                    <div class="time-section">
                                        <label>Minutos</label>
                                        <select id="minuteSelect" class="time-select">
                                            <!-- Los minutos se generarán dinámicamente -->
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Fecha de finalización -->
                            <div class="end-date-section" id="endDateSection" style="display: none;">
                                <label class="form-label">
                                    <i class="fas fa-calendar-times"></i>
                                    Fecha de Finalización
                                </label>
                                <div class="date-time-inputs">
                                    <div class="date-input-container">
                                        <input type="text" id="fecha_finalizacion_display" class="form-input date-display" readonly placeholder="Seleccionar fecha">
                                        <button type="button" class="date-picker-toggle" id="endDatePickerToggle">
                                            <i class="fas fa-calendar-alt"></i>
                                        </button>
                                    </div>
                                    <div class="time-input-container" style="display: none;">
                                        <input type="text" id="hora_finalizacion_display" class="form-input time-display" readonly placeholder="11:00">
                                        <button type="button" class="time-picker-toggle" id="endTimePickerToggle">
                                            <i class="fas fa-clock"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Opciones adicionales -->
                            <div class="date-options" id="dateOptions" style="display: none;">
                                <div class="option-row">
                                    <label class="option-label">
                                        <input type="checkbox" id="fechaFinalizacionToggle" class="option-checkbox">
                                        Agregar fecha de finalización
                                    </label>
                                </div>
                                <div class="option-row">
                                    <label class="option-label">
                                        <input type="checkbox" id="incluirHoraToggle" class="option-checkbox">
                                        Incluir hora
                                    </label>
                                </div>
                                <div class="option-row">
                                    <button type="button" class="clear-date-btn" id="clearDateBtn">
                                        <i class="fas fa-trash"></i>
                                        Borrar
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Inputs ocultos para el envío -->
                        <input type="hidden" id="fecha_planeada" name="fecha_planeada" required>
                        <input type="hidden" id="fecha_finalizacion" name="fecha_finalizacion">
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
                        <div class="dropdown-container">
                            <button type="button" class="dropdown-toggle" id="medioDropdown">
                                <span class="dropdown-text">Seleccione uno o más medios...</span>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <div class="dropdown-menu" id="medioDropdownMenu">
                                <div class="loading" id="medioLoading">
                                    <i class="fas fa-spinner fa-spin"></i> Cargando...
                                </div>
                                <div class="dropdown-options" id="medioOptions">
                                    <!-- Las opciones se cargarán aquí dinámicamente -->
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="medio" name="medio" required>
                        <div class="selected-items" id="selectedMedios">
                            <!-- Los elementos seleccionados se mostrarán aquí -->
                        </div>
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
                        Enviar Petición
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
                this.setupMedioDropdown();
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
                this.initializeDatePicker();
                this.initializeTimePicker();
                this.initializeDateOptions();
                this.setDefaultDateTime();
            }

            initializeDatePicker() {
                this.currentDate = new Date();
                this.selectedDate = new Date();
                this.calendarContainer = document.getElementById('calendarContainer');
                this.calendarMonthYear = document.getElementById('calendarMonthYear');
                this.calendarDays = document.getElementById('calendarDays');
                this.datePickerToggle = document.getElementById('datePickerToggle');
                this.fechaDisplay = document.getElementById('fecha_planeada_display');
                
                // Variables de modo
                this.isEndDateMode = false;
                this.isEndTimeMode = false;
                
                // Eventos del calendario
                this.datePickerToggle.addEventListener('click', () => this.toggleCalendar());
                document.getElementById('prevMonth').addEventListener('click', () => this.changeMonth(-1));
                document.getElementById('nextMonth').addEventListener('click', () => this.changeMonth(1));
                
                // Cerrar calendario al hacer clic fuera
                document.addEventListener('click', (e) => {
                    if (!e.target.closest('.date-time-picker')) {
                        this.closeCalendar();
                    }
                });
                
                this.renderCalendar();
            }

            initializeTimePicker() {
                this.timePickerContainer = document.getElementById('timePickerContainer');
                this.timePickerToggle = document.getElementById('timePickerToggle');
                this.horaDisplay = document.getElementById('hora_planeada_display');
                this.hourSelect = document.getElementById('hourSelect');
                this.minuteSelect = document.getElementById('minuteSelect');
                
                // Eventos del selector de hora
                this.timePickerToggle.addEventListener('click', () => this.toggleTimePicker());
                
                // Cerrar selector de hora al hacer clic fuera
                document.addEventListener('click', (e) => {
                    if (!e.target.closest('.time-picker-container') && !e.target.closest('.time-picker-toggle')) {
                        this.closeTimePicker();
                    }
                });
                
                this.populateTimeSelects();
            }

            initializeDateOptions() {
                this.fechaFinalizacionToggle = document.getElementById('fechaFinalizacionToggle');
                this.incluirHoraToggle = document.getElementById('incluirHoraToggle');
                this.clearDateBtn = document.getElementById('clearDateBtn');
                this.endDateSection = document.getElementById('endDateSection');
                this.timeInputContainer = document.getElementById('timeInputContainer');
                this.dateOptions = document.getElementById('dateOptions');
                
                // Eventos de las opciones
                this.fechaFinalizacionToggle.addEventListener('change', () => this.toggleEndDate());
                this.incluirHoraToggle.addEventListener('change', () => this.toggleTimeInclusion());
                this.clearDateBtn.addEventListener('click', () => this.clearDate());
                
                // Inicializar fecha de finalización
                this.initializeEndDatePicker();
            }

            initializeEndDatePicker() {
                this.endDatePickerToggle = document.getElementById('endDatePickerToggle');
                this.endTimePickerToggle = document.getElementById('endTimePickerToggle');
                this.fechaFinalizacionDisplay = document.getElementById('fecha_finalizacion_display');
                this.horaFinalizacionDisplay = document.getElementById('hora_finalizacion_display');
                
                // Eventos para fecha de finalización
                this.endDatePickerToggle.addEventListener('click', () => this.toggleEndDateCalendar());
                this.endTimePickerToggle.addEventListener('click', () => this.toggleEndTimePicker());
                
                // Eventos para los inputs de fecha de finalización
                this.fechaFinalizacionDisplay.addEventListener('click', () => this.toggleEndDateCalendar());
                this.horaFinalizacionDisplay.addEventListener('click', () => this.toggleEndTimePicker());
            }

            setDefaultDateTime() {
                // No establecer valores por defecto, el usuario debe seleccionar
                this.selectedDate = null;
                this.selectedTime = null;
                this.updateHiddenInputs();
            }

            // Funciones de control del calendario
            toggleCalendar() {
                if (this.calendarContainer.classList.contains('show')) {
                    this.closeCalendar();
                } else {
                    this.isEndDateMode = false; // Modo fecha principal
                    this.openCalendar();
                }
            }

            openCalendar() {
                this.calendarContainer.classList.add('show');
                this.closeTimePicker();
                // Mostrar opciones cuando se abre el calendario
                this.showDateOptions();
            }

            closeCalendar() {
                this.calendarContainer.classList.remove('show');
                this.isEndDateMode = false;
            }

            showDateOptions() {
                this.dateOptions.style.display = 'block';
            }

            hideDateOptions() {
                this.dateOptions.style.display = 'none';
            }

            toggleTimePicker() {
                if (this.timePickerContainer.classList.contains('show')) {
                    this.closeTimePicker();
                } else {
                    this.isEndTimeMode = false; // Modo hora principal
                    this.openTimePicker();
                }
            }

            openTimePicker() {
                this.timePickerContainer.classList.add('show');
                this.closeCalendar();
            }

            closeTimePicker() {
                this.timePickerContainer.classList.remove('show');
                this.isEndTimeMode = false;
            }

            changeMonth(direction) {
                this.currentDate.setMonth(this.currentDate.getMonth() + direction);
                this.renderCalendar();
            }

            renderCalendar() {
                const year = this.currentDate.getFullYear();
                const month = this.currentDate.getMonth();
                
                // Actualizar header del calendario
                const monthNames = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 
                                  'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
                this.calendarMonthYear.textContent = `${monthNames[month]} ${year}`;
                
                // Limpiar días del calendario
                this.calendarDays.innerHTML = '';
                
                // Obtener primer día del mes y cuántos días tiene
                const firstDay = new Date(year, month, 1);
                const lastDay = new Date(year, month + 1, 0);
                const daysInMonth = lastDay.getDate();
                const startingDayOfWeek = firstDay.getDay();
                
                // Días del mes anterior
                const prevMonth = new Date(year, month - 1, 0);
                const daysInPrevMonth = prevMonth.getDate();
                
                for (let i = startingDayOfWeek - 1; i >= 0; i--) {
                    const day = daysInPrevMonth - i;
                    const dayElement = this.createDayElement(day, true, false);
                    this.calendarDays.appendChild(dayElement);
                }
                
                // Días del mes actual
                for (let day = 1; day <= daysInMonth; day++) {
                    const dayDate = new Date(year, month, day);
                    const isToday = this.isToday(dayDate);
                    const isSelected = this.isSelectedDate(dayDate);
                    const isDisabled = this.isDateDisabled(dayDate);
                    
                    const dayElement = this.createDayElement(day, false, isToday, isSelected, isDisabled);
                    this.calendarDays.appendChild(dayElement);
                }
                
                // Días del mes siguiente para completar la grilla
                const totalCells = this.calendarDays.children.length;
                const remainingCells = 42 - totalCells; // 6 filas x 7 días
                
                for (let day = 1; day <= remainingCells; day++) {
                    const dayElement = this.createDayElement(day, true, false);
                    this.calendarDays.appendChild(dayElement);
                }
            }

            createDayElement(day, isOtherMonth, isToday = false, isSelected = false, isDisabled = false) {
                const dayElement = document.createElement('div');
                dayElement.className = 'calendar-day';
                dayElement.textContent = day;
                
                if (isOtherMonth) {
                    dayElement.classList.add('other-month');
                }
                if (isToday) {
                    dayElement.classList.add('today');
                }
                if (isSelected) {
                    dayElement.classList.add('selected');
                }
                if (isDisabled) {
                    dayElement.classList.add('disabled');
                }
                
                if (!isOtherMonth && !isDisabled) {
                    dayElement.addEventListener('click', () => this.selectDate(day));
                }
                
                return dayElement;
            }

            selectDate(day) {
                const year = this.currentDate.getFullYear();
                const month = this.currentDate.getMonth();
                const selectedDate = new Date(year, month, day);
                
                if (this.isEndDateMode) {
                    // Modo fecha de finalización
                    this.endSelectedDate = selectedDate;
                    this.updateEndDateDisplay();
                } else {
                    // Modo fecha principal
                    this.selectedDate = selectedDate;
                    this.updateDateDisplay();
                }
                
                this.updateHiddenInputs();
                this.closeCalendar();
                // Mantener las opciones visibles después de seleccionar fecha
                this.showDateOptions();
                this.validateDateField();
            }

            isToday(date) {
                const today = new Date();
                return date.toDateString() === today.toDateString();
            }

            isSelectedDate(date) {
                if (this.isEndDateMode) {
                    return this.endSelectedDate && date.toDateString() === this.endSelectedDate.toDateString();
                } else {
                    return this.selectedDate && date.toDateString() === this.selectedDate.toDateString();
                }
            }

            isDateDisabled(date) {
                const today = new Date();
                today.setHours(0, 0, 0, 0);
                return date < today;
            }

            // Funciones de actualización de display
            updateDateDisplay() {
                if (this.selectedDate) {
                    const day = this.selectedDate.getDate().toString().padStart(2, '0');
                    const month = (this.selectedDate.getMonth() + 1).toString().padStart(2, '0');
                    const year = this.selectedDate.getFullYear();
                    this.fechaDisplay.value = `${day}/${month}/${year}`;
                }
            }

            updateTimeDisplay() {
                if (this.selectedTime) {
                    const hour = this.selectedTime.hour.toString().padStart(2, '0');
                    const minute = this.selectedTime.minute.toString().padStart(2, '0');
                    this.horaDisplay.value = `${hour}:${minute}`;
                }
            }

            populateTimeSelects() {
                // Poblar horas (0-23)
                for (let hour = 0; hour < 24; hour++) {
                    const option = document.createElement('option');
                    option.value = hour;
                    option.textContent = hour.toString().padStart(2, '0');
                    this.hourSelect.appendChild(option);
                }
                
                // Poblar minutos (0, 15, 30, 45)
                const minuteOptions = [0, 15, 30, 45];
                minuteOptions.forEach(minute => {
                    const option = document.createElement('option');
                    option.value = minute;
                    option.textContent = minute.toString().padStart(2, '0');
                    this.minuteSelect.appendChild(option);
                });
                
                // Eventos para actualizar la hora
                this.hourSelect.addEventListener('change', () => this.updateTimeFromSelects());
                this.minuteSelect.addEventListener('change', () => this.updateTimeFromSelects());
            }

            setTimeSelectsValues(time) {
                if (time) {
                    this.hourSelect.value = time.hour;
                    this.minuteSelect.value = time.minute;
                }
            }

            updateTimeFromSelects() {
                const time = {
                    hour: parseInt(this.hourSelect.value),
                    minute: parseInt(this.minuteSelect.value)
                };
                
                if (this.isEndTimeMode) {
                    // Modo hora de finalización
                    this.endSelectedTime = time;
                    this.updateEndTimeDisplay();
                } else {
                    // Modo hora principal
                    this.selectedTime = time;
                    this.updateTimeDisplay();
                }
                
                this.updateHiddenInputs();
                this.validateDateField();
            }

            // Funciones de control de opciones
            toggleEndDate() {
                if (this.fechaFinalizacionToggle.checked) {
                    this.endDateSection.style.display = 'block';
                    this.initializeEndDate();
                } else {
                    this.endDateSection.style.display = 'none';
                    this.clearEndDate();
                }
                
                // Actualizar la visibilidad de la hora según el estado de "Incluir hora"
                this.updateTimeVisibility();
            }

            initializeEndDate() {
                if (!this.endSelectedDate) {
                    this.endSelectedDate = new Date(this.selectedDate);
                    this.updateEndDateDisplay();
                }
                // Solo establecer hora si "Incluir hora" está marcado
                if (this.incluirHoraToggle.checked) {
                    if (!this.endSelectedTime) {
                        this.endSelectedTime = this.selectedTime ? { ...this.selectedTime } : { hour: 0, minute: 0 };
                        this.updateEndTimeDisplay();
                    }
                }
            }

            toggleEndDateCalendar() {
                // Cerrar selector de hora si está abierto
                this.closeTimePicker();
                
                // Si el calendario principal está abierto, cerrarlo
                if (this.calendarContainer.classList.contains('show')) {
                    this.closeCalendar();
                }
                
                // Cambiar el modo a fecha de finalización
                this.isEndDateMode = true;
                this.openCalendar();
            }

            toggleEndTimePicker() {
                // Cerrar calendario si está abierto
                this.closeCalendar();
                
                // Si el selector de hora principal está abierto, cerrarlo
                if (this.timePickerContainer.classList.contains('show')) {
                    this.closeTimePicker();
                }
                
                // Cambiar el modo a hora de finalización
                this.isEndTimeMode = true;
                
                // Establecer los valores actuales en los selects
                if (this.endSelectedTime) {
                    this.setTimeSelectsValues(this.endSelectedTime);
                } else {
                    this.setTimeSelectsValues(this.selectedTime);
                }
                
                this.openTimePicker();
            }

            updateEndDateDisplay() {
                if (this.endSelectedDate) {
                    const day = this.endSelectedDate.getDate().toString().padStart(2, '0');
                    const month = (this.endSelectedDate.getMonth() + 1).toString().padStart(2, '0');
                    const year = this.endSelectedDate.getFullYear();
                    this.fechaFinalizacionDisplay.value = `${day}/${month}/${year}`;
                }
            }

            updateEndTimeDisplay() {
                if (this.endSelectedTime) {
                    const hour = this.endSelectedTime.hour.toString().padStart(2, '0');
                    const minute = this.endSelectedTime.minute.toString().padStart(2, '0');
                    this.horaFinalizacionDisplay.value = `${hour}:${minute}`;
                }
            }

            toggleTimeInclusion() {
                this.updateTimeVisibility();
                this.updateHiddenInputs();
            }

            updateTimeVisibility() {
                const includeTime = this.incluirHoraToggle.checked;
                
                // Controlar visibilidad de hora en fecha principal
                if (includeTime) {
                    this.timeInputContainer.style.display = 'block';
                    // Si no hay hora seleccionada, establecer una por defecto
                    if (!this.selectedTime) {
                        this.selectedTime = { hour: 0, minute: 0 };
                        this.updateTimeDisplay();
                    }
                } else {
                    this.timeInputContainer.style.display = 'none';
                    this.selectedTime = null;
                    this.horaDisplay.value = '';
                }
                
                // Controlar visibilidad de hora en fecha de finalización
                if (this.endDateSection && this.endDateSection.style.display !== 'none') {
                    const endTimeContainer = this.endDateSection.querySelector('.time-input-container');
                    if (endTimeContainer) {
                        if (includeTime) {
                            endTimeContainer.style.display = 'block';
                            // Si no hay hora de finalización seleccionada, establecer una por defecto
                            if (!this.endSelectedTime) {
                                this.endSelectedTime = { hour: 0, minute: 0 };
                                this.updateEndTimeDisplay();
                            }
                        } else {
                            endTimeContainer.style.display = 'none';
                            this.endSelectedTime = null;
                            this.horaFinalizacionDisplay.value = '';
                        }
                    }
                }
            }


            clearDate() {
                // Limpiar fecha principal
                this.selectedDate = null;
                this.selectedTime = null;
                this.fechaDisplay.value = '';
                this.horaDisplay.value = '';
                
                // Limpiar fecha de finalización
                this.clearEndDate();
                
                // Desmarcar todos los checkboxes
                this.fechaFinalizacionToggle.checked = false;
                this.incluirHoraToggle.checked = false;
                
                // Ocultar secciones
                this.endDateSection.style.display = 'none';
                this.timeInputContainer.style.display = 'none';
                this.hideDateOptions();
                
                // Actualizar inputs ocultos
                this.updateHiddenInputs();
                this.validateDateField();
            }

            clearEndDate() {
                this.endSelectedDate = null;
                this.endSelectedTime = null;
                this.fechaFinalizacionDisplay.value = '';
                this.horaFinalizacionDisplay.value = '';
                this.updateHiddenInputs();
            }

            updateHiddenInputs() {
                const fechaInput = document.getElementById('fecha_planeada');
                const fechaFinalizacionInput = document.getElementById('fecha_finalizacion');
                
                // Actualizar fecha principal
                if (this.selectedDate) {
                    const dateTime = new Date(this.selectedDate);
                    if (this.incluirHoraToggle.checked && this.selectedTime) {
                        dateTime.setHours(this.selectedTime.hour, this.selectedTime.minute, 0, 0);
                    } else {
                        dateTime.setHours(0, 0, 0, 0);
                    }
                    fechaInput.value = this.formatDateTimeForNotion(dateTime);
                } else {
                    fechaInput.value = '';
                }
                
                // Actualizar fecha de finalización
                if (this.endSelectedDate) {
                    const endDateTime = new Date(this.endSelectedDate);
                    if (this.endSelectedTime) {
                        endDateTime.setHours(this.endSelectedTime.hour, this.endSelectedTime.minute, 0, 0);
                    } else {
                        endDateTime.setHours(0, 0, 0, 0);
                    }
                    fechaFinalizacionInput.value = this.formatDateTimeForNotion(endDateTime);
                } else {
                    fechaFinalizacionInput.value = '';
                }
            }

            validateDateField() {
                const hasDate = this.selectedDate !== null;
                const hasTime = this.incluirHoraToggle.checked ? (this.selectedTime !== null) : true;
                const isValid = hasDate && hasTime;
                const container = this.fechaDisplay.closest('.form-group');
                
                if (isValid) {
                    this.fechaDisplay.classList.remove('invalid');
                    this.fechaDisplay.classList.add('valid');
                    this.hideFieldError(this.fechaDisplay);
                } else {
                    this.fechaDisplay.classList.remove('valid');
                    this.fechaDisplay.classList.add('invalid');
                    if (!hasDate) {
                        this.showFieldError(this.fechaDisplay, 'Debe seleccionar una fecha válida.');
                    } else if (this.incluirHoraToggle.checked && !hasTime) {
                        this.showFieldError(this.fechaDisplay, 'Debe seleccionar una hora válida.');
                    }
                }
                
                return isValid;
            }

            updateDateTimeDisplay() {
                const fechaInput = document.getElementById('fecha_planeada');
                
                if (fechaInput.value) {
                    // Crear la fecha desde el valor del input datetime-local
                    const selectedDateTime = new Date(fechaInput.value);
                    
                    // Crear un input oculto con el valor formateado correctamente para el envío
                    this.updateHiddenDateTimeValue(selectedDateTime);
                }
            }

            updateHiddenDateTimeValue(dateTime) {
                // Crear o actualizar un input oculto con el formato YYYY-MM-DDTHH:MM:SS.FFF-HH:MM
                let hiddenInput = document.getElementById('fecha_planeada_formatted');
                if (!hiddenInput) {
                    hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.id = 'fecha_planeada_formatted';
                    hiddenInput.name = 'fecha_planeada';
                    document.getElementById('fecha_planeada').parentNode.appendChild(hiddenInput);
                }
                
                // Formatear al formato YYYY-MM-DDTHH:MM:SS.FFF-HH:MM
                const formattedValue = this.formatDateTimeForNotion(dateTime);
                hiddenInput.value = formattedValue;
                
                // Remover el name del input original para evitar duplicados
                const originalInput = document.getElementById('fecha_planeada');
                originalInput.removeAttribute('name');
            }

            formatDateTimeForNotion(dateTime) {
                // Obtener la zona horaria local en formato -HH:MM
                const timezoneOffset = -dateTime.getTimezoneOffset();
                const timezoneHours = Math.floor(Math.abs(timezoneOffset) / 60);
                const timezoneMinutes = Math.abs(timezoneOffset) % 60;
                const sign = timezoneOffset >= 0 ? '+' : '-';
                const timezoneString = `${sign}${timezoneHours.toString().padStart(2, '0')}:${timezoneMinutes.toString().padStart(2, '0')}`;
                
                // Formatear la fecha y hora
                const year = dateTime.getFullYear();
                const month = (dateTime.getMonth() + 1).toString().padStart(2, '0');
                const day = dateTime.getDate().toString().padStart(2, '0');
                const hours = dateTime.getHours().toString().padStart(2, '0');
                const minutes = dateTime.getMinutes().toString().padStart(2, '0');
                const seconds = dateTime.getSeconds().toString().padStart(2, '0');
                
                // Formato: YYYY-MM-DDTHH:MM:SS.FFF-HH:MM
                return `${year}-${month}-${day}T${hours}:${minutes}:${seconds}.000${timezoneString}`;
            }

            // Cargar datos para los selects
            async loadSelectData() {
                const selects = [
                    { id: 'tipo', endpoint: CONFIG.endpoints.tipo },
                    { id: 'prioridad', endpoint: CONFIG.endpoints.prioridad }
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

            // Configurar dropdown personalizado para medios
            setupMedioDropdown() {
                this.medioDropdown = document.getElementById('medioDropdown');
                this.medioDropdownMenu = document.getElementById('medioDropdownMenu');
                this.medioOptions = document.getElementById('medioOptions');
                this.medioLoading = document.getElementById('medioLoading');
                this.selectedMedios = document.getElementById('selectedMedios');
                this.medioHiddenInput = document.getElementById('medio');
                
                this.selectedMediosList = [];
                
                // Eventos del dropdown
                this.medioDropdown.addEventListener('click', () => this.toggleMedioDropdown());
                
                // Cerrar dropdown al hacer clic fuera
                document.addEventListener('click', (e) => {
                    if (!e.target.closest('.dropdown-container')) {
                        this.closeMedioDropdown();
                    }
                });
                
                // Cargar opciones de medios
                this.loadMedioOptions();
            }

            toggleMedioDropdown() {
                if (this.medioDropdownMenu.classList.contains('show')) {
                    this.closeMedioDropdown();
                } else {
                    this.openMedioDropdown();
                }
            }

            openMedioDropdown() {
                this.medioDropdownMenu.classList.add('show');
                this.medioDropdown.classList.add('active');
            }

            closeMedioDropdown() {
                this.medioDropdownMenu.classList.remove('show');
                this.medioDropdown.classList.remove('active');
            }

            async loadMedioOptions() {
                try {
                    this.showLoading(this.medioLoading, true);
                    
                    const response = await fetch(CONFIG.endpoints.medio, {
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
                        this.populateMedioOptions(data.data);
                    } else {
                        throw new Error(data.message || 'Error en la respuesta del servidor');
                    }
                } catch (error) {
                    console.error('Error cargando opciones de medios:', error);
                    this.medioOptions.innerHTML = '<div class="dropdown-option">Error cargando opciones</div>';
                } finally {
                    this.showLoading(this.medioLoading, false);
                }
            }

            populateMedioOptions(options) {
                this.medioOptions.innerHTML = '';
                
                options.forEach(option => {
                    const optionDiv = document.createElement('div');
                    optionDiv.className = 'dropdown-option';
                    
                    const checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.id = `medio_${option.name || option.value}`;
                    checkbox.value = option.name || option.value;
                    
                    const label = document.createElement('label');
                    label.htmlFor = `medio_${option.name || option.value}`;
                    label.textContent = option.name || option.text || option.label;
                    
                    optionDiv.appendChild(checkbox);
                    optionDiv.appendChild(label);
                    
                    // Evento para manejar la selección
                    checkbox.addEventListener('change', () => {
                        this.handleMedioSelection(option.name || option.value, checkbox.checked);
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
                
                this.updateMedioDisplay();
                this.updateMedioHiddenInput();
                this.validateMedioField();
            }

            updateMedioDisplay() {
                this.selectedMedios.innerHTML = '';
                
                if (this.selectedMediosList.length === 0) {
                    this.medioDropdown.querySelector('.dropdown-text').textContent = 'Seleccione uno o más medios...';
                } else {
                    this.medioDropdown.querySelector('.dropdown-text').textContent = `${this.selectedMediosList.length} medio(s) seleccionado(s)`;
                    
                    this.selectedMediosList.forEach(medio => {
                        const itemDiv = document.createElement('div');
                        itemDiv.className = 'selected-item';
                        itemDiv.innerHTML = `
                            ${medio}
                            <button type="button" class="remove-btn" data-value="${medio}">
                                <i class="fas fa-times"></i>
                            </button>
                        `;
                        
                        // Evento para remover elemento
                        const removeBtn = itemDiv.querySelector('.remove-btn');
                        removeBtn.addEventListener('click', () => {
                            this.removeMedio(medio);
                        });
                        
                        this.selectedMedios.appendChild(itemDiv);
                    });
                }
            }

            removeMedio(medio) {
                this.selectedMediosList = this.selectedMediosList.filter(item => item !== medio);
                
                // Desmarcar checkbox
                const checkbox = document.querySelector(`input[value="${medio}"]`);
                if (checkbox) {
                    checkbox.checked = false;
                }
                
                this.updateMedioDisplay();
                this.updateMedioHiddenInput();
                this.validateMedioField();
            }

            updateMedioHiddenInput() {
                this.medioHiddenInput.value = JSON.stringify(this.selectedMediosList);
            }

            validateMedioField() {
                const isValid = this.selectedMediosList.length > 0;
                const container = this.medioDropdown.closest('.form-group');
                
                if (isValid) {
                    this.medioDropdown.classList.remove('invalid');
                    this.medioDropdown.classList.add('valid');
                    this.hideFieldError(this.medioDropdown);
                } else {
                    this.medioDropdown.classList.remove('valid');
                    this.medioDropdown.classList.add('invalid');
                    this.showFieldError(this.medioDropdown, 'Debe seleccionar al menos un medio.');
                }
                
                return isValid;
            }

            async loadSelectOptions(selectId, endpoint) {
                const select = document.getElementById(selectId);
                const loading = document.getElementById(`${selectId}Loading`);
                
                try {
                    this.showLoading(loading, true);
                    
                    const response = await fetch(endpoint, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json'
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
                let value, isValid, errorMessage = '';
                
                if (field.type === 'select-multiple') {
                    // Para multi-select, verificar que al menos una opción esté seleccionada
                    const selectedOptions = Array.from(field.selectedOptions);
                    value = selectedOptions.map(option => option.value).join(',');
                    isValid = selectedOptions.length > 0 && !selectedOptions.some(option => option.value === '');
                    if (!isValid) {
                        errorMessage = 'Debe seleccionar al menos un medio.';
                    }
                } else if (field.type === 'select-one') {
                    // Para select simple, verificar que no sea la opción por defecto
                    value = field.value.trim();
                    isValid = value !== '' && value !== null && value !== undefined;
                    if (!isValid) {
                        errorMessage = 'Debe seleccionar una opción.';
                    }
                } else if (field.type === 'datetime-local') {
                    // Para campos de fecha y hora, verificar que no esté vacío y sea válida
                    value = field.value.trim();
                    isValid = value !== '' && !isNaN(Date.parse(value));
                    if (!isValid) {
                        errorMessage = 'Debe seleccionar una fecha y hora válida.';
                    }
                } else if (field.type === 'textarea') {
                    // Para textarea, verificar que tenga contenido significativo
                    value = field.value.trim();
                    isValid = value !== '' && value.length >= 3; // Mínimo 3 caracteres
                    if (!isValid) {
                        errorMessage = value === '' ? 'Este campo es obligatorio.' : 'Debe escribir al menos 3 caracteres.';
                    }
                } else {
                    // Para inputs de texto, verificar que no esté vacío
                    value = field.value.trim();
                    isValid = value !== '' && value.length >= 2; // Mínimo 2 caracteres
                    if (!isValid) {
                        errorMessage = value === '' ? 'Este campo es obligatorio.' : 'Debe escribir al menos 2 caracteres.';
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

            // Mostrar error específico del campo
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

            // Ocultar error específico del campo
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
                
                // Validar cada campo requerido
                requiredFields.forEach(field => {
                    if (!this.validateField(field)) {
                        isValid = false;
                        const fieldName = this.getFieldDisplayName(field);
                        if (fieldName && !emptyFields.includes(fieldName)) {
                            emptyFields.push(fieldName);
                        }
                    }
                });
                
                // Validar dropdown de medios por separado
                if (!this.validateMedioField()) {
                    isValid = false;
                    if (!emptyFields.includes('Medio')) {
                        emptyFields.push('Medio');
                    }
                }
                
                // Validar componente de fecha personalizado
                if (!this.validateDateField()) {
                    isValid = false;
                    if (!emptyFields.includes('Fecha Planeada')) {
                        emptyFields.push('Fecha Planeada');
                    }
                }
                
                // Mostrar mensaje específico si hay campos vacíos
                if (!isValid && emptyFields.length > 0) {
                    const message = emptyFields.length === 1 
                        ? `El campo "${emptyFields[0]}" es obligatorio.`
                        : `Los siguientes campos son obligatorios: ${emptyFields.join(', ')}.`;
                    this.showMessage(message, 'error');
                }
                
                return isValid;
            }

            // Obtener nombre legible del campo para mostrar en errores
            getFieldDisplayName(field) {
                const fieldNames = {
                    'tipo': 'Area',
                    'solicitante': 'Quien Solicita',
                    'indicaciones': 'Indicaciones a Seguir',
                    'fecha_planeada': 'Fecha Planeada',
                    'prioridad': 'Prioridad',
                    'medio': 'Medio'
                };
                return fieldNames[field.name] || field.name;
            }

            // Manejo del envío del formulario
            async handleSubmit(e) {
                e.preventDefault();
                
                // Validar formulario antes de enviar
                if (!this.validateForm()) {
                    // El mensaje de error ya se muestra en validateForm()
                    return;
                }

                try {
                    this.setSubmitState(true);
                    
                    // Preparar los datos del formulario
                    const formData = new FormData(this.form);
                    
                    console.log('Enviando formulario...');
                    console.log('Endpoint:', CONFIG.endpoints.submit);

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
                        this.form.reset();
                        this.clearAllValidations();
                    } else {
                        // Mostrar errores específicos de validación si están disponibles
                        if (result.errors) {
                            console.error('Errores de validación:', result.errors);
                            let errorMessage = result.message || 'Error de validación:\n';
                            for (const [field, errors] of Object.entries(result.errors)) {
                                errorMessage += `• ${field}: ${errors.join(', ')}\n`;
                            }
                            this.showMessage(errorMessage, 'error');
                        } else {
                            this.showMessage(result.message || 'Error al enviar la solicitud. Por favor, inténtelo nuevamente.', 'error');
                        }
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
                
                // Limpiar dropdown de medios
                if (this.selectedMediosList) {
                    this.selectedMediosList = [];
                    this.updateMedioDisplay();
                    this.updateMedioHiddenInput();
                }
                
                // Limpiar componente de fecha
                this.clearDate();
                this.clearEndDate();
                this.fechaFinalizacionToggle.checked = false;
                this.endDateSection.style.display = 'none';
                this.incluirHoraToggle.checked = false;
                this.timeInputContainer.style.display = 'none';
                this.hideDateOptions();
            }

            clearAllValidations() {
                const fields = this.form.querySelectorAll('.valid, .invalid');
                fields.forEach(field => {
                    field.classList.remove('valid', 'invalid');
                    this.hideFieldError(field);
                });
                
                // Limpiar validación del dropdown de medios
                if (this.medioDropdown) {
                    this.medioDropdown.classList.remove('valid', 'invalid');
                    this.hideFieldError(this.medioDropdown);
                }
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

            // Mostrar popup de éxito
            showSuccessPopup() {
                // Crear el overlay del popup
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

                // Crear el contenido del popup
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
                    <h2 style="color: #1f2937; margin-bottom: 15px; font-size: 1.5rem;">¡Petición Enviada!</h2>
                    <p style="color: #6b7280; font-size: 1.1rem; line-height: 1.6; margin-bottom: 25px;">
                        Su petición ya fue enviada al área de mesa, en breve le llegará un correo con datos de dicha petición
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

                // Cerrar popup al hacer clic en el overlay
                overlay.addEventListener('click', (e) => {
                    if (e.target === overlay) {
                        overlay.remove();
                    }
                });

                // Cerrar popup con la tecla Escape
                const handleEscape = (e) => {
                    if (e.key === 'Escape') {
                        overlay.remove();
                        document.removeEventListener('keydown', handleEscape);
                    }
                };
                document.addEventListener('keydown', handleEscape);
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
