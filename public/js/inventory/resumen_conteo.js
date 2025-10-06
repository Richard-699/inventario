$(document).ready(function () {
    const handlerUrl = '../../Handler/inventory/stockHandler.php';
    const id_grupo = document.getElementById("id_grupo").value;

    if (id_grupo) {
        mostrarCarga();
        $.ajax({
            url: handlerUrl,
            method: 'GET',
            data: {
                action: 'onGet_InfoConteoResumen',
                id_grupo: id_grupo
            },
            dataType: 'json',
            success: function (resp) {
                if (resp && resp.success && resp.data) {
                    $('#tablaDatos tbody').empty();
                    renderizarTabla(resp.data);
                } else {
                    console.warn('Handler respondió con error:', resp.message);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('Error en AJAX GET a handler:', textStatus, errorThrown);
            },
            complete: function () {
                ocultarCarga();
            }
        });
    } else {
        console.warn('No se encontró el ID del grupo.');
    }
});

// Función de ayuda para limpiar los números
function cleanNumber(value) {
    if (value === null || value === undefined || value === 'N/A') {
        return 'N/A';
    }
    // Convertir el valor a una cadena para manipularlo
    let strValue = String(value);

    // Si la cadena termina en '.000', eliminar los decimales
    if (strValue.endsWith('.000')) {
        return strValue.slice(0, -4); // Eliminar el '.000'
    }

    // Si tiene otros decimales, devolver el valor original
    return strValue;
}

//  Resaltar celdas con N/A y 0
function highlightCell(value) {
    // Si el valor es 'N/A' o 0, devuelve un objeto con el valor y la clase de resaltado.
    if (value === 'N/A' || value === '0' || value === 0) {
        return { value: value, class: 'bg-danger text-white fw-bold' };
    }
    // Si no, devuelve solo el valor con una clase vacía
    return { value: value, class: 'bg-success text-white fw-bold' };
}
function renderizarTabla(data) {
    const infoMB52 = data.infoMB52;
    const infoWM = data.infoWM;
    const infoStock = data.infoStock;
    const infoPartNumbers = data.infoPartNumbers || [];
    const infoAlmacenes = data.infoAlmacenes || [];
    const infoLocalizaciones = data.infoLocalizaciones || [];
    const infoInventarioUmbs = data.infoInventarioHwiUmb || [];
    const tbody = $('#tablaDatos tbody');

    tbody.empty();

    if (infoMB52.length === 0) {
        const noDataRow = `<tr><td colspan="10" class="text-center">No se encontraron datos para este grupo.</td></tr>`;
        tbody.append(noDataRow);
        return;
    }

    const wmMap = new Map();
    infoWM.forEach(item => {
        if (!wmMap.has(item.id_part_number_informacion_sap_wm)) {
            wmMap.set(item.id_part_number_informacion_sap_wm, []);
        }
        wmMap.get(item.id_part_number_informacion_sap_wm).push(item);
    });

    const stockMap = new Map();
    infoStock.forEach(item => {
        if (!stockMap.has(item.id_informacion_sap_mb52_stock)) {
            stockMap.set(item.id_informacion_sap_mb52_stock, []);
        }
        stockMap.get(item.id_informacion_sap_mb52_stock).push(item);
    });

    const partNumberMap = new Map(infoPartNumbers.map(item => [item.id_partnumber, item.partnumber]));
    const almacenMap = new Map(infoAlmacenes.map(item => [item.id_almacen, item.descripcion_almacen]));
    const localizacionMap = new Map(infoLocalizaciones.map(item => [item.id_localizacion, item.descripcion_localizacion]));
    const umbMap = new Map(infoInventarioUmbs.map(item => [item.id_umb, item.descripcion_umb]));

    infoMB52.forEach(mb52Item => {
        const relatedWM = wmMap.get(mb52Item.id_part_number_informacion_sap_mb52) || [];
        const relatedStock = stockMap.get(mb52Item.id_informacion_sap_mb52) || [];
        const partNumberFullData = infoPartNumbers.find(p => p.id_partnumber === mb52Item.id_part_number_informacion_sap_mb52);

        const groupedWM = new Map();
        relatedWM.forEach(item => {
            const locKey = item.id_localizacion_informacion_sap_wm;
            if (!groupedWM.has(locKey)) {
                groupedWM.set(locKey, []);
            }
            groupedWM.get(locKey).push(item);
        });
        const uniqueWMItems = Array.from(groupedWM.values()).map(group => group[0]);

        const numRows = Math.max(uniqueWMItems.length, relatedStock.length, 1);

        let wmIndex = 0;
        let stockIndex = 0;

        for (let i = 0; i < numRows; i++) {
            const wmItem = uniqueWMItems[wmIndex] || {};
            const stockItem = relatedStock[stockIndex] || {};

            // Nuevo: Determinar la clase para la celda de stock
            const stockValue = cleanNumber(stockItem.cantidad_stock);
            const highlightedStock = highlightCell(stockValue);

            // Obtener el valor de la observación
            const observaciones = stockItem.observaciones_novedad_stock || 'N/A';

            let rowContent = '';

            if (i === 0) {
                rowContent = `
                    <td class="bg-secundary text-black" rowspan="${numRows}">${partNumberMap.get(mb52Item.id_part_number_informacion_sap_mb52) || 'N/A'}</td>
                    <td class="bg-secundary text-black" rowspan="${numRows}">${umbMap.get(partNumberFullData?.id_umb_partnumber) || 'N/A'}</td>
                    <td class="bg-secundary text-black" rowspan="${numRows}">${almacenMap.get(mb52Item.id_almacen_informacion_sap_mb52) || 'N/A'}</td>
                    <td class="bg-secundary text-black" rowspan="${numRows}">${cleanNumber(mb52Item.cantidad_informacion_sap_mb52)}</td>
                `;
            }

            rowContent += `
                <td>${localizacionMap.get(wmItem.id_localizacion_informacion_sap_wm) || 'N/A'}</td>
                <td>${cleanNumber(wmItem.stock_disponible_sap_informacion_sap_wm)}</td>
                <td>${cleanNumber(wmItem.stock_entrada_sap_informacion_sap_wm)}</td>
                <td>${cleanNumber(wmItem.stock_salida_sap_informacion_sap_wm)}</td>
                <td class="${highlightedStock.class}">${highlightedStock.value}</td>
                <td class="observaciones-cell" title="${observaciones}">${observaciones}</td>
            `;

            const finalRow = `<tr>${rowContent}</tr>`;
            tbody.append(finalRow);

            if (wmIndex < uniqueWMItems.length - 1) {
                wmIndex++;
            }
            if (stockIndex < relatedStock.length - 1) {
                stockIndex++;
            }
        }
    });
}