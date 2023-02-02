var senha = document.querySelector('.senha');
var confirmar_senha = document.querySelector('.confirmar_senha');
var olho_fechado1 = document.querySelector('.olho_fechado1');
var olho_aberto1 = document.querySelector('.olho_aberto1');
var olho_fechado2 = document.querySelector('.olho_fechado2');
var olho_aberto2 = document.querySelector('.olho_aberto2');

//  SENHA
document.querySelector('.olho_fechado1').addEventListener('click', function(){
    if(senha.type == 'password'){
        senha.setAttribute('type', 'text');
        olho_fechado1.classList.toggle('esconder');
        olho_aberto1.classList.toggle('esconder');
    }
})
document.querySelector('.olho_aberto1').addEventListener('click', function(){
    if(senha.type == 'text'){
        senha.setAttribute('type', 'password');
        olho_aberto1.classList.toggle('esconder');
        olho_fechado1.classList.toggle('esconder');
    }
})





//  CONFIRMAR SENHA
document.querySelector('.olho_fechado2').addEventListener('click', function(){
    if(confirmar_senha.type == 'password'){
        confirmar_senha.setAttribute('type', 'text');
        olho_fechado2.classList.toggle('esconder');
        olho_aberto2.classList.toggle('esconder');
    }
})
document.querySelector('.olho_aberto2').addEventListener('click', function(){
    if(confirmar_senha.type == 'text'){
        confirmar_senha.setAttribute('type', 'password');
        olho_aberto2.classList.toggle('esconder');
        olho_fechado2.classList.toggle('esconder');
    }
})






