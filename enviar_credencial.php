<?php
// Inclua o PHPMailer
include('conexao.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Inicie a sessão
session_start();

// Verifique se o formulário foi enviado via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Capture os dados enviados pelo formulário
    $nome_evento = $_POST['nome_evento'];
    $local_evento = $_POST['local_evento'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $empresa = $_POST['empresa'];
    $cargo = $_POST['cargo'];

    // Instancie o PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Configurações do servidor SMTP (ajuste conforme o seu provedor de email)
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // Servidor SMTP
        $mail->SMTPAuth   = true;
        $mail->Username   = 'campustec2024@gmail.com';  // Email do sistema
        $mail->Password   = 'xwmh dagm lgxt lsrr';  // Senha do sistema
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Remetente e destinatário
        $mail->setFrom('campustec2024@gmail.com', 'Sistema CampusTec');
        $mail->addAddress('campustec2024@gmail.com'); // Enviar para o email do evento

        // Assunto e corpo do email
        $mail->isHTML(true); // Definir como HTML
        $mail->Subject = 'Credenciamento para o evento: ' . $nome_evento;
        $mail->Body    = "
            <h2>Detalhes do Credenciamento</h2>
            <p><strong>Nome do Evento:</strong> {$nome_evento}</p>
            <p><strong>Local do Evento:</strong> {$local_evento}</p>
            <p><strong>Nome:</strong> {$nome}</p>
            <p><strong>Email:</strong> {$email}</p>
            <p><strong>Telefone:</strong> {$telefone}</p>
            <p><strong>Empresa/Instituição:</strong> {$empresa}</p>
            <p><strong>Cargo/Função:</strong> {$cargo}</p>
        ";

        // Enviar email
        $mail->send();
        echo header('Location: visualizar_evento.php');
    } catch (Exception $e) {
        echo "Erro ao enviar credenciamento: {$mail->ErrorInfo}";
    }
} else {
    echo "Erro: O formulário não foi enviado corretamente.";
}
?>
