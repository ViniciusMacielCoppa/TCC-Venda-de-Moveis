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
    <link rel="stylesheet" href="css/adm_usuarios.css">
    <title>Document</title>
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
                    <li><i class="fa-solid fa-gear"></i><a href="#">Configurações</a></li>
                    <li><i class="fa-solid fa-right-from-bracket"></i><a href="deslogar.php">Sair</a></li>
                </ul>
            </nav>

        </section>

        <!-- ESSA MAIN É ONDE O CONTEUDO DA PÁGINA IRÁ APARECER -->
        <main id="main_conteudo_principal">
            <header class="header_conteudo_principal">
                <h2>Lista de Usuários</h2>
                <!--  FORMULÁRIO PARA PODER FAZER A BUSCA  -->
                <form action="adm_usuarios.php" id='pesquisa_usuarios' method="post" autocomplete="off">
                    <input type='text' id='pesquisa_buscar' name="buscar" placeholder='Faça uma busca...'>
                    <input type='submit' id='pesquisa_bnt' name='bnt_buscar' value='Buscar'>
                </form>
            </header>
            <main class="main_inicio">
                <div id="container_usuarios">
                    <header class="header_container_usuarios">
                        <h4 class="id_usuario_lista">ID</h4>
                        <h4 class="nome_usuario_lista">USUÁRIO</h4>
                        <h4 class="email_usuario_lista">E-MAIL</h4>
                        <h4 class="telefone_usuario_lista">TELEFONE</h4>
                        <h4 class="status_usuario_lista">STATUS</h4>
                    </header>
                    <?php
                        // O CÓDIGO ABAIXO IDENTIFICA SE O BOTÃO DE BUSCA FOI PRESSIONADO E EM SEGUIDA PASSARÁ...
                        //...O VALOR DA BUSCA PARA A VÁRIAVEL $BUSCAR E BUSCAR NO BANCO DE DADOS
                        if(isset($_POST['bnt_buscar'])){
                            $buscar = $_POST['buscar'];
                        }else{
                            $buscar = '';
                        }
                        // COMPARAÇÃO NO BD PEGANDO A VARIAVEL $BUSCAR E VER SE TEM ALGO PARECIDO NO BD PARA APARECER NA TELA
                        $sql = "SELECT * FROM usuarios WHERE user_nome LIKE '%$buscar%' OR user_email LIKE '%$buscar%'
                        OR user_telefone LIKE '%$buscar%' OR user_status LIKE '%$buscar%' OR user_id LIKE '$buscar'";
                        
                        $resultado = mysqli_query($conexao, $sql);
                        $linhas = mysqli_num_rows($resultado);

                        for ($i = 0; $i < $linhas; $i++){
                            $amz = mysqli_fetch_array($resultado);
                            
                            // O CÓDIGO ABAIXO CRIA UMA SECTION QUE MOSTRARÁ AS INFORMAÇÕES DO USUÁRIO
                            echo "<section class='section_container_usuarios'>";
                            echo "<div class='mostrar_id_container'>".$amz['user_id']."</div>";
                            echo "<div class='mostrar_nome_container'>".$amz['user_nome']."</div>";
                            echo "<div class='mostrar_email_container'>".$amz['user_email']."</div>";
                            echo "<div class='mostrar_telefone_container'>".$amz['user_telefone']."</div>";
                            echo "<div class='mostrar_status_container'>".$amz['user_status']."</div>";
                            echo "</section>";
                        }
                    ?>
                </div>

            </main>
        </main>

    </main>
</body>
</html>