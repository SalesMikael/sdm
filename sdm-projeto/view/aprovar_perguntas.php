<?php
include 'cabelhaco.php';

include '../scripts/conexao.inc';

$query = "SELECT * FROM perguntas WHERE revisao = 0";
$result = mysqli_query($conn, $query);

?>
<div class="principal">
    <a href="tela_principal.html">
        <button class="btn btn-sdm-info" style="margin-left: 30px;">
            <span class="material-symbols-outlined">
                arrow_back
            </span>
        </button>
    </a>

    <div class="card-perguntas" style="margin-top: 0px;">
        <h1>Aprovação de perguntas</h1>

        <?php
        // Loop para exibir as perguntas
        while ($row = mysqli_fetch_assoc($result)) {
            $enunciado = $row['enunciado'];
            $alternativa1 = $row['alternativa1'];
            $alternativa2 = $row['alternativa2'];
            $alternativa3 = $row['alternativa3'];
            $alternativa4 = $row['alternativa4'];
        ?>

<div class="perguntas">
                <div>
                    <h3><?php echo $enunciado; ?></h3>

                    <div>
                        <button id="reprovado" class="btn-outline-sdm-danger btn-maior">
                            <span class="material-symbols-outlined">
                                close
                            </span>
                        </button>

                        <button id="aprovado" class="btn-outline-sdm-verde btn-maior">
                            <span class="material-symbols-outlined">
                                done
                            </span>
                        </button>

                        <button id="detalhes" class="btn-outline-sdm btn-maior detalhes">
                            <span class="material-symbols-outlined">
                                info
                            </span>
                        </button>
                    </div>

                </div>
            </div>
        <?php
        }
        ?>
    </div>
</div>
<!-- fim da tela principal -->

<div class="teladesobreposicao">
    <div class="teladesobreposicao-cont">

        <!-- botao de voltar -->
        <button id="voltar" class="btn-outline-sdm fechar-btn">
            <span class="material-symbols-outlined">
                arrow_back
            </span>
        </button>
        <div class="perguntas centralizador" style="width: 50%; margin-top: 20px; margin-bottom: 0px;">
            <div>
                <div class="textodapergunta">
                    <h3>
                        <?php echo $enunciado; ?>
                    </h3>
                </div>
            </div>
        </div>

        <div class="opcoes">
            <div class="botao-texto" style="margin-bottom: 0px;">
                <button type="button" id="opcaoA" class="btn  btn-sdm-info btn-maior"><strong> A) <?php echo $alternativa1; ?></strong></button>

                <!-- a resposta certa deve ficar pintada de verde -->
                <button type="button" id="opcaoA" class="btn btn-sdm-verde btn-maior"><strong>B) <?php echo $alternativa2; ?></strong></button>
            </div>


            <div class="botao-texto" style="margin-top: 0px;">
                <button type="button" id="opcaoA" class="btn btn-sdm-info btn-maior"><strong>C) <?php echo $alternativa3; ?></strong></button>


                <button type="button" id="opcaoA" class="btn btn-sdm-info btn-maior"><strong>D) <?php echo $alternativa4; ?></strong></button>
            </div>

        </div> <!--fim do div de opções-->

    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var fecharBtns = document.querySelectorAll(".fechar-btn"); //funcao pra fechar telas
        var principal = document.querySelector(".principal"); //tela principal
        var telainfo = document.querySelector(".teladesobreposicao")
        var btninfo = document.querySelector(".detalhes")

        btninfo.addEventListener("click", function() {
            telainfo.classList.add("active");
            principal.style.filter = "blur(5px)";
        })

        fecharBtns.forEach(function(btn) { //função para que todos os btn-fechar fechem os conteudos
            btn.addEventListener("click", function() {
                principal.style.filter = "blur(0)"; // Remove o desfoque do fundo
                telainfo.classList.remove("active"); //esconde a tela de denuncia
            });
        });
    })
</script>
</body>

</html>