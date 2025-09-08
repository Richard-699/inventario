let jsonConteoStock = null;
let tableStock = null;
const id_grupo = obtenerParametroURL('id_grupo');

$(document).ready(function () {
  const id_almacen = obtenerParametroURL("id_almacen");
  const id_partnumber = obtenerParametroURL("id_partnumber");

  if (!id_almacen || !id_partnumber) {
    window.location.href = "cronograma.php";
  }

  tableStock = $("#tabla-stock").DataTable({
    language: {
      url: "https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json",
    },
    lengthMenu: [
      [10, 50, 100, 200, -1],
      [10, 50, 100, 200, "Todos"],
    ],
    scrollCollapse: true,
    paging: true,
    pageLength: 10,

    ajax: {
      url: `../../Handler/inventory/stockHandler.php?action=onGet_InfoStock&id_almacen=${id_almacen}&id_partnumber=${id_partnumber}`,
      dataSrc: function (json) {
        const infoConteoStock = (json.informacionSAP || []).map((item) => ({
          id_informacion_sap_mb52: item.id_informacion_sap_mb52,
          id_part_number_informacion_sap_mb52:
            item.id_part_number_informacion_sap_mb52,
          id_almacen_informacion_sap_mb52: item.id_almacen_informacion_sap_mb52,
        }));

        jsonConteoStock = {
          informacionSAP: infoConteoStock,
        };

        if (json.informacionSAP && json.informacionSAP.length > 0) {
          const item = json.informacionSAP.find(
            (data) => data.id_almacen_informacion_sap_mb52 === id_almacen
          );

          let almacen = null;
          let partnumber = null;
          let descripcion_partnumber = null;
          let cantidad_informacion_sap_mb52 = null;
          let umb = null;

          if (item) {
            almacen = item.almacen ?? "N/A";
            partnumber = item.partnumber ?? "N/A";
            descripcion_partnumber = item.descripcion_partnumber ?? "N/A";
            umb = item.umb ?? "N/A";
            cantidad_informacion_sap_mb52 = item.cantidad_formateada ?? "N/A";
          } else {
            console.log(
              "No se encontró el item con el ID de almacén especificado."
            );
          }

          let disponible_fisico = 0;
          if (json.stock && json.stock.length > 0) {
            disponible_fisico = json.stock.reduce(
              (acc, s) => acc + Number(s.cantidad_stock),
              0
            );
          }
          let diferencia = disponible_fisico - cantidad_informacion_sap_mb52;

          const almacenHTML = `
              <p id="info" class="text-muted small mt-2 mb-0">Almacén: <strong>${almacen}</strong></p>
              <p id="info" class="text-muted small mt-2 mb-0">PartNumber: <strong>${partnumber} - ${descripcion_partnumber}</strong></p>
              <p id="info" class="text-muted small mt-2 mb-0">UMB: <strong>${umb}</strong></p>
              <p id="info" class="text-muted small mt-2 mb-0">Disponible SAP: <strong>${cantidad_informacion_sap_mb52}</strong></p>
              <p id="info" class="text-muted small mt-2 mb-0">Disponible Físico: <strong>${disponible_fisico}</strong></p>
              <p id="info" class="text-muted small mt-2 mb-0">Diferencia: <strong>${diferencia}</strong></p>
              <hr class="mt-4">
          `;

          const contenedorTitulo = document.querySelector(
            ".d-flex.align-items-center.justify-content-between.mb-4.border-bottom.pb-2"
          );

          if (contenedorTitulo && !document.querySelector("#info")) {
            contenedorTitulo.insertAdjacentHTML("afterend", almacenHTML);
          }
        }

        return json.localizaciones.map((loc) => {
          const stockItem = json.stock.find(
            (s) => s.id_localizacion_stock == loc.id_localizacion
          );
          return {
            ...loc,
            cantidad_stock: stockItem ? stockItem.cantidad_stock : 0,
          };
        });
      },
    },
    columns: [
      { data: "id_localizacion", className: "dt-center" },
      { data: "tipo_localizacion", className: "dt-center" },
      { data: "descripcion_localizacion", className: "dt-center" },
      { data: "tipo_almacenamiento", className: "dt-center" },
      { data: "cantidad_stock", className: "dt-center" },
      {
        data: "id_localizacion",
        className: "dt-center",
        render: function (data, type, row) {
          return `
              <button class="btn btn-primary btn-sm" onclick="conteo(this, '${data}')">
                  <i class="fa-solid fa-arrow-up-1-9"></i>
              </button>
          `;
        },
      },
    ],
    responsive: true,
    ordering: true,
    info: true,
    searching: true,
  });
});

function obtenerParametroURL(nombre) {
  const params = new URLSearchParams(window.location.search);
  return params.get(nombre);
}

async function conteo(btn, id) {
  mostrarCarga();
  btn.disabled = true;

  if (!tableStock) {
    console.error("La tabla #tabla-stock no está inicializada aún.");
    btn.disabled = false;
    ocultarCarga();
    return;
  }

  const row = tableStock.row($(btn).closest("tr")).data();

  const infoConLocalizacion = (jsonConteoStock.informacionSAP || []).map(
    (it) => ({
      ...it,
      id_localizacion: row.id_localizacion,
    })
  );
  const jsonFinal = { ...jsonConteoStock, informacionSAP: infoConLocalizacion };
  sessionStorage.setItem("stockData", JSON.stringify(jsonFinal));

  try {
    const d = jsonFinal.informacionSAP[0] || {};

    const params = new URLSearchParams({
      id_informacion_sap_mb52: d.id_informacion_sap_mb52 ?? "",
      id_part_number_informacion_sap_mb52:
        d.id_part_number_informacion_sap_mb52 ?? "",
      id_almacen_informacion_sap_mb52: d.id_almacen_informacion_sap_mb52 ?? "",
      id_localizacion: d.id_localizacion ?? "",
      id_grupo: id_grupo
    });

    params.append("_ts", Date.now().toString());

    Fancybox.show([
      {
        src: `conteo_stock.php?${params.toString()}`,
        type: "ajax",
      },
    ]);

  } catch (e) {
    console.error(e);
  } finally {
    ocultarCarga();
    btn.disabled = false;
  }
}
