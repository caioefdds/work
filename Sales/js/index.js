
function Carrinho(id, descricao, valor) {

    if($("#id_user").val() == "") {
        if(localStorage.getItem("id_avulso") == null) {

            var time = $("#time").val();
            var id_random = $("#id_random").val();

            var id_avulso = time + id_random;

            localStorage.setItem("id_avulso", id_avulso);

            console.log(localStorage.getItem("id_avulso"));
        }

        var dados = {};
        var ajax = {};
        var funcao = 'classes/class.ajax.php?Ajax=AdicionaCarrinho';


        dados.id_produto = id;
        dados.id_avulso = localStorage.getItem("id_avulso");
        dados.descricao = descricao;
        dados.preco = valor;
        dados.unidades = 1;
        dados.processado = 0;

        ajax.dados =  dados;
        ajax.table = 'tab_carrinho';

        var result = ChamaAjax(ajax, funcao);
        result.done(function (resultado) {
           console.log(resultado);
        });

    }

}