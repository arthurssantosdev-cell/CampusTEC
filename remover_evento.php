<?php
session_start();
include('conexao.php');

// Verificar se o usuário está logado
if (!isset($_SESSION['email'])) {
    die("Erro: usuário não está logado.");
}

// Verifica se o ID do evento foi enviado
if (isset($_POST['evento_id'])) {
    $evento_id = $_POST['evento_id'];

    // Buscar o ID do usuário baseado no email
    $user_email = $_SESSION['email'];
    $sql_buscar_usuario = "SELECT id FROM usuarios WHERE emailInstitucional = ? OR emailPessoal = ?";
    $stmt = $conn->prepare($sql_buscar_usuario);
    $stmt->bind_param("ss", $user_email, $user_email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        die("Erro: Usuário não encontrado.");
    }

    $user = $result->fetch_assoc();
    $user_id = $user['id']; // ID do usuário encontrado

    // Remover o evento salvo
    $sql_remover = "DELETE FROM eventos_salvos WHERE evento_id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql_remover);
    $stmt->bind_param("ii", $evento_id, $user_id);

    // Executar a remoção e exibir o alerta correspondente
    if ($stmt->execute()) {
        echo "<script>alert('Evento removido com sucesso.'); window.location.href = 'meus_eventos.php';</script>";
    } else {
        echo "<script>alert('Erro ao remover o evento.'); window.location.href = 'meus_eventos.php';</script>";
    }
} else {
    echo "<script>alert('ID do evento não fornecido.'); window.location.href = 'meus_eventos.php';</script>";
}

$conn->close();
