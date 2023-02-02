var abrir = document.querySelector('#bnt_abrir');
var fechar = document.querySelector('#bnt_fechar');
var menu = document.querySelector('#menu_resposivo');
var header = document.querySelector('#container_header');

document.querySelector('#bnt_abrir').addEventListener('click', function(){
    abrir.classList.toggle('esconder');
    fechar.classList.toggle('esconder');
    menu.style.left = '0';
})
document.querySelector('#bnt_fechar').addEventListener('click', function(){
    abrir.classList.toggle('esconder');
    fechar.classList.toggle('esconder');
    menu.style.left = '-100%';
})
document.querySelector('.bnt_contato').addEventListener('click', function(){
    abrir.classList.toggle('esconder');
    fechar.classList.toggle('esconder');
    menu.style.left = '-100%';
})
