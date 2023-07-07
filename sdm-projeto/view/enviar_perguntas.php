<?php
include 'cabelhaco.php';
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "showdb";

// Criar a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recuperar os dados do formulário
    $enunciado = $_POST['enunciado'];
    $alternativa1 = $_POST['alternativa1'];
    $alternativa2 = $_POST['alternativa2'];
    $alternativa3 = $_POST['alternativa3'];
    $alternativa4 = $_POST['alternativa4'];
    $resposta = $_POST['resposta'];
    $criador_id = $_SESSION['user_id'];

    // Validar os dados do formulário
    $errors = array();
    if (empty($enunciado) || empty($alternativa1) || empty($alternativa2) || empty($alternativa3) || empty($alternativa4) || empty($resposta)) {
        $errors[] = 'Todos os campos são obrigatórios!';
    }

    if (count($errors) === 0) {
        // Preparar a consulta SQL para inserção da pergunta
        $sql = "INSERT INTO perguntas (enunciado, alternativa1, alternativa2, alternativa3, alternativa4, resposta, criador_id) VALUES (?, ?, ?, ?, ?, ?, ?)";

        // Preparar a declaração SQL
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssi", $enunciado, $alternativa1, $alternativa2, $alternativa3, $alternativa4, $resposta, $criador_id);

        // Executar a consulta
        if ($stmt->execute()) {
            $pergunta_id = $stmt->insert_id;
            $message = 'Pergunta enviada com sucesso! Aguardando aprovação.';

            // Selecionar 5 usuários aleatórios
            $sql_select = "SELECT id FROM usuarios ORDER BY RAND() LIMIT 5";
            $result = $conn->query($sql_select);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $usuario_id = $row["id"];

                    // Inserir na tabela de revisão
                    $sql_insert = "INSERT INTO revisoes (id_pergunta, avaliadores, aprovada) VALUES (?, ?, 0)";
                    $stmt_insert = $conn->prepare($sql_insert);
                    $stmt_insert->bind_param("ii", $pergunta_id, $usuario_id);
                    $stmt_insert->execute();
                }
            }
        } else {
            $message = 'O envio da pergunta falhou!';
        }
    }
}
?>
<body class="body-anim">
  <img id="logo-media" src="../images/Show do Milhãobranco.png">
  <div class="card-normal">
    <div class="forms">
      <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="form-group">
          <label for="pergunta">Escreva a sua pergunta aqui</label>
          <textarea class="form-control" name="enunciado" id="pergunta" rows="3" maxlength="255"></textarea>
          <small id="ajudaPergunta" class="form-text text-muted">
            A sua pergunta irá para uma avaliação antes de entrar no jogo.
            <br>Perguntas de conteúdo violento, que façam apologia a movimentos de ódio e afins <strong>NÃO SERÃO ACEITAS</strong> e o usuário pode ter a sua conta <strong>BANIDA</strong>.
          </small>
        </div>

        <div class="form-group">
          <label for="opcaoA">Opção A</label>
          <input type="text" class="form-control" id="opcaoA" name="alternativa1" placeholder="Opção A">
        </div>

        <div class="form-group">
          <label for="opcaoB">Opção B</label>
          <input type="text" class="form-control" id="opcaoB" name="alternativa2" placeholder="Opção B">
        </div>

        <div class="form-group">
          <label for="opcaoC">Opção C</label>
          <input type="text" class="form-control" name="alternativa3" id="opcaoC" placeholder="Opção C">
        </div>

        <div class="form-group">
          <label for="opcaoD">Opção D</label>
          <input type="text" class="form-control" id="opcaoD" name="alternativa4" placeholder="Opção D">
        </div>

        <div class="form-group">
          <label for="escolha">Escolha uma opção correta</label>
          <select class="custom-select" name="resposta">
            <option selected value="">Selecione a opção correta</option>
            <option value="A">Opção A</option>
            <option value="B">Opção B</option>
            <option value="C">Opção C</option>
            <option value="D">Opção D</option>
          </select>
        </div>

        <div class="texto-meio botao-texto">
          <button type="submit" class="btn btn-sdm btn-maior centralizador">
            <span class="material-symbols-outlined">
              task
            </span>
            Enviar
          </button>
          <a href="home.php" class="btn btn-sdm btn-maior centralizador">
            <span class="material-symbols-outlined">
              arrow_right_alt
            </span>
            Voltar
          </a>
        </div>
      </form>
      <?php if (isset($message)) { ?>
        <div class="alert <?php echo ($errors) ? 'alert-danger' : 'alert-success'; ?>" role="alert">
          <?php echo $message; ?>
          <?php if ($errors) { ?>
            <ul class="m-0">
              <?php foreach ($errors as $error) { ?>
                <li><?php echo $error; ?></li>
              <?php } ?>
            </ul>
          <?php } ?>
        </div>
      <?php } ?>
    </div>
  </div>
</body>

</html>
