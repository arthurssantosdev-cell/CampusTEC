<?php
include('conexao.php');

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verificar se o formulário foi submetido
include('conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtenha os dados do POST
    $nomeCompleto = $_POST['nomeCompleto'] ?? '';
    $numeroTel = $_POST['numeroTel'] ?? '';
    $setor = $_POST['setor'] ?? '';
    $emailPessoal = $_POST['emailPessoal'] ?? '';
    $emailCorporativo = $_POST['emailCorporativo'] ?? '';
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Criptografa a senha
    $biografia = $_POST['biografia'] ?? '';
    $empresa = $_POST['empresa'] ?? '';

    // Prepare a consulta SQL
    $sql = "INSERT INTO recrutadores (nomeCompleto, numeroTel, setor, emailPessoal, emailCorporativo, senha, biografia, empresa) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Verifique se a preparação da consulta foi bem-sucedida
    if ($stmt === false) {
        die('Erro na preparação da consulta: ' . $conn->error);
    }

    // Associe os parâmetros
    $stmt->bind_param("ssssssss", $nomeCompleto, $numeroTel, $setor, $emailPessoal, $emailCorporativo, $senha, $biografia, $empresa);

    // Execute a consulta
    if ($stmt->execute()) {
        echo "Cadastro realizado com sucesso!";
        header('Location: login_rec.html');
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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/cadastroRec.css">
    <title>CampusTec</title>
</head>

<body>

    <div class="tudo">
        <div class="container-form">
            <form action="processaCadastroRec.php" method="POST" enctype="multipart/form-data" class="container-form">
                <input type="text" name="nomeCompleto" placeholder="Nome Completo" required>

                <input type="tel" name="numeroTel" placeholder="Número de telefone" required maxlength="15" id="numeroTel" title="Formato: (XX) XXXXX-XXXX ou (XX) XXXX-XXXX">

                <select name="setor" id="setor" required>
                    <option value="" disabled selected>Setor de atuação</option>
                    <option value="tecnologia">Tecnologia</option>
                    <option value="nutricao">Nutrição e dietética</option>
                    <option value="adm">Administração</option>
                    <option value="saude">Saúde</option>
                    <option value="seguranca">Segurança</option>
                    <option value="outro">Outro</option>
                </select>

                <input type="email" name="emailPessoal" placeholder="Email Pessoal" required>

                <input type="email" name="emailCorporativo" placeholder="Email Corporativo (opcional)">

                <div class="password-wrapper">
                    <input type="password" name="senha" placeholder="Crie uma senha" required minlength="6" id="senha">
                    <i class="bi bi-eye-fill" id="togglePassword" style="cursor: pointer;"></i>
                </div>

                <textarea rows="3" cols="9" name="biografia" placeholder="Biografia (opcional)"></textarea><br>

                <textarea rows="3" cols="9" name="competencias" placeholder="Competências (opcional)"></textarea><br>

                <input type="text" name="empresa" id="empresa" placeholder="Empresa Atual">

                <button type="submit">Cadastrar</button>
            </form>

            <p><a href="login.html">Realizar login</a></p>
        </div>

        <div class="tituloLogo">
            <div class="imagem">
                <img src="imagens/mascote.png" alt="Logo">
            </div>
            <div class="container-titulo">
                <h1>Comece a sua jornada!</h1>
            </div>
        </div>
    </div>
    <script>
        function mascaraTelefone(value) {
            value = value.replace(/\D/g, ""); // Remove caracteres não numéricos
            if (value.length > 10) {
                value = value.replace(/^(\d{2})(\d{5})(\d{4}).*/, "($1) $2-$3");
            } else if (value.length > 5) {
                value = value.replace(/^(\d{2})(\d{4})(\d{0,4}).*/, "($1) $2-$3");
            } else if (value.length > 2) {
                value = value.replace(/^(\d{2})(\d{0,5})/, "($1) $2");
            } else {
                value = value.replace(/^(\d{0,2})/, "($1");
            }
            return value;
        }

        document.getElementById('numeroTel').addEventListener('input', function(e) {
            e.target.value = mascaraTelefone(e.target.value);
        });

        function validatePassword() {
            const password = document.querySelector('input[name="senha"]').value;
            if (password.length < 6) {
                alert("A senha deve ter pelo menos 6 caracteres.");
                return false;
            }
            return true;
        }
        const togglePassword = document.querySelector('#togglePassword');
        const passwordField = document.querySelector('#senha');

        togglePassword.addEventListener('click', function() {
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            this.classList.toggle('bi-eye');
            this.classList.toggle('bi-eye-slash');
        });
    </script>
</body>

</html>