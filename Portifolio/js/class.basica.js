function Cadastrar_Email() {

	var dados = {};
	dados.email = $('#user_email').val();
	dados.nome = $('#user_name').val();
	var url_ajax = 'ajax.php';

	$.ajax ({
		url: url_ajax,
		type: "POST",
		data: dados

	}).done(function(resultado) {
		Swal.fire(
		  'Dados salvos!',
		  resultado + ' obrigado!',
		  'success'
		);
	});
}