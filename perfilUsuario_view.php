<?php
session_start();

include('conexao.php');


if (isset($_GET['id'])) {
    $id_vaga = $_GET['id'];

    // Consultar o recrutador baseado na vaga selecionada
    $sql = "SELECT id, nomeCompleto, curso, biografia, emailPessoal, curriculo 
            FROM usuarios
            WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id_vaga);  // O 'i' indica que estamos passando um inteiro
    $stmt->execute();
    $result = $stmt->get_result();


    // Verificar se a consulta retornou algum resultado
    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
    } else {
        echo "Usuario nao encontrado.";
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
    <link rel="stylesheet" href="css/perfilUsuario_view.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Perfil de <?php echo htmlspecialchars($usuario['nomeCompleto']) ?></title>
</head>

<body>
    <header>
        <a href="postar_evento.php">
            <div class="logo"><img src="imagens/mascote.png" id="logo" alt="CampusTec Logo"></div>
        </a>
        <div class="center">
            <div class="menu">
                <a href="#"><img src="imagens/notificacaoBranco.png" id="notificacao" alt="Notificações"></a>
                <a href="perfilUsuario.php"><img src="imagens/perfilBranco.png" id="perfil" alt="Perfil"></a>
                <a href="#" id="menu-btn"><img src="imagens/menuBranco.png" id="menu" alt="Menu"></a>
            </div>
        </div>
    </header>

    <div class="profile-header">
        <img src="imagens/fotoCapa.jpg" alt="foto de capa" id="fotoCapa" class="fotoCapa">
        <img src="imagens/usuario-de-perfil.png" alt="Foto de Perfil" id="fotoPerfil" class="fotoPerfil">
    </div>

    <div class="profile-info">
        <h2 class="nome">Candidato: <?php echo htmlspecialchars($usuario['nomeCompleto']); ?></h2>
        <h3 class="cargo">Curso: <?php echo htmlspecialchars($usuario['curso']); ?></h3><br>
        <h3 class="email">Email: <?php echo htmlspecialchars($usuario['emailPessoal']); ?></h3><br>
        <hr>
        <p class="bioTitulo">Biografia:</p>
        <p class="biografia"><?php echo htmlspecialchars($usuario['biografia']); ?></p>
        <hr>
        <h3 class="habilidades">Curriculo:</h3>
        <p class="curriculo"><?php
                                // Verificar se o campo de currículo está disponível
                                if (!empty($usuario['curriculo'])) {
                                    echo '<a href="uploads/' . htmlspecialchars($usuario['curriculo']) . '" download>';
                                    echo '<button type="button" class="btn btn-primary">Baixar Currículo</button>';
                                    echo '</a>';
                                } else {
                                    echo '<p style="color: white;">Currículo não disponível.</p>';
                                }

                                ?></p>
    </div>


    <div id="side-menu" class="side-menu">
        <a href="javascript:void(0)" class="close-btn" onclick="closeMenu()">&times;</a>
        <a href="#">Tutorial</a>
        <a href="candidatos.php">Candidatos</a>
        <a href="eventosRecrutador.php">Eventos</a>
        <a href="editar_perfil_rec.php">Configurações</a>
        <a href="logout.php">Logout</a>
        <a href="sobre_nos.html">Sobre Nós</a>
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