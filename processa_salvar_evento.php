<?php
session_start();
include('conexao.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['email'])) {
    echo json_encode(["status" => "error", "message" => "Erro: Usuário não está logado."]);
    exit;
}

$user_email = $_SESSION['email']; // Email do usuário logado
$evento_id = $_POST['evento_id']; // ID do evento recebido por POST

// Buscar o ID do usuário baseado no email
$sql_buscar_usuario = "SELECT id FROM usuarios WHERE emailInstitucional = ? OR emailPessoal = ?";
$stmt = $conn->prepare($sql_buscar_usuario);
$stmt->bind_param("ss", $user_email, $user_email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["status" => "error", "message" => "Erro: Usuário não encontrado."]);
    exit;
}

$user = $result->fetch_assoc();
$user_id = $user['id']; // ID do usuário encontrado

// Verificar se o evento já foi salvo
$sql_verificar = "SELECT * FROM eventos_salvos WHERE user_id = ? AND evento_id = ?";
$stmt = $conn->prepare($sql_verificar);
$stmt->bind_param("ii", $user_id, $evento_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "Este evento já foi salvo.";
} else {
    // Salvar evento
    $sql = "INSERT INTO eventos_salvos (user_id, evento_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $evento_id);

    if ($stmt->execute()) {
        echo "Evento salvo com sucesso!";
    } else {
        echo "Erro ao salvar evento.";
    }
}

$conn->close();
