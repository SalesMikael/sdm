<?php
include 'cabelhaco.php';

include '../scripts/conexao.inc';

//iniciado a sessão do usuario cadastrado
session_start();
$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
};

//Destruido o login

if (isset($_GET['logout'])) {
    unset($user_id);
    session_destroy();
    header('location:login.php');
}

//Deletando a conta do usuario do banco de dados
if (isset($_POST['delete'])) {
    $delete = mysqli_query($conn, "DELETE FROM `usuarios` WHERE id = '$user_id'") or die('Sem conexão');
    unset($user_id);
    session_destroy();
}

//puxando os dados do usuario do banco de dados
$select = mysqli_query($conn, "SELECT * FROM `usuarios` WHERE id = '$user_id'") or die('Sem conexão');
if (mysqli_num_rows($select) > 0) {
    $fetch = mysqli_fetch_assoc($select);
    $nome = $fetch['nome'];
    $avatar = $fetch['avatar'];
} else {
    $nome = '';
    $avatar = '';
}

?>
<div class="principal">
    <div class="card-normal">
        <div class="Icon_com_texto">
            <?php
            if (empty($avatar)) {
                echo '<img src="../images/Icons/avatar.png">';
            } else {
                echo '<img class="profile_img" src="../uploaded_img/' . $avatar . '">';
            }
            ?>
        </div>
        <div class="informacoes">
            <h1><?php echo $nome; ?></h1>
            <div class="menu">
                <div class="botao-texto">
                    <a href="jogar.php">
                        <button type="button" class="btn btn-sdm btn-maior centralizador">
                            <span class="material-symbols-outlined">
                                play_arrow
                            </span>
                            <b>Jogar</b>
                        </button>
                    </a>
                </div>

                <div class="botao-texto">
                    <a href="perfil.php">
                        <button type="button" class="btn btn-sdm btn-maior centralizador">
                            <span class="material-symbols-outlined">
                                person
                            </span>
                            <b>Perfil</b>
                        </button>
                    </a>
                </div>


                <div class="botao-texto">
                    <a href="enviar_perguntas.php">
                        <button type="button" class="btn btn-sdm btn-maior centralizador">
                            <span class="material-symbols-outlined">
                                add_notes
                            </span>
                            <b>Enviar pergunta</b>
                        </button>
                    </a>
                </div>

                <div class="botao-texto">
                    <a href="listar_pergunta.php">
                        <button type="button" class="btn btn-sdm btn-maior centralizador">
                            <span class="material-symbols-outlined">
                                edit_note
                            </span>
                            <b>Revisar perguntas</b>
                        </button>
                    </a>
                </div>

                <div class="botao-texto">
                    <a href="home.php?logout=<?php echo $user_id; ?>">
                        <button type="button" class="btn btn-sdm-danger btn-maior centralizador">
                            <span class="material-symbols-outlined">
                                logout
                            </span>
                            <b>Sair</b>
                        </button>
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
<script>
var data1 = "x1=69";
function add(){
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "config.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
        // Callback de sucesso
        console.log("idPartida inserido no banco de dados.");
        }
    };
    
    // Define os dados a serem enviados para o arquivo PHP
    // Aqui você pode passar o valor atual do contador

    // Envia a solicitação AJAX
    xhr.send(data1);
}
</script>
<?php 
include 'footer.php'
?>