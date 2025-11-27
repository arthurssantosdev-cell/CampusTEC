<?php
include('conexao.php');

// Verificar se o formulário foi submetido via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Receber os dados do formulário
    $nomeCompleto = $_POST['nomeCompleto'] ?? '';
    $numeroTel = $_POST['numeroTel'] ?? '';
    $curso = $_POST['curso'] ?? '';
    $emailInstitucional = $_POST['emailInstitucional'] ?? '';
    $emailPessoal = $_POST['emailPessoal'] ?? '';
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Criptografando a senha
    $biografia = $_POST['biografia'] ?? null; // Permitir NULL para biografia
    $curriculoDestino = null; // Inicializa como null

    // Tratamento do upload do arquivo de currículo
    if (isset($_FILES['curriculo']) && $_FILES['curriculo']['error'] === 0) {
        $curriculoNome = $_FILES['curriculo']['name'];
        $curriculoTmp = $_FILES['curriculo']['tmp_name'];
        $curriculoDestino = "uploads/" . uniqid() . "-" . basename($curriculoNome); // Evita sobreposição de arquivos com o mesmo nome

        if (!move_uploaded_file($curriculoTmp, $curriculoDestino)) {
            echo "Erro ao mover o arquivo de currículo.";
            exit;
        }
    }

    // Inserir os dados no banco de dados
    $stmt = $conn->prepare("INSERT INTO usuarios (nomeCompleto, numeroTel, curso, emailInstitucional, emailPessoal, senha, biografia, curriculo) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    if ($stmt) {
        // Bind dos parâmetros; biografia e curriculo podem ser NULL
        $stmt->bind_param("ssssssss", $nomeCompleto, $numeroTel, $curso, $emailInstitucional, $emailPessoal, $senha, $biografia, $curriculoDestino);

        if ($stmt->execute()) {
            header("Location: login.html");
            exit();
        } else {
            echo "Erro ao realizar o cadastro: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Erro na preparação da consulta: " . $conn->error;
    }
}

// Fechar a conexão com o banco de dados
$conn->close();
