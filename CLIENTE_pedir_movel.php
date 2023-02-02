<?php
 // Inclui o conectar.php para conectar ao BD:
 include_once 'conectaBD.php';

 session_start();

 $status = $_SESSION['status'];
 $id = $_SESSION['id'];
 $nome = $_SESSION['nome'];
 if(!$status == 'cliente' && ($id == '' || $id == null)){
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
    <link rel="icon" href="img/mardeira_icone.png"> 
    <link rel="stylesheet" href="tela_cliente/CLIENTE_pedir_movel.css">
    <link rel="stylesheet" href="tela_cliente/media_cliente.css">
    <title>MARdeira | Comprar Móvel</title>
</head>
<body id="body_avaliacao">
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
                        <li> <a href="CLIENTE_meus_pedidos.php"><i class="fa-solid fa-tag"></i> Pedidos</a> </li>
                        <li> <a href='CLIENTE_avaliacoes.php' class="focar_link"><i class='fa-solid fa-star'></i> Avaliações</a> </li>
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
            <div class="container_pedir_movel">
                <header class="header_pedir_movel">
                    <h2>Meu pedido</h2>
                </header>
                <main class="main_pedir_movel">
                    <div class="ficar_moveis">
                        <?php
                            $id_compra = $_POST['comprar'];

                            $sql = "SELECT * FROM moveis WHERE movel_id = $id_compra";
                            
                            $resultado = mysqli_query($conexao, $sql);
                            $linhas = mysqli_num_rows($resultado);

                            while ($amz = mysqli_fetch_array($resultado)) {
                                echo "<section id='section_listar_moveis'>";

                                echo    "<div id='container_imagem'>";
                                echo        "<img src='adm_abrir_imagem_movel.php?id=".$id_compra."'>";
                                echo    "</div>";

                                echo    "<div id='container_conteudo'>";
                                echo            "<div class='conteudo_primario'>";
                                echo                "<div class='movel_nome'>";
                                echo                    "<h2>".$amz['movel_nome']."</h2>";
                                echo                "</div>";
                                echo                "<div class='movel_descricao'>";
                                echo                    "<p>".$amz['movel_descricao']."</p>";
                                echo                "</div>";
                                echo            "</div>";

                                echo            "<div id='conteudo_secundario'>";
                                echo               "<div class='movel_tipo'>";
                                echo                    "<h3>Tipo</h3>";
                                echo                    "<p>".$amz['movel_tipo']."</p>";
                                echo                "</div>";
                                echo                "<div class='movel_valor'>";
                                echo                    "<h3>Valor</h3>";
                                echo                    "<p>R$ ".$amz['movel_valor']."</p>";
                                echo                "</div>";
                                echo                "<div class='movel_medida'>";
                                echo                    "<h3>Medidas</h3>";
                                echo                    "<p>".$amz['movel_medidas']."</p>";
                                echo                "</div>";
                                echo            "</div>";
                                echo    "</div>";
                                echo "</section>";
                            }
                        ?>
                    </div>

                    <form action='cadastrar_pedido.php' method='post'>
                        <label>
                            <textarea class='textarea_pedir_movel' name='user_pedido' maxlength='500' placeholder='O que deseja mudar?'></textarea>
                        </label>
                        <footer id='footer_pedir_movel'>
                            <input type='submit' class='bnt_pedir_movel prosseguir' name='pedir_movel' value='Comprar'>
                            <input type='submit' class='bnt_pedir_movel cancelar_pedido' name='cancelar_compra' value='Cancelar'>
                            <input type='hidden' name='user_id' value='<?php echo $id; ?>'>
                            <input type='hidden' name='id_compra' value='<?php echo $id_compra; ?>'>
                        </footer>
                    </form>
                </main>
            </div>
        </div>
    </main>

</body>
</html>