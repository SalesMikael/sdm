<?php
include 'cabelhaco.php';
include '../scripts/conexao.inc';

session_start();
$user_id = $_SESSION['user_id'];

if (isset($_POST['update_profile'])) {
    $update_nickname = mysqli_real_escape_string($conn, $_POST['update_nickname']);
    $update_email = mysqli_real_escape_string($conn, $_POST['update_email']);
    $update_pass = mysqli_real_escape_string($conn, md5($_POST['novaSenha']));
    $confirm_pass = mysqli_real_escape_string($conn, md5($_POST['cnovaSenha']));

    if (!empty($_POST['update_nickname'])) {
        mysqli_query($conn, "UPDATE `usuarios` SET nickname = '$update_nickname' WHERE id = '$user_id'") or die('query failed');
    }

    if (!empty($_POST['update_email'])) {
        mysqli_query($conn, "UPDATE `usuarios` SET email = '$update_email' WHERE id = '$user_id'") or die('query failed');
    }

    if (!empty($_POST['novaSenha']) && !empty($_POST['cnovaSenha'])) {
        if ($update_pass == $confirm_pass) {
            mysqli_query($conn, "UPDATE `usuarios` SET password = '$update_pass' WHERE id = '$user_id'") or die('query failed');
            $message[] = 'Senha atualizada com sucesso!';
        } else {
            $message[] = 'As senhas não coincidem!';
        }
    }

    $update_image_tmp_name = $_FILES['novoAvatar']['tmp_name'];
    $update_image = $_FILES['novoAvatar']['name'];
    $update_image_folder = '../uploaded_img/' . $update_image;

    if (!empty($update_image)) {
        if (move_uploaded_file($update_image_tmp_name, $update_image_folder)) {
            mysqli_query($conn, "UPDATE `usuarios` SET avatar = '$update_image' WHERE id = '$user_id'") or die('query failed');
            $message[] = 'Imagem de avatar atualizada com sucesso!';
        } else {
            $message[] = 'Falha ao enviar a imagem de avatar!';
        }
    }
}

$select = mysqli_query($conn, "SELECT * FROM `usuarios` WHERE id = '$user_id'") or die('query failed');
if(mysqli_num_rows($select) > 0){
    $fetch = mysqli_fetch_assoc($select);
    $nome = $fetch['nome'];
    $nickname = $fetch['nickname'];
    $email = $fetch['email'];
}
?>

<img id="logo-media" src="../images/Show do Milhãobranco.png">
<div class="card-normal">
<?php
if($fetch['avatar'] == ''){
    echo '<img src="image/default-avatar.png">';
}else{
    echo '<img class="profile_img" src="../uploaded_img/'.$fetch['avatar'].'">';
}
?>
    <div class="card-body">
        <!-- conteúdo a partir daqui -->
        <form class="forms" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label class="text-left" for="nome">Nome</label>
                <input type="text" class="form-control" id="nome" name="update_name" value="<?php echo $nome; ?>" disabled>
            </div><!--desativar-->

            <div class="form-group">
                <label class="text-left" for="email">Endereço de email</label>
                <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Seu email"  value="<?php echo $email; ?>" disabled>
            </div><!--desativar-->

            <div class="form-group">
                <label class="text-left" for="nickname">Nickname</label>
                <input type="text" class="form-control" id="nickname" name="update_nickname" value="<?php echo $nickname; ?>">
            </div><!--desativar-->

            <div class="form-group">
                <label class="text-left" for="novoEmail">Novo endereço de email</label>
                <input type="email" class="form-control" id="novoEmail" name="update_email" aria-describedby="emailHelp" placeholder="Novo email">
            </div>

            <div class="form-group">
                <label for="novoAvatar">Escolha uma nova imagem de avatar</label>
                <input type="file" class="form-control-file" id="novoAvatar" name="novoAvatar">
            </div>

            <div class="form-group">
                <label class="text-left" for="novaSenha">Nova senha</label>
                <input type="password" class="form-control" id="novaSenha" name="novaSenha" placeholder="Nova senha">
            </div>

            <div class="form-group">
                <label class="text-left" for="cnovaSenha">Confirmar Nova senha</label>
                <input type="password" class="form-control" id="cnovaSenha" name="cnovaSenha" placeholder="Confirmar Nova senha">
            </div>

            <div class="texto-meio">
                <button type="submit" class="btn btn-maior btn-sdm botao-texto" name="update_profile">Salvar</button>
            </div>

            <div class="texto-meio">
                <a href="perfil.php">
                    <button type="button" class="btn btn-maior btn-sdm-danger">Não alterar</button>
                </a>
            </div>
        </form>
    </div>
</div>
<?php
include 'footer.php';
?>
