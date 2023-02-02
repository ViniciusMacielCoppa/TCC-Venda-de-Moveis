<?php
    include_once 'conectaBD.php';

//     ADICIONAR MOVEL
        if(isset($_POST['adicionar'])){
                $descricao = $_POST['movel_descricao'];
                $nome = $_POST['movel_nome'];
                $tipo = $_POST['movel_tipo'];
                $valor = $_POST['movel_valor'];
                $medidas = $_POST['movel_medidas'];
                $imagem = $_FILES['movel_imagem']['tmp_name'];
                $tamanho = $_FILES['movel_imagem']['size'];

                if($descricao == '' || $nome == '' || $tipo == '' || $valor == '' || $medidas == '' || $imagem == '' || $imagem == null){
                        header('location: adm_moveis.php');
                }else{
                        if($imagem != "none") {
                                $fp = fopen($imagem, "rb");
                                $conteudo = fread($fp, $tamanho);
                                $conteudo = addslashes($conteudo);
                                fclose($fp);

                                $sql = "INSERT INTO moveis (movel_nome, movel_descricao, movel_medidas, movel_valor, movel_tipo, movel_imagem)
                                VALUES ('$nome','$descricao','$medidas','$valor','$tipo','$conteudo')";
                                $resultado = mysqli_query($conexao,$sql);
                                header('location: adm_moveis.php');
                        }
                }
    }


//      EXCLUIR UM MÓVEL
        if(isset($_POST['excluir'])){
                $excluir = $_POST['excluir'];

                $sql = "DELETE FROM moveis WHERE movel_id = '$excluir'";
                $resultado = mysqli_query($conexao, $sql);
                header('Location: adm_moveis.php');
        }
        mysqli_close($conexao);
?>