<?php

    include 'class.session.php';
    include 'class.consulta.php';
    include 'class.basica.php';
    $__html = new Basica;
    $__cons = new Consulta;
    $__sess = new Session;



    $funcao = $_GET['Ajax'];

    if($funcao == 'UpdatePDO') {

        $_dados = $_POST['dados'];
        $_where = $_POST['where'];
        $_table = $_POST['table'];

        $__cons->UpdatePDO($_dados, $_table, $_where);

    } else if($funcao == 'AtualizaPreco') {

        $retorno = $__cons->ConsultaCarrinho($_POST);

        echo json_encode((object)$retorno);
    } else if($funcao == 'AdicionaCarrinho') {

//        print_r($_POST);
        $_dados = $_POST['dados'];
        $_table = $_POST['table'];

//        print_r($_dados);
//        print_r($_table);

        $retorno = $__cons->InsertPDO($_POST['dados'], $_POST['table']);

        echo $retorno;
    }