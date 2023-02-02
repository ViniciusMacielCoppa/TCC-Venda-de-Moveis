<?php
 // Inclui o conectar.php para conectar ao BD:
 include_once 'conectaBD.php';

 session_start();

 $status = $_SESSION['status'];
 $id = $_SESSION['id'];
 $nome = $_SESSION['nome'];
 if(!$status == 'adm' && ($id == '' || $id == null)){
    header('Location: index.html');
 }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=Questrial' rel='stylesheet' type='text/css'/>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/adm_dashboard.css">
    <link rel="stylesheet" href="css/adm_avaliacoes.css">
    <title>ADMINISTRAÇÃO | Avaliações</title>
</head>
<body>

    <!-- ESSE HEADER É O CABEÇALHO DA PÁGINA -->
    <header id="header_home">
        <div class="header_titulo_site">
            <h1>MARdeira</h1>
        </div>
        <div class="header_complemento"></div>
    </header>

    <!-- ESSE MAIN É O CONTEUDO CENTRAL -->
    <main id="main_home">

        <!-- ESSA SECTION É O MENU LATERAL ESQUERDO -->
        <section id="menu_lateral">
            <header id="header_menu_lateral">
                    <!--  AQUI MOSTRARÁ A FOTO DE PERFIL DO USUÁRIO  -->
                <div class="foto_usuario">
                    <?php
                        $sql = "SELECT * FROM usuarios WHERE user_id = $id";
                        $resultado = mysqli_query($conexao, $sql);

                        $registro = mysqli_fetch_array($resultado);
                        $id = $registro['user_id'];

                        if($registro['user_foto'] == null){
                        echo"<img src='https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460__340.png'>";
                        }else{
                            echo"<img src='abrir_foto.php?id=".$id."'>";
                        }
                    ?>
                </div>
                <div class="informacao_usuario">
                    <h3><?php echo $nome; ?></h3>
                    <p>Administrador</p>
                </div>
            </header>

            <nav id="nav_menu_lateral">
                <ul>
                    <li><i class="fa-sharp fa-solid fa-house"></i><a href="adm_dashboard.php">Início</a></li>
                    <li><i class="fa-solid fa-shop"></i><a href="adm_moveis.php">Móveis</a></li>
                    <li><i class="fa-solid fa-tag"></i><a href="adm_pedidos.php">Pedidos</a></li>
                    <li><i class="fa-sharp fa-solid fa-chair"></i><a href="adm_moveis_pedidos.php">Móveis Pedidos</a></li>
                    <li><i class="fa-solid fa-star"></i><a href="adm_avaliacoes.php">Avaliações</a></li>
                    <li><i class="fa-solid fa-user"></i><a href="adm_usuarios.php">Usuários</a></li>
                    <li><i class="fa-solid fa-palette"></i><a href="#">Aparência</a></li>
                    <li><i class="fa-solid fa-gear"></i><a href="tela_configuracao.php">Configurações</a></li>
                    <li><i class="fa-solid fa-right-from-bracket"></i><a href="deslogar.php">Sair</a></li>
                </ul>
            </nav>

        </section>

        <!-- ESSA MAIN É ONDE O CONTEUDO DA PÁGINA IRÁ APARECER -->
        <main id="main_conteudo_principal">
            <header class="header_conteudo_principal">
                <h2>Avaliacoes</h2>
                <!--  FORMULÁRIO PARA PODER FAZER A BUSCA  -->
                <form action="adm_avaliacoes.php" id='pesquisa_avaliacoes' method="post" autocomplete="off">
                    <input type='text' id='pesquisa_buscar' name="buscar" placeholder='Faça uma busca...'>
                    <input type='submit' id='pesquisa_bnt' name='bnt_buscar' value='Buscar'>
                </form>
            </header>
            <main class="main_inicio">
                <div id='mostrar_avaliacoes'>
                    <?php
                        // O CÓDIGO ABAIXO IDENTIFICA SE O BOTÃO DE BUSCA FOI PRESSIONADO E EM SEGUIDA PASSARÁ...
                        //...O VALOR DA BUSCA PARA A VÁRIAVEL $BUSCAR E BUSCAR NO BANCO DE DADOS
                        if(isset($_POST['bnt_buscar'])){
                            $buscar = $_POST['buscar'];
                        }else{
                            $buscar = '';
                        }
                        // COMPARAÇÃO NO BD PEGANDO A VARIAVEL $BUSCAR E VER SE TEM ALGO PARECIDO NO BD PARA APARECER NA TELA
                        $sql = "SELECT *, DATE_FORMAT(avaliacao_dia,'%d/%m/%y') AS 'data_formatada' FROM avaliacoes A INNER JOIN usuarios U ON A.user_id = U.user_id
                        WHERE A.user_id LIKE '$buscar' OR avaliacao_id LIKE '$buscar' OR user_nome LIKE '%$buscar%' ORDER BY avaliacao_id DESC";
                        
                        $resultado = mysqli_query($conexao, $sql);
                        $linhas = mysqli_num_rows($resultado);

                        for ($i = 0; $i < $linhas; $i++){
                            $amz = mysqli_fetch_array($resultado);
                            
                            // O CÓDIGO ABAIXO CRIA UMA SECTION QUE MOSTRARÁ AS INFORMAÇÕES DAS AVALIAÇÕES
                            echo"<section id='avaliacoes_clientes_container' action='adm_excluir_avaliacao.php'>";
                            echo    "<div class='descricao_avaliacao_cliente'>";
                            echo        "<h2>Avaliação:</h2>";
                            echo        "<p>".$amz['avaliacao_descricao']."</p>";
                            echo    "</div>";
                            echo    "<div class='descricao_informacoes'>";
                            echo        "<div>";
                            echo            "<p>Nome:</p>";
                            echo            "<span>".$amz['user_nome']."</span>";
                            echo        "</div>";
                            echo        "<div>";
                            echo            "<p>User ID:</p>";
                            echo            "<span>".$amz['user_id']."</span>";
                            echo        "</div>";
                            echo        "<div>";
                            echo            "<p>Avaliado em:</p>";
                            echo            "<span>".$amz['data_formatada']."</span>";
                            echo        "</div>";
                            echo        "<div>";
                            echo            "<p>Avaliação ID:</p>";
                            echo            "<span>".$amz['avaliacao_id']."</span>";
                            echo        "</div>";
                            echo    "</div>";
                            echo    "<form id='formulario_avaliacao' action='adm_excluir_avaliacao.php' method='post'>";
                            echo        "<button id='bnt_excluir_avaliacao' name='excluir' value='".$amz['avaliacao_id']."'>Excluir⠀|⠀ID: ".$amz['avaliacao_id']."</button>";
                            echo    "</form>";
                            echo"</section>";
                        }
                    ?>
                </div>
            </main>
        </main>
    </main>
</body>
</html>