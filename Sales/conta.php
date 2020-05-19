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
    if ($_SESSION['id_perfil'] == '3') {
        $_adm = $__html->addHtml('a', array('href' => 'administracao.php', 'class' => 'texto-nav'), 'ADMINISTRAÇÃO');
    } else {
        $_adm = "";
    }

    $cad = $_GET['cad'];

    if ($cad == '1') {
        $resposta = $__cons->Deslogar();
        if ($resposta == true) {
            echo $__html->SWALAtualiza('login.php', 'Saindo...', '', 'warning');
        }
    } else if ($cad == '2') {
        $dados['nome'] = $_POST['nome'];
        $dados['email'] = $_POST['email'];
        $dados['cpf'] = $_POST['cpf'];
        $dados['cep'] = $_POST['cep'];
        $dados['telefone'] = $_POST['telefone'];
        $dados['endereco'] = $_POST['endereco'];
        $dados['estado'] = $_POST['estado'];
        $where['id'] = $_SESSION['id_user'];

        $update = $__cons->UpdatePDO($dados, 'tab_user', $where);

        if ($update == '1') {
            echo $__html->SWALAtualiza('conta.php', 'Alterações salvas!', '', 'success');
        } else {
            echo $__html->SWALAtualiza('conta.php', 'Falha ao salvar alterações', '', 'error');
        }
    }

    $__html->NavigationBar();

    $_where['id_user'] = $_SESSION['id_user'];
    $result = $__cons->ConsultaCliente($_where);
    $pedido = $__cons->ConsultaPedidos($_where);

    echo $__html->addHtml('form', array('id' => 'formLogout','action' => 'conta.php?cad=1', 'method' => 'POST'), array(
        $__html->addHtml('div', array('id' => 'mySidenav', 'class' => 'sidenav'), array(
                $__html->addHtml('a', array('href' => "javascript:void(0)", 'class' => 'closebtn mb-5', 'onclick' => 'closeNav()'), '&times;'),
                $__html->addHtml('a', array('href' => '#', 'class' => 'texto-nav mt-5', 'onclick' => 'MostrarInfo()'), 'Informações'),
                $__html->addHtml('a', array('href' => '#', 'class' => 'texto-nav', 'onclick' => 'MostrarPedidos()'), 'Meus Pedidos'),
                $_adm,
                $__html->addHtml('a', array('href' => '#', 'class' => 'texto-nav', 'onclick' => "$('#formLogout').submit()"), 'Sair'),
        ))
    ));

    echo $__html->addHtml('div', array('class' => 'container-fluid'), array(
            $__html->addHtml('div', array('class' => 'my-5 py-5 form-dark text-center'), array(
                $__html->addHtml('span', array('class' => 'titulo-grande'),"BEM-VINDO", '1'),
                $__html->addHtml('span', array('class' => 'text-primary titulo-grande font-weight-bold'),"{$_SESSION['nome']}", '2'),
                $__html->addHtml('span', array('style' => 'font-size:30px;cursor:pointer', 'class' => 'titulo-prod', 'onclick' => 'openNav()'),'&#9776; OPÇÕES','3'),

                $__html->addHtml('div', array('class' => 'd-flex justify-content-center'), array(
                    $__html->addHtml('form', array('id' => 'formInfo','action' => 'conta.php?cad=2', 'method' => 'POST'), array(
                        $__html->addHtml('div', array('id' => 'informacoes', 'class' => 'container-fluid px-5'), array(
                            $__html->addHtml('div', array('class' => 'row'), array(
                                $__html->addHtml('div', array('class' => 'text-center col-md-3'), array(
                                    $__html->addHtml('label', array('for' => 'nome', 'class' => 'form-label'), 'NOME', '1'),
                                    $__html->addHtml('input', array('type' => 'text', 'class' => 'form-input', 'name' => 'nome', 'value' => "{$result[0]['nome']}"), ''),
                                )),
                                $__html->addHtml('div', array('class' => 'text-center col-md-3'), array(
                                    $__html->addHtml('label', array('for' => 'nome', 'class' => 'form-label'), 'E-MAIL', '1'),
                                    $__html->addHtml('input', array('type' => 'text', 'class' => 'form-input', 'name' => 'email', 'value' => "{$result[0]['email']}"), ''),
                                )),
                                $__html->addHtml('div', array('class' => 'text-center col-md-3'), array(
                                    $__html->addHtml('label', array('for' => 'nome', 'class' => 'form-label'), 'CPF', '1'),
                                    $__html->addHtml('input', array('type' => 'text', 'class' => 'form-input', 'name' => 'cpf', 'value' => "{$result[0]['cpf']}"), ''),
                                )),
                                $__html->addHtml('div', array('class' => 'text-center col-md-3'), array(
                                    $__html->addHtml('label', array('for' => 'nome', 'class' => 'form-label'), 'TELEFONE', '1'),
                                    $__html->addHtml('input', array('type' => 'text', 'class' => 'form-input', 'name' => 'telefone', 'value' => "{$result[0]['telefone']}"), ''),
                                )),
                            )),
                            $__html->addHtml('div', array('class' => 'row'), array(
                                $__html->addHtml('div', array('class' => 'text-center col-md-6'), array(
                                    $__html->addHtml('label', array('for' => 'nome', 'class' => 'form-label'), 'ENDEREÇO', '1'),
                                    $__html->addHtml('input', array('type' => 'text', 'class' => 'form-input', 'name' => 'endereco', 'value' => "{$result[0]['endereco']}"), ''),
                                )),
                                $__html->addHtml('div', array('class' => 'text-center col-md-3'), array(
                                    $__html->addHtml('label', array('for' => 'nome', 'class' => 'form-label'), 'ESTADO', '1'),
                                    $__html->addHtml('input', array('type' => 'text', 'class' => 'form-input', 'name' => 'estado', 'value' => "{$result[0]['estado']}"), ''),
                                )),
                                $__html->addHtml('div', array('class' => 'text-center col-md-3'), array(
                                    $__html->addHtml('label', array('for' => 'nome', 'class' => 'form-label'), 'CEP', '1'),
                                    $__html->addHtml('input', array('type' => 'text', 'class' => 'form-input', 'name' => 'cep', 'value' => "{$result[0]['cep']}"), ''),
                                )),
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
