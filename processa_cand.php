<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

include('conexao.php');

// Inicializa a query base
$sql = "SELECT id, nomeCompleto, emailPessoal, curso, numeroTel FROM usuarios";

// Verifica se existe um filtro selecionado
$filter = isset($_GET['filter']) ? $_GET['filter'] : '';
$whereClause = ''; // Inicializa a cláusula WHERE

switch ($filter) {
    case 'curriculo':
        $whereClause = " WHERE curriculo IS NOT NULL"; // Filtrar candidatos com currículo
        break;

    case 'soft_skills':
        $whereClause = " WHERE biografia LIKE '%soft skills%'"; // Filtrar candidatos com "soft skills" na biografia
        break;

    case 'email_institucional':
        $whereClause = " WHERE emailPessoal LIKE '%@etec.sp.gov.br'"; // Filtrar e-mails institucionais
        break;

    default:
        // Filtro por área/curso (se enviado na URL)
        $area = isset($_GET['area']) ? $_GET['area'] : '';
        if (!empty($area)) {
            $whereClause = " WHERE curso = '" . $conn->real_escape_string($area) . "'"; // Filtrar candidatos por curso
        }
        break;
}

// Adiciona a cláusula WHERE à consulta SQL, se existir
$sql .= $whereClause;

// Prepara a consulta
if ($stmt = $conn->prepare($sql)) {
    // Executa a consulta
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica se há usuários e exibe em blocos
    if ($result->num_rows > 0) {
        while ($usuario = $result->fetch_assoc()) {
            echo '<div class="vaga">';
            echo '<h2>Nome: ' . htmlspecialchars($usuario['nomeCompleto']) . '</h2>';
            echo '<p>Email: ' . htmlspecialchars($usuario['emailPessoal']) . '</p>';
            echo '<p>Curso: ' . htmlspecialchars($usuario['curso']) . '</p>';
            echo '<p>Telefone: ' . htmlspecialchars($usuario['numeroTel']) . '</p>';
            echo '<form method="post">';
            echo '<input type="hidden" name="id" value="' . $usuario['id'] . '">';
            echo '<a href="perfilUsuario_view.php?id=' . $usuario['id'] . '"><button type="button">Visualizar Perfil</button></a>';
            echo '</form>';
            echo '</div>';
        }
    } else {
        echo '<p>Nenhum usuário encontrado com o filtro selecionado.</p>';
    }

    // Fecha a declaração
    $stmt->close();
} else {
    echo 'Erro ao preparar a consulta: ' . $conn->error;
}

// Fecha a conexão
$conn->close();
?>
