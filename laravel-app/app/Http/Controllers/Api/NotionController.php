<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\NotionService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class NotionController extends Controller
{
    protected $notionService;

    public function __construct(NotionService $notionService)
    {
        $this->notionService = $notionService;
    }

    /**
     * Obtener información de la base de datos
     */
    public function getDatabase(): JsonResponse
    {
        try {
            $database = $this->notionService->getDatabase();
            
            if (!$database) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se pudo obtener la información de la base de datos'
                ], 500);
            }

            return response()->json([
                'success' => true,
                'data' => $database
            ]);

        } catch (\Exception $e) {
            Log::error('Error obteniendo base de datos', [
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor'
            ], 500);
        }
    }

    /**
     * Obtener opciones de status
     */
    public function getStatus(): JsonResponse
    {
        try {
            $options = $this->notionService->getStatusOptions();
            
            return response()->json([
                'success' => true,
                'data' => $options
            ]);

        } catch (\Exception $e) {
            Log::error('Error obteniendo opciones de status', [
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las opciones de status'
            ], 500);
        }
    }

    /**
     * Obtener opciones de tipo
     */
    public function getTipo(): JsonResponse
    {
        try {
            $options = $this->notionService->getTipoOptions();
            
            return response()->json([
                'success' => true,
                'data' => $options
            ]);

        } catch (\Exception $e) {
            Log::error('Error obteniendo opciones de tipo', [
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las opciones de tipo'
            ], 500);
        }
    }

    /**
     * Obtener opciones de prioridad
     */
    public function getPrioridad(): JsonResponse
    {
        try {
            $options = $this->notionService->getPrioridadOptions();
            
            return response()->json([
                'success' => true,
                'data' => $options
            ]);

        } catch (\Exception $e) {
            Log::error('Error obteniendo opciones de prioridad', [
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las opciones de prioridad'
            ], 500);
        }
    }

    /**
     * Obtener opciones de medio
     */
    public function getMedio(): JsonResponse
    {
        try {
            $options = $this->notionService->getMedioOptions();
            
            return response()->json([
                'success' => true,
                'data' => $options
            ]);

        } catch (\Exception $e) {
            Log::error('Error obteniendo opciones de medio', [
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las opciones de medio'
            ], 500);
        }
    }

    /**
     * Crear una nueva página en Notion
     */
    public function createPage(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = $this->notionService->createPage($data);
            
            return response()->json($result, $result['success'] ? 200 : 500);

        } catch (\Exception $e) {
            Log::error('Error creando página en Notion', [
                'data' => $request->all(),
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor'
            ], 500);
        }
    }
}