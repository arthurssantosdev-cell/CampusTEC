<?php
include('conexao.php');
session_start();
include('header_rec.php');

// Verifica se o recrutador está logado
if (isset($_SESSION['id_recrutador'])) {
    $id_recrutador = $_SESSION['id_recrutador'];

    // Consulta para buscar as informações do recrutador
    $sql = "SELECT id, nomeCompleto, setor, biografia, competencias, empresa, emailCorporativo 
            FROM recrutadores 
            WHERE id = ?";

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Erro na preparação da consulta: " . $conn->error);
    }

    $stmt->bind_param('i', $id_recrutador);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica se algum recrutador foi encontrado
    if ($result->num_rows > 0) {
        $recrutador = $result->fetch_assoc();
    } else {
        echo "Recrutador não encontrado.";
        exit;
    }
} else {
    echo "Recrutador não logado.";
    exit;
}

// Processa o formulário de adição de vagas
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomeEmpresa = $_POST['nomeEmpresa'] ?? null;
    $empregador = $_POST['empregador'] ?? null;
    $pretensoes = $_POST['pretensoes'] ?? null;
    $descricao_vaga = $_POST['descricao_vaga'] ?? null;
    $salario = $_POST['salario'] ?? null;
    $email_contratante = $_POST['email_contratante'] ?? null;

    // Verifica se os campos obrigatórios foram preenchidos
    if (empty($nomeEmpresa) || empty($salario) || empty($descricao_vaga)) {
        echo "<script>alert('Por favor, preencha todos os campos obrigatórios.');</script>";
        exit;
    }

    // Inserção da vaga no banco de dados
    $sql = "INSERT INTO vagas_emprego (nome_empresa, empregador, descricao_vaga, salario, pretensoes, email_contratante) 
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Erro na preparação da consulta: " . $conn->error);
    }

    $stmt->bind_param("ssssss", $nomeEmpresa, $empregador, $descricao_vaga, $salario, $pretensoes, $email_contratante);

    if ($stmt->execute()) {
        echo "<script>alert('Vaga adicionada com sucesso!');</script>";
    } else {
        echo "<script>alert('Erro ao adicionar a vaga: " . addslashes($stmt->error) . "');</script>";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="id_recrutador" content="<?php echo $_SESSION['id_recrutador'] ?? ''; ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/perfilRecrutador.css">
    <title>Perfil</title>
</head>

<body>

    <div class="profile-header">
        <img src="imagens/fotoCapa.jpg" alt="foto de capa" id="fotoCapa" class="fotoCapa">
        <img src="imagens/usuario-de-perfil.png" alt="Foto de Perfil" id="fotoPerfil" class="fotoPerfil">
    </div>

    <div class="profile-info">
        <h2 class="nome">Recrutador: <?php echo htmlspecialchars($recrutador['nomeCompleto']); ?></h2>
        <h3 class="cargo">Cargo: <?php echo htmlspecialchars($recrutador['setor']); ?></h3><br>
        <h3 class="email">Email corportativo: <?php echo htmlspecialchars($recrutador['emailCorporativo']); ?></h3><br>
        <h3 class="instituicao">Instituição: <?php echo htmlspecialchars($recrutador['empresa']); ?></h3><br>
        <hr>
        <p class="bioTitulo">Biografia:</p>
        <p class="biografia"><?php echo htmlspecialchars($recrutador['biografia']); ?></p>
        <hr>
        <h3 class="habilidades">Competências:</h3>
        <ul>
            <?php
            $competencias = explode("\n", $recrutador['competencias']);
            foreach ($competencias as $competencia) {
                if (trim($competencia) !== '') {
                    echo '<li>' . htmlspecialchars(trim($competencia)) . '</li>';
                }
            }
            ?>
        </ul>
    </div>
<hr>
    <div id="vagas" class="vagas">
        <h2>Adicionar vagas</h2>
        <i class="bi bi-plus-circle abrirJanela" style="font-size: 2rem; cursor: pointer;"></i>
        <dialog class="addVaga" id="addVaga">
            <form action="perfilRecrutador.php" method="POST" class="container-form">
                <input type="text" name="nomeEmpresa" id="nomeEmpresa" placeholder="Nome da Empresa" required>
                <input type="text" name="empregador" id="empregador" placeholder="Nome contratante">
                <textarea name="descricao_vaga" id="descricao_vaga" placeholder="Sobre a Vaga" style="height: 60px; width:100%; resize: none; margin-top: 10px; font-size: 14px;" required></textarea>
                <input type="number" name="salario" id="salario" placeholder="Salário" required min="0">
                <textarea name="pretensoes" id="pretensoes" placeholder="Pretensões" style="height: 60px; width:100%; resize: none; margin-top: 10px; font-size: 14px;"></textarea>
                <input type="email" name="email_contratante" id="email_contratante" placeholder="Email contratante" required>
                <button type="submit">Enviar</button>
            </form>
            <button id="fecharVaga" class="fecharJanela">Fechar</button>
        </dialog>
    </div>



    <footer id="footer">
        <p>&copy; 2024 CampusTec. Todos os direitos reservados.</p>
    </footer>

    <script>
        function openMenu() {
            document.getElementById("side-menu").style.width = "250px";
        }

        function closeMenu() {
            document.getElementById("side-menu").style.width = "0";
        }
        document.getElementById("menu-btn").onclick = openMenu;

        // pop up vaga
        const popUp = document.getElementById('addVaga');
        const abrirJanela = document.querySelector('.abrirJanela');
        const fecharJanela = document.querySelector('.fecharJanela');

        abrirJanela.addEventListener('click', () => {
            popUp.showModal();
        });

        fecharJanela.addEventListener('click', () => {
            popUp.close();
        });

        window.addEventListener('click', (event) => {
            if (event.target === popUp) {
                popUp.close();
            }
        });
    </script>


</body>

</html>