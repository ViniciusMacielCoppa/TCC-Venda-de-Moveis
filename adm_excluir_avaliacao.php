<?php
    include_once 'conectaBD.php';

//      EXCLUIR UMA AVALIAÇÃO
        if(isset($_POST['excluir'])){
                $excluir = $_POST['excluir'];

                $sql = "DELETE FROM avaliacoes WHERE avaliacao_id = '$excluir'";
                $resultado = mysqli_query($conexao, $sql);
                header('Location: adm_avaliacoes.php');
        }
        mysqli_close($conexao);
?>