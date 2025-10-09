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

            Log::info('=== NOTION API REQUEST ===');
            Log::info('Sending to Notion:', ['payload' => json_encode($payload, JSON_PRETTY_PRINT)]);

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiToken,
                'Notion-Version' => $this->version,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/pages', $payload);

            Log::info('Notion API Response Status:', ['status' => $response->status()]);

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

        // Título (usando el campo correcto de Notion)
        if (isset($data['indicaciones'])) {
            $properties['INDICACIONES A SEGUIR (Que, como, y en donde)'] = [
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

        // Fecha planeada - usando el formato del curl POST
        if (isset($data['fecha_planeada'])) {
            $startDate = $this->convertToNotionFormat($data['fecha_planeada']);
            $dateConfig = [
                'start' => $startDate
            ];
            
            // Si también se proporciona fecha de fin, agregarla
            if (isset($data['fecha_fin']) && !empty($data['fecha_fin'])) {
                $endDate = $this->convertToNotionFormat($data['fecha_fin']);
                $dateConfig['end'] = $endDate;
            }
            
            $properties['FECHA PLANEADA'] = [
                'date' => $dateConfig
            ];
        }

        // Fecha límite (usando el campo FECHA Y HORA LIMITE) - set to null
        if (isset($data['fecha_fin']) && !empty($data['fecha_fin'])) {
            // Don't use the fecha_fin value, explicitly leave empty
            $properties['FECHA Y HORA LIMITE'] = [
                'date' => null
            ];
        }

        // Tipo (campo opcional - solo si se proporciona)
        if (isset($data['tipo']) && !empty($data['tipo'])) {
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

        // Notificación (checkbox) - siempre true por defecto
        // Commented out until field is added to Notion database
        // $properties['NOTIFICACIÓN'] = [
        //     'checkbox' => true
        // ];

        // Redacción (Redacción complementaria)
        if (isset($data['redaccion_complementaria']) && !empty($data['redaccion_complementaria'])) {
            $properties['REDACCION'] = [
                'rich_text' => [
                    [
                        'type' => 'text',
                        'text' => [
                            'content' => $data['redaccion_complementaria']
                        ]
                    ]
                ]
            ];
        }

        // Adjuntar archivo (files)
        if (isset($data['archivo_url']) && !empty($data['archivo_url'])) {
            $fileUrls = is_array($data['archivo_url']) ? $data['archivo_url'] : [$data['archivo_url']];

            Log::info('=== NOTION FILE PROPERTY ===');
            Log::info('Building file property for Notion', ['urls' => $fileUrls]);

            $fileProperty = array_map(function($url) {
                $fileData = [
                    'name' => basename($url),
                    'type' => 'external',
                    'external' => [
                        'url' => $url
                    ]
                ];
                Log::info('File data for Notion:', $fileData);
                return $fileData;
            }, $fileUrls);

            $properties['ARCHIVO & MULTIMEDIA'] = [
                'files' => $fileProperty
            ];

            Log::info('Final file property:', ['ARCHIVO & MULTIMEDIA' => $properties['ARCHIVO & MULTIMEDIA']]);
        } else {
            Log::info('No archivo_url in data, skipping file attachment');
        }

        return $properties;
    }

    /**
     * Convertir fecha a formato Notion con offset de México
     */
    protected function convertToNotionFormat($dateString)
    {
        try {
            // Crear objeto DateTime con la zona horaria de México
            $date = new \DateTime($dateString, new \DateTimeZone('America/Mexico_City'));
            
            // Formatear con offset de México (-06:00)
            return $date->format('Y-m-d\TH:i:s.000-06:00');
            
        } catch (\Exception $e) {
            Log::error('Error convirtiendo fecha a formato Notion', [
                'dateString' => $dateString,
                'error' => $e->getMessage()
            ]);
            
            // Si hay error, devolver la fecha original
            return $dateString;
        }
    }

    /**
     * Convertir fecha a formato UTC sin offset para usar con timezone (método legacy)
     */
    protected function convertToUTCFormat($dateString)
    {
        try {
            // Si la fecha ya tiene offset, convertirla a UTC
            if (strpos($dateString, '+') !== false || strpos($dateString, '-') !== false) {
                $date = new \DateTime($dateString);
                return $date->format('Y-m-d\TH:i:s.000\Z');
            }
            
            // Si no tiene offset, asumir que es local y convertir a UTC
            $date = new \DateTime($dateString, new \DateTimeZone('America/Mexico_City'));
            return $date->format('Y-m-d\TH:i:s.000\Z');
            
        } catch (\Exception $e) {
            // Si hay error, devolver la fecha original
            return $dateString;
        }
    }
}
