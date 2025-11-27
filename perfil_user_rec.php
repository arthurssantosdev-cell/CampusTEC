<?php
    session_start();
    include('conexao.php');
    
    // Verificar se o usuário está logado
    if (!isset($_SESSION['email'])) {
        // Redirecionar para a página de login se não estiver logado
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

    // Consultar o usuário pelo email
    $sql = "SELECT * FROM recrutadores WHERE emailPessoal = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Erro na preparação da consulta: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Extrair os dados do usuário
        $row = $result->fetch_assoc();
        $nomeCompleto = $row['nomeCompleto'];
        $numeroTel = $row['numeroTel'];
        $cpf = $row['cpf'];
        $setor = $row['setor'];
        $emailPessoal = $row['emailPessoal'];
        $biografia = $row['biografia'];
        $empresa = $row['empresa'];
    } else {
        echo "Nenhum usuário encontrado.";
        exit;
    }

    $stmt->close();
    $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/perfilUsuario.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Perfil de <?php echo $nomeCompleto?></title>
</head>
<body>

    <header>
        <a href="postar_evento.php"><div class="logo">
            <img src="imagens/mascote.png" id="logo" alt="CampusTec Logo">
        </div></a>
        <div class="center">
            <div class="menu">
                <a href="#"><img src="imagens/notificacaoBranco.png" id="notificacao" alt="Notificações"></a>
                <a href="#"><img src="imagens/perfilBranco.png" id="perfil" alt="Perfil"></a>
                <a href="#" id="menu-btn"><img src="imagens/menuBranco.png" id="menu" alt="Menu"></a>
            </div>
        </div>
    </header>

    <div class="profile-header">
        <img src="imagens/fotoCapa.jpg" alt="foto de capa" id="fotoCapa" class="fotoCapa">
        <img src="imagens/usuario-de-perfil.png" alt="Foto de Perfil" id="fotoPerfil" class="fotoPerfil">
    </div>

    <div class="profile-info">
        <h2 class="nome"><?php echo $nomeCompleto ?></h2>
        <h3 class="cargo">Empresa: <?php echo $empresa ?></h3><br>
        <h3 class="Email"><?php echo $emailPessoal ?></h3><br>
<hr>
        <p class="bioTitulo">Biografia:</p>
        <p class="biografia"><?php echo $biografia ?></p>
<hr>


    </div>

    <div id="side-menu" class="side-menu">
        <a href="javascript:void(0)" class="close-btn" onclick="closeMenu()">&times;</a>
        <a href="#">Tutorial</a>
        <a href="curriculo.html">Criador de currículo</a>
        <a href="sobre_nos.html">Sobre Nós</a>
        <a href="login_rec.html">Login</a>
        <a href="recrutadores.html">Recrutadores</a>
        <a href="visualizar_evento.php">Eventos</a>
        <a href="#">Configurações</a>
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

        // Abrir pop-up ao clicar no ícone
        abrirJanela.addEventListener('click', () => {
            popUp.showModal();
        });

        // Fechar pop-up ao clicar no botão fechar
        fecharJanela.addEventListener('click', () => {
            popUp.close();
        });

        // Fechar pop-up clicando fora do dialog
        window.addEventListener('click', (event) => {
            if (event.target === popUp) {
                popUp.close();
            }
        });
    </script>
    
</body>
</html>
