<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];
$texto = $_POST['texto'];
$arquivo = ''; // Caminho do arquivo (imagem ou vídeo)

// Verificar se um arquivo foi enviado
if (!empty($_FILES['imagem']['name'])) {
    $upload_dir = 'uploads/';
    $nome_arquivo = basename($_FILES['imagem']['name']);
    $arquivo = $upload_dir . $nome_arquivo;

    // Verificar se a pasta existe ou criar
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Mover o arquivo enviado para a pasta de uploads
    if (!move_uploaded_file($_FILES['imagem']['tmp_name'], $arquivo)) {
        die("Erro ao fazer upload do arquivo.");
    }
}

// Obter ID e tipo do usuário logado
$sql_user = "
    SELECT id, 'usuario' AS tipo_autor 
    FROM usuarios 
    WHERE emailPessoal = ? 
    UNION 
    SELECT id, 'recrutador' AS tipo_autor 
    FROM recrutadores 
    WHERE emailPessoal = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("ss", $email, $email);
$stmt_user->execute();
$stmt_user->bind_result($usuario_id, $tipo_autor);
$stmt_user->fetch();
$stmt_user->close();

// Inserir a postagem no banco de dados
if ($tipo_autor === 'usuario') {
    $sql_post = "INSERT INTO posts (usuario_id, tipo_autor, texto, imagem) VALUES (?, ?, ?, ?)";
    $stmt_post = $conn->prepare($sql_post);
    $stmt_post->bind_param("isss", $usuario_id, $tipo_autor, $texto, $arquivo);
} else if ($tipo_autor === 'recrutador') {
    $sql_post = "INSERT INTO posts (recrutador_id, tipo_autor, texto, imagem) VALUES (?, ?, ?, ?)";
    $stmt_post = $conn->prepare($sql_post);
    $stmt_post->bind_param("isss", $usuario_id, $tipo_autor, $texto, $arquivo);
} else {
    die("Erro: Tipo de autor inválido.");
}

if ($stmt_post->execute()) {
    echo "
    <div class='post'>
        <h3>Postado por você</h3>
        <p>" . htmlspecialchars($texto) . "</p>
        " . renderizarArquivo($arquivo) . "
        <button class='salvar' data-id='{$stmt_post->insert_id}'>Salvar</button>
        <button class='compartilhar'>Compartilhar</button>
    </div>";
} else {
    echo "Erro ao postar: " . $stmt_post->error;
}

$stmt_post->close();
$conn->close();

// Função para renderizar imagem ou vídeo
function renderizarArquivo($caminho)
{
    if (empty($caminho)) {
        return "";
    }

    $extensao = strtolower(pathinfo($caminho, PATHINFO_EXTENSION));
    if (in_array($extensao, ['jpg', 'jpeg', 'png', 'gif'])) {
        return "<img src='$caminho' alt='Imagem da Postagem' style='max-width:100%;'>";
    } elseif (in_array($extensao, ['mp4', 'webm', 'ogg'])) {
        return "
        <video controls style='max-width:100%;'>
            <source src='$caminho' type='video/$extensao'>
            Seu navegador não suporta este formato de vídeo.
        </video>";
    } else {
        return "<p>[Arquivo não suportado]</p>";
    }
}
