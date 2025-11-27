<?php
    include('conexao.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Obtenha os dados do POST
        $nomeCompleto = $_POST['nomeCompleto'] ?? '';
        $numeroTel = $_POST['numeroTel'] ?? '';
        $setor = $_POST['setor'] ?? '';
        $emailPessoal = $_POST['emailPessoal'] ?? '';
        $emailCorporativo = !empty($_POST['emailCorporativo']) ? $_POST['emailCorporativo'] : null; // Define como NULL se estiver vazio
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Criptografa a senha
        $biografia = !empty($_POST['biografia']) ? $_POST['biografia'] : null; // Define como NULL se estiver vazio
        $competencias = !empty($_POST['competencias']) ? $_POST['competencias'] : null; // Define como NULL se estiver vazio
        $empresa = $_POST['empresa'] ?? '';

        // Prepare a consulta SQL sem o CPF
        $sql = "INSERT INTO recrutadores (nomeCompleto, numeroTel, setor, emailPessoal, emailCorporativo, senha, biografia, competencias, empresa) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        
        // Verifique se a preparação da consulta foi bem-sucedida
        if ($stmt === false) {
            die('Erro na preparação da consulta: ' . $conn->error);
        }

        // Associe os parâmetros sem o CPF
        $stmt->bind_param("sssssssss", $nomeCompleto, $numeroTel, $setor, $emailPessoal, $emailCorporativo, $senha, $biografia, $competencias, $empresa);
        
        // Execute a consulta
        if ($stmt->execute()) {
            header("Location: login.html");
            exit();        
        } else {
            echo "Erro ao realizar o cadastro: " . $stmt->error;
        }

        // Feche a declaração
        $stmt->close();
    } else {
        echo "Erro no upload do arquivo.";
    }
    // Feche a conexão
    $conn->close();
?>
