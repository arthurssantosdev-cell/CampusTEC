<?php
session_start(); // Mova esta linha para o início

include('conexao.php');
include('header_candidato.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/autoload.php';

// Verifica se o ID da vaga foi enviado via POST
if (isset($_POST['id_vaga'])) {
    $id_vaga = $_POST['id_vaga'];

    $sql_rec = "SELECT email_contratante FROM vagas_emprego WHERE id = ?";

    if ($stmt = $conn->prepare($sql_rec)) {
        $stmt->bind_param("i", $id_vaga);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $email_recrutador = $row['email_contratante'];
        } else {
            echo "Nenhum recrutador encontrado para essa vaga.";
            exit;
        }
    } else {
        die("Erro na preparação da consulta: " . $conn->error);
    }
} else {
    echo "ID da vaga não fornecido.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $biografia = $_POST['biografia'] ?? '';

    if (isset($_FILES['curriculo']) && $_FILES['curriculo']['error'] == 0) {
        $curriculoTmp = $_FILES['curriculo']['tmp_name'];
        $curriculoNome = basename($_FILES['curriculo']['name']);
        $destino = 'uploads/' . uniqid() . '-' . $curriculoNome;

        if (move_uploaded_file($curriculoTmp, $destino)) {
            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'campustec2024@gmail.com';  // Email do sistema, NÃO o do usuário
                $mail->Password   = 'xwmh dagm lgxt lsrr';  // Senha do sistema
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;

                $mail->setFrom($email, $nome); // Aqui pega o email do formulário
                $mail->addAddress($email_recrutador); // Envia para o email do recrutador

                $mail->addAttachment($destino);
                $mail->isHTML(true);
                $mail->Subject = 'Nova Candidatura: ' . $nome;
                $mail->Body    = "<h1>Nova Candidatura</h1>
                                  <p><strong>Nome:</strong> {$nome}</p>
                                  <p><strong>Email:</strong> {$email}</p>
                                  <p><strong>Biografia:</strong> {$biografia}</p>";

                $mail->send();
                echo "<script>alert('Sua candidatura foi enviada com sucesso!');</script>";
                header('Location: home.html');
                exit();
            } catch (Exception $e) {
                echo "Erro ao enviar candidatura: {$mail->ErrorInfo}";
            }
        } else {
            echo 'Erro ao fazer upload do currículo.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Candidatura</title>
    <link rel="stylesheet" href="css/candidatar.css"> <!-- O arquivo CSS fornecido -->
</head>

<body>

    <div class="main-curriculo">
        <h1>Formulário de Candidatura</h1>
        <form action="" method="POST" enctype="multipart/form-data">

            <label for="nome">Nome Completo</label>
            <input type="text" id="nome" name="nome">

            <label for="email">Email</label>
            <input type="email" id="email" name="email">

            <label for="biografia">Biografia</label>
            <textarea id="biografia" name="biografia" rows="4"></textarea>

            <label for="email_recrutador">Email do Recrutador</label>
            <input type="email" id="email_recrutador" name="email_recrutador" value="<?php echo $email_recrutador; ?>" readonly>

            <label for="curriculo">Currículo (PDF)</label>
            <input type="file" id="curriculo" name="curriculo" accept="application/pdf" required>

            <input type="hidden" name="id_vaga" value="<?php echo $id_vaga; ?>">
            <button type="submit" id="btn">Enviar Candidatura</button>
        </form>
    </div>

    <footer id="footer">
        <p>&copy; 2024 CampusTec. Todos os direitos reservados.</p>
    </footer>

</body>

<script>
    function openMenu() {
        document.getElementById("side-menu").style.width = "250px";
    }

    function closeMenu() {
        document.getElementById("side-menu").style.width = "0";
    }

    document.getElementById("menu-btn").onclick = openMenu;

    document.getElementById("btn").addEventListener("click", function() {
        this.textContent = "Candidatura Enviada"; // Muda o texto do botão
    });


    // Função para abrir e fechar o diálogo de notificações
    document.getElementById('notificacao').addEventListener('click', function() {
        getNotificacoes();
        document.getElementById('notificacaoDialog').style.display = 'block';
    });

    // Fechar o diálogo ao clicar no botão de fechar
    document.getElementById('closeBtn').addEventListener('click', function() {
        document.getElementById('notificacaoDialog').style.display = 'none';
    });

    // Fechar o diálogo ao clicar fora dele
    window.addEventListener('click', function(event) {
        const dialog = document.getElementById('notificacaoDialog');
        if (event.target == dialog) {
            dialog.style.display = 'none';
        }
    });

    // Função para obter as notificações via AJAX
    function getNotificacoes() {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'get_notificacoes.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                try {
                    var notificacoes = JSON.parse(xhr.responseText);
                    var notificacoesContent = document.getElementById('notificacoes-content');
                    notificacoesContent.innerHTML = ''; // Limpa o conteúdo anterior

                    if (notificacoes.length > 0) {
                        var html = '';
                        for (var i = 0; i < notificacoes.length; i++) {
                            var notificacao = notificacoes[i];

                            // Adicionar linha separadora
                            html += '<div style="border-bottom: 1px solid #ccc; padding: 10px 0;">';

                            // Exibir o nome do evento
                            html += '<p>' + notificacao.mensagem + '</p>';

                            // Adicionar botão "Ver evento" se o ID do evento estiver presente
                            if (notificacao.id) {
                                html += '<a href="visualizar_evento.php"' + notificacao.id + '</a>';
                                html += '<button onclick="verEvento(' + notificacao.id + ') id="btn_not">Ver evento</button>';
                            }

                            html += '</div>'; // Fechar o bloco da notificação
                        }
                        notificacoesContent.innerHTML = html;
                    } else {
                        notificacoesContent.innerHTML = 'Sem notificações';
                    }
                } catch (e) {
                    console.error('Erro ao processar as notificações:', e);
                    notificacoesContent.innerHTML = 'Erro ao carregar notificações';
                }
            } else {
                console.error('Erro na requisição AJAX');
            }
        };

        // Envie o ID do usuário (você precisa ajustar isso de acordo com sua implementação de sessão)
        var userID = 1; // Defina isso corretamente
        xhr.send('id_usuario=' + encodeURIComponent(userID));
    }

    // Função para redirecionar o usuário para a página de visualização de eventos
    function verEvento(eventoId) {
        window.location.href = 'visualizar_evento.php?id=' + eventoId;
    }
</script>

</html>