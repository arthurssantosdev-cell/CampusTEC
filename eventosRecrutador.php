<?php
include('conexao.php');
session_start();
include('header_rec.php');

// Verifica se o usuário está logado e obtém seu ID
if (!isset($_SESSION["id_recrutador"])) {
    header("Location: login.php");
    exit();
}

$criador_id = $_SESSION["id_recrutador"];

// Seleciona eventos criados pelo usuário logado
$sql = "SELECT id, nome, data, local, google_maps_link FROM eventos WHERE criador_id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    // Erro ao preparar a consulta
    die("Erro ao preparar a consulta: " . $conn->error);
}

// Corrigido: usar "i" para inteiros no bind_param (ajuste conforme necessário)
$stmt->bind_param("i", $criador_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Eventos</title>
    <link rel="stylesheet" href="css/visualizar_evento.css">
</head>

<body>
    <h1>Meus Eventos</h1>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $modalId = 'credenciamentoModal' . md5($row['nome']);
            $buttonId = 'credencial' . md5($row['nome']);

            echo "<div class='event'>";
            echo "<h3>" . htmlspecialchars($row["nome"]) . "</h3>";
            echo "<p>Data: " . htmlspecialchars($row["data"]) . "</p>";
            echo "<p>Local: " . htmlspecialchars($row["local"]) . "</p>";

            echo "<button id='$buttonId' onclick='openModal(\"$modalId\")'>Credenciar-me</button>";

            if (!empty($row["google_maps_link"])) {
                $embedLink = str_replace("/maps/", "/maps/embed?", htmlspecialchars($row["google_maps_link"]));
                echo "<iframe src='$embedLink' allowfullscreen></iframe>";
            }

            echo "<div id='$modalId' class='modal'>";
            echo    "<div class='modal-content'>";
            echo        "<span class='close' onclick='closeModal(\"$modalId\")'>&times;</span>";
            echo        "<h2>Credenciamento para o evento</h2>";
            echo        "<form id='credenciamentoForm' action='enviar_credencial.php' method='post'>";
            echo            "<input type='hidden' name='nome_evento' value='" . htmlspecialchars($row['nome']) . "'>";
            echo            "<input type='hidden' name='local_evento' value='" . htmlspecialchars($row['local']) . "'>";
            echo            "<div class='form-group'>";
            echo                "<label for='nome'>Nome Completo:</label>";
            echo                "<input type='text' id='nome' name='nome' required>";
            echo            "</div>";
            echo            "<div class='form-group'>";
            echo                "<label for='email'>E-mail:</label>";
            echo                "<input type='email' id='email' name='email' required>";
            echo            "</div>";
            echo            "<div class='form-group'>";
            echo                "<button type='submit' onclick='mudarTexto()'>Enviar Credenciamento</button>";
            echo            "</div>";
            echo        "</form>";
            echo    "</div>";
            echo "</div>";
            echo "</div>";
        }
    } else {
        echo "<p style='font-size: 30px; color: white; margin-left: 10px'>Nenhum evento encontrado.</p>";
    }

    $stmt->close();
    $conn->close();
    ?>
</body>

</html>
