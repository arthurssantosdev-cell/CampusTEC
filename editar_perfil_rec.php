<?php
session_start();
include('conexao.php');
include('header_rec.php');
// Verificar se o usuário está logado
if (!isset($_SESSION['email'])) {
    header("Location: login.html");
    exit();
}

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Obter o email do usuário logado da sessão
$email = trim($_SESSION['email']); // Usar trim para remover espaços

// Consultar o usuário pelo email
$sql = "SELECT id, nomeCompleto, numeroTel, setor, emailPessoal, emailCorporativo, biografia, competencias, empresa FROM recrutadores WHERE emailPessoal = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Erro na preparação da consulta: " . $conn->error);
}

$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Extrair os dados do usuário
    $row = $result->fetch_assoc();
    $user_id = htmlspecialchars($row['id']);
    $nomeCompleto = htmlspecialchars($row['nomeCompleto']);
    $numeroTel = htmlspecialchars($row['numeroTel']);
    $setor = htmlspecialchars($row['setor']);
    $emailPessoal = htmlspecialchars($row['emailPessoal']);
    $emailCorporativo = htmlspecialchars($row['emailCorporativo']);
    $biografia = htmlspecialchars($row['biografia']);
    $competencias = htmlspecialchars($row['competencias']);
    $empresa = htmlspecialchars($row['empresa']);
} else {
    echo "Email na sessão: " . $_SESSION['email'];
    echo "Nenhum usuário encontrado.";
    exit;
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/editar_perfil.css">
    <title>Editar Perfil</title>
</head>

<body>
    <div class="profile-container">
        <h2>Editar Perfil</h2>

        <!-- Exibir mensagem de sucesso/erro -->
        <?php
        $msg = isset($_GET['msg']) ? htmlspecialchars($_GET['msg']) : '';
        if (!empty($msg)): ?>
            <p class="message"><?= $msg ?></p>
        <?php endif; ?>

        <form id="editProfileForm" action="salvar_edicoes_rec.php" method="POST">

            <div class="profile-item">
                <label for="nomeCompleto">Nome Completo:</label>
                <input type="text" id="nomeCompleto" name="nomeCompleto" value="<?= $nomeCompleto ?>" disabled>
                <button type="button" class="edit-btn" onclick="enableEdit('nomeCompleto')">Editar</button>
            </div>

            <div class="profile-item">
                <label for="numeroTel">Telefone:</label>
                <input type="text" id="numeroTel" name="numeroTel" value="<?= $numeroTel ?>" disabled>
                <button type="button" class="edit-btn" onclick="enableEdit('numeroTel')">Editar</button>
            </div>

            <div class="profile-item">
                <label for="setor">Setor:</label>
                <input type="text" id="setor" name="setor" value="<?= $setor ?>" disabled>
                <button type="button" class="edit-btn" onclick="enableEdit('setor')">Editar</button>
            </div>

            <div class="profile-item">
                <label for="emailPessoal">Email Pessoal:</label>
                <input type="email" id="emailPessoal" name="emailPessoal" value="<?= $emailPessoal ?>" disabled>
                <button type="button" class="edit-btn" onclick="enableEdit('emailPessoal')">Editar</button>
            </div>

            <div class="profile-item">
                <label for="emailCorporativo">Email Corporativo:</label>
                <input type="email" id="emailCorporativo" name="emailCorporativo" value="<?= $emailCorporativo ?>" disabled>
                <button type="button" class="edit-btn" onclick="enableEdit('emailCorporativo')">Editar</button>
            </div>

            <div class="profile-item">
                <label for="biografia">Biografia:</label>
                <textarea id="biografia" name="biografia" rows="4" disabled><?= $biografia ?></textarea>
                <button type="button" class="edit-btn" onclick="enableEdit('biografia')">Editar</button>
            </div>

            <div class="profile-item">
                <label for="competencias">Competências:</label>
                <input type="text" id="competencias" name="competencias" value="<?= $competencias ?>" disabled>
                <button type="button" class="edit-btn" onclick="enableEdit('competencias')">Editar</button>
            </div>

            <div class="profile-item">
                <label for="empresa">Empresa:</label>
                <input type="text" id="empresa" name="empresa" value="<?= $empresa ?>" disabled>
                <button type="button" class="edit-btn" onclick="enableEdit('empresa')">Editar</button>
            </div>

            <div class="profile-item">
                <button type="submit" class="save-btn">Salvar Alterações</button>
            </div>

        </form>

    </div>

    <footer id="footer">
        <p>&copy; 2024 CampusTec. Todos os direitos reservados.</p>
    </footer>


    <script>
        function openMenu() {
            document.getElementById("side-menu").style.width = "250px";
        }

        function closeMenu() {
            document.getElementById("side-menu").style.width = "0";
        }

        document.getElementById("menu-btn").onclick = openMenu;

        // Função para habilitar edição dos campos
        function enableEdit(id) {
            document.getElementById(id).disabled = false;


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

            // Função para aplicar máscara de CPF
            function mascaraCPF(value) {
                value = value.replace(/\D/g, ""); // Remove caracteres não numéricos
                value = value.replace(/^(\d{3})(\d{3})(\d{3})(\d{2}).*/, "$1.$2.$3-$4"); // Aplica o formato XXX.XXX.XXX-XX
                return value;
            }

            // Aplica as máscaras ao digitar
            document.getElementById('numeroTel').addEventListener('input', function(e) {
                e.target.value = mascaraTelefone(e.target.value);
            });

            document.getElementById('cpf').addEventListener('input', function(e) {
                e.target.value = mascaraCPF(e.target.value);
            });

            function validatePassword() {
                const password = document.querySelector('input[name="senha"]').value;
                if (password.length < 6) {
                    alert("A senha deve ter pelo menos 6 caracteres.");
                    return false;
                }
                return true;
            }

        }
    </script>
</body>

</html>