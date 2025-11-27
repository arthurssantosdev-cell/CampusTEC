<?php
session_start();
include('conexao.php');
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
    header('Location: login.html');
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
    <link rel="stylesheet" href="css/perfilUsuario.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Perfil de <?php echo $nomeCompleto; ?></title>
</head>
<?php
include('header_candidato.php');
?>

<body>

    <div class="profile-header">
        <img src="imagens/fotoCapa.jpg" alt="foto de capa" id="fotoCapa" class="fotoCapa">
        <img src="imagens/usuario-de-perfil.png" alt="Foto de Perfil" id="fotoPerfil" class="fotoPerfil">
    </div>

    <div class="profile-info">
        <h2 class="id"><?php echo $user_id; ?></h2>
        <h2 class="nome"><?php echo $nomeCompleto; ?></h2>
        <h3 class="cargo">Curso: <?php echo $curso; ?></h3><br>
        <h3 class="instituicao"><?php echo $emailPessoal; ?></h3><br>
        <hr>
        <p class="bioTitulo">Biografia:</p>
        <p class="biografia"><?php echo $biografia; ?></p>
        <hr>
        <h3 class="habilidades">Currículo:</h3><br><br>
        <div class="curriculo">
            <form action="upload_curriculo.php" method="POST" enctype="multipart/form-data">
                <input type="file" id="fileInput" name="curriculo" accept=".pdf, .doc, .docx" onchange="exibirArquivo(event)">
                <label for="fileInput" class="upload-label">Escolher Arquivo</label>
                <button type="submit">Enviar Currículo</button>
            </form>
            <div id="preview"></div>
        </div>
    </div>

    <footer id="footer">
        <p>&copy; 2024 CampusTec. Todos os direitos reservados.</p>
    </footer>

    <script>
        // side-menu
        function openMenu() {
            document.getElementById("side-menu").style.width = "250px";
        }

        function closeMenu() {
            document.getElementById("side-menu").style.width = "0";
        }
        document.getElementById("menu-btn").onclick = openMenu;
    </script>

    </body>

</html>