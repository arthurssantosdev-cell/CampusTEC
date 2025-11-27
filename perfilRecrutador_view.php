<?php
session_start();

include('conexao.php');

if (isset($_GET['id'])) {
    $id_vaga = $_GET['id'];

    // Consultar o recrutador baseado na vaga selecionada
    $sql = "SELECT id, nomeCompleto, setor, biografia, empresa, emailCorporativo, competencias 
    FROM recrutadores 
    WHERE id = ?";


    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id_vaga);  // O 'i' indica que estamos passando um inteiro
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar se a consulta retornou algum resultado
    if ($result->num_rows > 0) {
        $recrutador = $result->fetch_assoc();
    } else {
        echo "Recrutador não encontrado para a vaga selecionada.";
        exit;
    }
} else {
    echo "ID não informado.";
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/perfilRecrutador.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Perfil</title>
</head>

<header>
    <div>
        <a href="home.php"><img src="imagens/mascote.png" id="logo" alt="CampusTec Logo"></a>
        <div class="logo">
            <div class="center">
                <div class="menu">
                    <a href="#"><img src="imagens/notificacaoBranco.png" id="notificacao" alt="Notificações"></a>
                    <a href="perfilUsuario.php"><img src="imagens/perfilBranco.png" id="perfil" alt="Perfil"></a>
                    <a href="#" id="menu-btn"><img src="imagens/menuBranco.png" id="menu" alt="Menu"></a>
                </div>
            </div>
        </div>
    </div>
</header>

<div id="side-menu" class="side-menu">
    <a href="javascript:void(0)" class="close-btn" onclick="closeMenu()">&times;</a>
    <a href="entrevista.php">Simulação de Entrevista</a>
    <a href="curriculo.php">Criador de currículo</a>
    <a href="feed.php">Feed</a>
    <a href="recrutadores.php">Recrutadores</a>
    <a href="visualizar_evento.php">Eventos</a>
    <a href="editar_perfil.php">Configurações</a>
    <a href="logout.php">Logout</a>
    <a href="sobre_nos.php">Sobre Nós</a>
</div>

<div id="notificacaoDialog" class="dialog">
    <span class="close-btn" id="closeBtn">&times;</span>
    <h2>Notificações</h2>
    <div id="notificacoes-content">
        <!-- As notificações serão carregadas aqui -->
    </div>
</div>


<body>
    <div class="profile-header">
        <img src="imagens/fotoCapa.jpg" alt="foto de capa" id="fotoCapa" class="fotoCapa">
        <img src="imagens/usuario-de-perfil.png" alt="Foto de Perfil" id="fotoPerfil" class="fotoPerfil">
    </div>

    <div class="profile-info">
        <h2 class="nome">Recrutador: <?php echo htmlspecialchars($recrutador['nomeCompleto']); ?></h2>
        <h3 class="cargo">Cargo: <?php echo htmlspecialchars($recrutador['setor']); ?></h3><br>
        <h3 class="instituicao">Instituição: <?php echo htmlspecialchars($recrutador['empresa']); ?></h3><br>
        <hr>
        <p class="bioTitulo">Biografia:</p>
        <p class="biografia"><?php echo htmlspecialchars($recrutador['biografia']); ?></p>

        <hr>

        <?php
        if (isset($recrutador['competencias']) && !empty($recrutador['competencias'])) {
            echo '<h3 class="habilidades">Competências:</h3><ul>';
            foreach (explode("\n", $recrutador['competencias']) as $competencia) {
                if (trim($competencia) !== '') {
                    echo '<li>' . htmlspecialchars(trim($competencia)) . '</li>';
                }
            }
            echo '</ul>';
        } else {
            echo '<p>Competências não informadas.</p>';
        }
        ?>

    </div>


    <footer id="footer">
        <p>&copy; 2024 CampusTec. Todos os direitos reservados.</p>
    </footer>

    <script>
        // side-menu
        function openMenu() {
            document.getElementById("side-menu").style.width = "250px";
        }

        function closeMenu() {
            document.getElementById("side-menu").style.width = "0";
        }
        document.getElementById("menu-btn").onclick = openMenu;
    </script>

    <script src="js/notificacao.js"></script>
</body>

</html>