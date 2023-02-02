<?php
    include_once('conectaBD.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href='https://fonts.googleapis.com/css?family=Questrial' rel='stylesheet' type='text/css'/>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,600;0,700;0,900;1,400;1,600;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/MARDEIRA_avaliacoes.css">
    <link rel="stylesheet" href="css/media.css">
    <link rel="icon" href="img/mardeira_icone.png"> 
    <title>MARdeira | Avaliações</title>
</head>
<body>

    <header id="header_principal">
        <div class="container70" id="container_header">
            <h1>MARdeira</h1>
            <i class="fa-solid fa-bars" id="bnt_abrir" onclick="abrir_menu()"></i>
            <i class="fa-solid fa-x esconder" id="bnt_fechar"></i>

            <nav id="navbar_principal">
                <ul>
                    <li> <a href="index.html">Início</a> </li>
                    <li class='bnt_pagina'> <a href="MARDEIRA_avaliacoes.php">Avaliações</a> </li>
                    <li> <a href="MARDEIRA_moveis.php">Móveis</a> </li>
                </ul>
            </nav>
            <nav id="navbar_login">
                <ul>
                    <li> <a href="login.html">Login</a> </li>
                    <li> <a href="cadastro.html">Cadastre-se</a> </li>
                </ul>
            </nav>
        </div>
    </header>

    <div id="menu_resposivo">
        <a href="index.html">Início</a> </li>
        <a href="MARDEIRA_avaliacoes.php">Avaliações</a>
        <a href="MARDEIRA_moveis.php">Móveis</a>
        <a href="login.html">Login</a>
        <a href="cadastro.html">Cadastre-se</a>
    </div>

    <main id="main_avaliacoes">
        <div class='container70' id='container_main_avaliacoes'>
            <?php 
                include_once 'mostrar_avaliacoes.php';
            ?>
        </div>
    </main>

    <footer id="footer_principal">
        <p>MARdeira © 2022 | Todos os direitos reservados.</p>
    </footer>
    
    <script src="javascript/menu.js"></script>
</body>
</html>