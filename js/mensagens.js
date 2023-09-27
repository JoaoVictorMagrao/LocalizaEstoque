var Toast = Swal.mixin({
    toast: true,
    position: 'bottom-right',
    showConfirmButton: false,
    timer: 8000
});

function mensagem(icone, texto) {
    Toast.fire({
        icon: icone, //success, info, error, warning
        title: texto
    });
}

