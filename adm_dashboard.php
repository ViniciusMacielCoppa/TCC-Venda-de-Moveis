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
    <title>ADMINISTRAÇÃO | Dashboard</title>
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
                <h2>Dashboard</h2>
            </header>
            <main class="main_inicio">
                <div id='caixas_informacoes'>
                    <?php 
                        $sql = "SELECT COUNT(*) AS usuarios FROM usuarios";
                        $sql2 = "SELECT COUNT(*) AS avaliacoes FROM avaliacoes";
                        $sql3 = "SELECT COUNT(*) AS moveis FROM moveis";
                        $sql4 = "SELECT COUNT(*) AS pedidos FROM pedidos WHERE pedido_status LIKE 0 OR pedido_status LIKE 1 OR pedido_status LIKE 3";

                        $resultado = mysqli_query($conexao, $sql);
                        $resultado2 = mysqli_query($conexao, $sql2);
                        $resultado3 = mysqli_query($conexao, $sql3);
                        $resultado4 = mysqli_query($conexao, $sql4);
                        $linhas = mysqli_num_rows($resultado);
                        $linhas2 = mysqli_num_rows($resultado2);
                        $linhas3 = mysqli_num_rows($resultado3);
                        $linhas4 = mysqli_num_rows($resultado4);

                        for ($i = 0; $i < $linhas; $i++){
                            $usuarios = mysqli_fetch_array($resultado);

                            echo"<div class='container_qntd_usuarios'>"
                                ,"<h3>Usuários</h3>"
                                ,"<p>".$usuarios['usuarios']."</p>"
                                ,"</div>";
                        }

                        for ($i = 0; $i < $linhas2; $i++){
                            $avaliacoes = mysqli_fetch_array($resultado2);

                            echo"<div class='container_qntd_avaliacoes'>"
                                ,"<h3>Avaliações</h3>"
                                ,"<p>".$avaliacoes['avaliacoes']."</p>"
                                ,"</div>";   
                        }

                        for ($i = 0; $i < $linhas4; $i++){
                            $pedidos = mysqli_fetch_array($resultado4);
                            if($pedidos['pedidos'] == '' || $pedidos['pedidos'] == null){
                                echo"<div class='container_qntd_pedidos'>"
                                ,"<h3>Pedidos</h3>"
                                ,"<p>0</p>"
                                ,"</div>";   
                            }else{
                                echo"<div class='container_qntd_pedidos'>"
                                    ,"<h3>Pedidos</h3>"
                                    ,"<p>".$pedidos['pedidos']."</p>"
                                    ,"</div>";   
                            }
                        }

                        for ($i = 0; $i < $linhas3; $i++){
                            $moveis = mysqli_fetch_array($resultado3);
                            if($moveis['moveis'] == '' || $moveis['moveis'] == null){
                                echo"<div class='container_qntd_moveis'>"
                                ,"<h3>Móveis</h3>"
                                ,"<p>0</p>"
                                ,"</div>"; 
                            }
                            else{
                                echo"<div class='container_qntd_moveis'>"
                                ,"<h3>Móveis</h3>"
                                ,"<p>".$moveis['moveis']."</p>"
                                ,"</div>";  
                            }
                        }
                    ?>
                </div>
            </main>
        </main>
    </main>
</body>
</html>