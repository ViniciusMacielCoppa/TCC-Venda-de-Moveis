<?php
 // Inclui o conectar.php para conectar ao BD:
 include_once 'conectaBD.php';

//  session_start();

//  $status = $_SESSION['status'];
//  $id = $_SESSION['id'];
//  $nome = $_SESSION['nome'];
//  if(!$status == 'cliente' && ($id == '' || $id == null)){
//     header('Location: index.html');
//  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=Questrial' rel='stylesheet' type='text/css'/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="img/mardeira_icone.png"> 
    <link rel="stylesheet" href="tela_cliente/CLIENTE_definicoes.css">
    <link rel="stylesheet" href="tela_cliente/media_cliente.css">
    
    <title>MARdeira | Configurações</title>
</head>
<body>

    <main id="main_definicoes">
        <div class="Conf_conta">
            <a href="CLIENTE_inicio.php"><i class="fa-solid fa-arrow-left"></i></a>
            <h2>Configurações da conta</h2>
        </div>

        <div class="definicoes_conta">
            <h2>Minha conta</h2>
            <div class="def_opcoes">
                <a href="#"><i class="fa-solid fa-gear"></i> Configurações</a>
                <a href="deslogar.php"><i class="fa-solid fa-right-from-bracket"></i> Sair</a>
            </div>
        </div>

        <footer id="footer_def">
            <p>Criador: Vinícius Maciel Coppa</p>
        </footer>
    </main>
    

</body>
</html>