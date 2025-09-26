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
            padding: 120px 10px;
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
            padding: 50px 50px 0 50px;
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
            flex-wrap: wrap;
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
            flex-wrap: wrap;
        }

        .notion-logo {
            width: 60px;
            height: 60px;
            object-fit: contain;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
            flex-shrink: 0;
            margin-left: auto;
        }

        .header-text {
            text-align: left;
            flex: 1;
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
        }

        /* Tablets pequeños y móviles grandes (576px - 767px) - iPads mini, móviles landscape */
        @media (min-width: 576px) and (max-width: 767px) {
            body {
                padding: 80px 10px;
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
            
            .form-header p {
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
        }
            
            .form-wrapper {
                padding: 25px 25px 0 25px;
            }

            .header-content {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
            
            .header-text {
                text-align: center;
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
                padding: 60px 8px;
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
            
            .form-header p {
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
        }
            
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
            
            .form-grid {
                gap: 12px;
            }
            
            .form-input,
            .form-select,
            .form-textarea {
                padding: 10px 12px;
                font-size: 16px; /* Previene zoom en iOS */
            }
            
            .btn {
                padding: 12px 20px;
                font-size: 14px;
                min-width: 120px;
            }
            
            .form-actions {
                flex-direction: column;
                gap: 10px;
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
        
        /* Móviles pequeños (320px - 399px) - iPhones pequeños */
        @media (min-width: 320px) and (max-width: 399px) {
            body {
                padding: 50px 5px;
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
            
            .form-header p {
                font-size: 0.9rem;
            }
            
            .form-input, .form-select, .form-textarea {
                font-size: 16px; /* Evita zoom en iOS */
                padding: 10px 12px;
            }
            
            .form-textarea {
                min-height: 80px;
            }
            
            .datetime-picker {
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 100vw;
                height: 100vh;
                max-width: none;
                max-height: none;
                border-radius: 0;
                z-index: 10000;
            }
            
            .datetime-picker-content {
                flex-direction: column;
                height: 100%;
                min-height: auto;
            }
            
            .calendar-section,
            .time-section {
                padding: 12px;
            }
            
            .calendar-day {
                min-height: 32px;
                font-size: 0.85rem;
            }
            
            .time-scroll {
                height: 100px;
                max-height: 100px;
            }
            
            .btn {
                padding: 10px 16px;
                font-size: 0.9rem;
            }
            
            .notion-logo {
                width: 40px;
                height: 40px;
            }
        }

        /* Móviles ultra pequeños (menos de 320px) - Dispositivos muy antiguos */
        @media (max-width: 319px) {
            body {
                padding: 40px 3px;
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
            
            .form-header p {
                font-size: 0.85rem;
            }
            
            .form-input, .form-select, .form-textarea {
                font-size: 16px;
                padding: 8px 10px;
            }
            
            .btn {
                padding: 8px 12px;
                font-size: 0.85rem;
            }
        }

        /* ===== ORIENTACIÓN LANDSCAPE EN MÓVILES ===== */
        
        /* Móviles en landscape (altura máxima 500px) */
        @media (max-height: 500px) and (orientation: landscape) {
            body {
                padding: 20px 10px;
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
            
            .form-header p {
                font-size: 0.9rem;
                margin-bottom: 15px;
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

        /* Estilos para el datetime picker personalizado */
        .datetime-picker-container {
            width: 100%;
        }
        
        /* Usar Bootstrap para posicionamiento */
        .datetime-picker {
            position: absolute !important;
            top: 100% !important;
            left: 0 !important;
            right: 0 !important;
            z-index: 1050 !important;
        }

        .datetime-display {
            width: 100%;
            padding: 12px 50px 12px 16px; /* Aumentar padding derecho para el icono */
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            background: #f8fafc;
            font-size: 16px;
            color: #374151;
            cursor: pointer;
            outline: none;
            transition: all 0.3s ease;
            box-sizing: border-box; /* Asegurar que el padding se incluya en el ancho */
        }

        .datetime-display:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .datetime-display::placeholder {
            color: #9ca3af;
        }

        .datetime-picker-toggle {
            position: absolute;
            right: 8px; /* Reducir distancia del borde */
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #667eea;
            cursor: pointer;
            padding: 8px; /* Aumentar área de click */
            border-radius: 6px;
            transition: all 0.3s ease;
            font-size: 16px; /* Aumentar tamaño del icono */
            z-index: 10; /* Asegurar que esté encima */
            display: flex;
            align-items: center;
            justify-content: center;
            width: 32px; /* Ancho fijo */
            height: 32px; /* Alto fijo */
        }

        .datetime-picker-toggle:hover {
            background: #e2e8f0;
            color: #4f46e5;
        }

        /* Solución específica para Safari y Chrome */
        @media screen and (-webkit-min-device-pixel-ratio: 0) {
            .datetime-picker-container {
                position: relative;
                overflow: visible;
            }
            
            .datetime-display {
                padding-right: 50px !important;
                box-sizing: border-box !important;
            }
            
            .datetime-picker-toggle {
                position: absolute !important;
                right: 8px !important;
                top: 50% !important;
                transform: translateY(-50%) !important;
                z-index: 10 !important;
            }
            
            /* Asegurar que el calendario tenga z-index alto en Safari/Chrome */
            .datetime-picker {
                z-index: 9999 !important;
                -webkit-transform: translateZ(0);
                transform: translateZ(0);
                -webkit-backface-visibility: hidden;
                backface-visibility: hidden;
                position: absolute !important;
                top: 100% !important;
                left: 0 !important;
                right: 0 !important;
            }
            
            /* Prevenir que el hover del form-group interfiera */
            .form-group:hover {
                z-index: 1 !important;
            }
            
            .datetime-picker-container .form-group {
                z-index: 1 !important;
            }
        }

        /* Overlay de fondo */
        .datetime-picker-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            display: none;
            backdrop-filter: blur(2px);
            -webkit-backdrop-filter: blur(2px);
        }

        .datetime-picker-overlay.show {
            display: block;
            animation: fadeIn 0.3s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* DateTime Picker - Usando Bootstrap */
        .datetime-picker {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            display: none;
            min-width: 400px;
            max-width: 450px;
            width: auto;
            margin-left: 0;
            margin-right: 0;
        }

        .datetime-picker.show {
            display: block;
            -webkit-animation: fadeInSlide 0.3s ease-out;
            animation: fadeInSlide 0.3s ease-out;
        }

        @-webkit-keyframes fadeInSlide {
            from {
                opacity: 0;
                -webkit-transform: translateY(-10px);
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                -webkit-transform: translateY(0);
                transform: translateY(0);
            }
        }

        @keyframes fadeInSlide {
            from {
                opacity: 0;
                -webkit-transform: translateY(-10px);
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                -webkit-transform: translateY(0);
                transform: translateY(0);
            }
        }
        
        .datetime-picker.mobile-picker {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 90vw;
            max-width: 500px;
            max-height: 80vh;
            overflow-y: auto;
            z-index: 10000;
        }
        
        .datetime-picker.mobile-picker::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.5);
            z-index: -1;
        }
        
        .datetime-picker-header {
            display: none;
            padding: 15px 20px;
            border-bottom: 1px solid #e2e8f0;
            justify-content: flex-end;
        }
        
        .close-picker-btn {
            background: none;
            border: none;
            color: #6b7280;
            cursor: pointer;
            padding: 8px;
            border-radius: 50%;
            transition: all 0.2s ease;
            font-size: 16px;
            -webkit-tap-highlight-color: transparent;
            touch-action: manipulation;
        }
        
        .close-picker-btn:hover {
            background: #f3f4f6;
            color: #374151;
        }

        .datetime-picker-content {
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            height: auto;
            min-height: 350px;
            max-height: none;
            -webkit-flex-wrap: nowrap;
            -ms-flex-wrap: nowrap;
            flex-wrap: nowrap;
            /* Compatibilidad Safari mejorada */
            -webkit-box-orient: horizontal;
            -webkit-box-direction: normal;
            -webkit-flex-direction: row;
            -ms-flex-direction: row;
            flex-direction: row;
            -webkit-box-align: stretch;
            -webkit-align-items: stretch;
            -ms-flex-align: stretch;
            align-items: stretch;
            /* Mejoras de rendimiento */
            -webkit-transform: translateZ(0);
            transform: translateZ(0);
            contain: layout;
        }

        /* Sección del calendario */
        .calendar-section {
            -webkit-box-flex: 1;
            -webkit-flex: 1;
            -ms-flex: 1;
            flex: 1;
            padding: 12px;
            border-right: 1px solid #e2e8f0;
            min-width: 180px;
            max-width: 200px;
            /* Compatibilidad Safari mejorada */
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            /* Mejoras de rendimiento */
            -webkit-transform: translateZ(0);
            transform: translateZ(0);
            contain: layout style;
        }

        .calendar-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
            /* Mejoras de compatibilidad */
            -webkit-box-align: center;
            -webkit-align-items: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: justify;
            -webkit-justify-content: space-between;
            -ms-flex-pack: justify;
            justify-content: space-between;
        }

        .calendar-nav {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 8px 12px;
            cursor: pointer;
            transition: all 0.2s ease;
            color: #6b7280;
        }

        .calendar-nav:hover {
            background: #e2e8f0;
            color: #374151;
        }

        .calendar-month-year {
            font-size: 1.125rem;
            font-weight: 600;
            color: #1f2937;
            display: flex;
            align-items: center;
            gap: 8px;
            /* Mejoras de compatibilidad */
            -webkit-box-align: center;
            -webkit-align-items: center;
            -ms-flex-align: center;
            align-items: center;
        }

        .month-year-dropdown {
            margin-left: 4px;
            color: #6b7280;
            font-size: 0.75rem;
        }

        .calendar-nav-group {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .calendar-weekdays {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 2px;
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
            gap: 2px;
        }

        .calendar-day {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 500;
            transition: all 0.15s ease;
            color: #374151;
            min-height: 24px;
            -webkit-tap-highlight-color: transparent;
            tap-highlight-color: transparent;
            touch-action: manipulation;
            /* Mejoras de compatibilidad */
            -webkit-box-align: center;
            -webkit-align-items: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -webkit-justify-content: center;
            -ms-flex-pack: center;
            justify-content: center;
            /* Mejoras de rendimiento */
            -webkit-transform: translateZ(0);
            transform: translateZ(0);
            contain: layout style;
        }
        
        .calendar-day:hover {
            cursor: pointer;
            background: #f1f5f9;
            color: #1f2937;
        }
        
        .calendar-day.selected {
            cursor: pointer;
            background: #3b82f6;
            color: white;
            font-weight: 600;
            box-shadow: 0 2px 4px rgba(59, 130, 246, 0.3);
            border-radius: 4px;
        }
        
        .calendar-day.today {
            cursor: pointer;
            background: #dbeafe;
            color: #1d4ed8;
            font-weight: 600;
        }

        .calendar-day.other-month {
            color: #d1d5db;
        }

        .calendar-day.disabled {
            color: #d1d5db;
            cursor: not-allowed;
        }

        .calendar-day.disabled:hover {
            background: none;
            color: #d1d5db;
        }

        .calendar-footer {
            margin-top: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .clear-btn {
            background: none;
            border: none;
            color: #6b7280;
            font-size: 0.875rem;
            cursor: pointer;
            padding: 4px 8px;
            border-radius: 4px;
            transition: all 0.2s ease;
        }

        .clear-btn:hover {
            color: #ef4444;
            background: #fef2f2;
        }

        .today-btn {
            background: #667eea;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 8px 16px;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .today-btn:hover {
            background: #5a67d8;
            transform: translateY(-1px);
        }

        /* Separador */
        .datetime-separator {
            width: 1px;
            background: #e2e8f0;
        }

        /* Sección de tiempo */
        .time-section {
            -webkit-box-flex: 0;
            -webkit-flex: 0 0 130px;
            -ms-flex: 0 0 130px;
            flex: 0 0 130px;
            padding: 8px;
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            gap: 3px;
            min-width: 130px;
            max-width: 130px;
            background: #f8fafc;
            /* Compatibilidad Safari mejorada */
            -webkit-box-orient: horizontal;
            -webkit-box-direction: normal;
            -webkit-flex-direction: row;
            -ms-flex-direction: row;
            flex-direction: row;
            -webkit-box-align: center;
            -webkit-align-items: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -webkit-justify-content: center;
            -ms-flex-pack: center;
            justify-content: center;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            /* Mejoras de rendimiento */
            -webkit-transform: translateZ(0);
            transform: translateZ(0);
            contain: layout style;
        }

        .time-column {
            -webkit-box-flex: 1;
            -webkit-flex: 1;
            -ms-flex: 1;
            flex: 1;
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -webkit-flex-direction: column;
            -ms-flex-direction: column;
            flex-direction: column;
            -webkit-box-align: center;
            -webkit-align-items: center;
            -ms-flex-align: center;
            align-items: center;
            min-width: 0;
            max-width: 50px;
            /* Compatibilidad Safari mejorada */
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            /* Mejoras de rendimiento */
            -webkit-transform: translateZ(0);
            transform: translateZ(0);
            contain: layout style;
        }

        .time-column label {
            font-size: 0.75rem;
            font-weight: 500;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 8px;
            /* Mejoras de compatibilidad */
            -webkit-text-transform: uppercase;
            text-transform: uppercase;
        }

        .time-columns {
            display: flex;
            gap: 4px;
            flex: 1;
            justify-content: center;
            align-items: stretch;
        }

        .ampm-column {
            flex: 0 0 50px;
            min-width: 50px;
        }

        .time-scroll {
            height: 150px;
            overflow-y: auto;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            background: #ffffff;
            min-height: 150px;
            max-height: 150px;
            width: 100%;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
            /* Compatibilidad Safari/Chrome mejorada */
            -webkit-overflow-scrolling: touch;
            overflow-scrolling: touch;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            /* Mejoras de rendimiento */
            -webkit-transform: translateZ(0);
            transform: translateZ(0);
            contain: layout style;
        }

        .time-option {
            padding: 4px 6px;
            text-align: center;
            cursor: pointer;
            -webkit-transition: all 0.2s ease;
            -o-transition: all 0.2s ease;
            transition: all 0.2s ease;
            font-size: 0.7rem;
            font-weight: 500;
            color: #374151;
            -webkit-tap-highlight-color: transparent;
            touch-action: manipulation;
            border-bottom: 1px solid #f3f4f6;
            min-height: 24px;
            width: 100%;
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -webkit-align-items: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -webkit-justify-content: center;
            -ms-flex-pack: center;
            justify-content: center;
            background: #ffffff;
            /* Compatibilidad Safari/Chrome mejorada */
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            /* Mejoras de rendimiento */
            -webkit-transform: translateZ(0);
            transform: translateZ(0);
            contain: layout style;
        }

        .time-option:hover {
            cursor: pointer;
            background: #f1f5f9 !important;
            color: #1f2937 !important;
        }

        .time-option.selected {
            cursor: pointer;
            background: #3b82f6 !important;
            color: #ffffff !important;
            font-weight: 600 !important;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(59, 130, 246, 0.3);
        }


        /* Botón de aplicar removido - se cierra automáticamente */

        .time-section {
            position: relative;
        }

        .time-section::before {
            content: '🕐 Selecciona la hora';
            position: absolute;
            top: -25px;
            left: 50%;
            -webkit-transform: translateX(-50%);
            transform: translateX(-50%);
            background: #f3f4f6;
            color: #6b7280;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 500;
            white-space: nowrap;
            opacity: 0;
            -webkit-transition: opacity 0.3s ease;
            -o-transition: opacity 0.3s ease;
            transition: opacity 0.3s ease;
        }

        .datetime-picker.show .time-section::before {
            opacity: 1;
        }

        /* Estilos específicos para Safari y Chrome */
        @media screen and (-webkit-min-device-pixel-ratio: 0) {
            .datetime-picker {
                -webkit-transform: translateZ(0);
                transform: translateZ(0);
                -webkit-backface-visibility: hidden;
                backface-visibility: hidden;
                -webkit-perspective: 1000px;
                perspective: 1000px;
            }
            
            .time-scroll {
                -webkit-overflow-scrolling: touch;
                overflow-scrolling: touch;
            }
            
            .time-option {
                -webkit-tap-highlight-color: transparent;
                tap-highlight-color: transparent;
                -webkit-transform: translateZ(0);
                transform: translateZ(0);
            }
            
            .calendar-day {
                -webkit-tap-highlight-color: transparent;
                tap-highlight-color: transparent;
            }
            
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
            
            /* Mejoras específicas para el date picker en Safari */
            .datetime-picker-content {
                -webkit-box-orient: horizontal;
                -webkit-box-direction: normal;
                -webkit-flex-direction: row;
                -ms-flex-direction: row;
                flex-direction: row;
                -webkit-box-align: stretch;
                -webkit-align-items: stretch;
                -ms-flex-align: stretch;
                align-items: stretch;
            }
            
            .calendar-section {
                -webkit-box-flex: 1;
                -webkit-flex: 1;
                -ms-flex: 1;
                flex: 1;
                -webkit-box-sizing: border-box;
                box-sizing: border-box;
            }
            
            .time-section {
                -webkit-box-flex: 0;
                -webkit-flex: 0 0 200px;
                -ms-flex: 0 0 200px;
                flex: 0 0 200px;
                -webkit-box-sizing: border-box;
                box-sizing: border-box;
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
                <div class="header-content">
                    <div class="header-text">
                        <h1>Formulario de Peticiones</h1>
                        <p>Asignación de servicio mesa</p>
                    </div>
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e9/Notion-logo.svg/2048px-Notion-logo.svg.png" alt="Notion Logo" class="notion-logo">
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

                    <!-- Fecha de Inicio -->
                    <div class="form-group">
                        <label for="fecha_inicio" class="form-label">
                            <i class="fas fa-calendar-alt"></i>
                            Fecha de Inicio <span class="required">*</span>
                        </label>
                        <div class="datetime-picker-container position-relative">
                            <input type="text" id="fecha_inicio_display" class="form-input datetime-display" readonly placeholder="Seleccionar fecha y hora">
                            <button type="button" class="datetime-picker-toggle" id="fechaInicioToggle">
                                <i class="fas fa-calendar-alt"></i>
                            </button>
                            
                            <!-- DateTime Picker -->
                            <div class="datetime-picker position-absolute top-100 start-0 w-100" id="fechaInicioPicker" style="z-index: 1050;">
                                <div class="datetime-picker-content">
                                    <!-- Calendario -->
                                    <div class="calendar-section">
                                        <div class="calendar-header">
                                            <div class="calendar-month-year" id="calendarMonthYearInicio">
                                                <span class="month"></span>
                                                <span class="year"></span>
                                                <div class="month-year-dropdown">
                                                    <i class="fas fa-chevron-down"></i>
                                                </div>
                                            </div>
                                            <div class="calendar-nav-group">
                                                <button type="button" class="calendar-nav" id="prevMonthInicio">
                                                    <i class="fas fa-chevron-up"></i>
                                                </button>
                                                <button type="button" class="calendar-nav" id="nextMonthInicio">
                                                    <i class="fas fa-chevron-down"></i>
                                                </button>
                                            </div>
                                        </div>
                                        
                                        <div class="calendar-weekdays">
                                            <div class="weekday">L</div>
                                            <div class="weekday">M</div>
                                            <div class="weekday">M</div>
                                            <div class="weekday">J</div>
                                            <div class="weekday">V</div>
                                            <div class="weekday">S</div>
                                            <div class="weekday">D</div>
                                        </div>
                                        
                                        <div class="calendar-days" id="calendarDaysInicio">
                                            <!-- Los días se generan dinámicamente -->
                                        </div>
                                        
                                        <div class="calendar-footer">
                                            <button type="button" class="clear-btn" id="clearInicio">
                                                Borrar
                                            </button>
                                            <button type="button" class="today-btn" id="todayBtnInicio">
                                                Hoy
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <!-- Selector de hora -->
                                    <div class="time-section">
                                        <div class="time-columns">
                                            <div class="time-column">
                                                <div class="time-scroll" id="hourScrollInicio">
                                                    <div class="time-option" data-value="1">01</div>
                                                    <div class="time-option" data-value="2">02</div>
                                                    <div class="time-option" data-value="3">03</div>
                                                    <div class="time-option" data-value="4">04</div>
                                                    <div class="time-option" data-value="5">05</div>
                                                    <div class="time-option" data-value="6">06</div>
                                                    <div class="time-option" data-value="7">07</div>
                                                    <div class="time-option" data-value="8">08</div>
                                                    <div class="time-option" data-value="9">09</div>
                                                    <div class="time-option" data-value="10">10</div>
                                                    <div class="time-option" data-value="11">11</div>
                                                    <div class="time-option" data-value="12">12</div>
                                                </div>
                                            </div>
                                            <div class="time-column">
                                                <div class="time-scroll" id="minuteScrollInicio">
                                                    <div class="time-option" data-value="0">00</div>
                                                    <div class="time-option" data-value="5">05</div>
                                                    <div class="time-option" data-value="10">10</div>
                                                    <div class="time-option" data-value="15">15</div>
                                                    <div class="time-option" data-value="20">20</div>
                                                    <div class="time-option" data-value="25">25</div>
                                                    <div class="time-option" data-value="30">30</div>
                                                    <div class="time-option" data-value="35">35</div>
                                                    <div class="time-option" data-value="40">40</div>
                                                    <div class="time-option" data-value="45">45</div>
                                                    <div class="time-option" data-value="50">50</div>
                                                    <div class="time-option" data-value="55">55</div>
                                                </div>
                                            </div>
                                            <div class="time-column ampm-column">
                                                <div class="time-scroll" id="ampmScrollInicio">
                                                    <div class="time-option" data-value="PM">p.m.</div>
                                                    <div class="time-option" data-value="AM">a.m.</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Input oculto para el envío -->
                        <input type="hidden" id="fecha_inicio" name="fecha_inicio" required>
                    </div>

                    <!-- Fecha de Fin -->
                    <div class="form-group">
                        <label for="fecha_fin" class="form-label">
                            <i class="fas fa-calendar-times"></i>
                            Fecha de Fin <span class="required">*</span>
                        </label>
                        <div class="datetime-picker-container position-relative">
                            <input type="text" id="fecha_fin_display" class="form-input datetime-display" readonly placeholder="Seleccionar fecha y hora">
                            <button type="button" class="datetime-picker-toggle" id="fechaFinToggle">
                                <i class="fas fa-calendar-alt"></i>
                            </button>
                            
                            <!-- DateTime Picker -->
                            <div class="datetime-picker position-absolute top-100 start-0 w-100" id="fechaFinPicker" style="z-index: 1050;">
                                <div class="datetime-picker-content">
                                    <!-- Calendario -->
                                    <div class="calendar-section">
                                        <div class="calendar-header">
                                            <div class="calendar-month-year" id="calendarMonthYearFin">
                                                <span class="month"></span>
                                                <span class="year"></span>
                                                <div class="month-year-dropdown">
                                                    <i class="fas fa-chevron-down"></i>
                                                </div>
                                            </div>
                                            <div class="calendar-nav-group">
                                                <button type="button" class="calendar-nav" id="prevMonthFin">
                                                    <i class="fas fa-chevron-up"></i>
                                                </button>
                                                <button type="button" class="calendar-nav" id="nextMonthFin">
                                                    <i class="fas fa-chevron-down"></i>
                                                </button>
                                            </div>
                                        </div>
                                        
                                        <div class="calendar-weekdays">
                                            <div class="weekday">L</div>
                                            <div class="weekday">M</div>
                                            <div class="weekday">M</div>
                                            <div class="weekday">J</div>
                                            <div class="weekday">V</div>
                                            <div class="weekday">S</div>
                                            <div class="weekday">D</div>
                                        </div>
                                        
                                        <div class="calendar-days" id="calendarDaysFin">
                                            <!-- Los días se generan dinámicamente -->
                                        </div>
                                        
                                        <div class="calendar-footer">
                                            <button type="button" class="clear-btn" id="clearFin">
                                                Borrar
                                            </button>
                                            <button type="button" class="today-btn" id="todayBtnFin">
                                                Hoy
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <!-- Selector de hora -->
                                    <div class="time-section">
                                        <div class="time-columns">
                                            <div class="time-column">
                                                <div class="time-scroll" id="hourScrollFin">
                                                    <div class="time-option" data-value="1">01</div>
                                                    <div class="time-option" data-value="2">02</div>
                                                    <div class="time-option" data-value="3">03</div>
                                                    <div class="time-option" data-value="4">04</div>
                                                    <div class="time-option" data-value="5">05</div>
                                                    <div class="time-option" data-value="6">06</div>
                                                    <div class="time-option" data-value="7">07</div>
                                                    <div class="time-option" data-value="8">08</div>
                                                    <div class="time-option" data-value="9">09</div>
                                                    <div class="time-option" data-value="10">10</div>
                                                    <div class="time-option" data-value="11">11</div>
                                                    <div class="time-option" data-value="12">12</div>
                                                </div>
                                            </div>
                                            <div class="time-column">
                                                <div class="time-scroll" id="minuteScrollFin">
                                                    <div class="time-option" data-value="0">00</div>
                                                    <div class="time-option" data-value="5">05</div>
                                                    <div class="time-option" data-value="10">10</div>
                                                    <div class="time-option" data-value="15">15</div>
                                                    <div class="time-option" data-value="20">20</div>
                                                    <div class="time-option" data-value="25">25</div>
                                                    <div class="time-option" data-value="30">30</div>
                                                    <div class="time-option" data-value="35">35</div>
                                                    <div class="time-option" data-value="40">40</div>
                                                    <div class="time-option" data-value="45">45</div>
                                                    <div class="time-option" data-value="50">50</div>
                                                    <div class="time-option" data-value="55">55</div>
                                                </div>
                                            </div>
                                            <div class="time-column ampm-column">
                                                <div class="time-scroll" id="ampmScrollFin">
                                                    <div class="time-option" data-value="PM">p.m.</div>
                                                    <div class="time-option" data-value="AM">a.m.</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Botón de aplicar removido - se cierra automáticamente -->
                                </div>
                            </div>
                        </div>
                        
                        <!-- Input oculto para el envío -->
                        <input type="hidden" id="fecha_fin" name="fecha_fin" required>
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
                this.initializeDateTimePickers();
            }

            initializeDateTimePickers() {
                // Inicializar picker de fecha de inicio
                this.initializeDateTimePicker('inicio');
                // Inicializar picker de fecha de fin
                this.initializeDateTimePicker('fin');
            }

            initializeDateTimePicker(type) {
                const prefix = type === 'inicio' ? 'Inicio' : 'Fin';
                const prefixLower = type.toLowerCase();
                
                // Elementos del picker
                this[`${prefixLower}Picker`] = document.getElementById(`fecha${prefix}Picker`);
                this[`${prefixLower}Toggle`] = document.getElementById(`fecha${prefix}Toggle`);
                this[`${prefixLower}Display`] = document.getElementById(`fecha_${prefixLower}_display`);
                this[`${prefixLower}HiddenInput`] = document.getElementById(`fecha_${prefixLower}`);
                
                // Elementos del calendario
                this[`${prefixLower}CalendarDays`] = document.getElementById(`calendarDays${prefix}`);
                this[`${prefixLower}CalendarMonthYear`] = document.getElementById(`calendarMonthYear${prefix}`);
                this[`${prefixLower}PrevMonth`] = document.getElementById(`prevMonth${prefix}`);
                this[`${prefixLower}NextMonth`] = document.getElementById(`nextMonth${prefix}`);
                this[`${prefixLower}TodayBtn`] = document.getElementById(`todayBtn${prefix}`);
                this[`${prefixLower}ClearBtn`] = document.getElementById(`clear${prefix}`);
                
                // Elementos del selector de hora
                this[`${prefixLower}HourScroll`] = document.getElementById(`hourScroll${prefix}`);
                this[`${prefixLower}MinuteScroll`] = document.getElementById(`minuteScroll${prefix}`);
                this[`${prefixLower}AmpmScroll`] = document.getElementById(`ampmScroll${prefix}`);
                
                // Estado del picker
                this[`${prefixLower}CurrentDate`] = new Date();
                this[`${prefixLower}SelectedDate`] = null;
                this[`${prefixLower}SelectedTime`] = { hour: 12, minute: 0, ampm: 'PM' };
                
                // Eventos
                this[`${prefixLower}Toggle`].addEventListener('click', () => this.toggleDateTimePicker(type));
                this[`${prefixLower}Display`].addEventListener('click', () => this.openDateTimePicker(type));
                this[`${prefixLower}PrevMonth`].addEventListener('click', () => this.changeMonth(type, -1));
                this[`${prefixLower}NextMonth`].addEventListener('click', () => this.changeMonth(type, 1));
                this[`${prefixLower}TodayBtn`].addEventListener('click', () => this.selectToday(type));
                this[`${prefixLower}ClearBtn`].addEventListener('click', () => this.clearSelection(type));
                // Botón de aplicar removido - se cierra automáticamente
                
                // Cerrar picker al hacer clic fuera (pero no al seleccionar fechas)
                document.addEventListener('click', (e) => {
                    if (!e.target.closest(`#fecha${prefix}Picker`) && 
                        !e.target.closest(`#fecha${prefix}Toggle`) && 
                        !e.target.closest(`#fecha_${prefixLower}_display`) &&
                        !e.target.closest('.calendar-day') &&
                        !e.target.closest('.time-option')) {
                        this.closeDateTimePicker(type);
                    }
                });
                
                // Inicializar calendario y selector de hora
                this.renderCalendar(type);
                console.log(`Inicializando picker para ${type}`);
                this.populateTimeScrolls(type);
                
                // Establecer hora por defecto y actualizar display
                this.setDefaultTimeSelection(type);
                this.updateDateTimeDisplay(type);
                
                // Asegurar que las opciones de hora sean visibles
                setTimeout(() => {
                    this.ensureTimeOptionsVisible(type);
                }, 200);
            }


            forceFormElementsBelow() {
                // Esta función ya no es necesaria en la versión original
            }

            restoreFormElementsZIndex() {
                // Esta función ya no es necesaria en la versión original
            }


            // Funciones del DateTime Picker
            toggleDateTimePicker(type) {
                const prefix = type === 'inicio' ? 'Inicio' : 'Fin';
                const prefixLower = type.toLowerCase();
                const picker = this[`${prefixLower}Picker`];
                
                if (picker.classList.contains('show')) {
                    this.closeDateTimePicker(type);
                } else {
                    this.openDateTimePicker(type);
                }
            }

            openDateTimePicker(type) {
                const prefix = type === 'inicio' ? 'Inicio' : 'Fin';
                const prefixLower = type.toLowerCase();
                const picker = this[`${prefixLower}Picker`];
                
                if (picker) {
                    // Cerrar otros pickers
                    if (type === 'inicio') {
                        this.closeDateTimePicker('fin');
                    } else {
                        this.closeDateTimePicker('inicio');
                    }
                    
                    // Asegurar que el picker sea visible
                    picker.style.display = 'block';
                    picker.style.visibility = 'visible';
                    picker.style.opacity = '1';
                    picker.classList.add('show');
                    
                    // Cerrar otros dropdowns cuando se abre el calendario
                    this.closeMedioDropdown();
                    
                    // Asegurar que el calendario esté por encima usando Bootstrap z-index
                    picker.style.zIndex = '1050';
                    
                    // Forzar repaint en Safari
                    picker.offsetHeight;
                    
                    // Forzar que las opciones de hora sean visibles
                    setTimeout(() => {
                        this.forceTimeOptionsVisibility(type);
                    }, 50);
                }
            }

            closeDateTimePicker(type) {
                const prefix = type === 'inicio' ? 'Inicio' : 'Fin';
                const prefixLower = type.toLowerCase();
                const picker = this[`${prefixLower}Picker`];
                
                if (picker) {
                    picker.classList.remove('show');
                    picker.classList.remove('mobile-picker');
                    
                    // Asegurar que el picker se oculte completamente
                    picker.style.display = 'none';
                    picker.style.visibility = 'hidden';
                    picker.style.opacity = '0';
                    
                    // El z-index se maneja automáticamente con Bootstrap
                    
                    // No necesitamos manejar clases del body
                }
            }

            changeMonth(type, direction) {
                const prefixLower = type.toLowerCase();
                this[`${prefixLower}CurrentDate`].setMonth(this[`${prefixLower}CurrentDate`].getMonth() + direction);
                this.renderCalendar(type);
            }

            selectToday(type) {
                const prefixLower = type.toLowerCase();
                const today = new Date();
                this[`${prefixLower}SelectedDate`] = today;
                this[`${prefixLower}CurrentDate`] = new Date(today);
                this.renderCalendar(type);
                this.updateDateTimeDisplay(type);
                
                // Mostrar mensaje de confirmación
                const display = this[`${prefixLower}Display`];
                const originalValue = display.value;
                display.style.color = '#22c55e';
                display.value = '✓ Fecha de hoy seleccionada';
                
                setTimeout(() => {
                    display.style.color = '';
                    display.value = originalValue;
                }, 1500);
            }

            clearSelection(type) {
                const prefixLower = type.toLowerCase();
                this[`${prefixLower}SelectedDate`] = null;
                this[`${prefixLower}SelectedTime`] = { hour: 12, minute: 0, ampm: 'PM' };
                this.renderCalendar(type);
                this.updateDateTimeDisplay(type);
                
                // Mostrar mensaje de confirmación
                const display = this[`${prefixLower}Display`];
                const originalValue = display.value;
                display.style.color = '#ef4444';
                display.value = '✓ Selección borrada';
                
                setTimeout(() => {
                    display.style.color = '';
                    display.value = originalValue;
                }, 1500);
            }

            renderCalendar(type) {
                const prefixLower = type.toLowerCase();
                const currentDate = this[`${prefixLower}CurrentDate`];
                const year = currentDate.getFullYear();
                const month = currentDate.getMonth();
                
                // Actualizar header del calendario
                const monthNames = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 
                                  'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
                const monthYearElement = this[`${prefixLower}CalendarMonthYear`];
                monthYearElement.querySelector('.month').textContent = monthNames[month];
                monthYearElement.querySelector('.year').textContent = year;
                
                // Limpiar días del calendario
                const calendarDays = this[`${prefixLower}CalendarDays`];
                calendarDays.innerHTML = '';
                
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
                    const dayElement = this.createDayElement(type, day, true, false);
                    calendarDays.appendChild(dayElement);
                }
                
                // Días del mes actual
                for (let day = 1; day <= daysInMonth; day++) {
                    const dayDate = new Date(year, month, day);
                    const isToday = this.isToday(dayDate);
                    const isSelected = this.isSelectedDate(type, dayDate);
                    
                    const dayElement = this.createDayElement(type, day, false, isToday, isSelected);
                    calendarDays.appendChild(dayElement);
                }
                
                // Días del mes siguiente para completar la grilla
                const totalCells = calendarDays.children.length;
                const remainingCells = 42 - totalCells; // 6 filas x 7 días
                
                for (let day = 1; day <= remainingCells; day++) {
                    const dayElement = this.createDayElement(type, day, true, false);
                    calendarDays.appendChild(dayElement);
                }
            }

            createDayElement(type, day, isOtherMonth, isToday = false, isSelected = false) {
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
                
                if (!isOtherMonth) {
                    dayElement.addEventListener('click', () => this.selectDate(type, day));
                }
                
                return dayElement;
            }

            selectDate(type, day) {
                const prefixLower = type.toLowerCase();
                const currentDate = this[`${prefixLower}CurrentDate`];
                const year = currentDate.getFullYear();
                const month = currentDate.getMonth();
                const selectedDate = new Date(year, month, day);
                
                this[`${prefixLower}SelectedDate`] = selectedDate;
                this.updateDateTimeDisplay(type);
                this.renderCalendar(type); // Re-renderizar el calendario para mostrar la selección
                // El picker permanece abierto para permitir ajustar la hora
            }

            setDefaultTimeSelection(type) {
                const prefixLower = type.toLowerCase();
                const selectedTime = this[`${prefixLower}SelectedTime`];
                
                // Establecer selección visual por defecto
                this.updateTimeSelection(type, 'hour', selectedTime.hour);
                this.updateTimeSelection(type, 'minute', selectedTime.minute);
                this.updateTimeSelection(type, 'ampm', selectedTime.ampm);
            }

            ensureTimeOptionsVisible(type) {
                const prefixLower = type.toLowerCase();
                const prefix = prefixLower.charAt(0).toUpperCase() + prefixLower.slice(1);
                
                const hourScroll = document.getElementById(`hourScroll${prefix}`);
                const minuteScroll = document.getElementById(`minuteScroll${prefix}`);
                const ampmScroll = document.getElementById(`ampmScroll${prefix}`);
                
                console.log(`Verificando opciones de hora para ${type}:`, {
                    hourScroll: hourScroll,
                    hourOptions: hourScroll?.children.length || 0,
                    minuteScroll: minuteScroll,
                    minuteOptions: minuteScroll?.children.length || 0,
                    ampmScroll: ampmScroll,
                    ampmOptions: ampmScroll?.children.length || 0
                });
                
                // Forzar visibilidad
                if (hourScroll) {
                    hourScroll.style.display = 'block';
                    hourScroll.style.visibility = 'visible';
                }
                if (minuteScroll) {
                    minuteScroll.style.display = 'block';
                    minuteScroll.style.visibility = 'visible';
                }
                if (ampmScroll) {
                    ampmScroll.style.display = 'block';
                    ampmScroll.style.visibility = 'visible';
                }
            }

            forceTimeOptionsVisibility(type) {
                const prefixLower = type.toLowerCase();
                const prefix = prefixLower.charAt(0).toUpperCase() + prefixLower.slice(1);
                
                const hourScroll = document.getElementById(`hourScroll${prefix}`);
                const minuteScroll = document.getElementById(`minuteScroll${prefix}`);
                const ampmScroll = document.getElementById(`ampmScroll${prefix}`);
                
                // Forzar visibilidad de todos los elementos
                [hourScroll, minuteScroll, ampmScroll].forEach(scroll => {
                    if (scroll) {
                        scroll.style.display = 'block';
                        scroll.style.visibility = 'visible';
                        scroll.style.opacity = '1';
                        scroll.style.height = '250px';
                        scroll.style.minHeight = '250px';
                        
                        // Asegurar que las opciones sean visibles
                        scroll.querySelectorAll('.time-option').forEach(option => {
                            option.style.display = 'flex';
                            option.style.visibility = 'visible';
                            option.style.opacity = '1';
                        });
                    }
                });
                
                console.log(`Forzando visibilidad de opciones de hora para ${type}`);
            }

            // Función applyTimeSelection removida - se cierra automáticamente

            populateTimeScrolls(type) {
                const prefixLower = type.toLowerCase();
                const prefix = prefixLower.charAt(0).toUpperCase() + prefixLower.slice(1);
                
                // Configurar eventos para las opciones de hora (ya están en el HTML)
                const hourScroll = document.getElementById(`hourScroll${prefix}`);
                const minuteScroll = document.getElementById(`minuteScroll${prefix}`);
                const ampmScroll = document.getElementById(`ampmScroll${prefix}`);
                
                if (hourScroll) {
                    hourScroll.querySelectorAll('.time-option').forEach(option => {
                        option.addEventListener('click', () => {
                            const value = parseInt(option.dataset.value);
                            this.selectTime(type, 'hour', value);
                        });
                    });
                }
                
                if (minuteScroll) {
                    minuteScroll.querySelectorAll('.time-option').forEach(option => {
                        option.addEventListener('click', () => {
                            const value = parseInt(option.dataset.value);
                            this.selectTime(type, 'minute', value);
                        });
                    });
                }
                
                if (ampmScroll) {
                    ampmScroll.querySelectorAll('.time-option').forEach(option => {
                        option.addEventListener('click', () => {
                            this.selectTime(type, 'ampm', option.dataset.value);
                        });
                    });
                }
                
                console.log(`Opciones de hora configuradas para ${type}`);
            }

            selectTime(type, timeType, value) {
                const prefixLower = type.toLowerCase();
                
                if (timeType === 'hour') {
                    this[`${prefixLower}SelectedTime`].hour = value;
                } else if (timeType === 'minute') {
                    this[`${prefixLower}SelectedTime`].minute = value;
                } else if (timeType === 'ampm') {
                    this[`${prefixLower}SelectedTime`].ampm = value;
                }
                
                this.updateTimeSelection(type, timeType, value);
                this.updateDateTimeDisplay(type);
                
                // El picker permanece abierto para permitir múltiples selecciones
            }

            updateTimeSelection(type, timeType, value) {
                const prefixLower = type.toLowerCase();
                const prefix = prefixLower.charAt(0).toUpperCase() + prefixLower.slice(1);
                let scrollElement;
                
                if (timeType === 'hour') {
                    scrollElement = document.getElementById(`hourScroll${prefix}`);
                } else if (timeType === 'minute') {
                    scrollElement = document.getElementById(`minuteScroll${prefix}`);
                } else if (timeType === 'ampm') {
                    scrollElement = document.getElementById(`ampmScroll${prefix}`);
                }
                
                if (!scrollElement) return;
                
                // Remover selección anterior
                scrollElement.querySelectorAll('.time-option').forEach(option => {
                    option.classList.remove('selected');
                });
                
                // Seleccionar nueva opción
                const selectedOption = scrollElement.querySelector(`[data-value="${value}"]`);
                if (selectedOption) {
                    selectedOption.classList.add('selected');
                }
            }

            updateDateTimeDisplay(type) {
                const prefixLower = type.toLowerCase();
                const selectedDate = this[`${prefixLower}SelectedDate`];
                const selectedTime = this[`${prefixLower}SelectedTime`];
                const display = this[`${prefixLower}Display`];
                const hiddenInput = this[`${prefixLower}HiddenInput`];
                
                if (selectedDate) {
                    const day = selectedDate.getDate().toString().padStart(2, '0');
                    const month = (selectedDate.getMonth() + 1).toString().padStart(2, '0');
                    const year = selectedDate.getFullYear();
                    const hour = selectedTime.hour.toString().padStart(2, '0');
                    const minute = selectedTime.minute.toString().padStart(2, '0');
                    const ampm = selectedTime.ampm;
                    
                    display.value = `${day}/${month}/${year} ${hour}:${minute} ${ampm}`;
                    
                    // Crear fecha completa para el input oculto
                    const fullDate = new Date(selectedDate);
                    fullDate.setHours(selectedTime.ampm === 'PM' && selectedTime.hour !== 12 ? selectedTime.hour + 12 : 
                                     selectedTime.ampm === 'AM' && selectedTime.hour === 12 ? 0 : selectedTime.hour);
                    fullDate.setMinutes(selectedTime.minute);
                    fullDate.setSeconds(0);
                    fullDate.setMilliseconds(0);
                    
                    // Formatear en zona horaria local para mantener la hora exacta
                    const fullYear = fullDate.getFullYear();
                    const fullMonth = (fullDate.getMonth() + 1).toString().padStart(2, '0');
                    const fullDay = fullDate.getDate().toString().padStart(2, '0');
                    const fullHours = fullDate.getHours().toString().padStart(2, '0');
                    const fullMinutes = fullDate.getMinutes().toString().padStart(2, '0');
                    const fullSeconds = fullDate.getSeconds().toString().padStart(2, '0');
                    
                    // Crear string en formato ISO con offset local
                    const offset = fullDate.getTimezoneOffset();
                    const offsetHours = Math.floor(Math.abs(offset) / 60);
                    const offsetMinutes = Math.abs(offset) % 60;
                    const offsetSign = offset <= 0 ? '+' : '-';
                    const offsetString = `${offsetSign}${offsetHours.toString().padStart(2, '0')}:${offsetMinutes.toString().padStart(2, '0')}`;
                    
                    hiddenInput.value = `${fullYear}-${fullMonth}-${fullDay}T${fullHours}:${fullMinutes}:${fullSeconds}.000${offsetString}`;
                } else {
                    // Si no hay fecha seleccionada, solo mostrar la hora
                    const hour = selectedTime.hour.toString().padStart(2, '0');
                    const minute = selectedTime.minute.toString().padStart(2, '0');
                    const ampm = selectedTime.ampm;
                    
                    display.value = `Seleccionar fecha y hora - ${hour}:${minute} ${ampm}`;
                    hiddenInput.value = '';
                }
            }

            isToday(date) {
                const today = new Date();
                return date.toDateString() === today.toDateString();
            }

            isSelectedDate(type, date) {
                const prefixLower = type.toLowerCase();
                const selectedDate = this[`${prefixLower}SelectedDate`];
                return selectedDate && date.toDateString() === selectedDate.toDateString();
            }

            validateDateTimeField(type) {
                const prefixLower = type.toLowerCase();
                const selectedDate = this[`${prefixLower}SelectedDate`];
                const selectedTime = this[`${prefixLower}SelectedTime`];
                const display = this[`${prefixLower}Display`];
                const hiddenInput = this[`${prefixLower}HiddenInput`];
                
                const isValid = selectedDate !== null;
                
                if (isValid) {
                    display.classList.remove('invalid');
                    display.classList.add('valid');
                    this.hideFieldError(display);
                } else {
                    display.classList.remove('valid');
                    display.classList.add('invalid');
                    this.showFieldError(display, `Debe seleccionar una fecha de ${type === 'inicio' ? 'inicio' : 'fin'} válida.`);
                }
                
                return isValid;
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
                
                // Validar campos de fecha personalizados
                if (!this.validateDateTimeField('inicio')) {
                    isValid = false;
                    if (!emptyFields.includes('Fecha de Inicio')) {
                        emptyFields.push('Fecha de Inicio');
                    }
                }
                
                if (!this.validateDateTimeField('fin')) {
                    isValid = false;
                    if (!emptyFields.includes('Fecha de Fin')) {
                        emptyFields.push('Fecha de Fin');
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
                
                // Limpiar campos de fecha
                this.clearDateTimeFields();
            }

            clearDateTimeFields() {
                // Limpiar fecha de inicio
                this.inicioSelectedDate = null;
                this.inicioSelectedTime = { hour: 12, minute: 0, ampm: 'PM' };
                if (this.inicioDisplay) {
                    this.inicioDisplay.value = '';
                }
                if (this.inicioHiddenInput) {
                    this.inicioHiddenInput.value = '';
                }
                
                // Limpiar fecha de fin
                this.finSelectedDate = null;
                this.finSelectedTime = { hour: 12, minute: 0, ampm: 'PM' };
                if (this.finDisplay) {
                    this.finDisplay.value = '';
                }
                if (this.finHiddenInput) {
                    this.finHiddenInput.value = '';
                }
                
                // Cerrar pickers si están abiertos
                this.closeDateTimePicker('inicio');
                this.closeDateTimePicker('fin');
            }

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
                
                // Limpiar validación de los campos de fecha
                if (this.inicioDisplay) {
                    this.inicioDisplay.classList.remove('valid', 'invalid');
                    this.hideFieldError(this.inicioDisplay);
                }
                
                if (this.finDisplay) {
                    this.finDisplay.classList.remove('valid', 'invalid');
                    this.hideFieldError(this.finDisplay);
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
            console.log('Inicializando FormularioSolicitud...');
            const app = new FormularioSolicitud();
            
            // Depuración adicional después de la inicialización
            setTimeout(() => {
                console.log('Verificando elementos de hora después de la inicialización...');
                const hourScrollInicio = document.getElementById('hourScrollInicio');
                const minuteScrollInicio = document.getElementById('minuteScrollInicio');
                const hourScrollFin = document.getElementById('hourScrollFin');
                const minuteScrollFin = document.getElementById('minuteScrollFin');
                
                console.log('Elementos encontrados:', {
                    hourScrollInicio: hourScrollInicio,
                    minuteScrollInicio: minuteScrollInicio,
                    hourScrollFin: hourScrollFin,
                    minuteScrollFin: minuteScrollFin
                });
            }, 1000);
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

