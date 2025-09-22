<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class NotionService
{
    protected $apiToken;
    protected $databaseId;
    protected $version;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiToken = config('notion.api_token');
        $this->databaseId = config('notion.database_id');
        $this->version = config('notion.version');
        $this->baseUrl = config('notion.base_url');
    }

    /**
     * Obtener la información de la base de datos
     */
    public function getDatabase()
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiToken,
                'Notion-Version' => $this->version,
                'Content-Type' => 'application/json',
            ])->get($this->baseUrl . '/databases/' . $this->databaseId);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Error obteniendo base de datos de Notion', [
                'status' => $response->status(),
                'response' => $response->body()
            ]);

            return null;
        } catch (Exception $e) {
            Log::error('Excepción obteniendo base de datos de Notion', [
                'message' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Obtener opciones de un campo select específico
     */
    public function getSelectOptions($fieldName)
    {
        $database = $this->getDatabase();
        
        if (!$database || !isset($database['properties'][$fieldName])) {
            return [];
        }

        $field = $database['properties'][$fieldName];
        
        if ($field['type'] === 'select') {
            return $field['select']['options'] ?? [];
        } elseif ($field['type'] === 'multi_select') {
            return $field['multi_select']['options'] ?? [];
        }

        return [];
    }

    /**
     * Obtener opciones de status
     */
    public function getStatusOptions()
    {
        return $this->getSelectOptions('STATUS');
    }

    /**
     * Obtener opciones de tipo
     */
    public function getTipoOptions()
    {
        return $this->getSelectOptions('TIPO');
    }

    /**
     * Obtener opciones de prioridad
     */
    public function getPrioridadOptions()
    {
        return $this->getSelectOptions('PRIORIDAD');
    }

    /**
     * Obtener opciones de medio
     */
    public function getMedioOptions()
    {
        return $this->getSelectOptions('MEDIO ');
    }

    /**
     * Crear una nueva página en Notion
     */
    public function createPage($data)
    {
        try {
            $properties = $this->buildProperties($data);
            
            $payload = [
                'parent' => [
                    'database_id' => $this->databaseId
                ],
                'properties' => $properties
            ];

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiToken,
                'Notion-Version' => $this->version,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/pages', $payload);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json()
                ];
            }

            Log::error('Error creando página en Notion', [
                'status' => $response->status(),
                'response' => $response->body(),
                'payload' => $payload
            ]);

            return [
                'success' => false,
                'message' => 'Error al crear la página en Notion',
                'details' => $response->body()
            ];

        } catch (Exception $e) {
            Log::error('Excepción creando página en Notion', [
                'message' => $e->getMessage(),
                'data' => $data
            ]);

            return [
                'success' => false,
                'message' => 'Error interno del servidor',
                'details' => $e->getMessage()
            ];
        }
    }

    /**
     * Construir las propiedades para la página de Notion
     */
    protected function buildProperties($data)
    {
        $properties = [];

        // Título
        if (isset($data['indicaciones'])) {
            $properties['title'] = [
                'title' => [
                    [
                        'type' => 'text',
                        'text' => [
                            'content' => $data['indicaciones']
                        ]
                    ]
                ]
            ];
        }

        // Status
        if (isset($data['status'])) {
            $properties['STATUS'] = [
                'select' => [
                    'name' => $data['status']
                ]
            ];
        }

        // Fecha planeada
        if (isset($data['fecha_planeada'])) {
            $properties['FECHA PLANEADA'] = [
                'date' => [
                    'start' => $data['fecha_planeada']
                ]
            ];
        }

        // Tipo
        if (isset($data['tipo'])) {
            $properties['TIPO'] = [
                'select' => [
                    'name' => $data['tipo']
                ]
            ];
        }

        // Quien solicita
        if (isset($data['solicitante'])) {
            $properties['QUIEN SOLICITA'] = [
                'rich_text' => [
                    [
                        'type' => 'text',
                        'text' => [
                            'content' => $data['solicitante']
                        ]
                    ]
                ]
            ];
        }

        // Prioridad
        if (isset($data['prioridad'])) {
            $properties['PRIORIDAD'] = [
                'select' => [
                    'name' => $data['prioridad']
                ]
            ];
        }

        // Medio (multi-select)
        if (isset($data['medio'])) {
            $medios = is_array($data['medio']) ? $data['medio'] : [$data['medio']];
            $properties['MEDIO '] = [
                'multi_select' => array_map(function($medio) {
                    return ['name' => $medio];
                }, $medios)
            ];
        }

        return $properties;
    }
}
