$(document).ready(function () {

    document.getElementById('formOptionAlmacen').addEventListener('submit', async function (e) {
        e.preventDefault();
        mostrarCarga();

        let id_almacen_informacion_sap_mb52 = document.getElementById('id_almacen_informacion_sap_mb52').value;
        let id_partnumber = document.getElementById('id_partnumber').value;
        let id_grupo = document.getElementById('id_grupo').value;

        if(id_almacen_informacion_sap_mb52 == ""){
            notification('error', 'Debe seleccionar un almacén.', 2000);
        }else{
            window.open(`stock.php?id_almacen=${id_almacen_informacion_sap_mb52}&id_partnumber=${id_partnumber}&id_grupo=${id_grupo}`, '_blank');
        }

        ocultarCarga();
    });

    document.addEventListener('click', function (e) {
        if (e.target.matches('.carousel__button.is-close')) {
            location.reload();
        }
    });
});
