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
    <link rel="stylesheet" href="css/adm_pedidos.css">
    <link rel="stylesheet" href="css/pedidos_estilizados.css">
    <title>ADMINISTRAÇÃO | Pedidos</title>
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
                    <h2>Pedidos</h2>
                    <!--  FORMULÁRIO PARA PODER FAZER A BUSCA  -->
                    <form action="adm_pedidos.php" id='pesquisa_pedidos' method="post" autocomplete="off">
                        <input type='text' id='pesquisa_buscar' name="buscar_algo" placeholder='Faça uma busca...'>
                        <input type='submit' id='pesquisa_bnt' name='bnt_buscar' value='Buscar'>
                    </form>
            </header>
            <main class="main_inicio">
                <div id="container_pedidos">
                    <?php
                        // O CÓDIGO ABAIXO IDENTIFICA SE O BOTÃO DE BUSCA FOI PRESSIONADO E EM SEGUIDA PASSARÁ...
                        //...O VALOR DA BUSCA PARA A VÁRIAVEL $BUSCAR E BUSCAR NO BANCO DE DADOS
                        if(isset($_POST['bnt_buscar'])){
                            $buscar = $_POST['buscar_algo'];

                            if($buscar == 'aberto'){
                                $buscar = 0;
                                $sql = "SELECT *, DATE_FORMAT(pedido_dia,'%d/%m/%y') AS 'data_formatada' FROM usuarios U
                                INNER JOIN pedidos P ON U.user_id = P.user_id WHERE pedido_status LIKE '%$buscar%' ORDER BY pedido_id DESC";
                                
                                $resultado = mysqli_query($conexao, $sql);
                                $linhas = mysqli_num_rows($resultado);

                                for ($i = 0; $i < $linhas; $i++){
                                    $amz = mysqli_fetch_array($resultado);
                                    $status = $amz['pedido_status'];
                                    $referencia = $amz['pedido_referencia'];

                                //  PEDIDO FEITO RECENTEMENTE PELO CLIENTE
                                    if($status == 0 AND $referencia == null){
                                        echo"<form id='formulario_pedido_adm_aceitar' action='cadastrar_pedido.php' method='post'>";
                                        echo    "<div class='descricao_pedido_adm_aceitar'>";
                                        echo        "<h2>Pedido:</h2>";
                                        echo        "<p>".$amz['pedido_descricao']."</p>";
                                        echo    "</div>";
                                        echo    "<div class='info_pedido_adm_aceitar'>";
                                        echo        "<div>";
                                        echo            "<p>Nome:</p>";
                                        echo            "<span>".$amz['user_nome']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>User ID:</p>";
                                        echo            "<span>".$amz['user_id']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Aberto em:</p>";
                                        echo            "<span>".$amz['data_formatada']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Pedido ID:</p>";
                                        echo            "<span>".$amz['pedido_id']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Status do pedido:</p>";
                                        echo            "<span class='status_pedido_adm_aceitar'>Aberto</span>";
                                        echo        "</div>";
                                        echo    "</div>";

                                        echo    "<textarea class='resultado_adm' name='resposta_adm' maxlength='250' rows='5' placeholder='Deixe seu comentário...'></textarea>";
                                        echo    "<input type='hidden' name='pedido_id' value='".$amz['pedido_id']."'>";
                                        echo    "<input type='text' class='preco_adm_aceitar' name='valor' maxlength='10' placeholder='Digite um preço'>";
                                        echo    "<div class='botoes_aceitar_recusar'>";
                                        echo        "<input type='submit' class='bnt_aceitar bnt_resultado' name='adm_aceitar_pedido' value='Aceitar Pedido'>";
                                        echo        "<input type='submit' class='bnt_recusar bnt_resultado' name='adm_recusar_pedido' value='Recusar Pedido'>";
                                        echo    "</div>";
                                        echo"</form>";
                                    }
                                }
                            }
                            elseif($buscar == 'aceito'){
                                $buscar = 1;
                                $sql = "SELECT *, DATE_FORMAT(pedido_dia,'%d/%m/%y') AS 'data_formatada' FROM usuarios U INNER JOIN pedidos P ON U.user_id = P.user_id
                                WHERE pedido_status LIKE '%$buscar%' ORDER BY pedido_id DESC";

                                $resultado = mysqli_query($conexao, $sql);
                                $linhas = mysqli_num_rows($resultado);

                                for ($i = 0; $i < $linhas; $i++){
                                    $amz = mysqli_fetch_array($resultado);
                                    $status = $amz['pedido_status'];
                                    $referencia = $amz['pedido_referencia'];

                                //  PEDIDO ACEITO PELO ADM
                                    if($status == 1 AND $referencia == null){
                                        echo"<form id='formulario_pedido_adm_aceitou' action='cadastrar_pedido.php' method='post'>";
                                        echo    "<div class='descricao_pedido_adm_aceitou'>";
                                        echo        "<h2>Pedido:</h2>";
                                        echo        "<p>".$amz['pedido_descricao']."</p>";
                                        echo    "</div>";
                                        echo    "<div class='reposta_adm_aceitou'>";
                                        echo        "<h2>Resultado da análise:</h2>";
                                        echo        "<p>".$amz['pedido_resposta_adm']."</p>";
                                        echo    "</div>";
                                        echo    "<div class='info_pedido'>";
                                        echo        "<div>";
                                        echo            "<p>Nome:</p>";
                                        echo            "<span>".$amz['user_nome']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>User ID:</p>";
                                        echo            "<span>".$amz['user_id']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Aberto em:</p>";
                                        echo            "<span>".$amz['data_formatada']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Pedido ID:</p>";
                                        echo            "<span>".$amz['pedido_id']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Valor:</p>";
                                        echo            "<span class='info_pedido_adm_aceitou'>R$ ".$amz['pedido_valor']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Status do pedido:</p>";
                                        echo            "<span class='status_pedido_adm_aceitou'>Aceito</span>";
                                        echo        "</div>";
                                        echo    "</div>";
                                        echo"</form>";
                                    }
                                }
                            }
                            elseif($buscar == 'andamento'){
                                $buscar = 3;
                                $sql = "SELECT *, DATE_FORMAT(pedido_dia,'%d/%m/%y') AS 'data_formatada' FROM usuarios U INNER JOIN pedidos P ON U.user_id = P.user_id
                                WHERE pedido_status LIKE '%$buscar%' OR pedido_status LIKE '%$buscar%' ORDER BY pedido_id DESC";

                                $resultado = mysqli_query($conexao, $sql);
                                $linhas = mysqli_num_rows($resultado);

                                for ($i = 0; $i < $linhas; $i++){
                                    $amz = mysqli_fetch_array($resultado);
                                    $status = $amz['pedido_status'];
                                    $referencia = $amz['pedido_referencia'];

                                //  PEDIDO ACEITO PELO CLIENTE
                                    if ($status == 3 AND $referencia == null) {
                                        echo"<form id='formulario_pedido_cliente_aceitou' action='cadastrar_pedido.php' method='post'>";
                                        echo    "<div class='descricao_pedido_cliente_aceitou'>";
                                        echo        "<h2>Pedido:</h2>";
                                        echo        "<p>".$amz['pedido_descricao']."</p>";
                                        echo    "</div>";
                                        echo    "<div class='reposta_adm_cliente_aceitou'>";
                                        echo        "<h2>Resultado da análise:</h2>";
                                        echo        "<p>".$amz['pedido_resposta_adm']."</p>";
                                        echo    "</div>";
                                        echo    "<div class='reposta_cliente_cliente_aceitou'>";
                                        echo        "<h2>Retorno cliente:</h2>";
                                        echo        "<p>".$amz['pedido_resposta_cliente']."</p>";
                                        echo    "</div>";
                                        echo    "<div class='info_pedido_andamento'>";
                                        echo        "<div>";
                                        echo            "<p>Nome:</p>";
                                        echo            "<span>".$amz['user_nome']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>User ID:</p>";
                                        echo            "<span>".$amz['user_id']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Aberto em:</p>";
                                        echo            "<span>".$amz['data_formatada']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Pedido ID:</p>";
                                        echo            "<span>".$amz['pedido_id']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Valor:</p>";
                                        echo            "<span class='info_pedido_cliente_aceitou'>R$ ".$amz['pedido_valor']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Status do pedido:</p>";
                                        echo            "<span class='status_pedido_cliente_aceitou'>Em andamento</span>";
                                        echo        "</div>";
                                        echo        "</div>";
                                        echo        "<div class='botoes_aceitar_recusar'>";
                                        echo            "<input type='hidden' name='pedido_id' value='".$amz['pedido_id']."'>";
                                        echo            "<input type='submit' class='bnt_aceitar bnt_resultado' name='finalizar_pedido' value='Finalizar Pedido'>";
                                        echo            "<input type='submit' class='bnt_recusar bnt_resultado' name='cancelar_pedido' value='Cancelar Pedido'>";
                                        echo    "</div>";
                                        echo"</form>";
                                    } 
                                }
                            }
                            elseif($buscar == 'recusado'){
                                $buscar = 2;
                                $sql = "SELECT *, DATE_FORMAT(pedido_dia,'%d/%m/%y') AS 'data_formatada' FROM usuarios U INNER JOIN pedidos P ON U.user_id = P.user_id
                                WHERE pedido_status LIKE '%$buscar%'ORDER BY pedido_id DESC";

                                $resultado = mysqli_query($conexao, $sql);
                                $linhas = mysqli_num_rows($resultado);

                                for ($i = 0; $i < $linhas; $i++){
                                    $amz = mysqli_fetch_array($resultado);
                                    $status = $amz['pedido_status'];
                                    $referencia = $amz['pedido_referencia'];

                                //  PEDIDO RECUSADO PELO ADM
                                    if($status == 2 AND $referencia == null){
                                        echo"<form id='formulario_pedido_adm_recusar'>";
                                        echo    "<div class='descricao_pedido_adm_recusar'>";
                                        echo        "<h2>Pedido:</h2>";
                                        echo           "<p>".$amz['pedido_descricao']."</p>";
                                        echo    "</div>";
                                        echo    "<div class='reposta_adm_recusar'>";
                                        echo        "<h2>Resultado da análise:</h2>";
                                        echo        "<p>".$amz['pedido_resposta_adm']."</p>";
                                        echo    "</div>";
                                        echo    "<div class='info_pedido_adm_recusar'>";
                                        echo        "<div>";
                                        echo            "<p>Nome:</p>";
                                        echo            "<span>".$amz['user_nome']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>User ID:</p>";
                                        echo            "<span>".$amz['user_id']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Aberto em:</p>";
                                        echo            "<span>".$amz['data_formatada']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Pedido ID:</p>";
                                        echo            "<span>".$amz['pedido_id']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Status do pedido:</p>";
                                        echo            "<span class='status_pedido_adm_recusar'>Recusado</span>";
                                        echo        "</div>";
                                        echo    "</div>";
                                        echo"</form>";
                                    }
                                }

                                $buscar = 4;
                                $sql = "SELECT *, DATE_FORMAT(pedido_dia,'%d/%m/%y') AS 'data_formatada' FROM usuarios U INNER JOIN pedidos P ON U.user_id = P.user_id
                                WHERE pedido_status LIKE '%$buscar%'ORDER BY pedido_id DESC";

                                $resultado = mysqli_query($conexao, $sql);
                                $linhas = mysqli_num_rows($resultado);

                                for ($i = 0; $i < $linhas; $i++){
                                    $amz = mysqli_fetch_array($resultado);
                                    $status = $amz['pedido_status'];
                                    $referencia = $amz['pedido_referencia'];

                                    //  PEDIDO RECUSADO PELO CLIENTE
                                    if($status == 4 AND $referencia == null){
                                        echo"<form id='formulario_pedido_recusado'>";
                                        echo    "<div class='descricao_pedido_recusado'>";
                                        echo        "<h2>Pedido:</h2>";
                                        echo        "<p>".$amz['pedido_descricao']."</p>";
                                        echo    "</div>";
                                        echo    "<div class='reposta_adm_recusado'>";
                                        echo        "<h2>Resultado da análise:</h2>";
                                        echo        "<p>".$amz['pedido_resposta_adm']."</p>";
                                        echo    "</div>";
                                        echo    "<div class='reposta_cliente_recusado'>";
                                        echo        "<h2>Retorno cliente:</h2>";
                                        echo        "<p>".$amz['pedido_resposta_cliente']."</p>";
                                        echo    "</div>";
                                        echo    "<div class='info_pedido'>";
                                        echo        "<div>";
                                        echo            "<p>Nome:</p>";
                                        echo            "<span>".$amz['user_nome']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Aberto em:</p>";
                                        echo            "<span>".$amz['data_formatada']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Pedido ID:</p>";
                                        echo            "<span>".$amz['pedido_id']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Valor:</p>";
                                        echo            "<span class='info_pedido_recusado'>R$ ".$amz['pedido_valor']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Status do pedido:</p>";
                                        echo            "<span class='status_pedido_recusado'>Recusado</span>";
                                        echo        "</div>";
                                        echo    "</div>";
                                        echo"</form>";
                                    }
                                }
                            }
                            elseif($buscar == 'finalizado'){
                                $buscar = 5;
                                $sql = "SELECT *, DATE_FORMAT(pedido_dia,'%d/%m/%y') AS 'data_formatada' FROM usuarios U INNER JOIN pedidos P ON U.user_id = P.user_id
                                WHERE pedido_status LIKE '%$buscar%' ORDER BY pedido_id DESC";

                                $resultado = mysqli_query($conexao, $sql);
                                $linhas = mysqli_num_rows($resultado);

                                for ($i = 0; $i < $linhas; $i++){
                                    $amz = mysqli_fetch_array($resultado);
                                    $status = $amz['pedido_status'];
                                    $referencia = $amz['pedido_referencia'];

                                    //  PEDIDO FINALIZADO PELO ADM
                                    if($status == 5 AND $referencia == null){
                                        echo"<form id='formulario_pedido_finalizado'>";
                                        echo    "<div class='descricao_pedido_finalizado'>";
                                        echo        "<h2>Pedido:</h2>";
                                        echo        "<p>".$amz['pedido_descricao']."</p>";
                                        echo    "</div>";
                                        echo    "<div class='reposta_adm_finalizado'>";
                                        echo        "<h2>Resultado da análise:</h2>";
                                        echo        "<p>".$amz['pedido_resposta_adm']."</p>";
                                        echo    "</div>";
                                        echo    "<div class='reposta_cliente_finalizado'>";
                                        echo        "<h2>Retorno cliente:</h2>";
                                        echo        "<p>".$amz['pedido_resposta_cliente']."</p>";
                                        echo    "</div>";
                                        echo    "<div class='info_pedido'>";
                                        echo        "<div>";
                                        echo            "<p>Nome:</p>";
                                        echo            "<span>".$amz['user_nome']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>User ID:</p>";
                                        echo            "<span>".$amz['user_id']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Aberto em:</p>";
                                        echo            "<span>".$amz['data_formatada']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Pedido ID:</p>";
                                        echo            "<span>".$amz['pedido_id']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Valor:</p>";
                                        echo            "<span class='info_pedido_finalizado'>R$ ".$amz['pedido_valor']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Status do pedido:</p>";
                                        echo            "<span class='status_pedido_finalizado'>Finalizado</span>";
                                        echo        "</div>";
                                        echo    "</div>";
                                        echo"</form>";
                                    }
                                }
                            }
                            elseif($buscar == 'cancelado'){
                                $buscar = 6;
                                $sql = "SELECT *, DATE_FORMAT(pedido_dia,'%d/%m/%y') AS 'data_formatada' FROM usuarios U INNER JOIN pedidos P ON U.user_id = P.user_id
                                WHERE pedido_status LIKE '%$buscar%' ORDER BY pedido_id DESC";

                                $resultado = mysqli_query($conexao, $sql);
                                $linhas = mysqli_num_rows($resultado);

                                for ($i = 0; $i < $linhas; $i++){
                                    $amz = mysqli_fetch_array($resultado);
                                    $status = $amz['pedido_status'];
                                    $referencia = $amz['pedido_referencia'];

                                //  PEDIDO FINALIZADO PELO ADM
                                    if($status == 6 AND $referencia == null){
                                        echo"<form id='formulario_pedido_recusado'>";
                                        echo    "<div class='descricao_pedido_recusado'>";
                                        echo        "<h2>Pedido:</h2>";
                                        echo        "<p>".$amz['pedido_descricao']."</p>";
                                        echo    "</div>";
                                        echo    "<div class='reposta_adm_recusado'>";
                                        echo        "<h2>Resultado da análise:</h2>";
                                        echo        "<p>".$amz['pedido_resposta_adm']."</p>";
                                        echo    "</div>";
                                        echo    "<div class='reposta_cliente_recusado'>";
                                        echo        "<h2>Retorno cliente:</h2>";
                                        echo        "<p>".$amz['pedido_resposta_cliente']."</p>";
                                        echo    "</div>";
                                        echo    "<div class='info_pedido'>";
                                        echo        "<div>";
                                        echo            "<p>Nome:</p>";
                                        echo            "<span>".$amz['user_nome']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>User ID:</p>";
                                        echo            "<span>".$amz['user_id']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Aberto em:</p>";
                                        echo            "<span>".$amz['data_formatada']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Pedido ID:</p>";
                                        echo            "<span>".$amz['pedido_id']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Valor:</p>";
                                        echo            "<span class='info_pedido_recusado'>R$ ".$amz['pedido_valor']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Status do pedido:</p>";
                                        echo            "<span class='status_pedido_recusado'>Cancelado</span>";
                                        echo        "</div>";
                                        echo    "</div>";
                                        echo"</form>";
                                    }
                                }
                            }
                            else{
                                $buscar = $_POST['buscar_algo'];

                                $sql = "SELECT *, DATE_FORMAT(pedido_dia,'%d/%m/%y') AS 'data_formatada' FROM usuarios U INNER JOIN pedidos P ON U.user_id = P.user_id 
                                WHERE pedido_id LIKE '$buscar' OR user_nome LIKE '%$buscar%' ORDER BY pedido_id DESC"; //AQUI TINHA UM PARAMETRO PARA BUSCAR PELO STATUS TBM, SE DER ERRO, COLOCA  = user_nome LIKE '%$buscar%'
                                
                                $resultado = mysqli_query($conexao, $sql);
                                $linhas = mysqli_num_rows($resultado);

                                for ($i = 0; $i < $linhas; $i++){
                                    $amz = mysqli_fetch_array($resultado);
                                    $status = $amz['pedido_status'];
                                    $referencia = $amz['pedido_referencia'];
                                    
                                //  PEDIDO FEITO RECENTEMENTE PELO CLIENTE
                                    if($status == 0 AND $referencia == null){
                                        echo"<form id='formulario_pedido_adm_aceitar' action='cadastrar_pedido.php' method='post'>";
                                        echo    "<div class='descricao_pedido_adm_aceitar'>";
                                        echo        "<h2>Pedido:</h2>";
                                        echo        "<p>".$amz['pedido_descricao']."</p>";
                                        echo    "</div>";
                                        echo    "<div class='info_pedido_adm_aceitar'>";
                                        echo        "<div>";
                                        echo            "<p>Nome:</p>";
                                        echo            "<span>".$amz['user_nome']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>User ID:</p>";
                                        echo            "<span>".$amz['user_id']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Aberto em:</p>";
                                        echo            "<span>".$amz['data_formatada']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Pedido ID:</p>";
                                        echo            "<span>".$amz['pedido_id']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Status do pedido:</p>";
                                        echo            "<span class='status_pedido_adm_aceitar'>Aberto</span>";
                                        echo        "</div>";
                                        echo    "</div>";

                                        echo    "<textarea class='resultado_adm' name='resposta_adm' maxlength='250' rows='5' placeholder='Deixe seu comentário...'></textarea>";
                                        echo    "<input type='hidden' name='pedido_id' value='".$amz['pedido_id']."'>";
                                        echo    "<input type='text' class='preco_adm_aceitar' name='valor' maxlength='10' placeholder='Digite um preço'>";
                                        echo    "<div class='botoes_aceitar_recusar'>";
                                        echo        "<input type='submit' class='bnt_aceitar bnt_resultado' name='adm_aceitar_pedido' value='Aceitar Pedido'>";
                                        echo        "<input type='submit' class='bnt_recusar bnt_resultado' name='adm_recusar_pedido' value='Recusar Pedido'>";
                                        echo    "</div>";
                                        echo"</form>";
                                    }

                                //  PEDIDO ACEITO PELO ADM
                                    elseif($status == 1 AND $referencia == null){
                                        echo"<form id='formulario_pedido_adm_aceitou' action='cadastrar_pedido.php' method='post'>";
                                        echo    "<div class='descricao_pedido_adm_aceitou'>";
                                        echo        "<h2>Pedido:</h2>";
                                        echo        "<p>".$amz['pedido_descricao']."</p>";
                                        echo    "</div>";
                                        echo    "<div class='reposta_adm_aceitou'>";
                                        echo        "<h2>Resultado da análise:</h2>";
                                        echo        "<p>".$amz['pedido_resposta_adm']."</p>";
                                        echo    "</div>";
                                        echo    "<div class='info_pedido'>";
                                        echo        "<div>";
                                        echo            "<p>Nome:</p>";
                                        echo            "<span>".$amz['user_nome']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>User ID:</p>";
                                        echo            "<span>".$amz['user_id']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Aberto em:</p>";
                                        echo            "<span>".$amz['data_formatada']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Pedido ID:</p>";
                                        echo            "<span>".$amz['pedido_id']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Valor:</p>";
                                        echo            "<span class='info_pedido_adm_aceitou'>R$ ".$amz['pedido_valor']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Status do pedido:</p>";
                                        echo            "<span class='status_pedido_adm_aceitou'>Aceito</span>";
                                        echo        "</div>";
                                        echo    "</div>";
                                        echo"</form>";
                                    }

                                //  PEDIDO RECUSADO PELO ADM
                                    elseif($status == 2 AND $referencia == null){
                                        echo"<form id='formulario_pedido_adm_recusar'>";
                                        echo    "<div class='descricao_pedido_adm_recusar'>";
                                        echo        "<h2>Pedido:</h2>";
                                        echo           "<p>".$amz['pedido_descricao']."</p>";
                                        echo    "</div>";
                                        echo    "<div class='reposta_adm_recusar'>";
                                        echo        "<h2>Resultado da análise:</h2>";
                                        echo        "<p>".$amz['pedido_resposta_adm']."</p>";
                                        echo    "</div>";
                                        echo    "<div class='info_pedido_adm_recusar'>";
                                        echo        "<div>";
                                        echo            "<p>Nome:</p>";
                                        echo            "<span>".$amz['user_nome']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>User ID:</p>";
                                        echo            "<span>".$amz['user_id']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Aberto em:</p>";
                                        echo            "<span>".$amz['data_formatada']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Pedido ID:</p>";
                                        echo            "<span>".$amz['pedido_id']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Status do pedido:</p>";
                                        echo            "<span class='status_pedido_adm_recusar'>Recusado</span>";
                                        echo        "</div>";
                                        echo    "</div>";
                                        echo"</form>";
                                    }

                                //  PEDIDO ACEITO PELO CLIENTE
                                    elseif ($status == 3 AND $referencia == null) {
                                        echo"<form id='formulario_pedido_cliente_aceitou' action='cadastrar_pedido.php' method='post'>";
                                        echo    "<div class='descricao_pedido_cliente_aceitou'>";
                                        echo        "<h2>Pedido:</h2>";
                                        echo        "<p>".$amz['pedido_descricao']."</p>";
                                        echo    "</div>";
                                        echo    "<div class='reposta_adm_cliente_aceitou'>";
                                        echo        "<h2>Resultado da análise:</h2>";
                                        echo        "<p>".$amz['pedido_resposta_adm']."</p>";
                                        echo    "</div>";
                                        echo    "<div class='reposta_cliente_cliente_aceitou'>";
                                        echo        "<h2>Retorno cliente:</h2>";
                                        echo        "<p>".$amz['pedido_resposta_cliente']."</p>";
                                        echo    "</div>";
                                        echo    "<div class='info_pedido_andamento'>";
                                        echo        "<div>";
                                        echo            "<p>Nome:</p>";
                                        echo            "<span>".$amz['user_nome']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>User ID:</p>";
                                        echo            "<span>".$amz['user_id']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Aberto em:</p>";
                                        echo            "<span>".$amz['data_formatada']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Pedido ID:</p>";
                                        echo            "<span>".$amz['pedido_id']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Valor:</p>";
                                        echo            "<span class='info_pedido_cliente_aceitou'>R$ ".$amz['pedido_valor']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Status do pedido:</p>";
                                        echo            "<span class='status_pedido_cliente_aceitou'>Em andamento</span>";
                                        echo        "</div>";
                                        echo        "</div>";
                                        echo        "<div class='botoes_aceitar_recusar'>";
                                        echo            "<input type='hidden' name='pedido_id' value='".$amz['pedido_id']."'>";
                                        echo            "<input type='submit' class='bnt_aceitar bnt_resultado' name='finalizar_pedido' value='Finalizar Pedido'>";
                                        echo            "<input type='submit' class='bnt_recusar bnt_resultado' name='cancelar_pedido' value='Cancelar Pedido'>";
                                        echo    "</div>";
                                        echo"</form>";
                                    }    

                                //  PEDIDO RECUSADO PELO CLIENTE
                                    elseif($status == 4 AND $referencia == null){
                                        echo"<form id='formulario_pedido_recusado'>";
                                        echo    "<div class='descricao_pedido_recusado'>";
                                        echo        "<h2>Pedido:</h2>";
                                        echo        "<p>".$amz['pedido_descricao']."</p>";
                                        echo    "</div>";
                                        echo    "<div class='reposta_adm_recusado'>";
                                        echo        "<h2>Resultado da análise:</h2>";
                                        echo        "<p>".$amz['pedido_resposta_adm']."</p>";
                                        echo    "</div>";
                                        echo    "<div class='reposta_cliente_recusado'>";
                                        echo        "<h2>Retorno cliente:</h2>";
                                        echo        "<p>".$amz['pedido_resposta_cliente']."</p>";
                                        echo    "</div>";
                                        echo    "<div class='info_pedido'>";
                                        echo        "<div>";
                                        echo            "<p>Nome:</p>";
                                        echo            "<span>".$amz['user_nome']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>User ID:</p>";
                                        echo            "<span>".$amz['user_id']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Aberto em:</p>";
                                        echo            "<span>".$amz['data_formatada']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Pedido ID:</p>";
                                        echo            "<span>".$amz['pedido_id']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Valor:</p>";
                                        echo            "<span class='info_pedido_recusado'>R$ ".$amz['pedido_valor']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Status do pedido:</p>";
                                        echo            "<span class='status_pedido_recusado'>Recusado</span>";
                                        echo        "</div>";
                                        echo    "</div>";
                                        echo"</form>";
                                    }

                                //  PEDIDO FINALIZADO PELO ADM
                                    elseif($status == 5 AND $referencia == null){
                                        echo"<form id='formulario_pedido_finalizado'>";
                                        echo    "<div class='descricao_pedido_finalizado'>";
                                        echo        "<h2>Pedido:</h2>";
                                        echo        "<p>".$amz['pedido_descricao']."</p>";
                                        echo    "</div>";
                                        echo    "<div class='reposta_adm_finalizado'>";
                                        echo        "<h2>Resultado da análise:</h2>";
                                        echo        "<p>".$amz['pedido_resposta_adm']."</p>";
                                        echo    "</div>";
                                        echo    "<div class='reposta_cliente_finalizado'>";
                                        echo        "<h2>Retorno cliente:</h2>";
                                        echo        "<p>".$amz['pedido_resposta_cliente']."</p>";
                                        echo    "</div>";
                                        echo    "<div class='info_pedido'>";
                                        echo        "<div>";
                                        echo            "<p>Nome:</p>";
                                        echo            "<span>".$amz['user_nome']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>User ID:</p>";
                                        echo            "<span>".$amz['user_id']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Aberto em:</p>";
                                        echo            "<span>".$amz['data_formatada']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Pedido ID:</p>";
                                        echo            "<span>".$amz['pedido_id']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Valor:</p>";
                                        echo            "<span class='info_pedido_finalizado'>R$ ".$amz['pedido_valor']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Status do pedido:</p>";
                                        echo            "<span class='status_pedido_finalizado'>Finalizado</span>";
                                        echo        "</div>";
                                        echo    "</div>";
                                        echo"</form>";
                                    } 

                                    //  PEDIDO FINALIZADO PELO ADM
                                    elseif($status == 6 AND $referencia == null){
                                        echo"<form id='formulario_pedido_recusado'>";
                                        echo    "<div class='descricao_pedido_recusado'>";
                                        echo        "<h2>Pedido:</h2>";
                                        echo        "<p>".$amz['pedido_descricao']."</p>";
                                        echo    "</div>";
                                        echo    "<div class='reposta_adm_recusado'>";
                                        echo        "<h2>Resultado da análise:</h2>";
                                        echo        "<p>".$amz['pedido_resposta_adm']."</p>";
                                        echo    "</div>";
                                        echo    "<div class='reposta_cliente_recusado'>";
                                        echo        "<h2>Retorno cliente:</h2>";
                                        echo        "<p>".$amz['pedido_resposta_cliente']."</p>";
                                        echo    "</div>";
                                        echo    "<div class='info_pedido'>";
                                        echo        "<div>";
                                        echo            "<p>Nome:</p>";
                                        echo            "<span>".$amz['user_nome']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>User ID:</p>";
                                        echo            "<span>".$amz['user_id']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Aberto em:</p>";
                                        echo            "<span>".$amz['data_formatada']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Pedido ID:</p>";
                                        echo            "<span>".$amz['pedido_id']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Valor:</p>";
                                        echo            "<span class='info_pedido_recusado'>R$ ".$amz['pedido_valor']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Status do pedido:</p>";
                                        echo            "<span class='status_pedido_recusado'>Cancelado</span>";
                                        echo        "</div>";
                                        echo    "</div>";
                                        echo"</form>";
                                    }
                                } 
                            }
                        }else{
                            $sql = "SELECT *, DATE_FORMAT(pedido_dia,'%d/%m/%y') AS 'data_formatada' FROM usuarios U INNER JOIN pedidos P ON U.user_id = P.user_id ORDER BY pedido_id DESC"; //AQUI TINHA UM PARAMETRO PARA BUSCAR PELO STATUS TBM, SE DER ERRO, COLOCA  = user_nome LIKE '%$buscar%'
                                
                                $resultado = mysqli_query($conexao, $sql);
                                $linhas = mysqli_num_rows($resultado);

                                for ($i = 0; $i < $linhas; $i++){
                                    $amz = mysqli_fetch_array($resultado);
                                    $status = $amz['pedido_status'];
                                    $referencia = $amz['pedido_referencia'];
                                    
                                //  PEDIDO FEITO RECENTEMENTE PELO CLIENTE
                                    if($status == 0 AND $referencia == null){
                                        echo"<form id='formulario_pedido_adm_aceitar' action='cadastrar_pedido.php' method='post'>";
                                        echo    "<div class='descricao_pedido_adm_aceitar'>";
                                        echo        "<h2>Pedido:</h2>";
                                        echo        "<p>".$amz['pedido_descricao']."</p>";
                                        echo    "</div>";
                                        echo    "<div class='info_pedido_adm_aceitar'>";
                                        echo        "<div>";
                                        echo            "<p>Nome:</p>";
                                        echo            "<span>".$amz['user_nome']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>User ID:</p>";
                                        echo            "<span>".$amz['user_id']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Aberto em:</p>";
                                        echo            "<span>".$amz['data_formatada']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Pedido ID:</p>";
                                        echo            "<span>".$amz['pedido_id']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Status do pedido:</p>";
                                        echo            "<span class='status_pedido_adm_aceitar'>Aberto</span>";
                                        echo        "</div>";
                                        echo    "</div>";

                                        echo    "<textarea class='resultado_adm' name='resposta_adm' maxlength='250' rows='5' placeholder='Deixe seu comentário...'></textarea>";
                                        echo    "<input type='hidden' name='pedido_id' value='".$amz['pedido_id']."'>";
                                        echo    "<input type='text' class='preco_adm_aceitar' name='valor' maxlength='10' placeholder='Digite um preço'>";
                                        echo    "<div class='botoes_aceitar_recusar'>";
                                        echo        "<input type='submit' class='bnt_aceitar bnt_resultado' name='adm_aceitar_pedido' value='Aceitar Pedido'>";
                                        echo        "<input type='submit' class='bnt_recusar bnt_resultado' name='adm_recusar_pedido' value='Recusar Pedido'>";
                                        echo    "</div>";
                                        echo"</form>";
                                    }

                                //  PEDIDO ACEITO PELO ADM
                                    elseif($status == 1 AND $referencia == null){
                                        echo"<form id='formulario_pedido_adm_aceitou' action='cadastrar_pedido.php' method='post'>";
                                        echo    "<div class='descricao_pedido_adm_aceitou'>";
                                        echo        "<h2>Pedido:</h2>";
                                        echo        "<p>".$amz['pedido_descricao']."</p>";
                                        echo    "</div>";
                                        echo    "<div class='reposta_adm_aceitou'>";
                                        echo        "<h2>Resultado da análise:</h2>";
                                        echo        "<p>".$amz['pedido_resposta_adm']."</p>";
                                        echo    "</div>";
                                        echo    "<div class='info_pedido'>";
                                        echo        "<div>";
                                        echo            "<p>Nome:</p>";
                                        echo            "<span>".$amz['user_nome']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>User ID:</p>";
                                        echo            "<span>".$amz['user_id']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Aberto em:</p>";
                                        echo            "<span>".$amz['data_formatada']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Pedido ID:</p>";
                                        echo            "<span>".$amz['pedido_id']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Valor:</p>";
                                        echo            "<span class='info_pedido_adm_aceitou'>R$ ".$amz['pedido_valor']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Status do pedido:</p>";
                                        echo            "<span class='status_pedido_adm_aceitou'>Aceito</span>";
                                        echo        "</div>";
                                        echo    "</div>";
                                        echo"</form>";
                                    }

                                //  PEDIDO RECUSADO PELO ADM
                                    elseif($status == 2 AND $referencia == null){
                                        echo"<form id='formulario_pedido_adm_recusar'>";
                                        echo    "<div class='descricao_pedido_adm_recusar'>";
                                        echo        "<h2>Pedido:</h2>";
                                        echo           "<p>".$amz['pedido_descricao']."</p>";
                                        echo    "</div>";
                                        echo    "<div class='reposta_adm_recusar'>";
                                        echo        "<h2>Resultado da análise:</h2>";
                                        echo        "<p>".$amz['pedido_resposta_adm']."</p>";
                                        echo    "</div>";
                                        echo    "<div class='info_pedido_adm_recusar'>";
                                        echo        "<div>";
                                        echo            "<p>Nome:</p>";
                                        echo            "<span>".$amz['user_nome']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>User ID:</p>";
                                        echo            "<span>".$amz['user_id']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Aberto em:</p>";
                                        echo            "<span>".$amz['data_formatada']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Pedido ID:</p>";
                                        echo            "<span>".$amz['pedido_id']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Status do pedido:</p>";
                                        echo            "<span class='status_pedido_adm_recusar'>Recusado</span>";
                                        echo        "</div>";
                                        echo    "</div>";
                                        echo"</form>";
                                    }

                                //  PEDIDO ACEITO PELO CLIENTE
                                    elseif ($status == 3 AND $referencia == null) {
                                        echo"<form id='formulario_pedido_cliente_aceitou' action='cadastrar_pedido.php' method='post'>";
                                        echo    "<div class='descricao_pedido_cliente_aceitou'>";
                                        echo        "<h2>Pedido:</h2>";
                                        echo        "<p>".$amz['pedido_descricao']."</p>";
                                        echo    "</div>";
                                        echo    "<div class='reposta_adm_cliente_aceitou'>";
                                        echo        "<h2>Resultado da análise:</h2>";
                                        echo        "<p>".$amz['pedido_resposta_adm']."</p>";
                                        echo    "</div>";
                                        echo    "<div class='reposta_cliente_cliente_aceitou'>";
                                        echo        "<h2>Retorno cliente:</h2>";
                                        echo        "<p>".$amz['pedido_resposta_cliente']."</p>";
                                        echo    "</div>";
                                        echo    "<div class='info_pedido_andamento'>";
                                        echo        "<div>";
                                        echo            "<p>Nome:</p>";
                                        echo            "<span>".$amz['user_nome']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>User ID:</p>";
                                        echo            "<span>".$amz['user_id']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Aberto em:</p>";
                                        echo            "<span>".$amz['data_formatada']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Pedido ID:</p>";
                                        echo            "<span>".$amz['pedido_id']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Valor:</p>";
                                        echo            "<span class='info_pedido_cliente_aceitou'>R$ ".$amz['pedido_valor']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Status do pedido:</p>";
                                        echo            "<span class='status_pedido_cliente_aceitou'>Em andamento</span>";
                                        echo        "</div>";
                                        echo        "</div>";
                                        echo        "<div class='botoes_aceitar_recusar'>";
                                        echo            "<input type='hidden' name='pedido_id' value='".$amz['pedido_id']."'>";
                                        echo            "<input type='submit' class='bnt_aceitar bnt_resultado' name='finalizar_pedido' value='Finalizar Pedido'>";
                                        echo            "<input type='submit' class='bnt_recusar bnt_resultado' name='cancelar_pedido' value='Cancelar Pedido'>";
                                        echo    "</div>";
                                        echo"</form>";
                                    }    

                                //  PEDIDO RECUSADO PELO CLIENTE
                                    elseif($status == 4 AND $referencia == null){
                                        echo"<form id='formulario_pedido_recusado'>";
                                        echo    "<div class='descricao_pedido_recusado'>";
                                        echo        "<h2>Pedido:</h2>";
                                        echo        "<p>".$amz['pedido_descricao']."</p>";
                                        echo    "</div>";
                                        echo    "<div class='reposta_adm_recusado'>";
                                        echo        "<h2>Resultado da análise:</h2>";
                                        echo        "<p>".$amz['pedido_resposta_adm']."</p>";
                                        echo    "</div>";
                                        echo    "<div class='reposta_cliente_recusado'>";
                                        echo        "<h2>Retorno cliente:</h2>";
                                        echo        "<p>".$amz['pedido_resposta_cliente']."</p>";
                                        echo    "</div>";
                                        echo    "<div class='info_pedido'>";
                                        echo        "<div>";
                                        echo            "<p>Nome:</p>";
                                        echo            "<span>".$amz['user_nome']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>User ID:</p>";
                                        echo            "<span>".$amz['user_id']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Aberto em:</p>";
                                        echo            "<span>".$amz['data_formatada']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Pedido ID:</p>";
                                        echo            "<span>".$amz['pedido_id']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Valor:</p>";
                                        echo            "<span class='info_pedido_recusado'>R$ ".$amz['pedido_valor']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Status do pedido:</p>";
                                        echo            "<span class='status_pedido_recusado'>Recusado</span>";
                                        echo        "</div>";
                                        echo    "</div>";
                                        echo"</form>";
                                    }

                                //  PEDIDO FINALIZADO PELO ADM
                                    elseif($status == 5 AND $referencia == null){
                                        echo"<form id='formulario_pedido_finalizado'>";
                                        echo    "<div class='descricao_pedido_finalizado'>";
                                        echo        "<h2>Pedido:</h2>";
                                        echo        "<p>".$amz['pedido_descricao']."</p>";
                                        echo    "</div>";
                                        echo    "<div class='reposta_adm_finalizado'>";
                                        echo        "<h2>Resultado da análise:</h2>";
                                        echo        "<p>".$amz['pedido_resposta_adm']."</p>";
                                        echo    "</div>";
                                        echo    "<div class='reposta_cliente_finalizado'>";
                                        echo        "<h2>Retorno cliente:</h2>";
                                        echo        "<p>".$amz['pedido_resposta_cliente']."</p>";
                                        echo    "</div>";
                                        echo    "<div class='info_pedido'>";
                                        echo        "<div>";
                                        echo            "<p>Nome:</p>";
                                        echo            "<span>".$amz['user_nome']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>User ID:</p>";
                                        echo            "<span>".$amz['user_id']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Aberto em:</p>";
                                        echo            "<span>".$amz['data_formatada']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Pedido ID:</p>";
                                        echo            "<span>".$amz['pedido_id']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Valor:</p>";
                                        echo            "<span class='info_pedido_finalizado'>R$ ".$amz['pedido_valor']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Status do pedido:</p>";
                                        echo            "<span class='status_pedido_finalizado'>Finalizado</span>";
                                        echo        "</div>";
                                        echo    "</div>";
                                        echo"</form>";
                                    } 

                                    //  PEDIDO FINALIZADO PELO ADM
                                    elseif($status == 6 AND $referencia == null){
                                        echo"<form id='formulario_pedido_recusado'>";
                                        echo    "<div class='descricao_pedido_recusado'>";
                                        echo        "<h2>Pedido:</h2>";
                                        echo        "<p>".$amz['pedido_descricao']."</p>";
                                        echo    "</div>";
                                        echo    "<div class='reposta_adm_recusado'>";
                                        echo        "<h2>Resultado da análise:</h2>";
                                        echo        "<p>".$amz['pedido_resposta_adm']."</p>";
                                        echo    "</div>";
                                        echo    "<div class='reposta_cliente_recusado'>";
                                        echo        "<h2>Retorno cliente:</h2>";
                                        echo        "<p>".$amz['pedido_resposta_cliente']."</p>";
                                        echo    "</div>";
                                        echo    "<div class='info_pedido'>";
                                        echo        "<div>";
                                        echo            "<p>Nome:</p>";
                                        echo            "<span>".$amz['user_nome']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>User ID:</p>";
                                        echo            "<span>".$amz['user_id']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Aberto em:</p>";
                                        echo            "<span>".$amz['data_formatada']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Pedido ID:</p>";
                                        echo            "<span>".$amz['pedido_id']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Valor:</p>";
                                        echo            "<span class='info_pedido_recusado'>R$ ".$amz['pedido_valor']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Status do pedido:</p>";
                                        echo            "<span class='status_pedido_recusado'>Cancelado</span>";
                                        echo        "</div>";
                                        echo    "</div>";
                                        echo"</form>";
                                    }
                                }   
                        }
                    ?>
                </div>
            </main>
        </main>

    </main>

</body>
</html>