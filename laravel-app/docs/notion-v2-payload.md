# Notion API POST Payload - Formulario V2

**Endpoint:** `POST https://api.notion.com/v1/pages`

**Headers:**
```
Authorization: Bearer <NOTION_API_TOKEN>
Notion-Version: 2022-06-28
Content-Type: application/json
```

## Full Payload

```json
{
  "parent": {
    "database_id": "<NOTION_DATABASE_ID>"
  },
  "properties": {
    "INDICACIONES A SEGUIR (Que, como, y en donde)": {
      "title": [
        {
          "type": "text",
          "text": {
            "content": "texto de indicaciones"
          }
        }
      ]
    },
    "STATUS": {
      "select": {
        "name": "PENDIENTE"
      }
    },
    "ESTADO": {
      "select": {
        "name": "NUEVO LEON"
      }
    },
    "ENTIDAD": {
      "multi_select": [
        { "name": "MONTERREY" }
      ]
    },
    "TIPO": {
      "select": {
        "name": "COBERTURA"
      }
    },
    "RELEVANCIA": {
      "select": {
        "name": "PERIODISTICO"
      }
    },
    "ACTOR PRINCIPAL": {
      "rich_text": [
        {
          "type": "text",
          "text": {
            "content": "Nombre persona o empresa"
          }
        }
      ]
    },
    "TONO EDITORIAL": {
      "select": {
        "name": "NEUTRAL"
      }
    },
    "QUIEN SOLICITA": {
      "rich_text": [
        {
          "type": "text",
          "text": {
            "content": "Oscar Eguia"
          }
        }
      ]
    },
    "EMAIL": {
      "email": "oscar@email.com"
    },
    "FECHA PLANEADA": {
      "date": {
        "start": "2026-03-19T15:30:00.000-06:00"
      }
    },
    "MEDIO ": {
      "multi_select": [
        { "name": "TV" },
        { "name": "WEB" }
      ]
    },
    "REDACCION": {
      "rich_text": [
        {
          "type": "text",
          "text": {
            "content": "texto de redaccion complementaria (max 1990 chars)"
          }
        }
      ]
    },
    "REDACCION2": {
      "rich_text": [
        {
          "type": "text",
          "text": {
            "content": "overflow si redaccion > 1990 chars"
          }
        }
      ]
    },
    "REDACCION3": {
      "rich_text": [
        {
          "type": "text",
          "text": {
            "content": "overflow si redaccion > 3980 chars"
          }
        }
      ]
    },
    "URL": {
      "url": "https://example.com/link-de-descarga"
    },
    "ARCHIVO & MULTIMEDIA": {
      "files": [
        {
          "name": "archivo.png",
          "type": "external",
          "external": {
            "url": "https://yourserver.com/storage/uploads/archivo.png"
          }
        }
      ]
    }
  }
}
```

## Field Mapping (Form V2 -> Notion)

| Form Field | Form Name | Notion Column | Notion Type |
|---|---|---|---|
| Estado | `estado` | `ESTADO` | select |
| Municipio | `municipio` | `ENTIDAD` | multi_select |
| Tipo de Cobertura | `tipo_cobertura` | `TIPO` | select |
| Relevancia | `relevancia` | `RELEVANCIA` | select |
| Actor principal | `actor_principal` | `ACTOR PRINCIPAL` | rich_text |
| Tono editorial | `tono_editorial` | `TONO EDITORIAL` | select |
| Indicaciones a seguir | `indicaciones` | `INDICACIONES A SEGUIR (Que, como, y en donde)` | title |
| Redaccion complementaria | `redaccion_complementaria` | `REDACCION` / `REDACCION2` / `REDACCION3` | rich_text |
| Fecha de Inicio | `fecha_inicio` | `FECHA PLANEADA` | date |
| Medio | `medio` | `MEDIO ` | multi_select |
| Link de descarga | `link_descarga` | `URL` | url |
| Adjuntar Archivo | `archivo` | `ARCHIVO & MULTIMEDIA` | files |
| Quien solicita | `solicitante` (hidden, from URL) | `QUIEN SOLICITA` | rich_text |
| Email | `email` (hidden, from URL) | `EMAIL` | email |
| Status | `status` (hidden, default PENDIENTE) | `STATUS` | select |

## Notes

- Fields are only included in the payload if they have a value.
- `REDACCION2` and `REDACCION3` are only used when `redaccion_complementaria` exceeds 1990 characters (split into chunks).
- `MEDIO ` has a trailing space in the Notion column name.
- Dates are sent in ISO format with GMT-6 offset (America/Mexico_City): `2026-03-19T15:30:00.000-06:00`.
- Files are uploaded to Laravel storage first, then the public URL is sent to Notion as an external file.
- `Tipo de Cobertura` reads its dropdown options from `TIPO DE SOLICITUD` column but writes to `TIPO` column.
- `Municipio` reads from `ENTIDAD` (filtered for NL), `ENT COAHUILA`, or `ENT TAMAULIPAS` based on selected Estado.
