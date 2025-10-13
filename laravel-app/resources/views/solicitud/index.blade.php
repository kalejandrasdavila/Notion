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

    <!-- jQuery and jQuery UI for datepicker -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

    <script>
        // Test if jQuery loaded
        if (typeof jQuery === 'undefined') {
            console.error('jQuery not loaded!');
        } else {
            console.log('jQuery loaded:', jQuery.fn.jquery);
        }
    </script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Configuración base para permitir scroll interno */
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
            overflow: visible !important; /* Cambiado para permitir que el datetime picker se extienda */
            position: relative; /* Añadido para mejor posicionamiento */
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

        /* Pantallas medianas-grandes (992px - 1199px) - Laptops estándar */
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
            min-width: 0; /* Permite que el contenido se ajuste */
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
            min-width: 0; /* Permite que se ajuste al contenedor */
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
            z-index: 1055;
            max-height: 300px;
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
            
            .datetime-picker {
                min-width: 400px;
                max-width: 500px;
            }
            
            .form-header h1 {
                font-size: 2.2rem;
            }
            
            .form-actions {
                gap: 15px;
                flex-wrap: nowrap;
            }
        }

        /* Tablets pequeños y móviles grandes (576px - 767px) - iPads mini, móviles landscape */
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
            
            .datetime-picker {
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 95vw;
                max-width: 600px;
                max-height: 85vh;
                overflow-y: auto;
                z-index: 10000;
            }
            
            .datetime-picker-content {
                flex-direction: column;
                height: auto;
            }
            
            .calendar-section {
                border-right: none;
                border-bottom: 1px solid #e2e8f0;
                padding: 20px;
            }
            
            .time-section {
                padding: 20px;
            }
            
            .form-actions {
                gap: 12px;
                flex-wrap: nowrap;
            }
        }
            
            .form-wrapper {
                padding: 25px 25px 0 25px;
            }

            .header-content {
                flex-direction: row;
                gap: 15px;
                justify-content: space-between;
                align-items: center;
            }
            
            .header-text {
                text-align: left;
                flex: 1;
                gap: 12px;
            }

            .notion-logo {
                width: 50px;
                height: 50px;
            }
            
            .datetime-picker {
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 95vw;
                max-width: 700px;
                max-height: 85vh;
                overflow-y: auto;
                min-width: 600px;
            }
            
            .datetime-picker-header {
                display: flex;
            }
            
            .datetime-picker-content {
                -webkit-box-orient: horizontal;
                -webkit-box-direction: normal;
                -webkit-flex-direction: row;
                -ms-flex-direction: row;
                flex-direction: row;
                min-height: 400px;
            }
            
            .calendar-section {
                border-right: 1px solid #e2e8f0;
                min-width: 280px;
                max-width: 320px;
            }
            
            .time-section {
                flex: 0 0 200px;
                min-width: 200px;
                background: #f8fafc;
            }
        }

        /* Móviles estándar (400px - 575px) - iPhones, Androids */
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
                font-size: 16px; /* Evita zoom en iOS */
                padding: 12px 15px;
            }
            
            .form-textarea {
                min-height: 100px;
            }
            
            .datetime-picker {
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 98vw;
                max-width: none;
                max-height: 90vh;
                border-radius: 12px;
                z-index: 10000;
            }
            
            .datetime-picker-content {
                flex-direction: column;
                height: auto;
                min-height: auto;
            }
            
            .calendar-section,
            .time-section {
                padding: 15px;
            }
            
            .calendar-day {
                min-height: 35px;
                font-size: 0.9rem;
            }
            
            .time-scroll {
                height: 120px;
                max-height: 120px;
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
        
        /* Móviles pequeños (320px - 399px) - iPhones pequeños */
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
                font-size: 16px; /* Evita zoom en iOS */
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
            
            .datetime-picker {
                width: 98vw;
                max-width: none;
                border-radius: 12px;
                min-width: 350px;
            }
            
            .datetime-picker-content {
                -webkit-box-orient: vertical;
                -webkit-box-direction: normal;
                -webkit-flex-direction: column;
                -ms-flex-direction: column;
                flex-direction: column;
                min-height: auto;
            }
            
            .calendar-section {
                padding: 15px;
                border-right: none;
                border-bottom: 1px solid #e2e8f0;
                min-width: auto;
                max-width: none;
            }
            
            .time-section {
                padding: 15px;
                gap: 10px;
                flex: none;
                min-width: auto;
                background: #f8fafc;
            }
            
            .time-scroll {
                height: 120px;
                min-height: 120px;
            }
            
            .time-option {
                padding: 8px 12px;
                min-height: 32px;
                font-size: 13px;
            }
            
            .calendar-day {
                min-height: 28px;
                font-size: 0.8rem;
            }
            
            .dropdown-menu {
                max-height: 150px;
            }
        }
        

        /* Móviles ultra pequeños (menos de 320px) - Dispositivos muy antiguos */
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

        /* ===== ORIENTACIÓN LANDSCAPE EN MÓVILES ===== */
        
        /* Móviles en landscape (altura máxima 500px) */
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
            
            .datetime-picker {
                max-height: 90vh;
                overflow-y: auto;
            }
            
            .datetime-picker-content {
                flex-direction: row;
                height: auto;
                min-height: 250px;
            }
            
            .calendar-section {
                border-right: 1px solid #e2e8f0;
                border-bottom: none;
                flex: 1;
                min-width: 280px;
            }
            
            .time-section {
                flex: 0 0 200px;
            }
        }
            
            .btn {
                padding: 10px 16px;
                font-size: 13px;
                min-width: 100px;
            }
            
            .datetime-picker {
                width: 98vw;
                border-radius: 8px;
            }
            
            .calendar-section,
            .time-section {
                padding: 10px;
            }
        }

        /* jQuery UI Datepicker customization */
        .ui-datepicker {
            font-size: 0.9rem;
            z-index: 1050 !important;
        }

        .ui-timepicker-wrapper {
            z-index: 1051 !important;
        }

        /* Custom timepicker styling */
        .ui-timepicker-div {
            padding: 10px;
            background: white;
        }

        .ui-timepicker-div dl {
            text-align: left;
            margin: 0;
        }

        .ui-timepicker-div dl dt {
            float: left;
            clear: left;
            font-weight: bold;
            margin-right: 5px;
        }

        .ui-timepicker-div dl dd {
            margin: 0 0 10px 40%;
        }

        .ui_tpicker_hour_slider,
        .ui_tpicker_minute_slider {
            display: none !important;
        }

        .ui-timepicker-select {
            padding: 5px;
            margin: 2px;
        }







        /* Estilos específicos para Safari y Chrome */
        @media screen and (-webkit-min-device-pixel-ratio: 0) {
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
        }
        
        /* Estilos específicos para Chrome */
        @supports (-webkit-appearance: none) {
            .datetime-picker {
                will-change: transform;
                z-index: 9999 !important;
                -webkit-transform: translateZ(0);
                transform: translateZ(0);
                position: absolute !important;
                top: 100% !important;
                left: 0 !important;
                right: 0 !important;
            }
            
            .time-scroll {
                scroll-behavior: smooth;
            }
            
            /* Asegurar que el calendario esté por encima en Chrome */
            .datetime-picker.show {
                z-index: 9999 !important;
            }
            
            /* Prevenir conflictos de z-index en Chrome */
            .form-group:hover {
                z-index: 1 !important;
            }
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
        
        /* Mejoras para el datetime picker en dispositivos táctiles */
        @media (hover: none) and (pointer: coarse) {
            .datetime-picker {
                -webkit-overflow-scrolling: touch;
                overflow-scrolling: touch;
            }
            
            .time-scroll {
                -webkit-overflow-scrolling: touch;
                overflow-scrolling: touch;
            }
            
            .calendar-day,
            .time-option {
                min-height: 44px;
                min-width: 44px;
            }
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

        /* Reducir tamaño de scrollbars en time pickers */
        .time-picker::-webkit-scrollbar {
            width: 6px;
        }

        .time-picker::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        .time-picker::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }

        .time-picker::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        /* Aplicar a todos los elementos con scroll en time pickers */
        .flatpickr-time input,
        .flatpickr-time .flatpickr-time-separator,
        .time-list,
        .hour-list,
        .minute-list {
            scrollbar-width: thin;
            scrollbar-color: #c1c1c1 #f1f1f1;
        }

        /* CSS específico para datetime pickers */
        .flatpickr-calendar,
        .flatpickr-time {
            z-index: 9999 !important;
        }

        .flatpickr-calendar {
            max-height: none !important;
            max-width: 320px !important;
            width: 280px !important;
            overflow: visible !important;
            font-size: 10px !important;
        }

        .flatpickr-calendar .flatpickr-months {
            padding: 2px 6px !important;
        }

        .flatpickr-calendar .flatpickr-month {
            height: 16px !important;
        }

        .flatpickr-calendar .flatpickr-current-month {
            font-size: 9px !important;
            padding: 0 !important;
        }

        .flatpickr-calendar .flatpickr-weekdays {
            height: 14px !important;
        }

        .flatpickr-calendar .flatpickr-weekday {
            font-size: 7px !important;
            height: 14px !important;
            line-height: 14px !important;
        }

        .flatpickr-calendar .flatpickr-days {
            padding: 0.5px !important;
        }

        .flatpickr-calendar .flatpickr-day {
            height: 14px !important;
            line-height: 14px !important;
            font-size: 7px !important;
            margin: 0.05px !important;
        }

        .flatpickr-time {
            width: 120px !important;
            min-width: 120px !important;
            max-width: 120px !important;
            overflow: visible !important;
            padding: 2px !important;
        }

        .flatpickr-time .flatpickr-time-separator {
            margin: 0 2px !important;
            font-size: 8px !important;
        }

        .flatpickr-time input {
            width: 25px !important;
            min-width: 25px !important;
            max-width: 25px !important;
            font-size: 7px !important;
            padding: 0.5px 1px !important;
        }

        .flatpickr-time .flatpickr-am-pm {
            font-size: 7px !important;
            padding: 0.5px 2px !important;
        }

        /* Calendario - solución optimizada y simple */
        .datetime-picker {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            z-index: 1000;
            background: white;
            border: 1px solid #e1e5e9;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            display: none;
            max-height: 300px;
            overflow-y: auto;
        }

        .datetime-picker.show {
            display: block;
        }

        /* Ajustar el contenedor del datetime picker */
        .flatpickr-input {
            position: relative !important;
        }

        .flatpickr-calendar {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
            border: 1px solid #e1e5e9 !important;
        }

        /* Asegurar que el calendario nunca se salga del contenedor */
        .container {
            position: relative !important;
            overflow: visible !important;
        }

        .form-group {
            position: relative !important;
            overflow: visible !important;
        }

        .form-group:hover {
            z-index: 10;
        }

        /* Contenedor del datetime picker */
        .datetime-picker-container {
            position: relative;
        }

        /* Dropdowns normales - usando Bootstrap z-index */
        .dropdown-container {
            z-index: 1;
        }
        
        .dropdown-menu {
            z-index: 1;
        }
        
        .dropdown-toggle {
            z-index: 1;
        }

        /* Calendario siempre encima usando Bootstrap z-index */
        .datetime-picker.show {
            display: block;
        }
        
        /* Cuando el dropdown de Medio está abierto, asegurar que esté por encima */
        .dropdown-menu.show {
            z-index: 1055 !important;
        }
        
        /* Asegurar que el dropdown de Medio no sea obstruido por el calendario */
        .dropdown-container .dropdown-menu {
            z-index: 1055 !important;
        }

        /* Estilos para el grupo de checkboxes de Medio */
        .checkbox-group {
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 15px;
            background-color: #fafafa;
            min-height: 60px;
        }

        .checkbox-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 10px;
            margin-top: 10px;
        }

        .checkbox-option {
            display: flex;
            align-items: center;
            padding: 8px 12px;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .checkbox-option:hover {
            background-color: #f3f4f6;
            border-color: #667eea;
        }

        .checkbox-option input[type="checkbox"] {
            margin-right: 10px;
            transform: scale(1.2);
        }

        .checkbox-option label {
            cursor: pointer;
            margin: 0;
            flex: 1;
            font-size: 14px;
            color: #374151;
        }

        .checkbox-option.checked {
            background-color: #e0f2fe;
            border-color: #0ea5e9;
        }



        /* Scrollbars más delgados para todos los elementos */
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
    </style>
</head>
<body>
    <!-- Widget de fecha y hora -->
    <div class="datetime-widget">
        <div class="location">Monterrey, NL, México</div>
        <div class="date" id="currentDate"></div>
        <div class="time" id="currentTime"></div>
    </div>

    <div class="container">
        <div class="form-wrapper">
            <div class="form-header">
                <div class="header-content" style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                    <div style="flex: 1;"></div>
                    <div style="flex: 2;">
                        <p id="welcome-message" class="text-center mb-2" style="font-size: 1.2rem; color: #333; font-weight: 500; display: none;"></p>
                        <h1 class="mb-0" style="text-align: center;">Formulario de Peticiones</h1>
                        <p class="text-muted mb-0 mt-2" style="font-size: 1.1rem; text-align: left; padding-left: 11%;">Asignación de servicio mesa</p>
                    </div>
                    <div style="flex: 1; text-align: right;">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e9/Notion-logo.svg/2048px-Notion-logo.svg.png" alt="Notion" class="logo-notion">
                    </div>
                </div>
            </div>
            
            <form id="solicitudForm" class="form" enctype="multipart/form-data">
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

                    <!-- Quien solicita (hidden but functional) -->
                    <input type="hidden" id="solicitante" name="solicitante" value="">

                    <!-- Indicaciones -->
                    <div class="form-group full-width">
                        <label for="indicaciones" class="form-label">
                            <i class="fas fa-list-ul"></i>
                            Indicaciones a seguir (Título corto ¿Qué? ¿Cómo? y ¿Dónde?)
                        </label>
                        <textarea id="indicaciones" name="indicaciones" class="form-textarea"
                                  placeholder="Describa las indicaciones detalladamente..."
                                  rows="4" maxlength="1990"></textarea>
                        <div class="character-counter text-muted small mt-1">
                            <span id="indicaciones-counter">0</span> / 1990 caracteres
                        </div>
                    </div>

                    <!-- Redacción complementaria -->
                    <div class="form-group full-width">
                        <label for="redaccion_complementaria" class="form-label">
                            <i class="fas fa-comment-dots"></i>
                            Redacción complementaria
                        </label>
                        <textarea id="redaccion_complementaria" name="redaccion_complementaria" class="form-textarea"
                                  placeholder="Información adicional o comentarios..."
                                  rows="4" maxlength="1990"></textarea>
                        <div class="character-counter text-muted small mt-1">
                            <span id="redaccion-counter">0</span> / 1990 caracteres
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

                    <!-- Fecha de Fin -->
                    <div class="form-group">
                        <label for="fecha_fin" class="form-label">
                            <i class="fas fa-calendar-times"></i>
                            Fecha de Fin <span class="required">*</span>
                        </label>
                        <input type="datetime-local" id="fecha_fin" name="fecha_fin" class="form-input"
                               required>
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
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-broadcast-tower"></i>
                            Medio <span class="required">*</span>
                        </label>
                        <div class="checkbox-group" id="medioCheckboxGroup">
                            <div class="loading" id="medioLoading">
                                <i class="fas fa-spinner fa-spin"></i> Cargando...
                            </div>
                            <div class="checkbox-options" id="medioOptions">
                                <!-- Las opciones se cargarán aquí dinámicamente -->
                            </div>
                        </div>
                        <input type="hidden" id="medio" name="medio" required>
                        <div class="field-error" id="medioError"></div>
                    </div>
                    <!-- Link de descarga -->
                    <div class="form-group full-width">
                        <label for="link_descarga" class="form-label">
                            <i class="fas fa-link"></i>
                            Link de descarga
                        </label>
                        <textarea id="link_descarga" name="link_descarga" class="form-textarea"
                                  placeholder="https://ejemplo.com/archivo&#10;https://ejemplo.com/otro-archivo&#10;(Puede ingresar múltiples URLs, una por línea)"
                                  rows="3" maxlength="1990"></textarea>
                        <div class="character-counter text-muted small mt-1">
                            <span id="link-counter">0</span> / 1990 caracteres
                        </div>
                        <small class="text-muted">Puede ingresar múltiples URLs separadas por líneas</small>
                        <div class="field-error" id="linkDescargaError"></div>
                    </div>

                    <!-- Adjuntar archivo -->
                    <div class="form-group full-width">
                        <label class="form-label">
                            <i class="fas fa-paperclip"></i>
                            Adjuntar Archivo
                        </label>
                        <input type="file" id="archivo" class="form-control" multiple accept=".pdf,.doc,.docx,.xls,.xlsx,.png,.jpg,.jpeg,.gif">
                        <small class="text-muted">Puede seleccionar múltiples archivos. Formatos permitidos: PDF, DOC, DOCX, XLS, XLSX, PNG, JPG, JPEG, GIF (Max: 10MB cada uno)</small>
                        <div id="fileList" class="mt-2"></div>
                        <!-- Hidden container for actual file inputs that will be submitted -->
                        <div id="fileInputsContainer" style="display: none;"></div>
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
        // Character counter for textareas
        function setupCharacterCounter(textareaId, counterId) {
            const textarea = document.getElementById(textareaId);
            const counter = document.getElementById(counterId);

            if (textarea && counter) {
                // Update counter on input
                textarea.addEventListener('input', function() {
                    const currentLength = this.value.length;
                    counter.textContent = currentLength;

                    // Change color when approaching limit
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

                // Initial count
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
                this.files = new Map(); // Store files with unique IDs
                this.fileCounter = 0;
                this.fileInput = document.getElementById('archivo');
                this.fileList = document.getElementById('fileList');
                this.fileInputsContainer = document.getElementById('fileInputsContainer');

                this.init();
            }

            init() {
                // Handle file selection
                this.fileInput.addEventListener('change', (e) => {
                    this.addFiles(e.target.files);
                    // Reset the input so the same file can be selected again
                    e.target.value = '';
                });
            }

            addFiles(fileList) {
                const files = Array.from(fileList);

                files.forEach(file => {
                    const fileId = `file_${this.fileCounter++}`;

                    // Check for duplicates
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
                this.updateHiddenInputs();
            }

            removeFile(fileId) {
                this.files.delete(fileId);
                this.updateFileDisplay();
                this.updateHiddenInputs();
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

            updateHiddenInputs() {
                // Clear existing hidden inputs
                this.fileInputsContainer.innerHTML = '';

                // Create a DataTransfer object to hold our files
                const dt = new DataTransfer();

                for (let [fileId, file] of this.files) {
                    dt.items.add(file);
                }

                // Create a hidden file input with all files
                if (dt.files.length > 0) {
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'file';
                    hiddenInput.name = 'archivo[]';
                    hiddenInput.multiple = true;
                    hiddenInput.style.display = 'none';
                    hiddenInput.files = dt.files;
                    this.fileInputsContainer.appendChild(hiddenInput);
                }
            }

            clearAll() {
                this.files.clear();
                this.updateFileDisplay();
                this.updateHiddenInputs();
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

        // Widget de fecha y hora para Monterrey, NL, México
        function updateDateTime() {
            const now = new Date();
            
            // Configurar zona horaria de Monterrey (America/Monterrey)
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
        
                // Actualizar inmediatamente y luego cada segundo
                updateDateTime();
                setInterval(updateDateTime, 1000);


        // Función para hacer el calendario más compacto
        function makeCalendarCompact() {
            const calendars = document.querySelectorAll('.flatpickr-calendar.open');
            calendars.forEach(calendar => {
                // Asegurar que el calendario sea ultra-compacto
                calendar.style.maxHeight = '150px';
                calendar.style.overflowY = 'auto';
                calendar.style.width = '220px';
                calendar.style.maxWidth = '220px';
            });
        }

        // Aplicar estilos compactos cuando se abre el calendario
        document.addEventListener('DOMContentLoaded', function() {
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.type === 'childList') {
                        const addedNodes = Array.from(mutation.addedNodes);
                        addedNodes.forEach(node => {
                            if (node.nodeType === 1 && node.classList && node.classList.contains('flatpickr-calendar')) {
                                setTimeout(makeCalendarCompact, 10);
                            }
                        });
                    }
                });
            });
            
            observer.observe(document.body, {
                childList: true,
                subtree: true
            });
        });

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
                // Date validation is now handled by jQuery datepicker
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

            // Configurar checkboxes para medios
            setupMedioDropdown() {
                this.medioCheckboxGroup = document.getElementById('medioCheckboxGroup');
                this.medioOptions = document.getElementById('medioOptions');
                this.medioLoading = document.getElementById('medioLoading');
                this.medioHiddenInput = document.getElementById('medio');
                this.medioError = document.getElementById('medioError');
                
                this.selectedMediosList = [];
                
                // Cargar opciones de medios
                this.loadMedioOptions();
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
                    
                    // Evento para manejar la selección
                    checkbox.addEventListener('change', () => {
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
                const container = this.medioCheckboxGroup.closest('.form-group');
                
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
                    // Para textarea, verificar solo si es required
                    value = field.value.trim();
                    if (field.hasAttribute('required')) {
                        isValid = value !== '' && value.length >= 3; // Mínimo 3 caracteres
                        if (!isValid) {
                            errorMessage = value === '' ? 'Este campo es obligatorio.' : 'Debe escribir al menos 3 caracteres.';
                        }
                    } else {
                        // Campo opcional - siempre válido
                        isValid = true;
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
                
                // Date validation is now handled by required attribute on inputs
                
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
                    'indicaciones': 'Indicaciones a seguir (Título corto ¿Qué? ¿Cómo? y ¿Dónde?)',
                    'fecha_inicio': 'Fecha de Inicio',
                    'fecha_fin': 'Fecha de Fin',
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

                    // Log file information
                    const fileInput = document.getElementById('archivo');
                    if (fileInput && fileInput.files.length > 0) {
                        console.log('=== FILES BEING UPLOADED ===');
                        console.log('Number of files:', fileInput.files.length);
                        for (let i = 0; i < fileInput.files.length; i++) {
                            const file = fileInput.files[i];
                            console.log(`File ${i + 1}:`, {
                                name: file.name,
                                size: file.size,
                                type: file.type,
                                lastModified: file.lastModified
                            });
                        }
                        console.log('=========================');
                    } else {
                        console.log('No files selected for upload');
                    }

                    // Get datetime values and convert to ISO format with GMT-6
                    const fechaInicioValue = document.getElementById('fecha_inicio').value;
                    const fechaFinValue = document.getElementById('fecha_fin').value;

                    if (fechaInicioValue) {
                        // The datetime-local value is in local time without timezone
                        // We need to append seconds and the Monterrey timezone offset
                        // This tells the backend that this time is in GMT-6
                        const fechaInicio = fechaInicioValue + ':00-06:00';
                        formData.set('fecha_inicio', fechaInicio);
                    }
                    if (fechaFinValue) {
                        // The datetime-local value is in local time without timezone
                        // We need to append seconds and the Monterrey timezone offset
                        // This tells the backend that this time is in GMT-6
                        const fechaFin = fechaFinValue + ':00-06:00';
                        formData.set('fecha_fin', fechaFin);
                    }
                    
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

                    // Log the full response from backend
                    console.log('=== BACKEND RESPONSE ===');
                    console.log('Full response:', result);
                    if (result.data && result.data.properties) {
                        console.log('Notion properties sent:', result.data.properties);
                        if (result.data.properties['ADJUNTAR ARCHIVO']) {
                            console.log('File URLs in Notion:', result.data.properties['ADJUNTAR ARCHIVO']);
                        }
                    }
                    console.log('========================');

                    if (result.success) {
                        this.showSuccessPopup();

                        // Save the solicitante value from hidden field
                        const solicitanteField = document.getElementById('solicitante');
                        const solicitanteValue = solicitanteField ? solicitanteField.value : null;

                        this.form.reset();
                        this.handleReset();

                        // Clear file manager after successful submission
                        if (typeof fileManager !== 'undefined') {
                            fileManager.clearAll();
                        }

                        // Restore solicitante value to hidden field
                        if (solicitanteField && solicitanteValue) {
                            solicitanteField.value = solicitanteValue;
                        }
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

                // Clear file manager
                if (typeof fileManager !== 'undefined') {
                    fileManager.clearAll();
                }

                // Limpiar checkboxes de medios
                if (this.selectedMediosList) {
                    this.selectedMediosList = [];
                    this.updateMedioHiddenInput();
                    // Desmarcar todos los checkboxes
                    const checkboxes = this.medioOptions.querySelectorAll('input[type="checkbox"]');
                    checkboxes.forEach(checkbox => {
                        checkbox.checked = false;
                        const optionDiv = checkbox.closest('.checkbox-option');
                        if (optionDiv) {
                            optionDiv.classList.remove('checked');
                        }
                    });
                }

                // Clear datetime fields
                document.getElementById('fecha_inicio').value = '';
                document.getElementById('fecha_fin').value = '';
            }

            // OLD - No longer needed with datetime-local input
            /*convertDateToISO(dateString) {
                if (!dateString || dateString.trim() === '') {
                    return null;
                }

                // Try to parse DD/MM/YYYY HH:MM AM/PM format
                const dateTimeRegex = /^(\d{1,2})\/(\d{1,2})\/(\d{4})\s+(\d{1,2}):(\d{2})\s*(AM|PM)?$/i;
                const match = dateString.match(dateTimeRegex);

                if (match) {
                    const day = parseInt(match[1]);
                    const month = parseInt(match[2]);
                    const year = parseInt(match[3]);
                    let hours = parseInt(match[4]);
                    const minutes = parseInt(match[5]);
                    const ampm = (match[6] || 'AM').toUpperCase();

                    // Convert to 24-hour format
                    if (ampm === 'PM' && hours !== 12) {
                        hours += 12;
                    } else if (ampm === 'AM' && hours === 12) {
                        hours = 0;
                    }

                    // Create date and format with GMT-6
                    const localDate = new Date(year, month - 1, day, hours, minutes);
                    return formatDateTimeWithTimezone(localDate, -6);
                }

                return null;
            }*/

            clearAllValidations() {
                const fields = this.form.querySelectorAll('.valid, .invalid');
                fields.forEach(field => {
                    field.classList.remove('valid', 'invalid');
                    this.hideFieldError(field);
                });
                
                // Limpiar validación del grupo de checkboxes de medios
                if (this.medioCheckboxGroup) {
                    this.medioCheckboxGroup.classList.remove('valid', 'invalid');
                    this.hideFieldError(this.medioError);
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

        // Función para formatear fecha y hora con timezone específico
        // OLD - No longer needed with datetime-local input
        /*function formatDateTimeWithTimezone(date, timezoneOffsetHours) {
            // Crear una nueva fecha ajustada al timezone especificado
            const offsetMs = timezoneOffsetHours * 60 * 60 * 1000;
            const utcTime = date.getTime() + (date.getTimezoneOffset() * 60000);
            const targetTime = new Date(utcTime + offsetMs);
            
            // Formatear en formato ISO con timezone
            const year = targetTime.getFullYear();
            const month = String(targetTime.getMonth() + 1).padStart(2, '0');
            const day = String(targetTime.getDate()).padStart(2, '0');
            const hours = String(targetTime.getHours()).padStart(2, '0');
            const minutes = String(targetTime.getMinutes()).padStart(2, '0');
            const seconds = String(targetTime.getSeconds()).padStart(2, '0');
            const milliseconds = String(targetTime.getMilliseconds()).padStart(3, '0');
            
            // Formatear el offset del timezone
            const offsetSign = timezoneOffsetHours >= 0 ? '+' : '-';
            const offsetHours = String(Math.abs(timezoneOffsetHours)).padStart(2, '0');
            const offsetMinutes = '00'; // Asumimos que siempre son horas completas
            
            return `${year}-${month}-${day}T${hours}:${minutes}:${seconds}.${milliseconds}${offsetSign}${offsetHours}:${offsetMinutes}`;
        }*/

        // Función para obtener parámetros de la URL
        function getUrlParameter(name) {
            name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
            var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
            var results = regex.exec(location.search);
            return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
        }

        // Inicializar la aplicación cuando el DOM esté listo
        $(document).ready(function() {
            console.log('Inicializando FormularioSolicitud...');

            // Check for 'solicitante' parameter in URL
            const solicitanteParam = getUrlParameter('solicitante');
            if (solicitanteParam) {
                // Set the hidden field value from URL parameter
                const solicitanteField = document.getElementById('solicitante');
                if (solicitanteField) {
                    solicitanteField.value = solicitanteParam;
                }

                // Display welcome message
                const welcomeMessage = document.getElementById('welcome-message');
                if (welcomeMessage) {
                    welcomeMessage.textContent = `Bienvenid@ ${solicitanteParam}`;
                    welcomeMessage.style.display = 'block';
                }
            }

            // Set minimum date/time to current local time
            // The browser should already be in Monterrey timezone
            const now = new Date();

            // Format for datetime-local input using local time
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const minDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;

            // Set minimum to current time
            document.getElementById('fecha_inicio').min = minDateTime;
            document.getElementById('fecha_fin').min = minDateTime;

            // Set default values to current time
            document.getElementById('fecha_inicio').value = minDateTime;
            document.getElementById('fecha_fin').value = minDateTime;

            // Auto-set end date when start date changes
            document.getElementById('fecha_inicio').addEventListener('change', function() {
                const startDate = this.value;
                if (startDate) {
                    // Set end date minimum to start date
                    document.getElementById('fecha_fin').min = startDate;

                    // If end date is before start date, clear it
                    const endDate = document.getElementById('fecha_fin').value;
                    if (endDate && endDate < startDate) {
                        document.getElementById('fecha_fin').value = '';
                    }
                }
            });

            // Initialize the form application
            /*OLD CODE REMOVED - was using jQuery datepicker
            $.datepicker.regional['es'] = {
                closeText: 'Cerrar',
                prevText: '&#x3C;Ant',
                nextText: 'Sig&#x3E;',
                currentText: 'Hoy',
                monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
                'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
                monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun',
                'Jul','Ago','Sep','Oct','Nov','Dic'],
                dayNames: ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'],
                dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
                dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
                weekHeader: 'Sm',
                dateFormat: 'dd/mm/yy',
                firstDay: 1,
                isRTL: false,
                showMonthAfterYear: false,
                yearSuffix: ''
            };
            $.datepicker.setDefaults($.datepicker.regional['es']);

            // Simple approach: Use regular datepicker and let users type time
            $('#fecha_inicio, #fecha_fin').each(function() {
                const inputId = $(this).attr('id');
                const $input = $(this);

                // Initialize just the datepicker (no time picker)
                $input.datepicker({
                    dateFormat: 'dd/mm/yy',
                    changeMonth: true,
                    changeYear: true,
                    showButtonPanel: true,
                    minDate: 0, // Prevent selecting past dates
                    onSelect: function(dateText) {
                        // Always set to standard format with time
                        $input.val(dateText + ' 12:00 PM');
                        $input.trigger('input');
                    },
                    beforeShow: function(input, inst) {
                        // Override the Today button behavior
                        setTimeout(function() {
                            const $buttonPane = $(inst.dpDiv).find('.ui-datepicker-buttonpane');
                            const $todayBtn = $buttonPane.find('.ui-datepicker-current');

                            // Remove default handler and add custom one
                            $todayBtn.off('click');
                            $todayBtn.on('click', function() {
                                const now = new Date();
                                const day = now.getDate().toString().padStart(2, '0');
                                const month = (now.getMonth() + 1).toString().padStart(2, '0');
                                const year = now.getFullYear();
                                let hours = now.getHours();
                                const minutes = now.getMinutes().toString().padStart(2, '0');

                                // Convert to 12-hour format
                                const ampm = hours >= 12 ? 'PM' : 'AM';
                                hours = hours % 12;
                                hours = hours ? hours : 12; // 0 should be 12
                                const hoursStr = hours.toString().padStart(2, '0');

                                // Set the value with current date and time
                                const dateTimeStr = `${day}/${month}/${year} ${hoursStr}:${minutes} ${ampm}`;
                                $input.val(dateTimeStr);
                                $input.datepicker('hide');
                                $input.trigger('blur');
                            });
                        }, 1);
                    }
                });

                // Prevent invalid characters and format on keypress for better control
                $input.on('keypress', function(e) {
                    const char = String.fromCharCode(e.which);
                    const value = $(this).val();
                    const cursorPos = this.selectionStart;

                    // Allow backspace, delete, tab, escape, enter
                    if (e.which === 0 || e.which === 8) {
                        return true;
                    }

                    // Only allow numbers, A, M, P
                    if (!/[0-9APMapm]/.test(char)) {
                        e.preventDefault();
                        return false;
                    }

                    // If typing A or P to change AM/PM
                    if (/[APap]/.test(char) && value.includes(':')) {
                        e.preventDefault();
                        let newValue = value.replace(/\s*(AM|PM|am|pm)\s*$/i, '');

                        if (char.toUpperCase() === 'A') {
                            newValue += ' AM';
                        } else if (char.toUpperCase() === 'P') {
                            newValue += ' PM';
                        }

                        $(this).val(newValue);
                        // Move cursor to end
                        this.setSelectionRange(newValue.length, newValue.length);
                        return false;
                    }

                    // If typing a number in time section
                    if (cursorPos >= 11 && cursorPos <= 16 && /[0-9]/.test(char)) {
                        // Check if we're at the colon position
                        if (value[cursorPos] === ':') {
                            // Jump past the colon
                            e.preventDefault();
                            const before = value.substring(0, cursorPos + 1);
                            const after = value.substring(cursorPos + 1);
                            $(this).val(before + char + after.substring(1));
                            this.setSelectionRange(cursorPos + 2, cursorPos + 2);
                            return false;
                        }
                    }
                });

                // Format on input
                $input.on('input', function(e) {
                    let value = $(this).val();
                    let cursorPos = this.selectionStart;

                    // Remove invalid characters
                    value = value.replace(/[^0-9\/:\sAPMamp]/gi, '');

                    // Extract AM/PM if present
                    let ampmPart = '';
                    const ampmMatch = value.match(/\s+(AM|PM|am|pm|A|P|a|p)\s*$/i);
                    if (ampmMatch) {
                        const typed = ampmMatch[1].toUpperCase();
                        if (typed === 'A' || typed === 'AM') {
                            ampmPart = 'AM';
                        } else if (typed === 'P' || typed === 'PM') {
                            ampmPart = 'PM';
                        }
                        // Remove the AM/PM part for processing
                        value = value.replace(/\s+(AM|PM|am|pm|A|P|a|p)\s*$/i, '');
                    }

                    // Split into parts (without AM/PM)
                    const match = value.match(/^(\d{0,2})\/?(\d{0,2})\/?(\d{0,4})\s*(\d{0,2}):?(\d{0,2})?/);

                    if (match) {
                        let formatted = '';

                        // Date part
                        if (match[1]) {
                            formatted += match[1];
                            if (match[1].length === 2) formatted += '/';
                        }
                        if (match[2]) {
                            formatted += match[2];
                            if (match[2].length === 2) formatted += '/';
                        }
                        if (match[3]) {
                            formatted += match[3];
                        }

                        // Time part
                        if (match[4]) {
                            if (formatted.length > 0) formatted += ' ';

                            // Validate hours
                            let hours = parseInt(match[4]) || 0;
                            if (hours > 12) hours = 12;
                            if (hours === 0) hours = 12;

                            formatted += hours.toString().padStart(2, '0') + ':';

                            // Minutes
                            if (match[5]) {
                                let mins = parseInt(match[5]) || 0;
                                if (mins > 59) mins = 59;
                                formatted += mins.toString().padStart(2, '0');
                            } else {
                                formatted += '00';
                            }

                            // Add AM/PM
                            if (ampmPart) {
                                formatted += ' ' + ampmPart;
                            } else if (formatted.includes(':')) {
                                formatted += ' AM';
                            }
                        }

                        $(this).val(formatted);

                        // Maintain cursor position
                        if (this.setSelectionRange) {
                            this.setSelectionRange(cursorPos, cursorPos);
                        }
                    }
                });

                // Format and validate on blur
                $input.on('blur', function() {
                    let value = $(this).val().trim();

                    // Try to parse and reformat
                    const dateTimeRegex = /^(\d{1,2})\/(\d{1,2})\/(\d{4})\s+(\d{1,2}):(\d{2})\s*(AM|PM)?$/i;
                    const match = value.match(dateTimeRegex);

                    if (match) {
                        const day = parseInt(match[1]);
                        const month = parseInt(match[2]);
                        const year = parseInt(match[3]);
                        let hours = parseInt(match[4]);
                        const minutes = parseInt(match[5]);
                        const ampm = (match[6] || 'AM').toUpperCase();

                        // Validate ranges
                        if (day >= 1 && day <= 31 && month >= 1 && month <= 12 &&
                            hours >= 1 && hours <= 12 && minutes >= 0 && minutes <= 59) {

                            // Format with proper padding
                            const formattedDate =
                                day.toString().padStart(2, '0') + '/' +
                                month.toString().padStart(2, '0') + '/' +
                                year + ' ' +
                                hours.toString().padStart(2, '0') + ':' +
                                minutes.toString().padStart(2, '0') + ' ' +
                                ampm;

                            $(this).val(formattedDate);

                            // Convert to 24-hour format for backend
                            if (ampm === 'PM' && hours !== 12) {
                                hours += 12;
                            } else if (ampm === 'AM' && hours === 12) {
                                hours = 0;
                            }

                            // Create ISO date for backend with GMT-6 timezone
                            const localDate = new Date(year, month - 1, day, hours, minutes);
                            const isoDate = formatDateTimeWithTimezone(localDate, -6);
                            $(this).data('iso-value', isoDate);
                        } else {
                            // Invalid values, clear the field
                            $(this).val('');
                            $(this).attr('placeholder', 'DD/MM/YYYY HH:MM AM/PM');
                        }
                    } else if (value === '') {
                        // Empty is ok
                        $(this).attr('placeholder', 'DD/MM/YYYY HH:MM AM/PM');
                    } else {
                        // Invalid format, clear
                        $(this).val('');
                        $(this).attr('placeholder', 'DD/MM/YYYY HH:MM AM/PM');
                    }
                });

                // Prevent pasting invalid content
                $input.on('paste', function(e) {
                    e.preventDefault();
                    let pastedText = (e.originalEvent.clipboardData || window.clipboardData).getData('text');

                    // Clean the pasted text
                    pastedText = pastedText.replace(/[^0-9\/:\sAPMamp]/gi, '');
                    pastedText = pastedText.replace(/\s+/g, ' ').trim();

                    // Insert at cursor position
                    const start = this.selectionStart;
                    const end = this.selectionEnd;
                    const text = $(this).val();
                    const newText = text.substring(0, start) + pastedText + text.substring(end);
                    $(this).val(newText);
                    $(this).trigger('input');
                });

                // Set placeholder
                $input.attr('placeholder', 'DD/MM/YYYY HH:MM AM/PM');
                $input.attr('maxlength', '22'); // Maximum valid length
            });*/

            const app = new FormularioSolicitud();
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

