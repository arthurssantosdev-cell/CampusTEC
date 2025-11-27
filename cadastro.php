<?php
include('conexao.php');

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verificar se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Receber os dados do formulário
    $nomeCompleto = $_POST['nomeCompleto'] ?? '';
    $numeroTel = $_POST['numeroTel'] ?? '';
    $curso = $_POST['curso'] ?? '';
    $emailInstitucional = $_POST['emailInstitucional'] ?? '';
    $emailPessoal = $_POST['emailPessoal'] ?? '';
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Criptografa a senha
    $biografia = $_POST['biografia'] ?? '';

    // Tratamento do arquivo de currículo
    if (isset($_FILES['curriculo']) && $_FILES['curriculo']['error'] === 0) {
        $curriculoNome = $_FILES['curriculo']['name'];
        $curriculoTmp = $_FILES['curriculo']['tmp_name'];
        $curriculoDestino = "uploads/" . basename($curriculoNome);

        if (move_uploaded_file($curriculoTmp, $curriculoDestino)) {
            // Inserir os dados no banco
            $stmt = $conn->prepare("INSERT INTO usuarios (nomeCompleto, numeroTel, curso, emailInstitucional, emailPessoal, senha, biografia, curriculo) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssss", $nomeCompleto, $numeroTel, $curso, $emailInstitucional, $emailPessoal, $senha, $biografia, $curriculoDestino);

            if ($stmt->execute()) {
                echo "Cadastro realizado com sucesso!";
            } else {
                echo "Erro ao realizar o cadastro: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Erro ao enviar o currículo.";
        }
    } else {
        echo "Erro no upload do arquivo.";
    }
}

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
    <form action="processa_cadastro.php" method="post" enctype="multipart/form-data">
    <div class="dados">
        <input type="text" name="nomeCompleto" placeholder="Nome Completo" required>

        <input type="tel" name="numeroTel" placeholder="Número de telefone" required maxlength="15" id="numeroTel" title="Formato: (XX) XXXXX-XXXX ou (XX) XXXX-XXXX">

        <select name="curso" id="cursos" required>
            <option value="" disabled selected>Selecione seu curso</option>
            <option value="dsEtim">Desenvolvimento de sistemas (ETIM)</option>
            <option value="nutriEtim">Nutrição e dietética (ETIM)</option>
            <option value="admEtim">Administração (ETIM)</option>
            <option value="dsModular">Desenvolvimento de sistemas (Modular)</option>
            <option value="nutriModular">Nutrição e dietética (Modular)</option>
            <option value="admModular">Administração (Modular)</option>
            <option value="enfermagem">Enfermagem</option>
            <option value="seguranca">Segurança do trabalho</option>
            <option value="gastronomia">Gastronomia</option>
        </select>

        <input type="email" name="emailInstitucional" placeholder="Email Institucional" required>

        <input type="email" name="emailPessoal" placeholder="Email Pessoal" required>

        <div class="password-wrapper">
            <input type="password" name="senha" placeholder="Crie uma senha" required minlength="6" id="senha">
            <i class="bi bi-eye-fill" id="togglePassword" style="cursor: pointer;"></i>
        </div>

        <textarea name="biografia" placeholder="Biografia (opcional)"></textarea><br>

        <label for="curriculo">Currículo (opcional):</label>
        <input type="file" name="curriculo" accept=".pdf,.doc,.docx">

        <button type="submit">Cadastrar</button>
    </div>
</form>

        <p><a href="login.html">Realizar login</a></p>
    </div>
 
    <div class="tituloLogo">
        <div class="imagem">
            <img src="imagens/mascote.png" alt="Logo" >
        </div>
        <div class="container-titulo">
            <h1>Comece a sua jornada!</h1>
        </div>
    </div>
</div>

<script>
            // Função para aplicar máscara de telefone
        function mascaraTelefone(value) {
        value = value.replace(/\D/g, ""); // Remove caracteres não numéricos
        if (value.length > 10) {
            // Formato para celulares (XX) XXXXX-XXXX
            value = value.replace(/^(\d{2})(\d{5})(\d{4}).*/, "($1) $2-$3");
        } else if (value.length > 5) {
            // Formato para telefones fixos (XX) XXXX-XXXX
            value = value.replace(/^(\d{2})(\d{4})(\d{0,4}).*/, "($1) $2-$3");
        } else if (value.length > 2) {
            // Parênteses e primeiro pedaço do telefone
            value = value.replace(/^(\d{2})(\d{0,5})/, "($1) $2");
        } else {
            // Código de área
            value = value.replace(/^(\d{0,2})/, "($1");
        }
        return value;
    }

    // Aplica a máscara de telefone ao digitar
    document.getElementById('numeroTel').addEventListener('input', function (e) {
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
        function validarTelefone() {
            const telefone = document.querySelector('input[name="numeroTel"]').value;
            if (telefone.length < 11) {
                alert("O telefone deve ter pelo menos 11 caracteres.");
                return false;
            }
            return true;
        }

        const togglePassword = document.querySelector('#togglePassword');
            const passwordField = document.querySelector('#senha');

            togglePassword.addEventListener('click', function () {
                // Alterna o tipo de campo entre 'password' e 'text'
                const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', type);
                
                // Alterna o ícone entre olho aberto e fechado
                this.classList.toggle('bi-eye');
                this.classList.toggle('bi-eye-slash');
            });
    </script>
</body>
</html>
