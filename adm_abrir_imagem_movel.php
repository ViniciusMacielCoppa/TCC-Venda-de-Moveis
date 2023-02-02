<?php

    include_once('conectaBD.php');

    $id = $_GET['id'];

    $sql = "SELECT movel_imagem FROM moveis WHERE movel_id = $id";
    $resultado = mysqli_query($conexao, $sql);

    foreach($resultado as $result) {
        $conteudo = $result['movel_imagem'];
        echo $conteudo;
    }

?>