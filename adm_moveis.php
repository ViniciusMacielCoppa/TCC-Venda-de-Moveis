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
    <link rel="stylesheet" href="css/adm_moveis.css">
    <title>ADMINISTRAÇÃO | Móveis</title>
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
                <h2>Gerenciar Móveis</h2>
                <form action="adm_moveis.php" id='pesquisa_moveis' method="get" autocomplete="off">
                    <input type='text' id='pesquisa_buscar' name="buscar" placeholder='Faça uma busca...'>
                    <input type='submit' id='pesquisa_bnt' name='bnt_buscar' value='Buscar'>
                </form>
                <button id='bnt_add_novo'><i class="fa-solid fa-plus"></i> Adicionar Novo</button>
                <button id='bnt_voltar_movel'><i class="fa-solid fa-arrow-left"></i> Voltar</button>
            </header>
            <main class="main_inicio">
                <div id='mostrar_moveis'>
                    <!-- AQUI MOSTRARÁ OS MOVEIS -->

                    <?php
                        // O CÓDIGO ABAIXO IDENTIFICA SE O BOTÃO DE BUSCA FOI PRESSIONADO E EM SEGUIDA PASSARÁ...
                        //...O VALOR DA BUSCA PARA A VÁRIAVEL $BUSCAR E BUSCAR NO BANCO DE DADOS
                        if(isset($_GET['bnt_buscar'])){
                            $buscar = $_GET['buscar'];
                        }else{
                            $buscar = '';
                        }
                        // COMPARAÇÃO NO BD PEGANDO A VARIAVEL $BUSCAR E VER SE TEM ALGO PARECIDO NO BD PARA APARECER NA TELA
                        $sql = "SELECT * FROM moveis WHERE movel_nome LIKE '%$buscar%' OR movel_tipo LIKE '%$buscar%'
                        OR movel_valor LIKE '%$buscar%' OR movel_descricao LIKE '%$buscar%' OR movel_id LIKE '$buscar'
                        ORDER BY movel_id DESC";
                        
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

                            echo    "<form action='adm_adicionar_moveis.php' method='post'>";
                            echo        "<button id='bnt_excluir_movel' name='excluir' value='".$registro['movel_id']."'>Excluir⠀|⠀ID: ".$registro['movel_id']."</button>";
                            echo    "</form>";
                            echo "</section>";
                        }
                    ?>
                </div>  
                
                <div id='add_novo'>
                    <!-- AQUI SERÁ O CADASTRO DE MOVEIS -->
                    <header class='adc_movel_titulo'>
                        <h2>Adicionar Móvel</h2>
                    </header>
                    <main class='formulario_add_movel'>
                        <!--  FORMULARIO PARA ADICIONAR NOVOS MOVEIS AO SISTEMAS  -->
                        <form name="adicionar_movel" action="adm_adicionar_moveis.php" method="post" id='formulario' autocomplete="off" enctype="multipart/form-data">
                            <label id='label_nome'>
                                <p>Nome</p> <input type='text' id='movel_nome' class='input_escrever' name='movel_nome' placeholder='Adicione um nome' maxlength='20'>
                            </label>
                            
                            <label id='label_tipo'>
                                <p>Tipo de Móvel</p> <input type='text' id='movel_tipo' class='input_escrever' name='movel_tipo' placeholder='Ex: Cadeira, mesa, armário' maxlength='15'>
                            </label>
                            
                            <label id='label_descricao'>
                                <p>Descrição</p> <input type='text' id='movel_descricao' class='input_escrever' name='movel_descricao' placeholder='Dê uma descrição ao móvel' maxlength='150'>
                            </label>
                            
                            <label id='label_valor'>
                                <p>Valor</p> <input type='text' id='movel_valor' class='input_escrever' name='movel_valor' placeholder='Ex: R$ 500,00' maxlength='10'>
                            </label>
                            
                            <label id='label_medidas'>
                                <p>Medidas</p> <input type='text' id='movel_medidas' class='input_escrever' name='movel_medidas' placeholder='Ex: 1,23m' maxlength='30'>
                            </label>

                            <label id='label_imagem'>
                                <spam for='movel_imagem'>Enviar arquivo</spam>
                                <input type='file' name='movel_imagem'>
                            </label>
                            
                            <div id='label_botoes'>
                                <button type='submit' name='adicionar' class='botao_formulario bnt_adicionar' value='adicionar'>Adicionar</button>
                                <button type='reset' name='limpar' class='botao_formulario bnt_limpar' value='Limpar'>Limpar</button>
                            </div>
                        </form>

                    </main>
                </div>

            </main>
        </main>
    </main>

    <script src='javascript/moveis.js'></script>
</body>
</html>