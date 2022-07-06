const HUMAN_FORMAT = null;
const TIMESTAMP_FORMAT = 'DD/MM/YYYY h:m A'
const OUTPUT_DATE_FORMAT = 'dddd DD/MMM/YYYY'
const DEFAULT_FORMAT = 'YYYY-MM-DD hh:mm:ss A';

const dtLanguageOptions = {
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
};

const dtOverrideGlobals = {
    language: dtLanguageOptions,
    paginate: true,
    processing: true,
};


export {
    HUMAN_FORMAT,
    TIMESTAMP_FORMAT,
    OUTPUT_DATE_FORMAT,
    DEFAULT_FORMAT,
    dtLanguageOptions,
    dtOverrideGlobals,
};