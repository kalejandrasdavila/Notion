-- =============================================
-- CREATE TABLE dbo.Notion_Q
-- Mirrors all fields sent to Notion from V2 form
-- =============================================

CREATE TABLE dbo.Notion_Q (
    [Id]                      INT IDENTITY(1,1) PRIMARY KEY,
    [Status]                  NVARCHAR(255)   DEFAULT 'PENDIENTE',
    [Estado]                  NVARCHAR(255)   NULL,
    [Municipio]               NVARCHAR(255)   NULL,
    [TipoDeCobertura]         NVARCHAR(255)   NULL,
    [Relevancia]              NVARCHAR(255)   NULL,
    [ActorPrincipal]          NVARCHAR(500)   NULL,
    [TonoEditorial]           NVARCHAR(255)   NULL,
    [Indicaciones]            NVARCHAR(2000)  NULL,
    [RedaccionComplementaria] NVARCHAR(MAX)   NULL,
    [FechaInicio]             DATETIME        NULL,
    [Medio]                   NVARCHAR(500)   NULL,
    [LinkDescarga]            NVARCHAR(2000)  NULL,
    [ArchivoURL]              NVARCHAR(MAX)   NULL,
    [Solicitante]             NVARCHAR(255)   NULL,
    [Email]                   NVARCHAR(255)   NULL,
    [NotionPageId]            NVARCHAR(255)   NULL,
    [CreatedAt]               DATETIME        DEFAULT GETDATE()
);
GO

-- =============================================
-- INSERT example
-- =============================================

INSERT INTO dbo.Notion_Q (
    [Status],
    [Estado],
    [Municipio],
    [TipoDeCobertura],
    [Relevancia],
    [ActorPrincipal],
    [TonoEditorial],
    [Indicaciones],
    [RedaccionComplementaria],
    [FechaInicio],
    [Medio],
    [LinkDescarga],
    [ArchivoURL],
    [Solicitante],
    [Email],
    [NotionPageId]
)
VALUES (
    N'PENDIENTE',
    N'NUEVO LEON',
    N'MONTERREY',
    N'COBERTURA',
    N'PERIODISTICO',
    N'Juan Perez',
    N'NEUTRAL',
    N'Titulo corto de las indicaciones...',
    N'Texto complementario de redaccion...',
    '2026-03-19 15:30:00',
    N'TV,WEB',
    N'https://example.com/archivo',
    N'https://yourserver.com/storage/uploads/archivo.png',
    N'Oscar Eguia',
    N'oscar@email.com',
    N'328cf2b8-d3c4-815c-a2a3-ee3859cc3468'
);
GO

-- =============================================
-- Column mapping reference
-- =============================================
-- dbo.Notion_Q Column      | Notion Column                                    | Form Field
-- -------------------------+--------------------------------------------------+---------------------------
-- Id                       | (auto increment)                                 | -
-- Status                   | STATUS                                           | status (hidden)
-- Estado                   | ESTADO                                           | estado
-- Municipio                | ENTIDAD                                          | municipio
-- TipoDeCobertura          | TIPO                                             | tipo_cobertura
-- Relevancia               | RELEVANCIA                                       | relevancia
-- ActorPrincipal           | ACTOR PRINCIPAL                                  | actor_principal
-- TonoEditorial            | TONO EDITORIAL                                   | tono_editorial
-- Indicaciones             | INDICACIONES A SEGUIR (Que, como, y en donde)    | indicaciones
-- RedaccionComplementaria  | REDACCION / REDACCION2 / REDACCION3              | redaccion_complementaria
-- FechaInicio              | FECHA PLANEADA                                   | fecha_inicio
-- Medio                    | MEDIO                                            | medio (comma separated)
-- LinkDescarga             | URL                                              | link_descarga
-- ArchivoURL               | ARCHIVO & MULTIMEDIA                             | archivo
-- Solicitante              | QUIEN SOLICITA                                   | solicitante (from URL)
-- Email                    | EMAIL                                            | email (from URL)
-- NotionPageId             | (Notion response page ID)                        | -
-- CreatedAt                | (auto timestamp)                                 | -
