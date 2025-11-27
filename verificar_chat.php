<?php
session_start();
include('conexao.php');

// Recuperar dados do formulário
$nomeUsuario = $_POST['nomeUsuario'];
$nomeRecrutador = $_POST['nomeRecrutador'];

// Verificar se o nome do usuário existe na tabela `usuarios`
$sqlUsuario = "SELECT * FROM usuarios WHERE nomeCompleto = ?";
$stmtUsuario = $conn->prepare($sqlUsuario);
$stmtUsuario->bind_param("s", $nomeUsuario);
$stmtUsuario->execute();
$resultUsuario = $stmtUsuario->get_result();

// Verificar se o nome do recrutador existe na tabela `recrutadores`
$sqlRecrutador = "SELECT * FROM recrutadores WHERE nomeCompleto = ?";
$stmtRecrutador = $conn->prepare($sqlRecrutador);
$stmtRecrutador->bind_param("s", $nomeRecrutador);
$stmtRecrutador->execute();
$resultRecrutador = $stmtRecrutador->get_result();

if ($resultUsuario->num_rows > 0 && $resultRecrutador->num_rows > 0) {
    // Nomes estão corretos, redirecionar para a tela de chat com os dados
    $dadosUsuario = $resultUsuario->fetch_assoc();
    $dadosRecrutador = $resultRecrutador->fetch_assoc();
    
    session_start();
    $_SESSION['usuario'] = $dadosUsuario;
    $_SESSION['recrutador'] = $dadosRecrutador;
    
    header("Location: chat.php");
    exit();
} else {
    // Nomes estão incorretos, retornar à tela de pré-chat
    echo "<h3>Nome de usuário ou recrutador incorreto. Tente novamente.</h3>";
    echo "<a href='pre_chat.php'>Voltar</a>";
}

$conn->close();
?>
