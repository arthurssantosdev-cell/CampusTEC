<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

session_start(); // Inicia a sessão para acessar os dados do usuário logado

$servername = "localhost";
$username = "campust1_campustec";
$password = "joao2364";
$dbname = "campust1_campustec";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['busca'])) {
    $busca = $_POST['busca'];

    // Consulta SQL com prepared statements
    $sql = "SELECT id AS id, descricao_vaga AS descricao, nome_empresa AS empresa, salario 
            FROM vagas_emprego 
            WHERE descricao_vaga LIKE ? OR nome_empresa LIKE ?";

    // Prepara a consulta
    if ($stmt = $conn->prepare($sql)) {
        // Cria o parâmetro para a consulta
        $param = "%$busca%";
        $stmt->bind_param("ss", $param, $param);

        // Executa a consulta
        $stmt->execute();
        $result = $stmt->get_result();

        // Verifica se há vagas e exibe em blocos
        if ($result->num_rows > 0) {
            while ($vaga = $result->fetch_assoc()) {
                echo '<div class="vaga">';
                echo '<h2>Empresa: ' . htmlspecialchars($vaga['empresa']) . '</h2>';
                echo '<p>Salário: ' . htmlspecialchars($vaga['salario']) . '</p>';
                echo '<p>Descrição: ' . htmlspecialchars($vaga['descricao']) . '</p>';
                // Formulário para enviar o ID da vaga
                echo '<form action="candidatar.php" method="post">';
                echo '<input type="hidden" name="id_vaga" value="' . $vaga['id'] . '">'; // Envia o ID da vaga via POST
                echo '<button type="submit">Candidatar-se</button>';
                echo '</form>';
                echo '</div>';
            }
        } else {
            echo '<p>Nenhuma vaga disponível.</p>';
        }

        // Fecha a declaração
        $stmt->close();
    } else {
        echo 'Erro ao preparar a consulta: ' . $conn->error;
    }
}

// Fecha a conexão
$conn->close();
