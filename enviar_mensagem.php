<?php
session_start();
include('conexao.php');

// Verificar se o usuário está logado
if (!isset($_SESSION['id'])) {
    echo "Usuário não logado.";
    exit;
}

// Verificar se a mensagem foi enviada e se o ID do destinatário está presente
if (isset($_POST['mensagem']) && isset($_POST['destinatario_id'])) {
    $mensagem = $_POST['mensagem'];
    $destinatario_id = $_POST['destinatario_id'];

    // Inserir a nova mensagem na tabela de chats
    $insertQuery = "INSERT INTO chats (remetente_id, destinatario_id, conteudo, timestamp) VALUES (?, ?, ?, NOW())";
    $stmtInsert = $conn->prepare($insertQuery);
    
    // Bind dos parâmetros
    if ($stmtInsert) {
        $stmtInsert->bind_param('iis', $_SESSION['id'], $destinatario_id, $mensagem);
        
        if ($stmtInsert->execute()) {
            echo "Mensagem enviada com sucesso.";
        } else {
            echo "Erro ao enviar mensagem.";
        }
        
        $stmtInsert->close();
    } else {
        echo "Erro ao preparar a consulta.";
    }
} else {
    echo "Mensagem ou ID do destinatário não informado.";
}
?>