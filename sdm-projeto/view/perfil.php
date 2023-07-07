<?php
include 'cabelhaco.php';

session_start();
$user_id = $_SESSION['user_id'];

//conectado o banco de dados para obter os dados
include '../scripts/conexao.inc';

//consultado os dados do usuarios;
$query = "SELECT * FROM usuarios WHERE id = $user_id";
$resultado = mysqli_query($conn, $query);

//Obtém os dados do usuario
$usuario = mysqli_fetch_assoc($resultado);
?>

<body>
    <div class="principal">
        <div class="card-normal" style="text-align: center;">
            <div class="Icon_com_texto">
                <?php
                    if ($usuario['avatar'] == '') {
                        echo '<img class="profile_img" src="../image/default-avatar.png">';
                    } else {
                        echo '<img class="profile_img" src="../uploaded_img/' . $usuario['avatar'] . '">';
                    }
                    ?>
            </div>
            <div class="informacoes">
                <h1><?php echo $usuario['nome']; ?></h1>
                <!-- <h6>UID: 0123456789</h6> -->
                <hr class="divisoria">
                <p style="font-size: 20pt;">Estatísticas</p>
                <p>Perguntas enviadas: <b><?php echo $usuario['quant_perguntas_enviadas'] ?></b></p>
                <p>Partidas jogadas: <b><?php echo $usuario['partidas_jogadas'] ?></b></p>
                <p>Perguntas aceitas: <b><?php echo $usuario['perguntas_aceitas'] ?></b> </p>
                <p>Dinheiro ganho: R$ <b><?php echo $usuario['premiacao_total'] ?></b></p>
                <!--<a class="link">Ver mais estatísticas</a> esse link está incompleto, não sera apresentado agora-->
                <hr class="divisoria">

                <div>
                    <a href="editar_perfil.php">
                        <button type="button" class="btn btn-sdm btn-maior botao-texto"><b>Alterar Informações</b></button>
                    </a>
                    <!--esse botão leva para a tela de cadastro, fazer com que as informações retornem e fiquem nauquela tela
                                                        a rota tbm nao esta feita, implemnetar pf-->
                </div>
                <div>
                    <a href="home.php">
                        <button type="button" class="btn btn-sdm btn-maior botao-texto"><b>Voltar</b></button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
