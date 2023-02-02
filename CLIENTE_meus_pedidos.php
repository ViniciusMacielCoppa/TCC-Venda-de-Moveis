<?php
 // Inclui o conectar.php para conectar ao BD:
 include_once 'conectaBD.php';

 session_start();

 $status = $_SESSION['status'];
 $id = $_SESSION['id'];
 $nome = $_SESSION['nome'];
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
    <link rel="stylesheet" href="tela_cliente/CLIENTE_pedidos.css">
    <link rel="stylesheet" href="tela_cliente/media_cliente.css">
    <link rel="stylesheet" href="css/pedidos_estilizados.css">
    <title>MARdeira | Meus Pedidos</title>
</head>
<body id="body_pedidos">

    <header id="header_principal">
        <section id="section_para_pc">
            <div class="primario">
                <div id="informacao_cliente">
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
                    <p><?php echo $nome; ?></p>
                    <a href="#"><i class="fa-solid fa-gear"></i></a>
                </div>

                <div id="cliente_sair">
                    <a href="deslogar.php">Sair</a>
                </div>
            </div>

            <div class="secundario">
                <nav id="nav_bar_cliente">
                    <ul>
                        <li> <a href="CLIENTE_moveis.php"><i class="fa-solid fa-shop"></i> Móveis</a> </li>
                        <li> <a href="" class="focar_link"><i class="fa-solid fa-tag"></i> Pedidos</a> </li>
                        <li> <a href='CLIENTE_avaliacoes.php'><i class='fa-solid fa-star'></i> Avaliações</a> </li>
                    </ul>
                </nav>
            </div>
        </section>
    </header>

    <section id="section_para_celular">
        <nav id="nav_bar_celular">
            <ul>
                <li> <a href="CLIENTE_moveis.php"><i class="fa-solid fa-shop"></i> Móveis</a> </li>
                <li> <a href="CLIENTE_meus_pedidos.php"><i class="fa-solid fa-tag"></i> Pedidos</a> </li>
                <li> <a href="CLIENTE_avaliacoes.php"><i class="fa-solid fa-star"></i> Avaliações</a> </li>
                <li> <a href="CLIENTE_definicoes.php"><i class="fa-solid fa-user"></i> Perfil</a> </li>
            </ul>
        </nav>
    </section>

    <main id="main_principal">
        <div class="container90_main_avaliacoes" id="container_principal_cliente">

            <div class="container_fazer_pedidos">
                <a href="CLIENTE_fazer_pedido.php"> <i class="fa-solid fa-plus"></i>⠀Fazer Pedido</a>
            </div>
            <div class="container_fazer_pedidos">
                <a href="CLIENTE_moveis_pedidos.php"> <i class="fa-solid fa-bag-shopping"></i>⠀Móveis pedidos</a>
            </div>

            <div class="pedidos_cliente">
                <header id="header_titulo_pedidos">
                    <h2>Seus pedidos</h2>
                </header>

                <main id="main_mostrar_pedidos">

                    <div class="filtro_pedidos">
                        <button id="bnt_mostrar_todos" class="bt_pedido_filtro">Mostrar todos</button>
                        <button id="bnt_aberto" class="bt_pedido_filtro">Pedidos a serem finalizados</button>
                        <button id="bnt_cancelado_recusado" class="bt_pedido_filtro">Cancelados / Recusados</button>
                        <button id="bnt_finalizado" class="bt_pedido_filtro">Finalizados</button>
                    </div>
                    
                    <div class="ficar_pedidos">

                        <div class="todos_pedidos">
                            <?php
                                $sql = "SELECT *, DATE_FORMAT(pedido_dia,'%d/%m/%y') AS 'data_formatada' FROM usuarios U INNER JOIN pedidos P
                                ON U.user_id = P.user_id WHERE U.user_id = $id ORDER BY pedido_id DESC";

                                $resultado = mysqli_query($conexao, $sql);
                                $linhas = mysqli_num_rows($resultado);

                                for ($i = 0; $i < $linhas; $i++){
                                    $amz = mysqli_fetch_array($resultado);
                                    $status = $amz['pedido_status'];
                                    $referencia = $amz['pedido_referencia'];

                                        //  PEDIDO FEITO RECENTEMENTE PELO CLIENTE
                                        if($status == 0 AND $referencia == null){
                                            echo"<form id='formulario_pedido_cliente'>";
                                                echo    "<div class='descricao_pedido_cliente'>";
                                                echo        "<h2>Pedido:</h2>";
                                                echo        "<p>".$amz['pedido_descricao']."</p>";
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
                                                echo            "<p>Status do pedido:</p>";
                                                echo            "<span class='status_pedido_cliente'>Aberto</span>";
                                                echo        "</div>";
                                                echo    "</div>";
                                                echo"</form>";
                                            }

                                        //  PEDIDO ACEITO PELO ADM
                                        elseif($status == 1 AND $referencia == null){
                                            echo"<form id='formulario_pedido_cliente_aceitar' action='cadastrar_pedido.php' method='post'>";
                                            echo    "<div class='descricao_pedido_cliente_aceitar'>";
                                            echo        "<h2>Pedido:</h2>";
                                            echo        "<p>".$amz['pedido_descricao']."</p>";
                                            echo    "</div>";
                                            echo    "<div class='reposta_adm_cliente_aceitar'>";
                                            echo        "<h2>Resultado da análise:</h2>";
                                            echo        "<p>".$amz['pedido_resposta_adm']."</p>";
                                            echo    "</div>";
                                            echo    "<div class='info_pedido_cliente_aceitar'>";
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
                                            echo            "<span class='info_pedido_cliente_aceitar_valor'>R$".$amz['pedido_valor']."</span>";
                                            echo        "</div>";
                                            echo        "<div>";
                                            echo            "<p>Status do pedido:</p>";
                                            echo            "<span class='status_pedido_cliente_aceitar'>Aceito</span>";
                                            echo        "</div>";
                                            echo    "</div>";

                                            echo    "<textarea class='resultado_adm_cliente_aceitar' name='resposta_cliente' rows='5' maxlength='250' placeholder='Deixe seu comentário...''></textarea>";
                                            echo    "<input type='hidden' name='pedido_id' value='".$amz['pedido_id']."'>";
                                            echo    "<div class='botoes_aceitar_recusar'>";
                                            echo        "<input type='submit' class='bnt_aceitar bnt_resultado' name='cliente_aceitar_pedido' value='Aceitar Pedido'>";
                                            echo        "<input type='submit' class='bnt_recusar bnt_resultado' name='cliente_recusar_pedido' value='Recusar Pedido'>";
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
                                        elseif($status == 3 AND $referencia == null){
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
                                            echo            "<span class='info_pedido_cliente_aceitou'>R$ ".$amz['pedido_valor']."</span>";
                                            echo        "</div>";
                                            echo        "<div>";
                                            echo            "<p>Status do pedido:</p>";
                                            echo            "<span class='status_pedido_cliente_aceitou'>Em andamento</span>";
                                            echo        "</div>";
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
                                        
                                        //  PEDIDO RECUSADO PELO ADM
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
                            ?>
                        </div>

                        <div class='serem_finalizados pedidos_amostras'>
                            <?php
                                $sql = "SELECT *, DATE_FORMAT(pedido_dia,'%d/%m/%y') AS 'data_formatada' FROM usuarios U INNER JOIN pedidos P ON U.user_id = P.user_id WHERE U.user_id = $id ORDER BY pedido_id DESC";

                                $resultado = mysqli_query($conexao, $sql);
                                $linhas = mysqli_num_rows($resultado);

                                for ($i = 0; $i < $linhas; $i++){
                                    $amz = mysqli_fetch_array($resultado);
                                    $status = $amz['pedido_status'];
                                    $referencia = $amz['pedido_referencia'];

                                    //  PEDIDO FEITO RECENTEMENTE PELO CLIENTE
                                    if($status == 0 AND $referencia == null){
                                        echo"<form id='formulario_pedido_cliente'>";
                                        echo    "<div class='descricao_pedido_cliente'>";
                                        echo        "<h2>Pedido:</h2>";
                                        echo        "<p>".$amz['pedido_descricao']."</p>";
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
                                        echo            "<p>Status do pedido:</p>";
                                        echo            "<span class='status_pedido_cliente'>Aberto</span>";
                                        echo        "</div>";
                                        echo    "</div>";
                                        echo"</form>";
                                    }

                                    //  PEDIDO ACEITO PELO ADM
                                    elseif($status == 1 AND $referencia == null){
                                        echo"<form id='formulario_pedido_cliente_aceitar' action='cadastrar_pedido.php' method='post'>";
                                        echo    "<div class='descricao_pedido_cliente_aceitar'>";
                                        echo        "<h2>Pedido:</h2>";
                                        echo        "<p>".$amz['pedido_descricao']."</p>";
                                        echo    "</div>";
                                        echo    "<div class='reposta_adm_cliente_aceitar'>";
                                        echo        "<h2>Resultado da análise:</h2>";
                                        echo        "<p>".$amz['pedido_resposta_adm']."</p>";
                                        echo    "</div>";
                                        echo    "<div class='info_pedido_cliente_aceitar'>";
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
                                        echo            "<span class='info_pedido_cliente_aceitar_valor'>R$".$amz['pedido_valor']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Status do pedido:</p>";
                                        echo            "<span class='status_pedido_cliente_aceitar'>Aceito</span>";
                                        echo        "</div>";
                                        echo    "</div>";
                                        echo    "<textarea class='resultado_adm_cliente_aceitar' name='resposta_cliente' rows='5' maxlength='250' placeholder='Deixe seu comentário...''></textarea>";
                                        echo    "<input type='hidden' name='pedido_id' value='".$amz['pedido_id']."'>";
                                        echo    "<div class='botoes_aceitar_recusar'>";
                                        echo        "<input type='submit' class='bnt_aceitar bnt_resultado' name='cliente_aceitar_pedido' value='Aceitar Pedido'>";
                                        echo        "<input type='submit' class='bnt_recusar bnt_resultado' name='cliente_recusar_pedido' value='Recusar Pedido'>";
                                        echo    "</div>";
                                        echo"</form>";
                                    }

                                    //  PEDIDO ACEITO PELO CLIENTE
                                    elseif($status == 3 AND $referencia == null){
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
                                        echo            "<span class='info_pedido_cliente_aceitou'>R$ ".$amz['pedido_valor']."</span>";
                                        echo        "</div>";
                                        echo        "<div>";
                                        echo            "<p>Status do pedido:</p>";
                                        echo            "<span class='status_pedido_cliente_aceitou'>Em andamento</span>";
                                        echo        "</div>";
                                        echo    "</div>";
                                        echo"</form>";
                                    } 
                                }
                            ?>
                        </div>

                        <div class='cancelado_recusado pedidos_amostras'>
                            <?php
                                    $sql = "SELECT *, DATE_FORMAT(pedido_dia,'%d/%m/%y') AS 'data_formatada' FROM usuarios U INNER JOIN pedidos P
                                    ON U.user_id = P.user_id WHERE U.user_id = $id ORDER BY pedido_id DESC";

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

                                         //  PEDIDO RECUSADO PELO ADM
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
                            ?>
                        </div>

                        <div class='finalizados_cliente pedidos_amostras'>
                            <?php
                                $sql = "SELECT *, DATE_FORMAT(pedido_dia,'%d/%m/%y') AS 'data_formatada' FROM usuarios U INNER JOIN pedidos P
                                ON U.user_id = P.user_id WHERE U.user_id = $id ORDER BY pedido_id DESC";

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
                            ?>
                        </div>

                    </div>

                    <footer id="footer_mostrar_pedidos"></footer>

                </main>
            </div>
        </div>
    </main>

    <script src="javascript/pedidos.js"></script>
</body>
</html>