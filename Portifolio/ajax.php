<?php

include('conexao.php');

$email = $_POST['email'];
$nome  = $_POST['nome'];

$sql = "
		INSERT INTO
			tab_cadastro
		SET 
		 user_email = '$email',
		 user_name  = '$nome';
		";

$query = mysqli_query($conn, $sql);

echo $nome;

?>