<!-- ESSA PAGINA SERVE PARA FAZER O INCLUDE NAS OUTRAS PÁGINAS -->



<div id="container_mostrar_moveis">
    <header class="header_titulo_movel">
        <h2>Móveis feitos</h2>
    </header>

    <main class="main_mostrar_movel">

        <div class="ficar_formulario">
            <form id='pesquisa_moveis' method="post" autocomplete="off">
                <input type='text' id='pesquisa_buscar' name="buscar" placeholder='Faça uma busca...'>
                <input type='submit' id='pesquisa_bnt' name='bnt_buscar' value='Buscar'>
            </form>
        </div>

        <div class='ficar_moveis'>
                <?php
                    // O CÓDIGO ABAIXO IDENTIFICA SE O BOTÃO DE BUSCA FOI PRESSIONADO E EM SEGUIDA PASSARÁ...
                    //...O VALOR DA BUSCA PARA A VÁRIAVEL $BUSCAR E BUSCAR NO BANCO DE DADOS
                    if(isset($_POST['bnt_buscar'])){
                        $buscar = $_POST['buscar'];
                    }else{
                        $buscar = '';
                    }
                    // COMPARAÇÃO NO BD PEGANDO A VARIAVEL $BUSCAR E VER SE TEM ALGO PARECIDO NO BD PARA APARECER NA TELA
                    $sql = "SELECT * FROM moveis WHERE movel_nome LIKE '%$buscar%' OR movel_tipo LIKE '%$buscar%'
                    OR movel_valor LIKE '$buscar%' OR movel_descricao LIKE '%$buscar%' ORDER BY movel_id DESC";
                    
                    $resultado = mysqli_query($conexao, $sql);
                    $linhas = mysqli_num_rows($resultado);

                    while ($amz = mysqli_fetch_array($resultado)) {
                        $id = $amz['movel_id'];

                        echo "<section id='section_listar_moveis'>";

                        echo    "<div id='container_imagem'>";
                        echo        "<img src='adm_abrir_imagem_movel.php?id=".$id."'>";
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

                        echo    "<form action='CLIENTE_pedir_movel.php' method='post'>";
                        echo        "<button id='bnt_comprar_movel' name='comprar' value='".$amz['movel_id']."'>Comprar</button>";
                        echo    "</form>";
                        echo "</section>";
                    }
                ?>
            </div>

    </main>

    <footer class="footer_mostrar_movel"></footer>
</div>