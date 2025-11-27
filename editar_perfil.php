<?php
session_start();
include('conexao.php');
include('header_candidato.php');

// Verificar se o usuário está logado
if (!isset($_SESSION['email'])) {
    // Redirecionar para a página de login se não estiver logado
    header("Location: login.html");
    exit();
}

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Obter o email do usuário logado da sessão
$email = $_SESSION['email'];

// Consultar o usuário pelo email
$sql = "SELECT * FROM usuarios WHERE emailPessoal = ?";
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
    $curso = htmlspecialchars($row['curso']);
    $emailInstitucional = htmlspecialchars($row['emailInstitucional']);
    $emailPessoal = htmlspecialchars($row['emailPessoal']);
    $biografia = htmlspecialchars($row['biografia']);
    $curriculo = htmlspecialchars($row['curriculo']);
} else {
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

        <form id="editProfileForm" action="salvar_edicoes.php" method="POST">
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
                <label for="curso">Curso:</label>
                <input type="text" id="curso" name="curso" value="<?= $curso ?>" disabled>
                <button type="button" class="edit-btn" onclick="enableEdit('curso')">Editar</button>
            </div>

            <div class="profile-item">
                <label for="emailInstitucional">Email Institucional:</label>
                <input type="email" id="emailInstitucional" name="emailInstitucional" value="<?= $emailInstitucional ?>" disabled>
                <button type="button" class="edit-btn" onclick="enableEdit('emailInstitucional')">Editar</button>
            </div>

            <div class="profile-item">
                <label for="emailPessoal">Email Pessoal:</label>
                <input type="email" id="emailPessoal" name="emailPessoal" value="<?= $emailPessoal ?>" disabled>
                <button type="button" class="edit-btn" onclick="enableEdit('emailPessoal')">Editar</button>
            </div>

            <div class="profile-item">
                <label for="biografia">Biografia:</label>
                <textarea id="biografia" name="biografia" rows="4" disabled><?= $biografia ?></textarea>
                <button type="button" class="edit-btn" onclick="enableEdit('biografia')">Editar</button>
            </div>

            <div class="profile-item">
                <label for="curriculo">Currículo:</label>
                <input type="text" id="curriculo" name="curriculo" value="<?= $curriculo ?>" disabled>
                <button type="button" class="edit-btn" onclick="enableEdit('curriculo')">Editar</button>
            </div>

            <div class="profile-item">
                <button type="submit" class="save-btn">Salvar Alterações</button>
            </div>
        </form>
    </div>

    <footer id="footer">
        <p>&copy; 2024 CampusTec. Todos os direitos reservados.</p>
    </footer>

    <?php
    // Exibir mensagem baseada em query string 'msg'
    if (isset($_GET['msg'])) {
        if ($_GET['msg'] == "sucesso") {
            echo "<p class='message'>Perfil atualizado com sucesso!</p>";
        } elseif ($_GET['msg'] == "erro") {
            echo "<p class='message' style='color:red;'>Erro ao atualizar perfil. Tente novamente.</p>";
        } elseif ($_GET['msg'] == "sem_alteracoes") {
            echo "<p class='message' style='color:blue;'>Nenhuma alteração foi feita.</p>";
        }
    }
    ?>

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
        }
    </script>
    <script src="js/notificacao.js"></script>
</body>

</html>