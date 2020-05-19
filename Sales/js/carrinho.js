function AlteraPreco(id, id_carrinho, id_user){

    var dados = {};
    var where = {};
    var ajax = {};
    var funcao = 'classes/class.ajax.php?Ajax=UpdatePDO';


    dados.unidades = $('#unidades_'+id).val();

    where.id = id_carrinho;

    ajax.dados =  dados;
    ajax.where = where;
    ajax.table = 'tab_carrinho';

    var result = ChamaAjax(ajax, funcao);

    result.done(function (opa) {
        var funcao1 = 'classes/class.ajax.php?Ajax=AtualizaPreco';
        var ajax2   = {};
        ajax2.id_user = id_user;
        var result2 = ChamaAjax(ajax2, funcao1);
        result2.done(function (opa2) {
            console.log(opa2);
            var resultado = JSON.parse(opa2);
            $.each(resultado, function (i, item) {
                $('#soma_'+id).text((resultado[id]['soma']).toFixed(2));
            });
            $('#total').text("R$ "+ (resultado.total).toFixed(2));
        });
    });

}

function ConsultaAPI() {

    $.ajax({
        //METODO DE ENVIO
        type: "POST",
        //URL PARA QUAL OS DADOS SERÃO ENVIADOS
        url: "erp.bluesoft.com.br/beta/api",
        //DADOS QUE SERÃO ENVIADOS
        data: $("#formulario").serialize(),
        //TIPOS DE DADOS QUE O AJAX TRATA
        dataType: "json",
        //CASO DÊ TUDO CERTO NO ENVIO PARA A API
        success: function(){
            //SUBMETE O FORMULÁRIO PARA A ACTION DEFINIDA NO CABEÇALHO
            $("#formulario").submit();
        }
    });
}