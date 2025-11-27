<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
include('conexao.php');

// Consulta SQL para selecionar todos os recrutadores
$sql = "SELECT id, nomeCompleto, empresa, emailCorporativo, setor FROM recrutadores";

// Prepara a consulta
if ($stmt = $conn->prepare($sql)) {
    // Executa a consulta
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica se há recrutadores e exibe em blocos
    if ($result->num_rows > 0) {
        while ($recrutador = $result->fetch_assoc()) {
            echo '<div class="vaga">';
            echo '<h2>Nome: ' . htmlspecialchars($recrutador['nomeCompleto']) . '</h2>';
            echo '<p>Empresa: ' . htmlspecialchars($recrutador['empresa']) . '</p>';
            echo '<p>Email: ' . htmlspecialchars($recrutador['emailCorporativo']) . '</p>';
            echo '<p>Área: ' . htmlspecialchars($recrutador['setor']) . '</p>';
            // Formulário para enviar o ID do recrutador
            echo '<form method="post">';
            echo '<input type="hidden" name="id" value="' . $recrutador['id'] . '">'; // Envia o ID do recrutador via POST
            echo '<a href="perfilRecrutador_view.php?id=' . $recrutador['id'] . '"><button type="button">Visualizar Perfil</button></a>';
            echo '</form>';
            echo '</div>';
        }
    } else {
        echo "<p style='font-size: 30px; color: white; text-align:center; margin:5%'>Nenhum recrutador encontrado.</p>";
    }

    // Fecha a declaração
    $stmt->close();
} else {
    echo 'Erro ao preparar a consulta: ' . $conn->error;
}

// Fecha a conexão
$conn->close();
