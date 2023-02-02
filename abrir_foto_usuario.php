<?php

    include_once('conectaBD.php');

    $id = $_GET['id'];

    $sql = "SELECT user_foto FROM usuarios WHERE user_id = $id";
    $resultado = mysqli_query($conexao, $sql);

    foreach($resultado as $result) {
        $conteudo = $result['user_foto'];
        echo $conteudo;
    }

?>