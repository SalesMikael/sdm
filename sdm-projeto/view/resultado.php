<?php
session_start();

// Verifica se a pontuação está definida na sessão
if (isset($_SESSION['score'])) {
  $score = $_SESSION['score'];
} else {
  // Redireciona para a página inicial se a pontuação não estiver definida
  header("Location: index.php");
  exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Resultado</title>
  <style>
    body {
      font-family: Arial, sans-serif;
    }

    .container {
      max-width: 500px;
      margin: 0 auto;
      padding: 20px;
    }

    h1 {
      text-align: center;
    }

    p {
      text-align: center;
      font-size: 18px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Resultado Final</h1>
    <p>Parabéns! Você concluiu o jogo.</p>

    <p>Pontuação Final: <?php echo $score; ?></p>

    <p>Obrigado por jogar!</p>
    <a href="home.php"><button>Voltar para tela Principal</button></a>
  </div>
</body>
</html>
