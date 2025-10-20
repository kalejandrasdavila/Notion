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

        // Título (usando el campo correcto de Notion) - Required field, send empty if not provided
        $properties['INDICACIONES A SEGUIR (Que, como, y en donde)'] = [
            'title' => [
                [
                    'type' => 'text',
                    'text' => [
                        'content' => isset($data['indicaciones']) && !empty($data['indicaciones'])
                            ? $data['indicaciones']
                            : 'Sin indicaciones'
                    ]
                ]
            ]
        ];

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

        // Email
        if (isset($data['email']) && !empty($data['email'])) {
            $properties['EMAIL'] = [
                'email' => $data['email']
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

        // Redacción (Redacción complementaria) - Split across 3 columns if needed
        if (isset($data['redaccion_complementaria']) && !empty($data['redaccion_complementaria'])) {
            $fullText = $data['redaccion_complementaria'];
            $textLength = strlen($fullText);

            // Split text into chunks of max 1990 characters each
            $maxChunkSize = 1990;
            $chunks = [];

            if ($textLength <= $maxChunkSize) {
                // If text fits in first column, just use REDACCION
                $chunks[] = $fullText;
            } else {
                // Split text across columns
                $chunks[] = substr($fullText, 0, $maxChunkSize);

                if ($textLength > $maxChunkSize && $textLength <= ($maxChunkSize * 2)) {
                    // Use REDACCION and REDACCION2
                    $chunks[] = substr($fullText, $maxChunkSize, $maxChunkSize);
                } else {
                    // Use all three columns
                    $chunks[] = substr($fullText, $maxChunkSize, $maxChunkSize);
                    $chunks[] = substr($fullText, $maxChunkSize * 2, $maxChunkSize);
                }
            }

            // Set REDACCION (first chunk)
            if (isset($chunks[0]) && !empty($chunks[0])) {
                $properties['REDACCION'] = [
                    'rich_text' => [
                        [
                            'type' => 'text',
                            'text' => [
                                'content' => $chunks[0]
                            ]
                        ]
                    ]
                ];
            }

            // Set REDACCION2 (second chunk if exists)
            if (isset($chunks[1]) && !empty($chunks[1])) {
                $properties['REDACCION2'] = [
                    'rich_text' => [
                        [
                            'type' => 'text',
                            'text' => [
                                'content' => $chunks[1]
                            ]
                        ]
                    ]
                ];
            }

            // Set REDACCION3 (third chunk if exists)
            if (isset($chunks[2]) && !empty($chunks[2])) {
                $properties['REDACCION3'] = [
                    'rich_text' => [
                        [
                            'type' => 'text',
                            'text' => [
                                'content' => $chunks[2]
                            ]
                        ]
                    ]
                ];
            }

            Log::info('Redacción split across columns', [
                'total_length' => $textLength,
                'chunks_count' => count($chunks),
                'chunk_lengths' => array_map('strlen', $chunks)
            ]);
        }

        // URL (Link de descarga)
        if (isset($data['link_descarga']) && !empty($data['link_descarga'])) {
            $properties['URL'] = [
                'url' => $data['link_descarga']
            ];
        }

        // Adjuntar archivo (files)
        if (isset($data['archivo_url']) && !empty($data['archivo_url'])) {
            $fileUrls = is_array($data['archivo_url']) ? $data['archivo_url'] : [$data['archivo_url']];

            Log::info('=== NOTION FILE PROPERTY ===');
            Log::info('Building file property for Notion', [
                'urls' => $fileUrls,
                'count' => count($fileUrls)
            ]);

            $fileProperty = array_map(function($url) {
                // Ensure URL is absolute
                if (!filter_var($url, FILTER_VALIDATE_URL)) {
                    Log::warning('Invalid URL for file', ['url' => $url]);
                    return null;
                }

                $fileData = [
                    'name' => basename(parse_url($url, PHP_URL_PATH)) ?: 'file',
                    'type' => 'external',
                    'external' => [
                        'url' => $url
                    ]
                ];
                Log::info('File data for Notion:', $fileData);
                return $fileData;
            }, $fileUrls);

            // Filter out any null values
            $fileProperty = array_filter($fileProperty);

            if (!empty($fileProperty)) {
                $properties['ARCHIVO & MULTIMEDIA'] = [
                    'files' => array_values($fileProperty) // Re-index array
                ];

                Log::info('Final file property:', [
                    'ARCHIVO & MULTIMEDIA' => $properties['ARCHIVO & MULTIMEDIA'],
                    'files_count' => count($fileProperty)
                ]);
            } else {
                Log::warning('All file URLs were invalid, skipping file attachment');
            }
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
