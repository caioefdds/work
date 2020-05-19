<?php

Class Basica {
    public function addHtml($_tag, $_args, $_conteudos, $_quebra = '0', $_linha = false) {

        $result = '<'.$_tag;

        foreach($_args as $key => $value) {
            if ($value != '') {
                $result .= ' ' . $key . '="' . $value . '"';
            } else {
                $result .= ' ' . $key;
            }
        }
        $result .= '>';

        if ($_tag <> 'input') {
            if (is_array($_conteudos)) {
                foreach ($_conteudos as $conteudo) {
                    $result .= $conteudo;
                }
            } else {
                $result .= $_conteudos;
            }
        }
        $result .= '</' . $_tag . '>';

        if($_quebra <> '') {
            $a = 0;
            while ($a < $_quebra) {
                $result .= '<BR>';
                $a++;
            }
        }

        if($_linha == true) {
            $result .= '<HR>';
        }

        return $result;
    }

    public function NavigationBar() {

        $__html = $this;

        $navigation_bar = $__html->addHtml('nav', array('class' => 'navbar navbar-expand-lg navbar-dark bg-nav'), array(
            $__html->addHtml('div', array('class' => 'container-fluid'), array(
                $__html->addHtml('a', array('class' => 'navbar-brand texto-nav-title', 'href' => 'http://127.0.0.1/work/Sales/index.php'), array(
                    $__html->addHtml('img', array('src' => 'img/Logo-Min.png', 'class' => 'img-fluid', 'width' => '170px'),''),
                )),
                $__html->addHtml('button', array(
                    'class' => 'navbar-toggler',
                    'type' => 'button',
                    'data-toggle' => 'collapse',
                    'data-target' => '#navbarNavAltMarkup',
                    'aria-controls' => 'navbarNavAltMarkup',
                    'aria-expanded' => 'false',
                    'aria-label' => 'Toggle navigation'), array(
                    $__html->addHtml('span', array('class' => 'navbar-toggler-icon'),''),
                )),
                $__html->addHtml('div', array('class' => 'collapse navbar-collapse justify-content-end', 'id' => 'navbarNavAltMarkup'), array(
                    $__html->addHtml('div', array('class' => 'navbar-nav align-content-center'), array(
                        $__html->addHtml('a', array('class' => 'nav-item nav-link texto-nav mx-4', 'href' => 'http://127.0.0.1/work/Sales/index.php#start'), 'Home'),
                        $__html->addHtml('a', array('class' => 'nav-item nav-link texto-nav mx-4', 'href' => 'http://127.0.0.1/work/Sales/index.php#products'), 'Products'),
                        $__html->addHtml('a', array('class' => 'nav-item nav-link texto-nav mx-4', 'href' => 'carrinho.php'), array(
                            $__html->addHtml('i', array('class' => 'fas fa-shopping-cart text-success'),''),
                            $__html->addHtml('span', '',' CARRINHO'),
                        )),
                        $__html->addHtml('a', array('class' => 'nav-item nav-link texto-nav mx-4', 'href' => 'login.php'), array(
                            $__html->addHtml('i', array('class' => 'fas fa-user-circle'),''),
                            $__html->addHtml('span', '',' LOGIN / CADASTRO'),
                        )),
                    )),
                )),
            )),
        ));

        echo $navigation_bar;
    }
    public function ListaNomeBefore($nome, $corte) {
        return substr($nome, 0, strpos($nome, $corte));
    }
    public function InserirJS($arq) {
        echo $this->addHtml('script', array('src' => "js/$arq.js"),'');
    }
    public function InserirCSS($arq) {
        echo $this->addHtml('link', array('rel' => 'stylesheet', 'href' => "css/$arq.css", 'type' => 'text/css'),'');
    }
    public function SWALAtualiza($_idp, $_titulo = '', $_msg = '', $_tipo = '')
    {

        $_retorno = "<script>
            Swal.fire(
                '$_titulo',
                '$_msg',
                '$_tipo'
            ).then((value) => {
                window.location.href = '$_idp';
            });</script>";

        echo $_retorno;
    }

    public function GeraBoleto($_valor_boleto, $_email, $_nome_cliente, $_end_cliente) {
            include "../boletos/boleto_bb.php";


    }
}

