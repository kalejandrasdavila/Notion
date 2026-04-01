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
use Illuminate\Support\Facades\DB;

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
     * Mostrar el formulario de peticiones v2 (mesa de informacion)
     */
    public function indexV2(): View
    {
        return view('solicitud.indexv2');
    }

    /**
     * Obtener todas las opciones en una sola llamada
     */
    public function getAllOptions(): JsonResponse
    {
        try {
            $options = $this->notionService->getAllOptions();

            return response()->json([
                'success' => true,
                'data' => $options
            ]);
        } catch (\Exception $e) {
            Log::error('Error obteniendo todas las opciones', [
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las opciones'
            ], 500);
        }
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
                case 'entidad':
                    $options = $this->notionService->getEntidadOptions();
                    break;
                case 'estado':
                    $options = $this->notionService->getEstadoOptions();
                    break;
                case 'ent_coahuila':
                    $options = $this->notionService->getEntCoahuilaOptions();
                    break;
                case 'ent_tamaulipas':
                    $options = $this->notionService->getEntTamaulipasOptions();
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
            'estado' => 'required|string|max:255',
            'entidad' => 'nullable|string|max:255',
            'solicitante' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'indicaciones' => 'nullable|string|max:1990',
            'redaccion_complementaria' => 'nullable|string|max:5000',
            'link_descarga' => 'nullable|string|max:1990',
            'fecha_inicio' => 'nullable|string',
            'fecha_fin' => 'nullable|string',
            'prioridad' => 'nullable|string|max:255',
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
            Log::info('Has file "archivo[]"?', ['hasFile' => $request->hasFile('archivo')]);
            Log::info('All files in request:', ['files' => $request->allFiles()]);
            Log::info('Request keys:', ['keys' => array_keys($request->all())]);

            if ($request->hasFile('archivo')) {
                try {
                    $fileUrls = [];
                    $files = $request->file('archivo');

                    Log::info('Files received in SolicitudController:', [
                        'count' => is_array($files) ? count($files) : 1,
                        'type' => gettype($files),
                        'raw_files' => $files
                    ]);

                    // Handle single or multiple files
                    if (!is_array($files)) {
                        $files = [$files];
                    }

                    // Filter out null/empty entries and re-index array
                    $files = array_values(array_filter($files, function($file) {
                        return $file !== null && is_object($file);
                    }));

                    Log::info('Filtered files count:', ['count' => count($files)]);

                    foreach ($files as $index => $file) {
                        if (!$file || !is_object($file)) {
                            Log::error("File {$index} is null or not an object after filtering");
                            continue;
                        }

                        try {
                            Log::info("Processing file {$index} in SolicitudController", [
                                'original_name' => $file->getClientOriginalName(),
                                'mime_type' => $file->getMimeType(),
                                'size' => $file->getSize(),
                                'isValid' => $file->isValid()
                            ]);
                        } catch (\Exception $e) {
                            Log::error("Error getting file info for file {$index}", [
                                'error' => $e->getMessage()
                            ]);
                            continue;
                        }

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
                        Log::info('File URLs to be sent to Notion from SolicitudController:', [
                            'urls' => $fileUrls,
                            'count' => count($fileUrls)
                        ]);
                    }
                } catch (\Exception $e) {
                    Log::error('Error processing files:', [
                        'message' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                    // Don't fail the entire request if file upload fails
                    // Just continue without files
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
            
            // Insertar en SQL Server dbo.Notion_Q (ya no se envía a Notion API)
            $medioString = is_array($data['medio'] ?? []) ? implode(',', $data['medio']) : ($data['medio'] ?? '');
            $fechaInicio = null;
            if (isset($data['fecha_planeada']) && !empty($data['fecha_planeada'])) {
                try {
                    $date = new \DateTime($data['fecha_planeada'], new \DateTimeZone('America/Mexico_City'));
                    $fechaInicio = $date->format('Y-m-d H:i:s');
                } catch (\Exception $e) {
                    $fechaInicio = $data['fecha_planeada'];
                }
            }

            $archivoUrl = isset($data['archivo_url'])
                ? (is_array($data['archivo_url']) ? implode(',', $data['archivo_url']) : $data['archivo_url'])
                : null;

            DB::connection('sqlsrv_notion')->table('Notion_Q')->insert([
                'Status'                  => $data['status'] ?? 'PENDIENTE',
                'Estado'                  => $data['estado'] ?? null,
                'Municipio'               => $data['municipio'] ?? $data['entidad'] ?? null,
                'TipoDeCobertura'         => $data['tipo_cobertura'] ?? $data['tipo'] ?? null,
                'Relevancia'              => $data['relevancia'] ?? $data['prioridad'] ?? null,
                'ActorPrincipal'          => $data['actor_principal'] ?? null,
                'TonoEditorial'           => $data['tono_editorial'] ?? null,
                'Indicaciones'            => $data['indicaciones'] ?? null,
                'RedaccionComplementaria' => $data['redaccion_complementaria'] ?? null,
                'FechaInicio'             => $fechaInicio,
                'Medio'                   => $medioString,
                'LinkDescarga'            => $data['link_descarga'] ?? null,
                'ArchivoURL'              => $archivoUrl,
                'Solicitante'             => $data['solicitante'] ?? null,
                'Email'                   => $data['email'] ?? null,
            ]);

            Log::info('V1: Inserted into dbo.Notion_Q');

            return response()->json([
                'success' => true,
                'message' => 'Solicitud creada exitosamente'
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
     * Crear una nueva solicitud V2 - inserta en SQL Server dbo.Notion_Q
     */
    public function storeV2(Request $request): JsonResponse
    {
        $data = $request->all();

        // Procesar el campo medio si viene como JSON string
        if (isset($data['medio']) && is_string($data['medio'])) {
            $data['medio'] = json_decode($data['medio'], true) ?? [];
        }

        $validator = Validator::make($data, [
            'status' => 'sometimes|string|max:255',
            'estado' => 'required|string|max:255',
            'municipio' => 'nullable|string|max:255',
            'tipo_cobertura' => 'nullable|string|max:255',
            'relevancia' => 'nullable|string|max:255',
            'actor_principal' => 'nullable|string|max:500',
            'tono_editorial' => 'nullable|string|max:255',
            'indicaciones' => 'nullable|string|max:2000',
            'redaccion_complementaria' => 'nullable|string|max:5970',
            'fecha_inicio' => 'nullable|string',
            'medio' => 'required|array|min:1',
            'medio.*' => 'required|string|max:255',
            'link_descarga' => 'nullable|string|max:2000',
            'solicitante' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
        ]);

        if ($validator->fails()) {
            Log::error('Errores de validación V2', [
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
            $archivoUrl = null;
            if ($request->hasFile('archivo')) {
                try {
                    $fileUrls = [];
                    $files = $request->file('archivo');

                    if (!is_array($files)) {
                        $files = [$files];
                    }

                    $files = array_values(array_filter($files, function($file) {
                        return $file !== null && is_object($file);
                    }));

                    foreach ($files as $file) {
                        if ($file->isValid()) {
                            $path = $file->store('uploads', 'public');
                            $fileUrls[] = asset('storage/' . $path);
                        }
                    }

                    if (!empty($fileUrls)) {
                        $archivoUrl = implode(',', $fileUrls);
                    }
                } catch (\Exception $e) {
                    Log::error('Error processing files V2:', [
                        'message' => $e->getMessage()
                    ]);
                }
            }

            // Set defaults
            $status = $data['status'] ?? 'PENDIENTE';
            $medioString = is_array($data['medio']) ? implode(',', $data['medio']) : $data['medio'];

            // Convert fecha_inicio to datetime format for SQL Server
            $fechaInicio = null;
            if (isset($data['fecha_inicio']) && !empty($data['fecha_inicio'])) {
                try {
                    $date = new \DateTime($data['fecha_inicio'], new \DateTimeZone('America/Mexico_City'));
                    $fechaInicio = $date->format('Y-m-d H:i:s');
                } catch (\Exception $e) {
                    $fechaInicio = $data['fecha_inicio'];
                }
            }

            // Insert into SQL Server dbo.Notion_Q
            $insertData = [
                'Status'                  => $status,
                'Estado'                  => $data['estado'] ?? null,
                'Municipio'               => $data['municipio'] ?? null,
                'TipoDeCobertura'         => $data['tipo_cobertura'] ?? null,
                'Relevancia'              => $data['relevancia'] ?? null,
                'ActorPrincipal'          => $data['actor_principal'] ?? null,
                'TonoEditorial'           => $data['tono_editorial'] ?? null,
                'Indicaciones'            => $data['indicaciones'] ?? null,
                'RedaccionComplementaria' => $data['redaccion_complementaria'] ?? null,
                'FechaInicio'             => $fechaInicio,
                'Medio'                   => $medioString,
                'LinkDescarga'            => $data['link_descarga'] ?? null,
                'ArchivoURL'              => $archivoUrl,
                'Solicitante'             => $data['solicitante'] ?? null,
                'Email'                   => $data['email'] ?? null,
            ];

            Log::info('=== INSERTING INTO dbo.Notion_Q ===', $insertData);

            DB::connection('sqlsrv_notion')
                ->table('Notion_Q')
                ->insert($insertData);

            Log::info('Successfully inserted into dbo.Notion_Q');

            return response()->json([
                'success' => true,
                'message' => 'Solicitud creada exitosamente',
            ]);

        } catch (\Exception $e) {
            Log::error('Error insertando en dbo.Notion_Q', [
                'data' => $request->all(),
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor: ' . $e->getMessage()
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