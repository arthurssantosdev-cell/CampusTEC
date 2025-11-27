<?php
session_start();
include('conexao.php');

// Verificar se o usuário está logado
if (!isset($_SESSION['email'])) {
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

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Receber os novos dados do formulário
    $novoNomeCompleto = isset($_POST['nomeCompleto']) ? trim($_POST['nomeCompleto']) : null;
    $novoNumeroTel = isset($_POST['numeroTel']) ? trim($_POST['numeroTel']) : null;
    $novoCurso = isset($_POST['curso']) ? trim($_POST['curso']) : null;
    $novoEmailInstitucional = isset($_POST['emailInstitucional']) ? trim($_POST['emailInstitucional']) : null;
    $novoEmailPessoal = isset($_POST['emailPessoal']) ? trim($_POST['emailPessoal']) : null;
    $novaBiografia = isset($_POST['biografia']) ? trim($_POST['biografia']) : null;
    $novoCurriculo = isset($_POST['curriculo']) ? trim($_POST['curriculo']) : null;

    // Consultar os dados atuais do usuário
    $sql_select = "SELECT * FROM usuarios WHERE emailPessoal = ?";
    $stmt_select = $conn->prepare($sql_select);
    $stmt_select->bind_param("s", $email);
    $stmt_select->execute();
    $result_select = $stmt_select->get_result();

    if ($result_select->num_rows > 0) {
        $row = $result_select->fetch_assoc();

        // Obter o ID do usuário
        $user_id = $row['id'];

        // Verificar quais campos foram alterados
        $campos_para_atualizar = [];
        $valores_para_atualizar = [];

        // Comparar cada campo e adicionar apenas os que foram modificados
        if ($novoNomeCompleto && $novoNomeCompleto != $row['nomeCompleto']) {
            $campos_para_atualizar[] = "nomeCompleto = ?";
            $valores_para_atualizar[] = $novoNomeCompleto;
        }

        if ($novoNumeroTel && $novoNumeroTel != $row['numeroTel']) {
            $campos_para_atualizar[] = "numeroTel = ?";
            $valores_para_atualizar[] = $novoNumeroTel;
        }

        if ($novoCurso && $novoCurso != $row['curso']) {
            $campos_para_atualizar[] = "curso = ?";
            $valores_para_atualizar[] = $novoCurso;
        }

        if ($novoEmailInstitucional && $novoEmailInstitucional != $row['emailInstitucional']) {
            $campos_para_atualizar[] = "emailInstitucional = ?";
            $valores_para_atualizar[] = $novoEmailInstitucional;
        }

        if ($novoEmailPessoal && $novoEmailPessoal != $row['emailPessoal']) {
            $campos_para_atualizar[] = "emailPessoal = ?";
            $valores_para_atualizar[] = $novoEmailPessoal;
            // Atualizar a sessão se o email pessoal foi alterado
            $_SESSION['email'] = $novoEmailPessoal;
        }

        if ($novaBiografia && $novaBiografia != $row['biografia']) {
            $campos_para_atualizar[] = "biografia = ?";
            $valores_para_atualizar[] = $novaBiografia;
        }

        if ($novoCurriculo && $novoCurriculo != $row['curriculo']) {
            $campos_para_atualizar[] = "curriculo = ?";
            $valores_para_atualizar[] = $novoCurriculo;
        }

        // Se houver campos para atualizar, construa a query dinâmica
        if (count($campos_para_atualizar) > 0) {
            // Montar a query de atualização dinâmica
            $sql_update = "UPDATE usuarios SET " . implode(", ", $campos_para_atualizar) . " WHERE id = ?";
            $stmt_update = $conn->prepare($sql_update);

            if ($stmt_update === false) {
                die("Erro na preparação da consulta: " . $conn->error);
            }

            // Adicionar o ID ao final do array de valores
            $valores_para_atualizar[] = $user_id;

            // Vincular os parâmetros dinamicamente
            $tipos_parametros = str_repeat("s", count($valores_para_atualizar) - 1) . "i";  // 's' para string, 'i' para ID inteiro
            $stmt_update->bind_param($tipos_parametros, ...$valores_para_atualizar);

            // Executar a consulta e verificar o sucesso
            if ($stmt_update->execute()) {
                header("Location: editar_perfil.php?msg=sucesso");
                
            } else {
                header("Location: editar_perfil.php?msg=erro");
            }

            $stmt_update->close();
        } else {
            // Se não houver mudanças, redirecionar sem fazer nada
            header("Location: editar_perfil.php?msg=sem_alteracoes");
        }
    } else {
        echo "Usuário não encontrado.";
        exit();
    }

    $stmt_select->close();
}

$conn->close();
?>
