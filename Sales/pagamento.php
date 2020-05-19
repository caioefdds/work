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
<body style="background-color: white !important; background-image: none;">
<?php

$id = $_GET['id'];

$_cons = $__cons->ConsultaBoleto($id);

$a = 0;
while ($a < $_cons['produtos']['contador']) {

    $_descrição .= $_cons['produtos'][$a]['descricao'] . "<br>";
    $_unidades += $_cons['produtos'][$a]['unidades'];

    $a++;
}



// DADOS DO BOLETO PARA O SEU CLIENTE
$dias_de_prazo_para_pagamento = 5;
$taxa_boleto = 2.50;
$data_venc = date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006";
$valor_cobrado = $_cons['produtos']['total']; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
$valor_cobrado = str_replace(",", ".", $valor_cobrado);
$valor_boleto = number_format($valor_cobrado + $taxa_boleto, 2, ',', '');

$dadosboleto["nosso_numero"] = "87654";
$dadosboleto["numero_documento"] = "27.030195.10";    // Num do pedido ou do documento
$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
$dadosboleto["data_documento"] = date("d/m/Y"); // Data de emiss?o do Boleto
$dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
$dadosboleto["valor_boleto"] = $valor_boleto;    // Valor do Boleto - REGRA: Com v?rgula e sempre com duas casas depois da virgula

// DADOS DO SEU CLIENTE
$dadosboleto["sacado"] = $_cons[0]['nome'];
$dadosboleto["endereco1"] = $_cons[0]['endereco'];
$dadosboleto["endereco2"] = $_cons[0]['estado']." -  CEP: ". $_cons[0]['cep'];

// INFORMACOES PARA O CLIENTE
$dadosboleto["demonstrativo1"] = "Pagamento de Compra na Loja CaioEFDDS";
$dadosboleto["demonstrativo2"] = "Pagamento referente a: <br>". $_descrição;
$dadosboleto["demonstrativo3"] = "Taxa bancária - R$ " . number_format($taxa_boleto, 2, ',', '');

// INSTRU??ES PARA O CAIXA
$dadosboleto["instrucoes1"] = "- Sr. Caixa, cobrar multa de 2% após o vencimento";
$dadosboleto["instrucoes2"] = "- Receber até 10 dias após o vencimento";
$dadosboleto["instrucoes3"] = "- Em caso de dúvidas entre em contato conosco: caioefdds@gmail.com";
$dadosboleto["instrucoes4"] = "&nbsp; ";

// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
$dadosboleto["quantidade"] = $_unidades;
$dadosboleto["valor_unitario"] = "";
$dadosboleto["aceite"] = "N";
$dadosboleto["especie"] = "R$";
$dadosboleto["especie_doc"] = "DM";


// ---------------------- DADOS FIXOS DE CONFIGURA??O DO SEU BOLETO --------------- //


// DADOS DA SUA CONTA - BANCO DO BRASIL
$dadosboleto["agencia"] = "9999"; // Num da agencia, sem digito
$dadosboleto["conta"] = "99999";    // Num da conta, sem digito

// DADOS PERSONALIZADOS - BANCO DO BRASIL
$dadosboleto["convenio"] = "7777777";  // Num do conv?nio - REGRA: 6 ou 7 ou 8 d?gitos
$dadosboleto["contrato"] = "999999"; // Num do seu contrato
$dadosboleto["carteira"] = "18";
$dadosboleto["variacao_carteira"] = "-019";  // Varia??o da Carteira, com tra?o (opcional)

// TIPO DO BOLETO
$dadosboleto["formatacao_convenio"] = "7"; // REGRA: 8 p/ Conv?nio c/ 8 d?gitos, 7 p/ Conv?nio c/ 7 d?gitos, ou 6 se Conv?nio c/ 6 d?gitos
$dadosboleto["formatacao_nosso_numero"] = "2"; // REGRA: Usado apenas p/ Conv?nio c/ 6 d?gitos: informe 1 se for NossoN?mero de at? 5 d?gitos ou 2 para op??o de at? 17 d?gitos


// SEUS DADOS
$dadosboleto["identificacao"] = "Boleto da empresa Caioefdds";
$dadosboleto["cpf_cnpj"] = "";
$dadosboleto["endereco"] = "";
$dadosboleto["cidade_uf"] = "";
$dadosboleto["cedente"] = "CAIOEFDDS E SERVIÇOS DIGITAIS";

// N?O ALTERAR!
include("boletos/include/funcoes_bb.php");
include("boletos/include/layout_bb.php");


?>

</body>
</html>

