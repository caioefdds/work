<!DOCTYPE html>
<html>
<head>
    <title>Sales Site</title>

</head>
<body>
<?php
            include 'construct.php';
            $arq = basename( __FILE__ );
            $js = $__html->ListaNomeBefore($arq, '.');
            $__html->InserirJS($js);

            $__html->NavigationBar();
?>

<!-- FIRST SCREEN -->
<div id="start" class="container-fluid mb-5">
    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="img/BUY-Banner.jpg" alt="First slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="img/FRIEND-Banner.jpg" alt="Second slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="img/SETUP-Banner.jpg" alt="Third slide">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</div>

<!-- SECOND SCREEN -->
<?php

    $cons_produtos = $__cons->QueryPDO('tab_produto');

    $cad = $_GET['cad'];

    if($cad == '1') {

        $c = 0;
        while($c < $cons_produtos['contador']) {
            if($_GET['id_produto'] == $cons_produtos[$c]['id']) {
                $_dados['id_produto'] = $cons_produtos[$c]['id'];
                $_dados['descricao'] = $cons_produtos[$c]['descricao'];
                $_dados['preco'] = $cons_produtos[$c]['valor'];
                $_dados['processado'] = '0';
                $_dados['unidades'] = '1';
                break;
            } else {
                $c++;
            }
        }

        $_where_update['processado'] = '0';

        if($_SESSION['id_user'] <> '') {
            $_dados['id_user'] = $_SESSION['id_user'];

            $_where_update['id_user'] = $_SESSION['id_user'];
            $_where_update['id_produto'] = $_GET['id_produto'];

            $_consulta = $__cons->QueryPDO('tab_carrinho', $_where_update);

            if($_consulta['contador'] <> '0') {

                $_update['unidades'] = $_consulta[0]['unidades'] + 1;

                $_update_carrinho = $__cons->UpdatePDO($_update, 'tab_carrinho', $_where_update);
            } else {
                $_carrinho = $__cons->AdicionaCarrinho($_dados);
            }
        } else if($_SESSION['id_avulso'] <> '') {
            $_dados['id_avulso'] = $_SESSION['id_avulso'];

            $_where_update['id_avulso'] = $_SESSION['id_avulso'];
            $_where_update['id_produto'] = $_GET['id_produto'];

            $_consulta = $__cons->QueryPDO('tab_carrinho', $_where_update);

            if($_consulta['contador'] <> '0') {

                $_update['unidades'] = $_consulta[0]['unidades'] + 1;

                $_update_carrinho = $__cons->UpdatePDO($_update, 'tab_carrinho', $_where_update);
            } else {
                $_carrinho = $__cons->AdicionaCarrinho($_dados);
            }
        } else {
            $numero_avulso = rand(0,100000);
            $time = time();
            $_dados['id_avulso'] = $time.$numero_avulso;

            $_carrinho = $__cons->AdicionaCarrinho($_dados);
        }

        echo $__html->SWALAtualiza('carrinho.php', 'Adicionado ao Carrinho', '', 'success');
    }

    $a = 0;
    while ($a < $cons_produtos['contador']) {

        $_produtos .= $__html->addHtml('div', array('class' => 'col col-lg-4 col-md-6 col-sm-12 col-12 text-center mb-2 mx-2 prod-card px-1'), array(
            $__html->addHtml('form', array('id' => "FormProduto_$a", 'action' => "index.php?cad=1&id_produto={$cons_produtos[$a]['id']}", 'method' => 'POST'), array(
                $__html->addHtml('img', array('class' => 'img-fluid', 'width' => '250px', 'height' => '250px', 'src' => "img/Products/{$cons_produtos[$a]['img']}"), '', '', true),
                $__html->addHtml('div', array('class' => 'titulo-prod mb-5', 'style' => 'height: 120px'), $cons_produtos[$a]['descricao'], '', true),
                $__html->addHtml('span', array('class' => 'bg-success p-2 prod-botao'), "R$ ". number_format($cons_produtos[$a]['valor'], 2, ',', '.')),
                $__html->addHtml('button', array('class' => 'prod-botao btn btn-light mt-5', 'onclick' => "$('#FormProduto_$a').submit();"), " COMPRAR"),
            )),
        ));

        $a++;
    }

    $produtos = $__html->addHtml('div', array('class' => 'container mt-5 text-center', 'id' => 'products'), array(
        $__html->addHtml('h1', array('class' => 'titulo text-center mb-5'), 'PRODUTOS', '1'),
        $__html->addHtml('input', array('type' => 'hidden', 'id' => 'id_user','value' => "{$_SESSION['id_user']}"), ''),
        $__html->addHtml('input', array('type' => 'hidden', 'id' => 'id_random', 'value' => "$numero_avulso"), ''),
        $__html->addHtml('input', array('type' => 'hidden', 'id' => 'time', 'value' => "$time"), ''),
        $__html->addHtml('div', array('class' => 'row justify-content-center'), array(
            $_produtos,
        )),
    ));

    echo $produtos;

    $rodape = $__html->addHtml('div', array('class' => 'jumbotron justify-content-center border-top border-danger py-5 mt-5 mb-0 rounded-0 rodape'), array(
        $__html->addHtml('img', array('class' => 'img-fluid mx-auto d-block', 'width' => '250px', 'height' => '250px', 'src' => 'img/Logo-Min.png'), '', '', true),
        $__html->addHtml('h5', array('class' => 'text-center text-white-50'), 'Informação da empresa contratada'),
        $__html->addHtml('h6', array('class' => 'text-center text-white-50'), 'CNPJ: 00.000.000/0000-00'),
        $__html->addHtml('h6', array('class' => 'text-center text-white-50'), 'TAUBATÉ-SP'),
    ));

    echo $rodape;

?>

</body>
</html>