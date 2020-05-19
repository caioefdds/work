function ValidaObrigatorio () {
    var validado = 1;
    var msg = '';
    $(".obrigatorio").each(function (index) {
        var valida = $(this).val();
        if ((valida.length == 0) && ($(this).is('div') == false)) {
            var id = this.id;
            msg = msg + '\n- ' + $('#label_' + id).html();
            validado = 0;
        }
    });
    if (validado == 0) {
        Swal.fire(
            'Alerta!',
            'existem campos vazios',
            'warning'
        );
        return false;
    }
    else {
        return true;
    }
}

function ChamaAjax(dados = '', funcao, metodo = "POST") {

    return $.ajax({
        data: dados,
        url: funcao,
        type: metodo
    });
}