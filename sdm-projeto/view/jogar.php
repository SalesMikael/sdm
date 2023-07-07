<?php

include 'cabelhaco.php';
include '../scripts/conexao.inc';

session_start();
$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
  header('location:login.php');
};

// Verifica se é a primeira pergunta
if (!isset($_GET['questionNumber']) || $_GET['questionNumber'] == 1) {
  // Reseta as variáveis de sessão
  $_SESSION['questionNumber'] = 1;
  $_SESSION['correctCount'] = 0;
  $_SESSION['eliminatedOptionsCount'] = 0; // Adicionada a variável para contar as opções eliminadas
  $_SESSION['score'] = 0;
  $_SESSION['perguntasExibidas'] = array();

  //criar id
  //$insert = mysqli_query($conn, "INSERT INTO `partidas`(`numErros`) VALUES ('6')");

} elseif ($_SESSION['questionNumber'] > 7) {
  // Redireciona para a página final se o número da pergunta for maior que 7
  header("Location: resultado.php");
  exit();
}

// Define os valores de pontuação para cada pergunta
$scoringValues = array(
  1 => array('acertar' => 1000, 'parar' => 0, 'errar' => 0),
  2 => array('acertar' => 5000, 'parar' => 1000, 'errar' => 500),
  3 => array('acertar' => 50000, 'parar' => 5000, 'errar' => 2500),
  4 => array('acertar' => 100000, 'parar' => 50000, 'errar' => 25000),
  5 => array('acertar' => 300000, 'parar' => 100000, 'errar' => 50000),
  6 => array('acertar' => 500000, 'parar' => 300000, 'errar' => 150000),
  7 => array('acertar' => 1000000, 'parar' => 500000, 'errar' => 0)
);

// Consulta o banco de dados para buscar a pergunta na tabela "perguntas"
$query = "SELECT idPerguntas, enunciado, alternativa1, alternativa2, alternativa3, alternativa4 FROM perguntas WHERE revisao = 1 ORDER BY RAND() LIMIT 1";
$result = mysqli_query($conn, $query);

