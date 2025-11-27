<?php
session_start();  // Inicia a sessão

include('conexao.php');

// Checar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['eventName'];
    $data = $_POST['eventDate'];
    $local = $_POST['eventLocation'];
    $mapLink = $_POST['eventMapLink'];

    // Verificar se o recrutador está logado
    if (!isset($_SESSION['id_recrutador'])) {
        echo "<script>alert('Você precisa estar logado para adicionar um evento.'); window.location.href='login.php';</script>";
        exit();
    }

    $criador_id = $_SESSION['id_recrutador'];

    // Verificar se o recrutador existe na tabela recrutadores
    $sql_check_user = "SELECT id FROM recrutadores WHERE id = '$criador_id'";
    $result_check_user = $conn->query($sql_check_user);

    if ($result_check_user->num_rows == 0) {
        echo "<script>alert('Recrutador não encontrado.'); window.location.href='login.php';</script>";
        exit();
    }

    // Inserir o evento no banco de dados
    $sql = "INSERT INTO eventos (nome, data, local, google_maps_link, criador_id) VALUES ('$nome', '$data', '$local', '$mapLink', '$criador_id')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Evento adicionado com sucesso!'); window.location.href='eventosRecrutador.php';</script>";
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }
}

// Fechar a conexão
$conn->close();
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="id_recrutador" content="<?php echo $_SESSION['id_recrutador'] ?? ''; ?>">
    <title>Postagem de Eventos</title>
    <link rel="stylesheet" href="css/postar_evento.css">
</head>
<?php
include('header_rec.php');
?>

<body>

    <div id="side-menu" class="side-menu">
        <a href="javascript:void(0)" class="close-btn" onclick="closeMenu()">&times;</a>
        <a href="#">Tutorial</a>
        <a href="candidatos.php">Candidatos</a>
        <a href="eventosRecrutador.php">Eventos</a>
        <a href="editar_perfil_rec.php">Configurações</a>
        <a href="tutorial_rec.php">Como usar o sistema</a>
        <a href="logout.php">Logout</a>
        <a href="sobre_nos.html">Sobre Nós</a>
    </div>

    <h1>Postagem de Eventos</h1>

    <!-- Formulário de Postagem -->
    <form action="postar_evento.php" method="POST">
        <input type="text" name="eventName" placeholder="Nome do Evento" required>
        <input type="date" name="eventDate" required>
        <input type="text" name="eventLocation" placeholder="Local do Evento" required>
        <input type="url" name="eventMapLink" placeholder="Link do Google Maps" required>
        <button type="submit" class="addEvent">Adicionar Evento</button>
    </form>

</body>

</html>