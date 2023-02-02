var senha = document.querySelector('.senha');
var olho_fechado = document.querySelector('.olho_fechado');
var olho_aberto = document.querySelector('.olho_aberto');

document.querySelector('.olho_fechado').addEventListener('click', function(){
    if(senha.type == 'password'){
        senha.setAttribute('type', 'text');
        olho_fechado.classList.toggle('esconder');
        olho_aberto.classList.toggle('esconder');
    }
})

document.querySelector('.olho_aberto').addEventListener('click', function(){
    if(senha.type == 'text'){
        senha.setAttribute('type', 'password');
        olho_aberto.classList.toggle('esconder');
        olho_fechado.classList.toggle('esconder');
    }
})

