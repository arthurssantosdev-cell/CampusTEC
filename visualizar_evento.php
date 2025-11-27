<?php
include('conexao.php');
session_start();
include('header_candidato.php');

// Selecionar todos os eventos
$sql = "SELECT id, nome, data, local, google_maps_link FROM eventos";
$result = $conn->query($sql);


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todos os Eventos</title>
    <link rel="stylesheet" href="css/visualizar_evento.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> <!-- Link para Bootstrap Icons -->
</head>

<body>

    <h1>Todos os Eventos</h1>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $modalId = 'credenciamentoModal' . md5($row['nome']);
            $buttonId = 'credencial' . md5($row['nome']);

            echo "<div class='event'>";
            echo "<h3>" . $row["nome"] . "</h3>";
            echo "<p>Data: " . $row["data"] . "</p>";
            echo "<p>Local: " . $row["local"] . "</p>";

            echo "<button id='$buttonId' onclick='openModal(\"$modalId\")'>Credenciar-me</button>";
            echo "<button class='save-btn' onclick='salvarEvento(" . $row['id'] . ", this)'><i class='bi bi-floppy icon-large'></i></button>"; // Ícone inicial

            if (!empty($row["google_maps_link"])) {
                $embedLink = str_replace("/maps/", "/maps/embed?", $row["google_maps_link"]);
                echo "<iframe src='$embedLink' allowfullscreen></iframe>";
            }

            echo "<div id='$modalId' class='modal'>";
            echo    "<div class='modal-content'>";
            echo        "<span class='close' onclick='closeModal(\"$modalId\")'>&times;</span>";
            echo        "<h2>Credenciamento para o evento</h2>";
            echo        "<form id='credenciamentoForm' action='enviar_credencial.php' method='post'>";
            echo            "<input type='hidden' name='nome_evento' value='" . $row['nome'] . "'>";
            echo            "<input type='hidden' name='local_evento' value='" . $row['local'] . "'>";
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
        echo "<p style='font-size: 30px; color: white; text-align:center; margin:5%'>Nenhum evento encontrado.</p>";
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

        function openModal(modalId) {
            document.getElementById(modalId).style.display = 'flex';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        window.onclick = function(event) {
            const modals = document.getElementsByClassName('modal');
            for (let i = 0; i < modals.length; i++) {
                if (event.target == modals[i]) {
                    modals[i].style.display = 'none';
                }
            }
        }

        function mudarTexto() {
            var botao = document.getElementById("meuBotao");
            botao.innerHTML = "Enviado";
        }

        function salvarEvento(eventId, button) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "processa_salvar_evento.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert(xhr.responseText); // Mostrar a resposta do servidor

                    // Mudar o ícone dependendo da resposta
                    if (xhr.responseText.includes("salvo")) {
                        button.innerHTML = "<i class='bi bi-floppy-fill'></i>"; // Ícone preenchido
                    } else {
                        button.innerHTML = "<i class='bi bi-floppy'></i>"; // Ícone padrão
                    }
                }
            };
            xhr.send("evento_id=" + eventId);
        }

        document.querySelectorAll('.dismiss-btn').forEach(button => {
            button.addEventListener('click', event => {
                const notification = event.target.closest('.notificacao');
                notification.style.display = 'none';
            });
        });
    </script>
</body>

</html>