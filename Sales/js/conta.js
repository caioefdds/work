$(document).ready(function() {
    $('#informacoes').hide();
    $('#pedidos').hide();
});
function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}

function MostrarInfo() {
    $('#informacoes').show();
    $('#pedidos').hide();
}

function MostrarPedidos() {
    $('#pedidos').show();
    $('#informacoes').hide();
}

function VisualizarPedido(id) {
    window.location.href = 'pagamento.php?id='+id;
}