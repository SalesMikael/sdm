<?php
include 'cabelhaco.php';
include '../scripts/conexao.inc';

// Iniciando a sessão do usuário cadastrado
session_start();
$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location: login.php');
}

$query = "SELECT * FROM perguntas WHERE revisao = 0";
$result = mysqli_query($conn, $query);
$perguntas = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<style>

</style>

<div class="principal">
    <a href="home.php">
        <button class="btn btn-sdm-info" style="margin-left: 30px;">
            <span class="material-symbols-outlined">
                arrow_back
            </span>
        </button>
    </a>

    <div class="card-perguntas" style="margin-top: 0px;">
        <h1>Aprovação de perguntas</h1>

        <?php foreach ($perguntas as $pergunta) { ?>
            <div class="perguntas">
                <div>
                    <h3><?php echo $pergunta['enunciado']; ?></h3>

                    <div>
                        <button class="btn-outline-sdm-danger btn-maior reprovado">
                            <span class="material-symbols-outlined">
                                close
                            </span>
                        </button>

                        <button class="btn-outline-sdm-verde btn-maior aprovado" data-pergunta-id="<?php echo $pergunta['idPerguntas']; ?>">
                            <span class="material-symbols-outlined">
                                done
                            </span>
                        </button>

                        <button class="btn-outline-sdm btn-maior detalhes" data-pergunta-id="<?php echo $pergunta['idPerguntas']; ?>">
                            <span class="material-symbols-outlined">
                                info
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<!-- Início da tela de detalhes -->
<div class="teladesobreposicao">
    <div class="teladesobreposicao-cont">
        <button class="btn-outline-sdm fechar-btn">
            <span class="material-symbols-outlined">
                arrow_back
            </span>
        </button>
        <div class="perguntas centralizador" style="width: 50%; margin-top: 20px; margin-bottom: 0px;">
            <div>
                <div class="textodapergunta">
                    <h3 id="enunciado"></h3>
                </div>
            </div>
        </div>

        <div class="opcoes">
            <div class="botao-texto" style="margin-bottom: 0px;">
                <button type="button" class="btn btn-sdm-info btn-maior opcaoa"><strong>A) <span id="alternativa1"></span></strong></button>
                <button type="button" class="btn btn-sdm-info btn-maior opcaob"><strong>B) <span id="alternativa2"></span></strong></button>
            </div>

            <div class="botao-texto" style="margin-top: 0px;">
                <button type="button" class="btn btn-sdm-info btn-maior opcaoc"><strong>C) <span id="alternativa3"></span></strong></button>
                <button type="button" class="btn btn-sdm-info btn-maior opcaod"><strong>D) <span id="alternativa4"></span></strong></button>
            </div>
            <div class="botao-texto" style="margin-top: 0px;">
            <h2>-----------------------Resposta Correta-----------------------</h2>
                <button type="button" class="btn btn-sdm-verde btn-maior opcao"><strong><span id="resposta"></span></strong></button>
            </div>
        </div> <!--fim do div de opções-->
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
  var fecharBtns = document.querySelectorAll(".fechar-btn");
  var principal = document.querySelector(".principal");
  var telainfo = document.querySelector(".teladesobreposicao");
  var btninfos = document.querySelectorAll(".detalhes");
  var aprovadosBtns = document.querySelectorAll(".aprovado");

  btninfos.forEach(function(btn) {
    btn.addEventListener("click", function() {
      var perguntaId = btn.getAttribute("data-pergunta-id");
      var pergunta = <?php echo json_encode($perguntas); ?>.find(function(item) {
        return item.idPerguntas == perguntaId;
      });

      document.getElementById("enunciado").innerText = pergunta.enunciado;
      document.getElementById("alternativa1").innerText = pergunta.alternativa1;
      document.getElementById("alternativa2").innerText = pergunta.alternativa2;
      document.getElementById("alternativa3").innerText = pergunta.alternativa3;
      document.getElementById("alternativa4").innerText = pergunta.alternativa4;
      document.getElementById("resposta").innerText = pergunta.resposta;

      telainfo.classList.add("active");
      principal.style.filter = "blur(5px)";
    });
  });

  fecharBtns.forEach(function(btn) {
    btn.addEventListener("click", function() {
      principal.style.filter = "blur(0)";
      telainfo.classList.remove("active");
    });
  });

  aprovadosBtns.forEach(function(btn) {
    var perguntaId = btn.getAttribute("data-pergunta-id");
    var usuarioId = <?php echo $user_id; ?>;

    // Verificar se a pergunta foi aprovada anteriormente
    var perguntaAprovada = localStorage.getItem("aprovacaoPergunta_" + perguntaId);
    if (perguntaAprovada && perguntaAprovada.includes(usuarioId)) {
      btn.disabled = true;
      btn.classList.add("reprovado"); // Adiciona a classe "reprovado" para manter a cor vermelha
    }

    btn.addEventListener("click", function() {
      var perguntaId = btn.getAttribute("data-pergunta-id");
      var usuarioId = <?php echo $user_id; ?>;

      var xhr = new XMLHttpRequest();
      xhr.open("POST", "aprovar_pergunta.php", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
            console.log(xhr.responseText);
            // Atualizar a interface ou mostrar uma mensagem de sucesso

            // Desabilitar o botão de aprovação
            btn.disabled = true;
            btn.classList.add("reprovado"); // Adiciona a classe "reprovado" para manter a cor vermelha

            // Armazenar o status de aprovação da pergunta no localStorage
            var aprovacaoAtual = localStorage.getItem("aprovacaoPergunta_" + perguntaId);
            if (aprovacaoAtual) {
              localStorage.setItem("aprovacaoPergunta_" + perguntaId, aprovacaoAtual + "," + usuarioId);
            } else {
              localStorage.setItem("aprovacaoPergunta_" + perguntaId, usuarioId);
            }
          } else {
            console.log("Ocorreu um erro ao aprovar a pergunta.");
            // Exibir uma mensagem de erro
          }
        }
      };
      xhr.send("perguntaId=" + perguntaId + "&usuarioId=" + usuarioId);
    });
  });
});

</script>

<?php 
include 'footer.php';
?>

