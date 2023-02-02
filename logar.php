<?php
    session_start();
    include_once "conectaBD.php";

    $email = $_POST['user_email'];
    $senha = $_POST['user_senha'];

    $sql = "SELECT * FROM usuarios WHERE user_email = '$email' AND user_senha = PASSWORD('$senha')";
    $resultado = mysqli_query($conexao, $sql);
    $amz = mysqli_fetch_assoc($resultado); 

    $_SESSION['nome'] = $amz['user_nome'];
    $_SESSION['id'] = $amz['user_id'];
    $_SESSION['status'] = $amz['user_status'];

    if($amz['user_status'] == 'adm'){     // CASO O STATUS DO USUARIO FOR "adm" ELE É DIRECIONADO A TELA DO ADM
        header('Location: adm_dashboard.php');
    }elseif($amz['user_status'] == 'cliente'){     // CASO O STATUS DO USUARIO FOR "cliente" ELE É DIRECIONADO A TELA DO CLIENTE
        header('Location: CLIENTE_moveis.php');
    }else{
        header('Location: login.html');
    }

?>