<?php
include 'cabelhaco.php';
//incluido a conexao com banco de dados;
include '../scripts/conexao.inc';
//iniciado a conexao com banco de dados;
session_start();

if (isset($_POST['submit'])) {
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $select_email = mysqli_query($conn, "SELECT * FROM `usuarios` WHERE email = '$email'") or die('query failed');
  if (mysqli_num_rows($select_email) == 0) {
    $message[] = 'E-mail não encontrado no banco de dados. Por favor, <a href="cadastro.php">cadastre-se</a>';
  } else {
    $pass = mysqli_real_escape_string($conn, md5($_POST['password']));

    $select = mysqli_query($conn, "SELECT * FROM `usuarios` WHERE email = '$email' AND password = '$pass'") or die('query failed');

    if (mysqli_num_rows($select) > 0) {
      $row = mysqli_fetch_assoc($select);
      $_SESSION['user_id'] = $row['id'];
      header('location:home.php');
    } else {
      $message[] = 'E-mail ou senha incorretos!';
    }
  }
}

?>

<body class="body-anim" style="overflow: hidden;">
  <img id="logo-grande" src="../images/Show do Milhãobranco.png">
  <div class="card-normal" style="text-align: left;" style="text-align: left;">
    <div class="forms">
      <!-- conteúdo a partir daqui -->
      <form action="" method="post" enctype="multipart/form-data">

        <?php
        if (isset($message)) {
          foreach ($message as $message) {
            echo '<div class="alert alert-danger" role="alert">
          <strong>' . $message . '</strong>
              </div>';
          }
        }
        ?>

        <div class="form-group">
          <label class="text-left" for="email">Endereço de email</label>
          <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Seu email">
        </div>

        <div class="form-group">
          <label class="text-left" for="Senha">Senha</label>
          <input type="password" name="password" class="form-control" id="Senha" placeholder="Senha">
        </div>

        <div class="texto-meio">
          <button type="submit" name="submit" class="btn btn-sdm btn-maior" id="btn-entrar" disabled>Entrar</button>
        </div>
      </form>
    </div>
    <div class="botao-texto texto-meio">
      <a class="link" href="cadastro.php">Não tem uma conta? Registre-se</a>

    </div>

  </div>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <script>
    const btnEntrar = document.getElementById('btn-entrar');
    const inputEmail = document.getElementById('email');
    const inputSenha = document.getElementById('Senha');

    function verificarCampos() {
      if (inputEmail.value.trim() === '' || inputSenha.value.trim() === '') {
        btnEntrar.disabled = true;
      } else {
        btnEntrar.disabled = false;
      }
    }

    inputEmail.addEventListener('input', verificarCampos);
    inputSenha.addEventListener('input', verificarCampos);
  </script>
</body>

</html>