class Upload extends Basica{
    private $arquivo;
    private $altura;
    private $largura;
    private $pasta;

    function __construct($arquivo, $altura, $largura, $pasta){
        $this->arquivo = $arquivo;
        $this->altura  = $altura;
        $this->largura = $largura;
        $this->pasta   = $pasta;
    }

    private function getExtensao(){
        //retorna a extensao da imagem
        $_nome = explode('.', $this->arquivo['name']);
        return $extensao = strtolower(end($_nome));
    }

    private function ehImagem($extensao){
        $extensoes = array('gif', 'jpeg', 'jpg', 'png');     // extensoes permitidas
        if (in_array($extensao, $extensoes)) {
            return true;
        } else {
            return false;
        }
    }

    //largura, altura, tipo, localizacao da imagem original
    private function redimensionar($imgLarg, $imgAlt, $tipo, $img_localizacao){
        //descobrir novo tamanho sem perder a proporcao
        if ( $imgLarg > $imgAlt ){
            $novaLarg = $this->largura;
            $novaAlt = $this->altura;
            //$novaAlt = round( ($novaLarg / $imgLarg) * $imgAlt );
        }
        elseif ( $imgAlt > $imgLarg ){
            $novaLarg = $this->largura;
            $novaAlt = $this->altura;
        }
        else // altura == largura
            $novaAltura = $novaLargura = max($this->largura, $this->altura);

        //redimencionar a imagem

        //cria uma nova imagem com o novo tamanho
        $novaimagem = imagecreatetruecolor($novaLarg, $novaAlt);

        switch ($tipo){
            case 1: // gif
                $origem = imagecreatefromgif($img_localizacao);
                imagecopyresampled($novaimagem, $origem, 0, 0, 0, 0,
                    $novaLarg, $novaAlt, $imgLarg, $imgAlt);
                imagegif($novaimagem, $img_localizacao);
                break;
            case 2: // jpg
                $origem = imagecreatefromjpeg($img_localizacao);
                imagecopyresampled($novaimagem, $origem, 0, 0, 0, 0,
                    $novaLarg, $novaAlt, $imgLarg, $imgAlt);
                imagejpeg($novaimagem, $img_localizacao);
                break;
            case 3: // png
                $origem = imagecreatefrompng($img_localizacao);
                imagecopyresampled($novaimagem, $origem, 0, 0, 0, 0,
                    $novaLarg, $novaAlt, $imgLarg, $imgAlt);
                imagepng($novaimagem, $img_localizacao);
                break;
        }

        //destroi as imagens criadas
        imagedestroy($novaimagem);
        imagedestroy($origem);
    }

    public function salvar(){
        $extensao = $this->getExtensao();

        //gera um nome unico para a imagem em funcao do tempo
        $novo_nome = time() . '.' . $extensao;
        //localizacao do arquivo
        $destino = $this->pasta . $novo_nome;

        //move o arquivo
        if (!move_uploaded_file($this->arquivo['tmp_name'], $destino)){
            if ($this->arquivo['error'] == 1) {
                $_retorno['status'] = false;
                $_retorno['msg'] = "Tamanho excede o permitido";

                return $_retorno;
            }
            else {
                $_retorno['status'] = false;
                $_retorno['msg']    = "Erro " . $this->arquivo['error'];

                return $_retorno;
            }
        }

        if ($this->ehImagem($extensao) == false) {
            $_retorno['status'] = false;
            $_retorno['msg']    = "Somente extensões tipo png, jpg, gif e jpeg";

            return $_retorno;
        } else {
            //pega a largura, altura, tipo e atributo da imagem
            list($largura, $altura, $tipo, $atributo) = getimagesize($destino);

            // testa se é preciso redimensionar a imagem
            if($largura/$altura <> 1)
                $this->redimensionar($largura, $altura, $tipo, $destino);
        }

        return $novo_nome;
    }
}
?>