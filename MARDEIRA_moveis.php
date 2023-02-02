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
    <link rel="stylesheet" href="css/MARDEIRA_moveis.css">
    <link rel="stylesheet" href="css/media.css">
    <link rel="icon" href="img/mardeira_icone.png"> 
    <title>MARdeira | Móveis</title>
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
                    <li> <a href="MARDEIRA_avaliacoes.php">Avaliações</a> </li>
                    <li class='bnt_pagina'> <a href="MARDEIRA_moveis.php">Móveis</a> </li>
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

    <main id="main_moveis">
        <div class='container70' id='container_main_moveis'>
            
        <!--  AQUI FICARÁ OS MÓVEIS  -->
            <div id="container_mostrar_moveis">
                <header class="header_titulo_movel">
                    <h2>Móveis feitos</h2>
                </header>

                <main class="main_mostrar_movel">

                    <div class="ficar_formulario">
                        <form id='pesquisa_moveis' method="post" autocomplete="off">
                            <input type='text' id='pesquisa_buscar' name="buscar" placeholder='Faça uma busca...'>
                            <input type='submit' id='pesquisa_bnt' name='bnt_buscar' value='Buscar'>
                        </form>
                    </div>

                    <div class='ficar_moveis'>
                            <?php
                                // O CÓDIGO ABAIXO IDENTIFICA SE O BOTÃO DE BUSCA FOI PRESSIONADO E EM SEGUIDA PASSARÁ...
                                //...O VALOR DA BUSCA PARA A VÁRIAVEL $BUSCAR E BUSCAR NO BANCO DE DADOS
                                if(isset($_POST['bnt_buscar'])){
                                    $buscar = $_POST['buscar'];
                                }else{
                                    $buscar = '';
                                }
                                // COMPARAÇÃO NO BD PEGANDO A VARIAVEL $BUSCAR E VER SE TEM ALGO PARECIDO NO BD PARA APARECER NA TELA
                                $sql = "SELECT * FROM moveis WHERE movel_nome LIKE '%$buscar%' OR movel_tipo LIKE '%$buscar%'
                                OR movel_valor LIKE '$buscar%' OR movel_descricao LIKE '%$buscar%' ORDER BY movel_id DESC";
                                
                                $resultado = mysqli_query($conexao, $sql);
                                $linhas = mysqli_num_rows($resultado);

                                while ($registro = mysqli_fetch_array($resultado)) {
                                    $id = $registro['movel_id'];

                                    echo "<section id='section_listar_moveis'>";

                                    echo    "<div id='container_imagem'>";
                                    echo        "<img src='adm_abrir_imagem_movel.php?id=".$id."'>";
                                    echo    "</div>";

                                    echo    "<div id='container_conteudo'>";
                                    echo            "<div class='conteudo_primario'>";
                                    echo                "<div class='movel_nome'>";
                                    echo                    "<h2>".$registro['movel_nome']."</h2>";
                                    echo                "</div>";
                                    echo                "<div class='movel_descricao'>";
                                    echo                    "<p>".$registro['movel_descricao']."</p>";
                                    echo                "</div>";
                                    echo            "</div>";

                                    echo            "<div id='conteudo_secundario'>";
                                    echo               "<div class='movel_tipo'>";
                                    echo                    "<h3>Tipo</h3>";
                                    echo                    "<p>".$registro['movel_tipo']."</p>";
                                    echo                "</div>";
                                    echo                "<div class='movel_valor'>";
                                    echo                    "<h3>Valor</h3>";
                                    echo                    "<p>R$ ".$registro['movel_valor']."</p>";
                                    echo                "</div>";
                                    echo                "<div class='movel_medida'>";
                                    echo                    "<h3>Medidas</h3>";
                                    echo                    "<p>".$registro['movel_medidas']."</p>";
                                    echo                "</div>";
                                    echo            "</div>";
                                    echo    "</div>";
                                    echo "</section>";
                                }
                            ?>
                        </div>
                </main>

                <footer class="footer_mostrar_movel"></footer>
            </div>

        </div>
    </main>

    <footer id="footer_principal">
        <p>MARdeira © 2022 | Todos os direitos reservados.</p>
    </footer>
    
    <script src="javascript/menu.js"></script>
</body>
</html>