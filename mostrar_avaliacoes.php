<!-- ESSA PAGINA SERVE PARA FAZER O INCLUDE NAS OUTRAS PÁGINAS -->



<!-- ESSA DIV CONTEM TODAS AS AVALIAÇÕES DO SITE -->
<div class="avaliacoes_cliente">

    <header id="header_avaliacoes_titulo">
        <h2>Avaliações feitas</h2>
    </header>

    <main id="main_avaliacoes_conteudo">
        <div id='mostrar_avaliacoes'>
            <?php
                $sql = "SELECT *, DATE_FORMAT(avaliacao_dia,'%d/%m/%y') AS 'data_formatada' FROM avaliacoes A INNER JOIN usuarios U ON A.user_id = U.user_id ORDER BY avaliacao_id DESC";

                $resultado = mysqli_query($conexao, $sql);
                $linhas = mysqli_num_rows($resultado);

                for ($i = 0; $i < $linhas; $i++){
                    $amz = mysqli_fetch_array($resultado);
                    
                    // O CÓDIGO ABAIXO CRIA UMA SECTION QUE MOSTRARÁ AS INFORMAÇÕES DAS AVALIAÇÕES
                    echo"<section id='avaliacoes_clientes_container'>";
                    echo    "<div class='descricao_avaliacao_cliente'>";
                    echo        "<h2>Avaliação:</h2>";
                    echo        "<p>".$amz['avaliacao_descricao']."</p>";
                    echo    "</div>";
                    echo    "<div class='descricao_informacoes'>";
                    echo        "<div>";
                    echo            "<p>Nome:</p>";
                    echo            "<span>".$amz['user_nome']."</span>";
                    echo        "</div>";
                    echo        "<div>";
                    echo            "<p>Avaliado em:</p>";
                    echo            "<span>".$amz['data_formatada']."</span>";
                    echo        "</div>";
                    echo        "<div>";
                    echo            "<p>Avaliação ID:</p>";
                    echo            "<span>".$amz['avaliacao_id']."</span>";
                    echo        "</div>";
                    echo    "</div>";
                    echo"</section>";
                }
            ?>
        </div>


    </main>

    <footer id="footer_avaliacoes_conteudo"></footer>

</div>