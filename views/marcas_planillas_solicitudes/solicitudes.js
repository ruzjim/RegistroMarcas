$(document).ready(function () {
    $('form').on('submit', function (e) {
        e.preventDefault();

        const datos = {
            tipo: $('#tipo-solicitud').val(),
            colaborador: $('#colaborador').val(),
            inicio: $('#fecha-inicio').val(),
            fin: $('#fecha-fin').val(),
            motivo: $('#motivo').val()
        };

        $.post('solicitudes.php', datos, function (respuesta) {
            const res = JSON.parse(respuesta);
            if (res.status === 'ok') {
                Swal.fire('Éxito', res.mensaje, 'success');
                $('form')[0].reset();
            } else {
                Swal.fire('Error', res.mensaje, 'error');
            }
        });
    });
});