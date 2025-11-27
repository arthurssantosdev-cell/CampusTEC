<?php
include('conexao.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];

    // Verifica se o email e telefone correspondem a um usuário
    $sql = "SELECT emailPessoal, id FROM usuarios WHERE emailPessoal = ? AND numeroTel = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $email, $telefone);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($emailPessoal, $userId);
        $stmt->fetch();

        // Gerar um token seguro e expiração
        $token = bin2hex(random_bytes(50));
        $expira_em = date("Y-m-d H:i:s", strtotime('+1 hour'));

        // Armazenar o token no banco de dados
        $sqlInsert = "INSERT INTO password_resets (user_id, token, expira_em) VALUES (?, ?, ?)";
        $stmtInsert = $conn->prepare($sqlInsert);
        $stmtInsert->bind_param('iss', $userId, $token, $expira_em);
        $stmtInsert->execute();

        // Enviar e-mail com link de redefinição de senha
        $reset_link = "http://seusite.com/redefinir_senha.php?token=" . $token;
        $mail = new PHPMailer(true);
        try {
            // Configuração do servidor de e-mail
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'campustec2024@gmail.com';  // Email do sistema
            $mail->Password   = 'xwmh dagm lgxt lsrr';  // Senha do sistema
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // Configurações do e-mail
            $mail->setFrom('campustec2024@gmail.com', 'CampusTec');
            $mail->addAddress($emailPessoal);  // Email do usuário

            // Conteúdo do e-mail
            $mail->isHTML(true);
            $mail->Subject = 'Redefinir Senha';
            $mail->Body    = "Clique no link para redefinir sua senha: <a href='$reset_link'>$reset_link</a>";

            $mail->send();
            echo 'E-mail de redefinição enviado!';
        } catch (Exception $e) {
            echo "Erro ao enviar e-mail: {$mail->ErrorInfo}";
        }
    } else {
        echo "Email ou Telefone incorretos!";
    }
}
?>
