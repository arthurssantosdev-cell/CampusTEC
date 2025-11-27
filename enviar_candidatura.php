<?php
include ('conexao.php');

session_start();
if (isset($_SESSION['emailPessoal']) && isset($_SESSION['senha'])) {
    $emailPessoal = $_SESSION['emailPessoal'];
    $senha = $_SESSION['senha'];

    $mail = new PHPMailer(true);

}
// Incluir os arquivos necessários do PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Verifica e processa o upload do currículo
if (isset($_FILES['curriculo']) && $_FILES['curriculo']['error'] == 0) {
    $curriculoTmp = $_FILES['curriculo']['tmp_name'];
    $curriculoNome = basename($_FILES['curriculo']['name']);
    $destino = 'uploads/' . uniqid() . '-' . $curriculoNome;
    
    // Move o arquivo do currículo para o diretório 'uploads'
    if (move_uploaded_file($curriculoTmp, $destino)) {
        // Enviar o email usando PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Configurações do servidor SMTP
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com'; // Substitua pelo seu servidor SMTP
            $mail->SMTPAuth   = true;
            $mail->Username   = $emailPessoal; // Substitua pelo seu email SMTP
            $mail->Password   = $senha; // Substitua pela senha do email
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587; // Porta SMTP (geralmente 587 para TLS)

            // Remetente e destinatário
            $mail->setFrom($email, $nome); // Email do candidato
            $mail->addAddress($email_recrutador); // Email do recrutador

            // Anexa o currículo
            $mail->addAttachment($destino); // Arquivo do currículo

            // Conteúdo do email
            $mail->isHTML(true);
            $mail->Subject = 'Nova Candidatura: ' . $nome;
            $mail->Body    = "<h1>Nova Candidatura</h1>
                              <p><strong>Nome:</strong> {$nome}</p>
                              <p><strong>Email:</strong> {$email}</p>
                              <p><strong>Biografia:</strong> {$biografia}</p>";

            // Enviar email
            $mail->send();
            echo 'Candidatura enviada com sucesso!';
        } catch (Exception $e) {
            echo "Erro ao enviar candidatura: {$mail->ErrorInfo}";
        }
    } else {
        echo 'Erro ao fazer upload do currículo.';
    }
}
?>