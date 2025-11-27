<?php 
include('conexao.php');

if (isset($_POST["email"]) && isset($_POST["senha"]) && isset($_POST["usuario"])) {
    $email = $_POST["email"];
    $senha = $_POST["senha"];
    $tipo_usuario = $_POST["usuario"];

    if (empty($email) || empty($senha) || empty($tipo_usuario)) {
        // Redireciona para a página de login com erro
        header('Location: login.html?erro=preenchimento');
        exit;
    } else {
        // Define a consulta baseada no tipo de usuário selecionado
        if ($tipo_usuario == "candidato") {
            $sql = "SELECT * FROM usuarios WHERE emailPessoal = ?";
        } elseif ($tipo_usuario == "recrutador") {
            $sql = "SELECT * FROM recrutadores WHERE emailPessoal = ?";
        }

        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            // Log interno para o desenvolvedor (sem expor ao usuário)
            error_log("Erro na preparação da consulta: " . $conn->error);
            // Redireciona o usuário de volta com erro genérico
            header('Location: login.html?erro=sistema');
            exit;
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Verifica se a senha no banco de dados é um hash
            if (password_verify($senha, $user['senha'])) {
                session_start();

                // Armazena os dados na sessão com base no tipo de usuário
                if ($tipo_usuario == "candidato") {
                    $_SESSION['id_usuario'] = $user['id'];
                    $_SESSION['email'] = $user['emailPessoal'];
                    header('Location: perfilUsuario.php');
                } elseif ($tipo_usuario == "recrutador") {
                    $_SESSION['id_recrutador'] = $user['id'];
                    $_SESSION['email'] = $user['emailPessoal'];
                    header('Location: perfilRecrutador.php');
                }
                exit;
            } else {
                // Redireciona para a página de login com erro genérico
                header('Location: login.html?erro=login');
                exit;
            }
        } else {
            // Redireciona para a página de login com erro genérico
            header('Location: login.html?erro=login');
            exit;
        }

        $stmt->close();
    }

    $conn->close();
} else {
    // Redireciona para a página de login com erro genérico
    header('Location: login.html?erro=preenchimento');
    exit;
}
?>
