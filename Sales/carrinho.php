<!DOCTYPE html>
<html>
<head>
    <title>Sales Site</title>
    <?php
    include 'construct.php';
    $arq = basename( __FILE__ );
    $js = $__html->ListaNomeBefore($arq, '.');
    $__html->InserirJS($js);
    ?>
</head>
<body>

<?php
echo $_SESSION['id_user'];
    if($_SESSION['id_user'] <> '') {
        $where['id_user'] = $_SESSION['id_user'];
    } else if($_SESSION['id_avulso'] <> '') {
        $where['id_avulso'] = $_SESSION['id_avulso'];
    }
    $where['processado'] = "0";

    $cad = $_GET['cad'];

    if ($cad == '1') {

        if($_SESSION['id_user'] <> '') {
            $cons_pedido = $__cons->ConsultaCarrinho($where);

            $a = 0;
            while ($a < $cons_pedido['contador']) {
                $id .= $cons_pedido[$a]['id'] . ',';
                $a++;
            }

            $_pedido['id_user'] = $_SESSION['id_user'];
            $_pedido['id_carrinho'] = $id;
            $_pedido['status'] = '0';
            $_pedido['data_mod'] = date("d-m-Y H:i:s");

            $result = $__cons->InsertPDO($_pedido, 'tab_pedido');

            if ($result <> '') {
                $_boleto['data_gerado'] = date("d-m-Y H:i:s");
                $_boleto['valor'] = $cons_pedido['total'];
                $_boleto['itens'] = $cons_pedido['contador'];
                $_boleto['id_pedido'] = $result;

                $_carrinho['processado'] = '1';
                $_where_carrinho['id_user'] = $_SESSION['id_user'];

                $result_carrinho = $__cons->UpdatePDO($_carrinho, 'tab_carrinho', $_where_carrinho);

                if ($result_carrinho <> '0') {
                    $resultado = $__cons->InsertPDO($_boleto, 'tab_boleto');

                    if($resultado = null) {
                        echo $__html->SWALAtualiza('carrinho.php', 'Falha na geração do boleto', 'Contate nosso suporte: caioefdds@gmail.com', 'error');
                    }

                    echo $__html->SWALAtualiza('conta.php', 'Pedido realizado com sucesso', "Numero do pedido: $result", 'success');
                } else {
                    echo $__html->SWALAtualiza('carrinho.php', 'Falha na Atualização do Carrinho!', 'Contate nosso suporte: caioefdds@gmail.com', 'error');
                }

            } else {
                echo $__html->SWALAtualiza('carrinho.php', 'Falha no Pedido!', 'Contate nosso suporte: caioefdds@gmail.com', 'error');
            }
        } else {
            echo $__html->SWALAtualiza('login.php', 'Crie sua conta!', 'Para finalizar o pedido você precisa possuir um cadastro', 'warning');
        }
    }


    $__html->NavigationBar();
    $cons_exe = $__cons->ConsultaCarrinho($where);

    $a = 0;
    while ($a < $cons_exe['contador']) {
        $linhas .= $__html->addHtml('tr', '', array(
            $__html->addHtml('th', array('class' => 'text-center', 'scope' => 'row'), $a + 1),
            $__html->addHtml('td', array('colspan' => '3'), $cons_exe[$a]['descricao']),
            $__html->addHtml('td', array('class' => 'text-center'), $__html->addHtml('input', array('type' => 'number', 'min' => '0','class' => 'form-input-sm', 'onchange' => "AlteraPreco($a, {$cons_exe[$a]['id']}, {$_SESSION['id_user']})",'step' => '1', 'id' => 'unidades_'.$a, 'name' => 'unidades_'.$a, 'value' => "{$cons_exe[$a]['unidades']}"), '')),
            $__html->addHtml('td', array('class' => 'text-center text-monospace', 'id' => "soma_".$a, 'name' => "soma_".$a, 'data-preco_'.$a => "{$cons_exe[$a]['preco']}"), $cons_exe[$a]['soma']),
            $__html->addHtml('td', array('class' => 'text-center'), $__html->addHtml('i', array('class' => 'fas fa-times-circle text-danger hover_cursor'),'')),
        ));
        $a++;
    }

    echo $__html->addHtml('div', array('class' => 'container table-responsive-md table-dark my-5 py-5'), array(
            $__html->addHtml('form', array('action' => 'carrinho.php?cad=1', 'method' => 'POST'), array(
                $__html->addHtml('table', array('class' => 'table table-bordered text-light'), array(
                    $__html->addHtml('thead', '', array(
                        $__html->addHtml('tr', '', array(
                            $__html->addHtml('th', array('scope' => 'col', 'class' => 'text-center'), '#'),
                            $__html->addHtml('th', array('scope' => 'col', 'class' => 'text-center form-label', 'colspan' => '3'), 'Descrição'),
                            $__html->addHtml('th', array('scope' => 'col', 'class' => 'text-center form-label'), 'Unidades'),
                            $__html->addHtml('th', array('scope' => 'col', 'class' => 'text-center form-label'), 'Preço'),
                            $__html->addHtml('th', array('scope' => 'col', 'class' => 'text-center form-label text-danger'), 'X'),
                        )),
                    )),
                    $__html->addHtml('tbody', '', array(
                        $linhas,
                    )),
                )),
                $__html->addHtml('div', array('class' => 'row mt-5 justify-content-between'), array(
                    $__html->addHtml('div', array('class' => 'col-md-4'), array(
                        $__html->addHtml('button', array('class' => 'btn btn-success font-century-button rounded-pill font-weight-bold px-3 mx-5'), ' FINALIZAR '),
                    )),
                    $__html->addHtml('div', array('class' => 'col-md-4 text-right'), array(
                        $__html->addHtml('span', array('class' => 'form-label mx-5 titulo-grande', 'id' => 'total'), "R$ " . number_format($cons_exe['total'], 2, ',', '.')),
                    )),
                )),
            )),
    ));

?>
</body>
</html>
