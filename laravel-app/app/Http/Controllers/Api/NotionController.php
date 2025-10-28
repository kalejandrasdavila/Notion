<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\NotionService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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

            // Handle file upload if present
            Log::info('=== FILE UPLOAD CHECK ===');
            Log::info('Has file "archivo"?', ['hasFile' => $request->hasFile('archivo')]);
            Log::info('All files in request:', ['files' => $request->allFiles()]);

            if ($request->hasFile('archivo')) {
                $fileUrls = [];
                $files = $request->file('archivo');

                Log::info('Files received:', ['count' => is_array($files) ? count($files) : 1]);

                // Handle single or multiple files
                if (!is_array($files)) {
                    $files = [$files];
                }

                foreach ($files as $index => $file) {
                    Log::info("Processing file {$index}", [
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

                        Log::info("File {$index} uploaded successfully", [
                            'path' => $path,
                            'url' => $url,
                            'storage_path' => storage_path('app/public/' . $path),
                            'exists' => file_exists(storage_path('app/public/' . $path))
                        ]);
                    } else {
                        Log::error("File {$index} is invalid");
                    }
                }

                if (!empty($fileUrls)) {
                    $data['archivo_url'] = $fileUrls;
                    Log::info('File URLs to be sent to Notion:', ['urls' => $fileUrls]);
                }
            } else {
                Log::info('No files in request');
            }

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

    /**
     * Upload file and return URL
     */
    public function uploadFile(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'file' => 'required|file|max:10240' // Max 10MB
            ]);

            $file = $request->file('file');

            if ($file->isValid()) {
                // Store file in public storage
                $path = $file->store('uploads', 'public');

                // Generate public URL
                $url = asset('storage/' . $path);

                return response()->json([
                    'success' => true,
                    'url' => $url,
                    'filename' => $file->getClientOriginalName()
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Invalid file'
            ], 400);

        } catch (\Exception $e) {
            Log::error('Error uploading file', [
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error uploading file'
            ], 500);
        }
    }
}