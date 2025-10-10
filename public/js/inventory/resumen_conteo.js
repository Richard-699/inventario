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
    const infoLocalizacionesAlmacenes = data.infoLocalizacionesAlmacenes || [];
    const tbody = $('#tablaDatos tbody');

    tbody.empty();

    if (infoMB52.length === 0) {
        const noDataRow = `<tr><td colspan="10" class="text-center">No se encontraron datos para este grupo.</td></tr>`;
        tbody.append(noDataRow);
        return;
    }

    // CORRECCIÓN: Se actualiza la clave compuesta para asegurar que coincida con la estructura de tus datos
    const stockMap = new Map();
    infoStock.forEach(item => {
        // La clave ahora incluye el id_partnumber_stock para asegurar unicidad y precisión
        const compoundKey = `${item.id_localizacion_stock}_${item.id_almacen_stock}_${item.id_partnumber_stock}`;
        stockMap.set(compoundKey, item);
    });

    const partNumberMap = new Map(infoPartNumbers.map(item => [item.id_partnumber, item.partnumber]));
    const almacenMap = new Map(infoAlmacenes.map(item => [item.id_almacen, item.descripcion_almacen]));
    const localizacionMap = new Map(infoLocalizaciones.map(item => [item.id_localizacion, item.descripcion_localizacion]));
    const umbMap = new Map(infoInventarioUmbs.map(item => [item.id_umb, item.descripcion_umb]));

    const locsByAlmacenMap = new Map();
    infoLocalizacionesAlmacenes.forEach(item => {
        const idAlmacen = item.id_almacen;
        const idLocalizacion = item.id_localizacion_localizaciones;
        if (!locsByAlmacenMap.has(idAlmacen)) {
            locsByAlmacenMap.set(idAlmacen, []);
        }
        locsByAlmacenMap.get(idAlmacen).push(idLocalizacion);
    });

    infoMB52.forEach(mb52Item => {
        const partNumberFullData = infoPartNumbers.find(p => p.id_partnumber === mb52Item.id_part_number_informacion_sap_mb52);
        const currentAlmacenId = mb52Item.id_almacen_informacion_sap_mb52;
        const currentPartNumberId = mb52Item.id_part_number_informacion_sap_mb52;

        const relatedWM = infoWM.filter(item => item.id_part_number_informacion_sap_wm === currentPartNumberId);

        const groupedWM = new Map();
        relatedWM.forEach(item => {
            const locKey = item.id_localizacion_informacion_sap_wm;
            if (!groupedWM.has(locKey)) {
                groupedWM.set(locKey, item);
            }
        });

        const uniqueWMItems = Array.from(groupedWM.values());

        let locationsToRender = locsByAlmacenMap.get(currentAlmacenId) || [];

        if (mb52Item.almacen === 'WM01') {
            locationsToRender = uniqueWMItems.map(item => item.id_localizacion_informacion_sap_wm);
        }

        const numRows = locationsToRender.length;

        if (numRows === 0) {
            const rowContent = `
                <td class="bg-secundary text-black" rowspan="1">${partNumberMap.get(currentPartNumberId) || 'N/A'}</td>
                <td class="bg-secundary text-black" rowspan="1">${umbMap.get(partNumberFullData?.id_umb_partnumber) || 'N/A'}</td>
                <td class="bg-secundary text-black" rowspan="1">${almacenMap.get(currentAlmacenId) || 'N/A'}</td>
                <td class="bg-secundary text-black" rowspan="1">${cleanNumber(mb52Item.cantidad_informacion_sap_mb52)}</td>
                <td>N/A</td>
                <td>N/A</td>
                <td>N/A</td>
                <td>N/A</td>
                <td class="bg-danger text-white fw-bold">N/A</td>
                <td class="observaciones-cell" title="N/A">N/A</td>
            `;
            const finalRow = `<tr>${rowContent}</tr>`;
            tbody.append(finalRow);
        } else {
            locationsToRender.forEach((locId, index) => {
                const wmItem = uniqueWMItems.find(item => item.id_localizacion_informacion_sap_wm === locId) || {};

                // CORRECCIÓN: La clave compuesta ahora usa el ID de PartNumber del item MB52
                const compoundKey = `${locId}_${currentAlmacenId}_${currentPartNumberId}`;
                const stockItem = stockMap.get(compoundKey) || {};

                const stockValue = cleanNumber(stockItem.cantidad_stock);
                const highlightedStock = highlightCell(stockValue);
                const observaciones = stockItem.observaciones_novedad_stock || 'N/A';

                let rowContent = '';
                if (index === 0) {
                    rowContent = `
                        <td class="bg-secundary text-black" rowspan="${numRows}">${partNumberMap.get(currentPartNumberId) || 'N/A'}</td>
                        <td class="bg-secundary text-black" rowspan="${numRows}">${umbMap.get(partNumberFullData?.id_umb_partnumber) || 'N/A'}</td>
                        <td class="bg-secundary text-black" rowspan="${numRows}">${almacenMap.get(currentAlmacenId) || 'N/A'}</td>
                        <td class="bg-secundary text-black" rowspan="${numRows}">${cleanNumber(mb52Item.cantidad_informacion_sap_mb52)}</td>
                    `;
                }

                rowContent += `
                    <td>${localizacionMap.get(locId) || 'N/A'}</td>
                    <td>${cleanNumber(wmItem.stock_disponible_sap_informacion_sap_wm) || 'N/A'}</td>
                    <td>${cleanNumber(wmItem.stock_entrada_sap_informacion_sap_wm) || 'N/A'}</td>
                    <td>${cleanNumber(wmItem.stock_salida_sap_informacion_sap_wm) || 'N/A'}</td>
                    <td class="${highlightedStock.class}">${highlightedStock.value}</td>
                    <td class="observaciones-cell" title="${observaciones}">${observaciones}</td>
                `;

                const finalRow = `<tr>${rowContent}</tr>`;
                tbody.append(finalRow);
            });
        }
    });
}