<?php
include 'cabelhaco.php';

include '../scripts/conexao.inc';

if (isset($_POST['submit'])) {
  $nome = mysqli_real_escape_string($conn, $_POST['nome']);
  $nickname = mysqli_real_escape_string($conn, $_POST['nickname']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
  $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
  $image = $_FILES['image']['name'];
  $image_size = $_FILES['image']['size'];
  $image_tmp_name = $_FILES['image']['tmp_name'];
  $image_folder = '../uploaded_img/' . $image;
  header('location:home.php');
  // Verificar se o email já existe no banco de dados
  $select = mysqli_query($conn, "SELECT * FROM `usuarios` WHERE email = '$email'") or die('query failed');
 
  //$insert = mysqli_query($conn, "INSERT INTO `usuarios`(nome, nickname, email, password) VALUES('$nome', '$nickname', '$email', '$pass')") or die('query failed');

  if(mysqli_num_rows($select) > 0){
    $message[] = 'Este email já está sendo utilizado por outro usuário.';
}else{
    if($pass != $cpass){
        $message[] = 'As senhas não correspondem!';
    }elseif($image_size > 2000000){
        $message[] = 'O tamanho da imagem é muito grande!';
    }else{
        $insert = mysqli_query($conn, "INSERT INTO `usuarios`(nome, nickname, email, password, avatar) VALUES('$nome', '$nickname', '$email', '$pass', '$image')") or die('query failed');

        if($insert){
            move_uploaded_file($image_tmp_name, $image_folder);
            $select = mysqli_query($conn, "SELECT * FROM `usuarios` WHERE email = '$email'") or die('query failed');
            $row = mysqli_fetch_assoc($select);
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['nome'];
            header('location:index.php');
        }else{
            $message[] = 'O cadastro falhou!';
        }
    }
}
}

?>

<body>
  <img id="logo-media" src="../images/Show do Milhãobranco.png">
  <div class="card-normal">
    <div class="card-body">
      <!-- conteúdo a partir daqui -->
      <form class="forms" method="POST" name="myForm" onsubmit="senhaOK();" enctype="multipart/form-data">
        <div class="form-group">
          <label class="text-left" for="nome">Nome</label>
          <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite seu nome completo">
        </div>

        <div class="form-group">
          <label for="Nickname">Nickname</label>
          <input type="text" class="form-control" name="nickname"  id="nickname" placeholder="Digite seu Nickname">
        </div>

        <div class="form-group">
          <label for="exampleFormControlFile1">Escolha uma imagem</label>
          <input type="file" class="form-control-file input" name="image"  id="exampleFormControlFile1">
        </div>

        <div class="form-group">
          <label class="text-left" for="email">Endereço de email</label>
          <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" placeholder="Seu email">
        </div>

        <div class="form-group">
          <label class="text-left" for="Senha">Senha</label>
          <input type="password" class="form-control" name="password" required onchange='confereSenha();'  id="Senha" placeholder="Senha">
        </div>

        <div class="form-group">
          <label class="text-left" for="ConfirmarSenha">Confirmar Senha</label>
          <input type="password" class="form-control" name="cpassword" required onchange='confereSenha();' id="ConfirmarSenha" placeholder="Confirmar Senha">
        </div>
        <div>
          <center>
          <button type="submit" name="submit" class="btn btn-sdm btn-maior">Enviar</button>
          <a href="home.php">
            <button type="button" name="voltar" class="btn btn-sdm-danger btn-maior">Voltar</button>
          </a>
</center>
        </div>
      </form>

    </div>
  </div>

  <script>
    function confereSenha(){
      const senha = document.querySelector('input[name=password]');
      const confirma = document.querySelector('input[name=cpassword]');

      if(confirma.value === senha.value){
        confirma.setCustomValidity('');
      }else{
        confirma.setCustomValidity('As senhas não conferem');
      }
    }

    function senhaOK(){
      //window.location.href = "http://www.devmedia.com.br";
     // alert("As senhas conferem!");
    }
  </script>

<?php 
  include 'footer.php'
?>