// Verifica se a consulta foi bem-sucedida
if ($result && mysqli_num_rows($result) > 0) {
  // Busca a pergunta e as alternativas do resultado
  $row = mysqli_fetch_assoc($result);
  $pergunta_id = $row['idPerguntas'];

  // Verifica se a pergunta atual já foi exibida
  if (in_array($pergunta_id, $_SESSION['perguntasExibidas'])) {
    // Redireciona para a próxima pergunta
    header("Location: jogar.php?questionNumber=" . ($_SESSION['questionNumber'] + 1));
    exit();
  }

  // Adiciona o ID da pergunta atual ao array 'perguntasExibidas' na sessão
  $_SESSION['perguntasExibidas'][] = $pergunta_id;

  $enunciado = $row['enunciado'];
  $alternativa1 = $row['alternativa1'];
  $alternativa2 = $row['alternativa2'];
  $alternativa3 = $row['alternativa3'];
  $alternativa4 = $row['alternativa4'];

  // Busca a resposta correta no banco de dados
  $query = "SELECT resposta FROM perguntas WHERE idPerguntas = $pergunta_id";
  $result = mysqli_query($conn, $query);
  $correctAnswer = mysqli_fetch_assoc($result)['resposta'];

  // Exibe o enunciado da pergunta
} else {
  echo "Nenhuma pergunta encontrada.";
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <title>Show do Milhão Branco</title>
  <link rel="stylesheet" type="text/css" href="../css/style.css">
  <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
  <script src="../scripts/jquery.js"></script>
  <script src="../scripts/bootstrap.js"></script>
</head>

<body>
  <div class="principal">
    <nav class="navbar">
      <a class="navbar-logo">
        <img id="logo-navbar" src="../images/Show do Milhãobranco.png">
      </a>
      <div class="navbar-cont centralizador">
        <button name="eliminar2" onclick="eliminateTwoOptions()" id="dica_menos_dois" class="btn btn-outline-sdm grupo-botoes-inline" type="button">
          <span class="material-symbols-outlined">
            exposure_neg_2
          </span>
        </button>

        <button id="ajuda" class="btn btn-sdm-info grupo-botoes-inline ajuda" style="cursor: help;">
          <div class="centralizador">
            <span>Valor a ganhar: R$ <?php echo $scoringValues[$_SESSION['questionNumber']]['acertar']; ?></span>
          </div>
        </button>

        <button id="ajuda" class="btn btn-sdm-info grupo-botoes-inline ajuda" style="cursor: help;">
          <div class="centralizador">
            <span>Valor se parar: R$ <?php echo $scoringValues[$_SESSION['questionNumber']]['parar']; ?></span>
          </div>
        </button>

        <button id="ajuda" class="btn btn-sdm-info grupo-botoes-inline ajuda" style="cursor: help;">
          <div class="centralizador">
            <span>Errar: R$ <?php echo $scoringValues[$_SESSION['questionNumber']]['errar']; ?></span>
          </div>
        </button>

        <!-- divisoria -->

        <button id="btn-denuncia" class="btn btn-outline-sdm-danger btn-denuncia grupo-botoes-inline" type="button" style="margin-left: 20px;">
          <span class="material-symbols-outlined">
            report
          </span>
        </button>

        <button id="btn-saida" class="btn btn-outline-sdm-danger btn-saida grupo-botoes-inline" type="button">
          <span class="material-symbols-outlined">
            logout
          </span>
        </button>
      </div>
    </nav>

    <div class="card-perguntas">
      <div>
        <div class="perguntas">
          <div>
            <h1>Pergunta <?php echo $_SESSION['questionNumber'] ?>/7</h1>
            <div class="textodapergunta"><?php echo $enunciado ?></div>
          </div>
        </div>

        <div class="opcoes">
          <div class="botao-texto">
            <button name="opcao" onclick="checkAnswer('<?php echo $alternativa1 ?>', 'opcaoA')" type="button" id="opcaoA" class="btn btn-opc"><strong>A) <?php echo $alternativa1 ?></strong></button>
          </div>

          <div class="botao-texto">
            <button name="opcao" onclick="checkAnswer('<?php echo $alternativa2 ?>', 'opcaoB')" type="button" id="opcaoB" class="btn btn-opc"><strong>B) <?php echo $alternativa2 ?></strong></button>
          </div>

          <div class="botao-texto">
            <button name="opcao" onclick="checkAnswer('<?php echo $alternativa3 ?>', 'opcaoC')" type="button" id="opcaoC" class="btn btn-opc"><strong>C) <?php echo $alternativa3 ?></strong></button>
          </div>

          <div class="botao-texto">
            <button name="opcao" onclick="checkAnswer('<?php echo $alternativa4 ?>', 'opcaoD')" type="button" id="opcaoD" class="btn btn-opc"><strong>D) <?php echo $alternativa4 ?></strong></button>
          </div>
        </div>
      </div>
    </div>
  </div>
<!-- Tela de pontuação -->
  <div id="telapontuacao" class="telapontuacao teladesobreposicao">
    <div class="teladesobreposicao-cont">
      <!--Div para o cabeçalho todo-->
      <div class="headerpont">
        <h2>Pontuação atual: R$???.???,??</h2>
        <!--Div apenas paraeditar estilos da subheader-->
        <div class="subhead">
          <h4>Pergunta Atual: ?/7</h4>
        </div>
      </div>
      <!--Começo do duv e conteudo da tabela-->
      <div class="tabela">
        <table class="table table-striped table-hover table-sm">
          <thead>
            <tr class="cabecalho-tabela">
              <th scope="col">N° pergunta</th>
              <th scope="col">Acertar</th>
              <th scope="col">Parar</th>
              <th scope="col">Errar</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th id="linha1" scope="row">1</th>
              <td>R$1 mil</td>
              <td>R$0</td>
              <td>R$0</td>
            </tr>
            <tr>
              <th id="linha2" scope="row">2</th>
              <td>R$5 mil</td>
              <td>R$1 mil</td>
              <td>R$500</td>
            </tr>
            <tr>
              <th id="linha3" scope="row">3</th>
              <td>R$50 mil</td>
              <td>R$5 mil</td>
              <td>R$2,5 mil</td>
            </tr>
            <tr>
              <th id="linha4" scope="row">4</th>
              <td>R$100 mil</td>
              <td>R$50 mil</td>
              <td>R$25 mil</td>
            </tr>
            <tr>
              <th id="linha5" scope="row">5</th>
              <td>R$300 mil</td>
              <td>R$100 mil</td>
              <td>R$50 mil</td>
            </tr>
            <tr>
              <th id="linha6" scope="row">6</th>
              <td>R$500 mil</td>
              <td>R$300 mil</td>
              <td>R$150 mil</td>
            </tr>
            <tr>
              <th id="linha7" scope="row">7</th>
              <td>R$1 milhão</td>
              <td>R$500 mil</td>
              <td>R$0</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="botao-texto">
        <button class="btn btn-outline-sdm-danger btn-maior fechar-btn">fechar</button>
      </div>
    </div>
  </div>
