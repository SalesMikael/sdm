<?php

include '../scripts/conexao.inc';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $perguntaId = $_POST["perguntaId"];
    $usuarioId = $_POST["usuarioId"]; // ID do usuário que aprovou a pergunta

    // Verificar se a pergunta já foi aprovada pelo usuário atual
    $queryVerificarAprovacao = "SELECT COUNT(*) AS total FROM revisoes WHERE id_pergunta = $perguntaId AND usuarios_aprovados LIKE '%$usuarioId%'";
    $resultVerificarAprovacao = mysqli_query($conn, $queryVerificarAprovacao);
    $rowVerificarAprovacao = mysqli_fetch_assoc($resultVerificarAprovacao);
    $jaAprovado = $rowVerificarAprovacao["total"];

    // Verificar o total de aprovações e usuários que aprovaram a pergunta
    $queryVerificarTotalAprovacoes = "SELECT COUNT(*) AS total, usuarios_aprovados FROM revisoes WHERE id_pergunta = $perguntaId";
    $resultTotalAprovacoes = mysqli_query($conn, $queryVerificarTotalAprovacoes);
    $rowTotalAprovacoes = mysqli_fetch_assoc($resultTotalAprovacoes);
    $totalAprovacoes = $rowTotalAprovacoes["total"];
    $usuariosAprovados = $rowTotalAprovacoes["usuarios_aprovados"];

    if ($jaAprovado == 0) {
        // Verificar se o usuário atual já aprovou a pergunta
        $usuariosAprovadosArray = explode(",", $usuariosAprovados);
        if (!in_array($usuarioId, $usuariosAprovadosArray)) {
            // Atualizar a tabela "revisoes" adicionando o ID do usuário aos usuários aprovados
            $usuariosAprovadosArray[] = $usuarioId;
            $usuariosAprovados = implode(",", $usuariosAprovadosArray);
            $queryAprovarPergunta = "UPDATE revisoes SET usuarios_aprovados = '$usuariosAprovados' WHERE id_pergunta = $perguntaId";
            mysqli_query($conn, $queryAprovarPergunta);

            // Atualizar o campo "total" na tabela "revisoes"
            $totalAprovacoes++;
            $queryAtualizarTotalAprovacoes = "UPDATE revisoes SET total = $totalAprovacoes WHERE id_pergunta = $perguntaId";
            mysqli_query($conn, $queryAtualizarTotalAprovacoes);

            // Verificar se o total de aprovações alcançou o limite
            if ($totalAprovacoes >= 1) {
                // Atualizar a tabela "revisoes" marcando a pergunta como aprovada
                $queryAtualizarAprovacao = "UPDATE revisoes SET aprovada = 1 WHERE id_pergunta = $perguntaId";
                mysqli_query($conn, $queryAtualizarAprovacao);

                // Atualizar a tabela "perguntas" definindo a coluna "revisao" como 1
                $queryAtualizarPergunta = "UPDATE perguntas SET revisao = 1 WHERE id = $perguntaId";
                mysqli_query($conn, $queryAtualizarPergunta);

                // Retornar uma resposta de sucesso
                echo "Pergunta aprovada com sucesso!";
            } else {
                // Retornar uma resposta informando que a aprovação foi registrada
                echo "Sua aprovação foi registrada. Aguarde mais aprovações para a pergunta ser aprovada.";
            }
        } else {
            // Retornar uma resposta informando que o usuário já aprovou a pergunta
            echo "Você já aprovou esta pergunta.";
        }
    }
}
?>
