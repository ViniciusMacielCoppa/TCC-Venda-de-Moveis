<?php
    include_once("conectaBD.php");

//  PEDIDO FEITO RECENTEMENTE PELO CLIENTE
    if(isset($_POST['novo_pedido'])){
        $pedido_descricao = $_POST['pedido'];
        $user_id = $_POST['user_id'];

        $sql = "INSERT INTO pedidos (pedido_descricao, user_id, pedido_dia, pedido_status)
        VALUES ('$pedido_descricao', '$user_id', now(), 0)";

        header('location: CLIENTE_meus_pedidos.php');    
    }

//  PEDIDO ACEITO PELO ADM
    if(isset($_POST['adm_aceitar_pedido'])){
        $reposta_adm = $_POST['resposta_adm'];
        $valor = $_POST['valor'];
        $pedido_id = $_POST['pedido_id'];

        $sql = "UPDATE pedidos SET pedido_resposta_adm ='$reposta_adm', pedido_valor ='$valor', pedido_status = 1 WHERE pedido_id = $pedido_id";

        header('location: adm_pedidos.php');    
    }

//  PEDIDO RECUSADO PELO ADM
    if(isset($_POST['adm_recusar_pedido'])){
        $reposta_adm = $_POST['resposta_adm'];
        $pedido_id = $_POST['pedido_id'];

        $sql = "UPDATE pedidos SET pedido_resposta_adm ='$reposta_adm', pedido_status = 2 WHERE pedido_id = $pedido_id";

        header('location: adm_pedidos.php');    
    }

//  PEDIDO ACEITO PELO CLIENTE
    if(isset($_POST['cliente_aceitar_pedido'])){
        $reposta_cliente = $_POST['resposta_cliente'];
        $pedido_id = $_POST['pedido_id'];

        $sql = "UPDATE pedidos SET pedido_resposta_cliente ='$reposta_cliente', pedido_status = 3 WHERE pedido_id = $pedido_id";

        header('location: CLIENTE_meus_pedidos.php');    
    }

//  PEDIDO RECUSADO PELO CLIENTE
    if(isset($_POST['cliente_recusar_pedido'])){
        $reposta_cliente = $_POST['resposta_cliente'];
        $pedido_id = $_POST['pedido_id'];

        $sql = "UPDATE pedidos SET pedido_resposta_cliente ='$reposta_cliente', pedido_status = 4 WHERE pedido_id = $pedido_id";

        header('location: CLIENTE_meus_pedidos.php');    
    }

//  PEDIDO FINALIZADO PELO ADM APÓS A ACEITAÇÃO DO CLIENTE
    if(isset($_POST['finalizar_pedido'])){
        $pedido_id = $_POST['pedido_id'];

        $sql = "UPDATE pedidos SET pedido_status = 5 WHERE pedido_id = $pedido_id";

        header('location: adm_pedidos.php');    
    }

//  PEDIDO CANCELADO PELO ADM APÓS A ACEITAÇÃO DO CLIENTE
    if(isset($_POST['cancelar_pedido'])){
        $pedido_id = $_POST['pedido_id'];

        $sql = "UPDATE pedidos SET pedido_status = 6 WHERE pedido_id = $pedido_id";

        header('location: adm_pedidos.php');    
    }

//  IF PARA INSERIR UMA AVALIAÇÃO 
    if(isset($_POST['avaliar'])){
        $avaliar = $_POST['user_avaliacao'];
        $user_id = $_POST['user_id'];

        if($avaliar == '' || $avaliar == null){
            header('location: CLIENTE_avaliacoes.php');
        }else{
        // LEMBRANDO Q A AVALIAÇÃO TEM Q SER DISPONIVEL DEPOIS Q O CLIENTE COMPRE ALGUM MOVEL
            $sql = "INSERT INTO avaliacoes (avaliacao_descricao, user_id, avaliacao_dia) VALUES ('$avaliar','$user_id',now())";
            header('location: CLIENTE_avaliacoes.php');
        }
    }


//  IF PARA FAZER UM PEDIDO COM REFERENCIA A UM MOVEL
    if(isset($_POST['pedir_movel'])){
        $pedido_descricao = $_POST['user_pedido'];
        $user_id = $_POST['user_id'];
        $referencia = $_POST['id_compra'];

        $sql = "INSERT INTO pedidos (pedido_descricao, user_id, pedido_dia, pedido_referencia, pedido_status)
        VALUES ('$pedido_descricao', '$user_id', now(), $referencia, 0)";
        header('location: CLIENTE_meus_pedidos.php');  

    }
    //  IFF PARA CANCELAR A COMPRA
    if(isset($_POST['cancelar_compra'])){
        header('location: CLIENTE_meus_pedidos.php');
    }
    
    
    
    $resultado = mysqli_query($conexao,$sql);
    mysqli_close($conexao);  

?>