<!--
    tela de denuncia
  -->
  <div id="telaDenuncia" class="telaDenuncia teladesobreposicao">
    <div class="teladesobreposicao-cont">
      <h2>Gostaria de denunciar essa pergunta?</h2>
      <div class="botoesdedenuncia botao-texto">
        <button id="denunciado" class="btn btn-outline-sdm btn-maior denunciado">Sim</button>
        <!--Quando clicar neste botão, realizar a denuncia e usar um alerta para notificar-->
        <button id="" class="btn btn-outline-sdm btn-maior nao-btn fechar-btn">Não</button>
      </div>
    </div>
  </div>

  <!--
    tela de saida
  -->
  <div id="tela_saida" class="tela_saida teladesobreposicao">
    <div class="teladesobreposicao-cont">
      <h2>Você deseja desistir?</h2>
      <div class="botao-texto">
        <button id="incerteza-btn" class="btn btn-outline-sdm btn-maior sim-btn incerteza-btn">Sim</button>
        <button class="btn btn-outline-sdm btn-maior nao-btn fechar-btn">Não</button>
      </div>
    </div>
  </div>

  <!--
    tela de "vc tem certeza que quer sair?"
  -->
  <div id="tela-temcerteza" class="tela-temcerteza teladesobreposicao">
    <div class="teladesobreposicao-cont">
      <div class="vctemcerteza">
        <h2>Você tem certeza?</h2>
      </div>
      <div class="botao-texto" style="margin-top: 53px;">
        <button class="btn btn-outline-sdm btn-maior nao-btn fechar-btn">Não</button>
        <button id="desistencia-btn" class="btn btn-outline-sdm btn-maior sim-btn desistencia-btn">Sim</button>
      </div>
    </div>
  </div>

  <!--
    tela de confimação de saida
  -->
  <div id="telaconfirmacaosaida" class="telaconfirmacaosaida teladesobreposicao">
    <div class="teladesobreposicao-cont">
      <h1>Fim de Jogo!</h1>
      <div class="botao-texto">
        <a href="home.php">
          <button type="button" class="btn btn-outline-sdm btn-maior" style="width: auto !important;"><b>Voltar para o
              menu</b></button>
        </a>
      </div>
    </div>
  </div>

  <!--
    Tela de confirmação
  -->
  <div id="telasucesso" class="telasucesso teladesobreposicao">
    <div class="teladesobreposicao-cont">
      <div class="centralizador">
        <span>
          <img src="../images/feitocomcirculogrosso-menor-cut (1).png" style="margin-bottom: -4px;">
        </span>
        <span>
          <h3 style="display: inline; margin-left: 25px;">Denuncia realizada com sucesso</h3>
        </span>
      </div>
      <div class="subtextoconfirmacao">
        <small>Clique em qualquer lugar para fechar a tela</small>
      </div>
    </div>

  </div>
  <script>
    function checkAnswer(selectedOption, optionId) {
      var correctOption = "<?php echo $correctAnswer ?>";

      if (selectedOption === correctOption) {
        <?php
        $_SESSION['questionNumber']++;
        if ($_SESSION['questionNumber'] <= 7) {
          echo "window.location.href = 'jogar.php?questionNumber=' + " . $_SESSION['questionNumber'] . ";";
        } else {
          echo "alert('Parabéns! Você respondeu todas as perguntas.');";
          echo "window.location.href = 'home.php';"; // Substitua "resultado.php" pelo caminho correto da página de resultado
        }
        ?>
      } else {
        var questionNumber = <?php echo $_SESSION['questionNumber'] ?>;
        var score = <?php echo $_SESSION['score'] ?>;
        var action = getAction();
        var scoringValues = <?php echo json_encode($scoringValues) ?>;
        var currentScoringValues = scoringValues[questionNumber];
        var questionScore = currentScoringValues[action];
        score += questionScore;
        <?php $_SESSION['score'] = "' + score + '"; ?>
        alert("Resposta incorreta. O jogo será encerrado.");
        window.location.href = "home.php"; // Substitua "resultado.php" pelo caminho correto da página de resultado
      }
    }

    function getAction() {
      var selectedAction = "responder";
      switch (selectedAction) {
        case "responder":
          return "acertar";
        case "parar":
          return "parar";
        case "errar":
          return "errar";
        case "eliminar":
          return "eliminar";
        default:
          return "acertar";
      }
    }

    var data = "contador=0";

    function eliminateTwoOptions() {
      numErros();
      // Verifica se a opção de eliminar duas alternativas já foi utilizada

      // Oculta duas opções incorretas aleatoriamente
      var options = ["opcaoA", "opcaoB", "opcaoC", "opcaoD"];
      var eliminatedCount = 0;

      while (eliminatedCount < 2) {
        var randomIndex = Math.floor(Math.random() * options.length);
        var optionId = options[randomIndex];
        var optionButton = document.getElementById(optionId);

        // Verifica se a opção é correta
        if (optionButton.innerHTML.includes("<?php echo $correctAnswer ?>")) {
          continue;
        }

        optionButton.style.display = "none";
        eliminatedCount++;
      }

      // Desativa o botão de eliminar duas opções
      document.getElementById("dica_menos_dois").disabled = true;

      // Atualiza a variável de sessão 'eliminatedOptions' para indicar que a dica foi usada
      <?php $_SESSION['eliminatedOptions'] = true; ?>
    }

    function numErros() {
      // Faz uma chamada AJAX para o arquivo PHP responsável pela inserção no banco de dados
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "config.php", true);
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
          // Callback de sucesso
          console.log("Valor do contador inserido no banco de dados.");
        }
      };

      // Define os dados a serem enviados para o arquivo PHP
      // Aqui você pode passar o valor atual do contador

      // Envia a solicitação AJAX
      xhr.send(data);
    }

    var telaDenuncia = document.querySelector(".telaDenuncia");//tela de denuncia
      var telaSaida = document.querySelector(".tela_saida"); // tela de saida
      var telaPont = document.querySelector(".telapontuacao");//tela de pontuacao
      var telaperdeu = document.querySelector(".telaconfirmacaosaida");//tela de confirmação de saida
      var telacerteza = document.querySelector(".tela-temcerteza");//tela de certza de saida
      var teladenunciado = document.querySelector(".telasucesso");//tela de denuncia realizada

      var fecharBtns = document.querySelectorAll(".fechar-btn"); //funcao pra fechar telas
      var principal = document.querySelector(".principal"); //tela principal

      var abrirdenuncia = document.querySelector(".btn-denuncia");//botão de denuncia
      var sairBtn = document.querySelector(".btn-saida"); //botao de saida
      var incerteza = document.querySelector(".incerteza-btn");//botao da incerteza
      var denunciado = document.querySelector(".denunciado");//botao de sim na denuncia
      var desistencia = document.querySelector(".desistencia-btn"); //botao de sim na tela de sair



      abrirdenuncia.addEventListener("click", function () {
        telaDenuncia.classList.add("active"); //exibe a tela de denuncia
        principal.style.filter = "blur(5px)"; // Aplica o desfoque ao fundo
      });

      sairBtn.addEventListener("click", function () {
        telaSaida.classList.add("active"); // Exibe a tela de saída
        principal.style.filter = "blur(5px)"; // Aplica o desfoque ao fundo
      });


      incerteza.addEventListener("click", function () {
        telacerteza.classList.add("active");//exibe a tela de incerteza
        telaSaida.classList.remove("active"); // Esconde a tela de saída
      })

      desistencia.addEventListener("click", function () {
        telaperdeu.classList.add("active");//exibe tela de desistencia
        telacerteza.classList.remove("active");
        principal.style.filter = "blur(5px)";//Aplica o desfoque ao fundo
      })

      denunciado.addEventListener("click", function () {
        teladenunciado.classList.add("active");//exibe tela de denuncia realizada
        telaDenuncia.classList.remove("active");
      })
      /*
        A função abaixo é para quando clicar na tela, ela fechar
      */
      teladenunciado.addEventListener("click", function () {
        principal.style.filter = "blur(0)"; // Remove o desfoque do fundo
        teladenunciado.classList.remove("active")
      })



      fecharBtns.forEach(function (btn) { //função para que todos os btn-fechar fechem os conteudos
        btn.addEventListener("click", function () {
          principal.style.filter = "blur(0)"; // Remove o desfoque do fundo
          telaDenuncia.classList.remove("active"); //esconde a tela de denuncia
          telaSaida.classList.remove("active"); // Esconde a tela de saída
          telaPont.classList.remove("active"); // esconde a tela de pontuação
          telacerteza.classList.remove("active");//esconde a tela de incerteza
        });
      });
      
  </script>
</body>

</html>