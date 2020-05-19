<!DOCTYPE html>
<html>
<head>
    <title>Sales Site</title>
    <?php
    include 'construct.php';
    $arq = basename( __FILE__ );
    $nome = $__html->ListaNomeBefore($arq, '.');
    $__html->InserirJS($nome);
    $__html->InserirCSS($nome);
    ?>
</head>
<body>
<?php

if ($_SESSION['id_user'] == '') {
    echo $__html->SWALAtualiza('login.php', 'Atenção!', 'Precisa fazer login antes!', 'warning');
    die;
}
if ($_SESSION['id_perfil'] <> '3') {
    echo $__html->SWALAtualiza('login.php', 'Sem permissão!', 'Restrito somente a administradores!', 'warning');
    die;
}

    $cad = $_GET['cad'];


        if($cad == '1') {
            if (!empty($_FILES['imagem'])) {
                $__upload = new Upload($_FILES['imagem'], 395, 395, "img/Products/");
                $_dados['img'] = $__upload->salvar();

                if($_dados['img']['status'] == false) {
                    $__html->SWALAtualiza('administracao.php', 'Falha!', $_dados['img']['msg'], 'error');
                } else {
                    $_dados['descricao'] = $_POST['descricao'];
                    $_dados['valor'] = $_POST['valor'];
                    $_dados['data_mod'] = date("d-m-Y H:i:s");

                    $_insert = $__cons->InsertPDO($_dados, 'tab_produto');

                    if($_insert <> '') {
                        $__html->SWALAtualiza('administracao.php', 'Sucesso!', 'Produto cadastrado!', 'success');
                    } else {
                        $__html->SWALAtualiza('administracao.php', 'Falha!', 'Produto não foi cadastrado!', 'error');
                    }
                }

            }
        }

    $__html->NavigationBar();

    $cons_produtos = $__cons->QueryPDO('tab_produto');

    $a = 0;
    while ($a < $cons_produtos['contador']) {

        $linha .= $__html->addHtml('tr', array('class' => 'text-dark'), array(
            $__html->addHtml('td', array('class' => 'text-dark px-5'), $cons_produtos[$a]['id']),
            $__html->addHtml('td', array('class' => 'text-dark px-5'), $cons_produtos[$a]['descricao']),
            $__html->addHtml('td', array('class' => 'text-dark px-5'), $cons_produtos[$a]['valor']),
            $__html->addHtml('td', array('class' => 'text-dark px-5'), $__html->addHtml('a', array('href' => "img/Products/{$cons_produtos[$a]['img']}", 'target' => '_blank'), $__html->addHtml('i', array('class' => 'fas fa-image'), ''))),
            $__html->addHtml('td', array('class' => 'text-dark px-5'), $cons_produtos[$a]['data_mod']),
            $__html->addHtml('td', array('class' => 'text-dark px-5'), $cons_produtos[$a]['id']),
        ));

        $a++;
    }

echo $__html->addHtml('form', array('id' => 'formLogout','action' => 'conta.php?cad=1', 'method' => 'POST'), array(
    $__html->addHtml('div', array('id' => 'mySidenav', 'class' => 'sidenav'), array(
        $__html->addHtml('a', array('href' => "javascript:void(0)", 'class' => 'closebtn mb-5', 'onclick' => 'closeNav()'), '&times;'),
        $__html->addHtml('a', array('href' => '#', 'class' => 'texto-nav mt-5', 'onclick' => 'MostrarInfo()'), 'Cadastrar Produtos'),
        $__html->addHtml('a', array('href' => '#', 'class' => 'texto-nav', 'onclick' => 'MostrarPedidos()'), 'Controle de Estoque'),
        $__html->addHtml('a', array('href' => '#', 'class' => 'texto-nav', 'onclick' => "$('#formLogout').submit()"), 'Sair'),
    ))
));

echo $__html->addHtml('div', array('class' => 'container-fluid'), array(
    $__html->addHtml('div', array('class' => 'my-5 py-5 form-dark text-center'), array(
        $__html->addHtml('span', array('class' => 'titulo-grande'),"ADMINISTRAÇÃO", '1'),
        $__html->addHtml('span', array('class' => 'text-primary titulo-grande font-weight-bold'),"{$_SESSION['nome']}", '2'),
        $__html->addHtml('span', array('style' => 'font-size:30px;cursor:pointer', 'class' => 'titulo-prod', 'onclick' => 'openNav()'),'&#9776; OPÇÕES','3'),

        $__html->addHtml('div', array('class' => 'd-flex justify-content-center'), array(
            $__html->addHtml('form', array('id' => 'formInfo','action' => 'administracao.php?cad=1', 'method' => 'POST', 'enctype' => 'multipart/form-data'), array(
                $__html->addHtml('div', array('id' => 'informacoes', 'class' => 'container-fluid px-5'), array(
                    $__html->addHtml('div', array('class' => 'row'), array(
                        $__html->addHtml('div', array('class' => 'text-center col-md-4'), array(
                            $__html->addHtml('label', array('for' => 'nome', 'class' => 'form-label'), 'DESCRIÇÃO', '1'),
                            $__html->addHtml('input', array('type' => 'text', 'class' => 'form-input', 'name' => 'descricao'), ''),
                        )),
                        $__html->addHtml('div', array('class' => 'text-center col-md-4'), array(
                            $__html->addHtml('label', array('for' => 'nome', 'class' => 'form-label'), 'VALOR', '1'),
                            $__html->addHtml('input', array('type' => 'number', 'step' => '0.1', 'class' => 'form-input', 'name' => 'valor'), ''),
                        )),
                        $__html->addHtml('div', array('class' => 'text-center col-md-4'), array(
                            $__html->addHtml('label', array('for' => 'nome', 'class' => 'form-label'), 'IMAGEM', '1'),
                            $__html->addHtml('input', array('type' => 'file', 'name' => 'imagem', 'value' => 'Cadastrar Imagem'), ''),
                        )),
                    ), '1'),

                    $__html->addHtml('table', array('class' => 'table table-hover table-dark bg-light'), array(
                        $__html->addHtml('tr', array('class' => 'text-dark texto-grande'), array(
                            $__html->addHtml('td', array('class' => 'text-dark px-5'), 'ID'),
                            $__html->addHtml('td', array('class' => 'text-dark px-5'), 'Descricao'),
                            $__html->addHtml('td', array('class' => 'text-dark px-5'), 'Valor'),
                            $__html->addHtml('td', array('class' => 'text-dark px-5'), 'Imagem'),
                            $__html->addHtml('td', array('class' => 'text-dark px-5'), 'Modificação'),
                            $__html->addHtml('td', array('class' => 'text-dark px-5'), 'Alterar'),
                        )),
                        $linha,
                    )),

                    $__html->addHtml('div', array('class' => 'row justify-content-end mt-5'), array(
                        $__html->addHtml('div', array('class' => 'text-center col-md-3'), array(
                            $__html->addHtml('button', array('class' => 'btn btn-success texto-grande', 'onclick' => "$('#formInfo').submit()"), 'SALVAR ALTERAÇÕES'),
                        )),
                    )),
                )),
            )),
            $__html->addHtml('form', array('id' => 'formPedidos','action' => 'conta.php?cad=3', 'method' => 'POST'), array(
                $__html->addHtml('div', array('id' => 'pedidos', 'class' => ' container-fluid px-5'), array(
                    $pedido,
                )),
            )),
        )),
    )),
));


?>
</body>
</html>
