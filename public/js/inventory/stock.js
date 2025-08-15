$(document).ready(function () {
  const id_almacen = obtenerParametroURL("id_almacen");
  if (!id_almacen) {
    window.location.href = "cronograma.php";
  }

  $("#tabla-stock").DataTable({
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
      url: `../../Handler/inventory/stockHandler.php?action=onGet_InfoStock&id_almacen=${id_almacen}`,
      dataSrc: function (json) {
        if (json.mb52 && json.mb52.length > 0) {
          const item = json.mb52.find(
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
            cantidad_informacion_sap_mb52 = item.cantidad_informacion_sap_mb52 ?? "N/A";
          } else {
            console.log("No se encontró el item con el ID de almacén especificado.");
          }
         
          let disponible_fisico = 0;
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

        return json.localizaciones;
      },
    },
    columns: [
      { data: "id_localizacion", className: "dt-center" },
      { data: "descripcion_localizacion", className: "dt-center" },
      { data: "descripcion_localizacion", className: "dt-center" },
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

  try {
    const responseMB52 = await fetch(
      `../../Handler/inventory/partnumbersGrupoHandler.php?action=onGet_MB52&id_partnumber=${encodeURIComponent(
        id
      )}`,
      {
        method: "GET",
      }
    );
    const MB52 = await responseMB52.json();
    const MB52Encoded = encodeURIComponent(JSON.stringify(MB52));

    var url = `options_almacenes.php?mb52=${MB52Encoded}`;

    Fancybox.show([
      {
        src: url,
        type: "ajax",
      },
    ]);

    setTimeout(() => {
      ocultarCarga();

      Fancybox.getInstance().options = {
        ...Fancybox.getInstance().options,
        click: false,
        trapFocus: false,
        placeFocusBack: false,
      };
    }, 100);
  } catch (error) {
    console.error("Error al cargar la modal:", error);
  } finally {
    btn.disabled = false;
  }
}
