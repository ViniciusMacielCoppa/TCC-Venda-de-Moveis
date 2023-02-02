function msg(){
    var algo = document.querySelector('#descricao');
    if(algo.value == ''){
    alert("preencha o campo para fazer uma avaliação!");
    return true;
}else{
    alert("avaliação feita!");
    
    }
    return false;
}




//  FUNÇÃO APARA APARECER A TELA DE ADICIONAR UM NOVO MOVEL AO SISTEMA
document.querySelector('#bnt_add_novo').addEventListener('click', function(){
    document.querySelector('#add_novo').style.display = 'block';
    document.querySelector('#mostrar_moveis').style.display = 'none';
    document.querySelector('#bnt_voltar_movel').style.display = 'block';
    document.querySelector('#bnt_add_novo').style.display = 'none';
    document.querySelector('#pesquisa_moveis').style.display = 'none';
})


//  FUNÇÃO APARA VOLTAR A APARECER A LISTAGEM DE MOVEIS DO SISTEMA
document.querySelector('#bnt_voltar_movel').addEventListener('click', function(){
    document.querySelector('#add_novo').style.display = 'none';
    document.querySelector('#mostrar_moveis').style.display = 'flex';
    document.querySelector('#bnt_voltar_movel').style.display = 'none';
    document.querySelector('#bnt_add_novo').style.display = 'block';
    document.querySelector('#pesquisa_moveis').style.display = 'flex';
})

