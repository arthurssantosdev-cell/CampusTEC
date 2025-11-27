<?php
session_start();

// Verifica se os dados necessários foram enviados
if (isset($_POST['mensagem']) && isset($_POST['remetente_id']) && isset($_POST['destinatario_id'])) {
    
    include('conexao.php');
    // Prepara os dados recebidos via POST
    // Prepara os dados recebidos via POST
    $mensagem = $_POST['mensagem'];
    $remetenteId = $_POST['remetente_id'];
    $destinatarioId = $_POST['destinatario_id'];

    // Insere a mensagem no banco de dados
    $sql = "INSERT INTO chats (remetente_id, destinatario_id, mensagem) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Vincula os parâmetros (remetente_id, destinatario_id, mensagem)
        $stmt->bind_param("iis", $remetenteId, $destinatarioId, $mensagem);

        if ($stmt->execute()) {
            echo "Mensagem salva com sucesso!";
        } else {
            echo "Erro ao salvar a mensagem: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Erro na preparação da query: " . $conn->error;
    }

    // Fecha a conexão com o banco de dados
    $conn->close();
} else {
    echo "Dados incompletos!";
}
?>