<?php

namespace App\Http\Controllers;

use App\Models\Solicitud;
use App\Services\NotionService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

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
        $validator = Validator::make($request->all(), [
            'status' => 'sometimes|string|max:255',
            'tipo' => 'required|string|max:255',
            'solicitante' => 'required|string|max:255',
            'indicaciones' => 'required|string|max:1000',
            'fecha_planeada' => 'required|date|after_or_equal:today',
            'prioridad' => 'required|string|max:255',
            'medio' => 'required|array|min:1',
            'medio.*' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Datos de validación incorrectos',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $data = $request->all();
            
            // Establecer status por defecto si no se proporciona
            if (!isset($data['status']) || empty($data['status'])) {
                $data['status'] = 'PENDIENTE';
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
                'tipo' => $data['tipo'],
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