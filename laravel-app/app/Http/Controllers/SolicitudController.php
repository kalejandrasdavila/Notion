<?php

namespace App\Http\Controllers;

use App\Models\Solicitud;
use App\Services\NotionService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SolicitudController extends Controller
{
    protected $notionService;

    public function __construct(NotionService $notionService)
    {
        $this->notionService = $notionService;
    }

    /**
     * Mostrar el formulario de solicitud
     */
    public function index(): View
    {
        return view('solicitud.index');
    }

    /**
     * Obtener opciones para los selects
     */
    public function getOptions(Request $request): JsonResponse
    {
        try {
            $type = $request->get('type');
            
            switch ($type) {
                case 'status':
                    $options = $this->notionService->getStatusOptions();
                    break;
                case 'tipo':
                    $options = $this->notionService->getTipoOptions();
                    break;
                case 'prioridad':
                    $options = $this->notionService->getPrioridadOptions();
                    break;
                case 'medio':
                    $options = $this->notionService->getMedioOptions();
                    break;
                default:
                    return response()->json([
                        'success' => false,
                        'message' => 'Tipo de opción no válido'
                    ], 400);
            }

            return response()->json([
                'success' => true,
                'data' => $options
            ]);

        } catch (\Exception $e) {
            Log::error('Error obteniendo opciones', [
                'type' => $type,
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las opciones'
            ], 500);
        }
    }

    /**
     * Crear una nueva solicitud
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->all();
        
        // Procesar el campo medio si viene como JSON string
        if (isset($data['medio']) && is_string($data['medio'])) {
            $data['medio'] = json_decode($data['medio'], true) ?? [];
        }
        
        $validator = Validator::make($data, [
            'status' => 'sometimes|string|max:255',
            'tipo' => 'nullable|string|max:255',
            'solicitante' => 'required|string|max:255',
            'indicaciones' => 'nullable|string|max:1990',
            'redaccion_complementaria' => 'nullable|string|max:1990',
            'link_descarga' => 'nullable|string|max:1990',
            'fecha_inicio' => 'required|string',
            'fecha_fin' => 'required|string',
            'prioridad' => 'required|string|max:255',
            'medio' => 'required|array|min:1',
            'medio.*' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            Log::error('Errores de validación', [
                'errors' => $validator->errors(),
                'data' => $request->all()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Datos de validación incorrectos',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Handle file upload if present
            Log::info('=== FILE UPLOAD CHECK IN SOLICITUD CONTROLLER ===');
            Log::info('Has file "archivo"?', ['hasFile' => $request->hasFile('archivo')]);
            Log::info('All files in request:', ['files' => $request->allFiles()]);

            if ($request->hasFile('archivo')) {
                $fileUrls = [];
                $files = $request->file('archivo');

                Log::info('Files received in SolicitudController:', ['count' => is_array($files) ? count($files) : 1]);

                // Handle single or multiple files
                if (!is_array($files)) {
                    $files = [$files];
                }

                foreach ($files as $index => $file) {
                    Log::info("Processing file {$index} in SolicitudController", [
                        'original_name' => $file->getClientOriginalName(),
                        'mime_type' => $file->getMimeType(),
                        'size' => $file->getSize(),
                        'isValid' => $file->isValid()
                    ]);

                    if ($file->isValid()) {
                        // Store file in public storage
                        $path = $file->store('uploads', 'public');

                        // Generate public URL
                        $url = asset('storage/' . $path);
                        $fileUrls[] = $url;

                        Log::info("File {$index} uploaded successfully in SolicitudController", [
                            'path' => $path,
                            'url' => $url,
                            'storage_path' => storage_path('app/public/' . $path),
                            'exists' => file_exists(storage_path('app/public/' . $path))
                        ]);
                    } else {
                        Log::error("File {$index} is invalid in SolicitudController");
                    }
                }

                if (!empty($fileUrls)) {
                    $data['archivo_url'] = $fileUrls;
                    Log::info('File URLs to be sent to Notion from SolicitudController:', ['urls' => $fileUrls]);
                }
            } else {
                Log::info('No files in request - SolicitudController');
            }

            // Establecer status por defecto si no se proporciona
            if (!isset($data['status']) || empty($data['status'])) {
                $data['status'] = 'PENDIENTE';
            }

            // Mapear fecha_inicio a fecha_planeada para la base de datos
            if (isset($data['fecha_inicio']) && !empty($data['fecha_inicio'])) {
                $data['fecha_planeada'] = $data['fecha_inicio'];
                Log::info('Fecha de inicio mapeada a fecha_planeada', [
                    'fecha_inicio' => $data['fecha_inicio'],
                    'fecha_planeada' => $data['fecha_planeada']
                ]);
            }
            
            // Mapear fecha_fin para Notion (si es necesario)
            if (isset($data['fecha_fin']) && !empty($data['fecha_fin'])) {
                $data['fecha_finalizacion'] = $data['fecha_fin'];
                Log::info('Fecha de fin mapeada a fecha_finalizacion', [
                    'fecha_fin' => $data['fecha_fin'],
                    'fecha_finalizacion' => $data['fecha_finalizacion']
                ]);
            }
            
            // Crear la página en Notion
            $notionResult = $this->notionService->createPage($data);
            
            if (!$notionResult['success']) {
                return response()->json([
                    'success' => false,
                    'message' => $notionResult['message'],
                    'details' => $notionResult['details'] ?? null
                ], 500);
            }

            // Guardar en la base de datos local
            $solicitud = Solicitud::create([
                'status' => $data['status'],
                'tipo' => $data['tipo'] ?? null, // Campo opcional
                'solicitante' => $data['solicitante'],
                'indicaciones' => $data['indicaciones'],
                'fecha_planeada' => $data['fecha_planeada'],
                'prioridad' => $data['prioridad'],
                'medio' => $data['medio'], // Ya es un array desde el frontend
                'notion_page_id' => $notionResult['data']['id'] ?? null,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Solicitud creada exitosamente',
                'data' => [
                    'id' => $solicitud->id,
                    'notion_page_id' => $solicitud->notion_page_id
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error creando solicitud', [
                'data' => $request->all(),
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor'
            ], 500);
        }
    }

    /**
     * Mostrar una solicitud específica
     */
    public function show(Solicitud $solicitud): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $solicitud
        ]);
    }

    /**
     * Listar todas las solicitudes
     */
    public function list(Request $request): JsonResponse
    {
        try {
            $query = Solicitud::query();

            // Filtros
            if ($request->has('status')) {
                $query->byStatus($request->get('status'));
            }

            if ($request->has('tipo')) {
                $query->byTipo($request->get('tipo'));
            }

            if ($request->has('prioridad')) {
                $query->byPrioridad($request->get('prioridad'));
            }

            if ($request->has('fecha')) {
                $query->byFecha($request->get('fecha'));
            }

            if ($request->has('solicitante')) {
                $query->bySolicitante($request->get('solicitante'));
            }

            $solicitudes = $query->orderBy('created_at', 'desc')->paginate(15);

            return response()->json([
                'success' => true,
                'data' => $solicitudes
            ]);

        } catch (\Exception $e) {
            Log::error('Error listando solicitudes', [
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las solicitudes'
            ], 500);
        }
    }
}