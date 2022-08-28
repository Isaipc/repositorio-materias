export const HUMAN_FORMAT = null;
export const TIMESTAMP_FORMAT = 'DD/MM/YYYY h:m A'
export const OUTPUT_DATE_FORMAT = 'dddd DD/MMM/YYYY'
export const DEFAULT_FORMAT = 'YYYY-MM-DD hh:mm:ss A';

export const dtLanguageOptions = {
    emptyTable: "No hay datos disponibles",
    zeroRecords: "No se encontraron resultados",
    infoFiltered: "(filtrado de _MAX_ registros totales)",
    infoEmpty: "Mostrando 0 registros",
    search: 'Buscar',
    info: "Mostrando pagina _PAGE_ de _PAGES_",
    paginate: {
        first: "Primero",
        last: "Ultimo",
        next: "Siguiente",
        previous: "Anterior"
    },
    lengthMenu: "Mostrar _MENU_ filas",
    processing: 'Procesando ...'
}

export const dtOverrideGlobals = {
    language: dtLanguageOptions,
    paginate: true,
    processing: true,
}

export const status_unprocessable_entity = 422
export const status_server_error = 500
export const status_default_error = 400