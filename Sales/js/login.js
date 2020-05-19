$(document).ready(function() {
    $('.phone').mask('(00) 00000-0000');
    $('.cep').mask('00000-000');
    $('.cpf').mask('000.000.000-00', {reverse: true});
});

function ValidaSenha() {
    if ($('#cad_pass').val() != $('#cad_pass_2').val()) {
        $('#cad_pass').removeClass('bg-success');
        $('#cad_pass_2').removeClass('bg-success');
        $('#cad_pass').addClass('bg-danger');
        $('#cad_pass_2').addClass('bg-danger');
    } else {
        $('#cad_pass').removeClass('bg-danger');
        $('#cad_pass_2').removeClass('bg-danger');
        $('#cad_pass').addClass('bg-success');
        $('#cad_pass_2').addClass('bg-success');
    }
}

function Enviar() {
    if(ValidaObrigatorio()) {
        $('#FormCad').submit();
    }
}