<?php
include 'cabelhaco.php';
include '../scripts/conexao.inc';

// Verifica se o ID da partida já foi definido
if (isset($_POST['partida_id'])) {
  // ID da partida já definido, obtém o valor enviado pela solicitação AJAX
  $partida_id = $_POST['partida_id'];
} else {
  // ID da partida ainda não definido, insere um novo registro na tabela "partidas"
  $x1 = $_POST['x1'];
  $insert = "INSERT INTO `partidas`(`x1`) VALUES ('$x1')";

  // Executa a inserção e verifica se foi bem-sucedida
  if (mysqli_query($conn, $insert)) {
    // Obtém o ID da partida inserida
    $partida_id = mysqli_insert_id($conn);
    echo "Inserção realizada com sucesso. ID da partida: " . $partida_id;
  } else {
    echo "Erro ao inserir no banco de dados: " . mysqli_error($conn);
    mysqli_close($conn);
    exit; // Encerra o script em caso de erro
  }
}

// Obtém o valor do contador enviado pela solicitação AJAX
$contador = $_POST['contador'];
$contador = $contador + 1;

// Atualiza o valor do contador no banco de dados
$update = "UPDATE `partidas` SET `eliminacoesUsadas` = $contador WHERE idPartida = $partida_id";

// Executa a atualização e verifica se foi bem-sucedida
if (mysqli_query($conn, $update)) {
  echo "Atualização realizada com sucesso.";
} else {
  echo "Erro ao atualizar no banco de dados: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
