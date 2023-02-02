<?php
    include_once("conectaBD.php");

    if(isset($_POST['bnt_cadastrar'])){
        $nome = $_POST['user_nome'];
        $email = $_POST['user_email'];
        $senha = $_POST['user_senha'];
        $confirmar_senha = $_POST['user_confirmar_senha'];
        $telefone = $_POST['user_telefone'];
        $cpf = $_POST['user_cpf'];
        $endereco = $_POST['user_endereco'];

            $sql = "INSERT INTO usuarios (user_nome, user_email, user_senha, user_cpf, user_endereco, user_telefone, user_status)
            VALUES ('$nome','$email',PASSWORD('$senha'),'$cpf','$endereco','$telefone','cliente')";

            if($senha == $confirmar_senha && !($email=='' || $nome=='' || $cpf=='' || $endereco=='' || $telefone=='')){
                header('location: index.html');
            }
            else if($senha=='' || $email=='' || $nome=='' || $confirmar_senha=='' || $cpf=='' || $endereco=='' || $telefone==''){
                header('location: cadastro.html');
            }
            else if($senha <> $confirmar_senha){
                header('location: cadastro.html');
            }
    }

        $resultado = mysqli_query($conexao,$sql);
        mysqli_close($conexao);
?>