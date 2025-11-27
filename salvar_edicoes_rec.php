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
$email = trim($_SESSION['email']); // Garantir que o email esteja sem espaços

// Verificar se o email está correto na sessão
var_dump($email);

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Receber os novos dados do formulário
    $novoNomeCompleto = isset($_POST['nomeCompleto']) ? trim($_POST['nomeCompleto']) : null;
    $novoNumeroTel = isset($_POST['numeroTel']) ? trim($_POST['numeroTel']) : null;
    $novoSetor = isset($_POST['setor']) ? trim($_POST['setor']) : null;
    $novoEmailPessoal = isset($_POST['emailPessoal']) ? trim($_POST['emailPessoal']) : null;
    $novoEmailCorporativo = isset($_POST['emailCorporativo']) ? trim($_POST['emailCorporativo']) : null;
    $novaBiografia = isset($_POST['biografia']) ? trim($_POST['biografia']) : null;
    $novasCompetencias = isset($_POST['competencias']) ? trim($_POST['competencias']) : null;
    $novaEmpresa = isset($_POST['empresa']) ? trim($_POST['empresa']) : null;

    // Consultar os dados atuais do recrutador
    $sql_select = "SELECT * FROM recrutadores WHERE emailPessoal = ?";
    $stmt_select = $conn->prepare($sql_select);
    $stmt_select->bind_param("s", $email);
    $stmt_select->execute();
    $result_select = $stmt_select->get_result();

    if ($result_select->num_rows > 0) {
        $row = $result_select->fetch_assoc();

        // Obter o ID do recrutador
        $recruiter_id = $row['id'];

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

        if ($novoSetor && $novoSetor != $row['setor']) {
            $campos_para_atualizar[] = "setor = ?";
            $valores_para_atualizar[] = $novoSetor;
        }

        if ($novoEmailPessoal && $novoEmailPessoal != $row['emailPessoal']) {
            $campos_para_atualizar[] = "emailPessoal = ?";
            $valores_para_atualizar[] = $novoEmailPessoal;
            // Atualizar a sessão se o email pessoal foi alterado
            $_SESSION['email'] = $novoEmailPessoal;
        }

        if ($novoEmailCorporativo && $novoEmailCorporativo != $row['emailCorporativo']) {
            $campos_para_atualizar[] = "emailCorporativo = ?";
            $valores_para_atualizar[] = $novoEmailCorporativo;
        }

        if ($novaBiografia && $novaBiografia != $row['biografia']) {
            $campos_para_atualizar[] = "biografia = ?";
            $valores_para_atualizar[] = $novaBiografia;
        }

        if ($novasCompetencias && $novasCompetencias != $row['competencias']) {
            $campos_para_atualizar[] = "competencias = ?";
            $valores_para_atualizar[] = $novasCompetencias;
        }

        if ($novaEmpresa && $novaEmpresa != $row['empresa']) {
            $campos_para_atualizar[] = "empresa = ?";
            $valores_para_atualizar[] = $novaEmpresa;
        }

        // Se houver campos para atualizar, construa a query dinâmica
        if (count($campos_para_atualizar) > 0) {
            // Montar a query de atualização dinâmica
            $sql_update = "UPDATE recrutadores SET " . implode(", ", $campos_para_atualizar) . " WHERE id = ?";
            $stmt_update = $conn->prepare($sql_update);

            if ($stmt_update === false) {
                die("Erro na preparação da consulta: " . $conn->error);
            }

            // Adicionar o ID ao final do array de valores
            $valores_para_atualizar[] = $recruiter_id;

            // Vincular os parâmetros dinamicamente
            $tipos_parametros = str_repeat("s", count($valores_para_atualizar) - 1) . "i";  // 's' para string, 'i' para ID inteiro
            $stmt_update->bind_param($tipos_parametros, ...$valores_para_atualizar);

            // Executar a consulta e verificar o sucesso
            if ($stmt_update->execute()) {
                header("Location: editar_perfil_rec.php?msg=sucesso");
            } else {
                header("Location: editar_perfil_rec.php?msg=erro");
            }

            $stmt_update->close();
        } else {
            // Se não houver mudanças, redirecionar sem fazer nada
            header("Location: editar_perfil_rec.php?msg=sem_alteracoes");
        }
    } else {
        echo "Recrutador não encontrado.";
        exit();
    }

    $stmt_select->close();
}

$conn->close();
?>
