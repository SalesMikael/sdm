<?php
include 'cabelhaco.php';
?>

<body class="body-anim">
    <img id="logo-grande" src="../images/Show do Milhãobranco.png">
    <div class="card-normal">
        <div class="botao-texto">
            <a href="login.php">
                <button type="button" class="btn btn-sdm btn-maior centralizador" id="entrar">
                    <span class="material-symbols-outlined">
                        login
                        </span>
                    Entrar
                </button>
            </a>
        </div>
        <div class="botao-texto">
            <a href="tela_ranking.html">
                <button type="button" class="btn btn-sdm btn-maior centralizador" id="ranking">
                    <span class="material-symbols-outlined">
                        social_leaderboard
                        </span>
                    Ranking
                </button>
    
            </a>
        </div>
        <div>
            <a class="link" href="cadastro.php">Não tem um Login? Cadastre-se</a>
        </div>
    </div>

    <?php
    include 'footer.php';
    ?>