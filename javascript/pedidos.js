

var div_todos_pedidos = document.querySelector(".todos_pedidos");
var div_aberto = document.querySelector(".serem_finalizados");
var div_cancelado_recusado = document.querySelector(".cancelado_recusado");
var div_finalizado = document.querySelector(".finalizados_cliente");



document.querySelector('#bnt_mostrar_todos').addEventListener('click', function(){
    div_todos_pedidos.style.display = 'flex';
    div_aberto.style.display = 'none';
    div_cancelado_recusado.style.display = 'none';
    div_finalizado.style.display = 'none';
})

document.querySelector('#bnt_aberto').addEventListener('click', function(){
    div_aberto.style.display = 'flex';
    div_todos_pedidos.style.display = 'none';
    div_cancelado_recusado.style.display = 'none';
    div_finalizado.style.display = 'none';
})

document.querySelector('#bnt_cancelado_recusado').addEventListener('click', function(){
    div_cancelado_recusado.style.display = 'flex';
    div_aberto.style.display = 'none';
    div_todos_pedidos.style.display = 'none';
    div_finalizado.style.display = 'none';
})

document.querySelector('#bnt_finalizado').addEventListener('click', function(){
    div_finalizado.style.display = 'flex';
    div_cancelado_recusado.style.display = 'none';
    div_aberto.style.display = 'none';
    div_todos_pedidos.style.display = 'none';
})