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

    if ($_SESSION['id_user'] <> '') {
        header("Location: conta.php");
    }

        $cad = $_GET['cad'];
        if ($cad == '1') {
            $_dados['email'] = $_POST['user_email'];
            $_dados['senha'] = md5($_POST['user_senha']);

            $result = $__cons->LoginCliente($_dados);

            if ($result == true) {
                $__html->SWALAtualiza('login.php', 'Login realizado com sucesso!', '', 'success');
            } else {
                $__html->SWALAtualiza('login.php', 'Falha no Login!', 'Verifique seu e-mail e senha', 'error');
            }

        }
        if ($cad == '2') {

            $_dados['nome'] = $_POST['cad_nome'];
            $_dados['cpf'] = $_POST['cad_cpf'];
            $_dados['email'] = $_POST['cad_email'];
            $_dados['senha'] = md5($_POST['cad_pass']);
            $_dados['telefone'] = $_POST['cad_telefone'];
            $_dados['cep'] = $_POST['cad_cep'];
            $_dados['id_perfil'] = '1';
            $_dados['data_mod'] = date("d-m-Y H:i:s");


            $result = $__cons->CadastraUser($_dados);

            if ($result <> '') {
                if($_SESSION['id_avulso'] <> '') {

                    $_where['id_avulso'] = $_SESSION['id_avulso'];
                    $_where['processado'] = '0';
                    $_dados_carrinho['id_user'] = $result;
                    $_dados_carrinho['id_avulso'] = '';

                   $_update_carrinho = $__cons->UpdatePDO($_dados_carrinho, 'tab_carrinho', $_where);
                }
                echo $__html->SWALAtualiza('conta.php', 'Sucesso!', 'Seu cadastro foi efetivado', 'success');
            } else {
                echo $__html->SWALAtualiza('login.php', 'ERRO!', 'Seu cadastro não foi efetivado', 'error');
            }
        }

        $__html->NavigationBar();

        $login = $__html->addHtml('div', array('class' => 'my-5 py-5 px-5 container form-dark rounded'), array(
            $__html->addHtml('form',array('method' => "POST", 'action' => 'login.php?cad=1'), array(
                $__html->addHtml('div', array('class' => 'row justify-content-md-center'), array(
                    $__html->addHtml('div', array('class' => 'col-md-12 align-self-center text-center'), array(
                        $__html->addHtml('span', array('class' => 'display-4 font-century-title'),'LOGIN'),
                        )),
                    $__html->addHtml('div', array('class' => 'col-md-6 align-self-center'), array(
                        $__html->addHtml('div',array('class' => 'form-group'), array(
                            $__html->addHtml('label', array('for' => 'user_email'),'E-mail'),
                            $__html->addHtml('input', array('type' => 'email', 'class' => 'form-control rounded-pill pl-4', 'name' => 'user_email', 'id' => 'user_email', 'placeholder' => 'Insira seu e-mail.'),''),
                        )),
                        $__html->addHtml('div',array('class' => 'form-group'), array(
                            $__html->addHtml('label', array('for' => 'user_senha'),'Senha'),
                            $__html->addHtml('input', array('type' => 'password', 'class' => 'form-control rounded-pill pl-4', 'name' => 'user_senha', 'id' => 'user_senha', 'placeholder' => 'Insira sua senha.'),''),
                        )),
                        $__html->addHtml('div', array('class' => 'col-md-12 align-self-center', 'align' => 'center'), array(
                            $__html->addHtml('span', '', 'Ainda não é cadastrado? '),
                            $__html->addHtml('a', array('href' => '#', 'data-toggle' => 'modal', 'data-target' => '#ModalCadastro'), 'clique aqui', '2'),
                            $__html->addHtml('button',array('type' => 'submit', 'class' => 'btn btn-light font-century-button rounded-pill px-5 py-2'), 'Entrar'),
                        )),
                    )),
                )),
            )),
        ));

        echo $login;
    ?>

    <div class="modal fade" id="ModalCadastro" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <form id='FormCad' method="POST" action="login.php?cad=2">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalScrollableTitle">CADASTRO</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label for="cad_email">Nome</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-address-card"></i></div>
                            </div>
                            <input type="text" class="form-control pl-3 obrigatorio" name="cad_nome" placeholder="Insira seu nome completo">
                        </div>
                        <label for="cad_email">CPF</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-user-alt"></i></div>
                            </div>
                            <input type="text" class="form-control pl-3 cpf obrigatorio" name="cad_cpf" placeholder="Insira seu CPF">
                        </div>
                        <label for="cad_email">E-mail</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-at"></i></div>
                            </div>
                            <input type="email" class="form-control pl-3 obrigatorio" name="cad_email" placeholder="Insira seu e-mail">
                        </div>
                        <label for="cad_email">Senha</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-key"></i></div>
                            </div>
                            <input type="password" class="form-control pl-3 obrigatorio" name="cad_pass" id="cad_pass" placeholder="Insira sua senha">
                        </div>
                        <label for="cad_email">Confirme a senha</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-key"></i></div>
                            </div>
                            <input type="password" class="form-control pl-3 obrigatorio" name="cad_pass_2" id="cad_pass_2" onblur="ValidaSenha()" placeholder="Insira novamente sua senha">
                        </div>
                        <label for="cad_email">Telefone</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-phone-alt"></i></div>
                            </div>
                            <input type="text" class="form-control pl-3 phone obrigatorio" name="cad_telefone" placeholder="Insira seu telefone">
                        </div>
                        <label for="cad_email">CEP</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-map-marker"></i></div>
                            </div>
                            <input type="text" class="form-control pl-3 cep obrigatorio" name="cad_cep" placeholder="Insira seu CEP">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button type="button" class="btn btn-primary" onclick="Enviar()">Cadastrar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    </body>
</html>