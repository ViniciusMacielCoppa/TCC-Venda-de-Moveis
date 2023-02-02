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
    <link rel="stylesheet" href="tela_cliente/CLIENTE_pedidos.css">
    <link rel="stylesheet" href="tela_cliente/media_cliente.css">
    <link rel="stylesheet" href="css/pedidos_estilizados.css">
    <title>MARdeira | Fazer Pedido</title>
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
                        <li> <a href="CLIENTE_meus_pedidos.php" class="focar_link"><i class="fa-solid fa-tag"></i> Pedidos</a> </li>
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
        <div class="container90_main_avaliacoes" id="container_principal_fazer_pedido">

            <div class="container_fazer_pedidos_meus">
                <a href="CLIENTE_meus_pedidos.php"><i class="fa-sharp fa-solid fa-arrow-left"></i>⠀Voltar</a>
            </div>
            <div class="container_fazer_pedidos_meus">
                <a href="CLIENTE_moveis.php"><i class="fa-solid fa-cart-shopping"></i>⠀Comprar um móvel sob medida</a>
            </div>

            <div class="container_fazer_pedido_description">
                <header class="header_fazer_pedido_description">
                    <h2><i class="fa-solid fa-check"></i>⠀Faça um pedido</h2>
                </header>

                <main class='main_fazer_pedido_description'>
                    <form action='cadastrar_pedido.php' method='post'>
                        <label>
                            <textarea class='textarea_fazer_pedido' name='pedido' maxlength='500' placeholder='Descreva seu pedido...'></textarea>
                        </label>
                        <footer id='footer_fazer_pedido_description'>
                            <input type='submit' id='bnt_fazer_pedido' name='novo_pedido' value='Pedir'>
                            <input type='hidden' name='user_id' value='<?php echo $id; ?>'>
                        </footer>
                    </form>
                </main>
            </div>


        </div>
    </main>

</body>
</html>