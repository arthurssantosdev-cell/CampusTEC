<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/recrutadores.css">
    <title>CampusTec</title>
</head>

<body>
    <style>
        .dialog {
            display: none;
            position: fixed;
            top: 20%;
            left: 70%;
            /* Centralizado horizontalmente */
            transform: translate(-50%, -20%);
            /* Ajusta o posicionamento para o centro */
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            z-index: 1000;
            width: 300px;
            /* Largura fixa */
            max-height: 400px;
            /* Altura máxima aumentada para notificações extras */
            overflow-y: auto;
            /* Adiciona barra de rolagem quando necessário */
        }

        .dialog .close-btn {
            cursor: pointer;
            float: right;
            font-size: 1.5em;
        }

        .dialog h2 {
            margin: 0 0 10px;
            text-align: center;
            font-size: 1.5em;
            color: #15471F;
        }

        .dialog .notificacao {
            border-bottom: 1px solid #ccc;
            padding: 10px 0;
            transition: background-color 0.3s;
            display: flex;
            /* Adicionado para alinhamento */
            align-items: center;
            justify-content: space-between;
            /* Para melhor espaçamento */
        }

        .dialog .notificacao:hover {
            background-color: #f1f1f1;
        }

        .dialog button {
            background-color: #15471F;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        .dialog button:hover {
            background-color: #1c5f29;
        }


        body {
            background-color: #ffffff;
            background: rgb(0, 0, 0);
            background: linear-gradient(180deg, rgb(0, 0, 0) 0%, rgba(83, 136, 75, 1) 100%);
        }

        .header {
            height: 100px;
            padding: 20px 0;
            background-color: #15471F;
            box-shadow: 2px 2px 7px rgba(70, 141, 49, 0.4);
            z-index: 2;
            width: 100%;
        }

        #menu,
        #notificacao,
        #perfil {
            width: 80px;
            margin-top: -10px;
            margin-left: 15px;
            padding: 20px;
            display: flex;
            float: right;
            z-index: 0;
        }

        #menu {
            margin-top: -5px;
        }

        .vaga {
            background-color: #333;
            color: #fff;
            border-radius: 8px;
            padding: 30px;
            margin: 25px 40px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        }

        .vaga h2 {
            font-size: 1.5em;
            margin: 0 0 10px;
        }

        .vaga p {
            font-size: 1em;
            margin: 5px 0;
        }

        .vaga form {
            margin-top: 10px;
        }

        .vaga button {
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 15px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .vaga button:hover {
            background-color: #0056b3;
        }
    </style>

    <header>
        <div>
            <a href="postar_evento.php"><img src="imagens/mascote.png" id="logo" alt="CampusTec Logo"></a>
            <div class="logo">
                <div class="center">
                    <div class="menu">
                        <a href="#"><img src="imagens/notificacaoBranco.png" id="notificacao" alt="Notificações"></a>
                        <a href="perfilRecrutador.php"><img src="imagens/perfilBranco.png" id="perfil" alt="Perfil"></a>
                        <a href="#" id="menu-btn"><img src="imagens/menuBranco.png" id="menu" alt="Menu"></a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div id="side-menu" class="side-menu">
        <a href="javascript:void(0)" class="close-btn" onclick="closeMenu()">&times;</a>
        <a href="tutorial_rec.php">Como usar o sistema</a>

        <a href="candidatos.php">Candidatos</a>
        <a href="eventosRecrutador.php">Meus Eventos</a>
        <a href="postar_evento.php">Adicionar evento</a>
        <a href="editar_perfil_rec.php">Editar Perfil</a>
        <a href="sobre_nos_rec.php">Sobre Nós</a>
        <a href="logout.php">Logout</a>
    </div>

    <div id="notificacaoDialog" class="dialog">
        <span class="close-btn" id="closeBtn">&times;</span>
        <h2>Notificações</h2>
        <div id="notificacoes-content">
            <!-- As notificações serão carregadas aqui -->
        </div>
    </div>



    </div>
    <div class="search-container">
        <h1 id="buscar">Lista de Candidatos</h1>
        <div class="filter-container" style="font-size: 26px; margin-top:20px;">

            <form action="" method="GET">
                <label for="filter">Filtrar Candidatos:</label>
                <select name="filter" id="filter">
                    <optgroup label="Selecione uma opção">
                        <option value="curriculo">Com Currículo</option>
                        <option value="soft_skills">Com Soft Skills</option>
                        <option value="email_institucional">E-mail Institucional (@etec.sp.gov.br)</option>
                    </optgroup>
                    <optgroup label="Tecnologia">
                        <option value="dsEtim">Desenvolvimento de Sistemas (ETIM)</option>
                        <option value="ciencia_computacao">Ciência da Computação</option>
                    </optgroup>
                    <optgroup label="Saúde">
                        <option value="nutriEtim">Nutrição (ETIM)</option>
                        <option value="medicina">Medicina</option>
                        <option value="enfermagem">Enfermagem</option>
                        <option value="psicologia">Psicologia</option>
                        <option value="odontologia">Odontologia</option>
                        <option value="fisioterapia">Fisioterapia</option>
                        <option value="biomedicina">Biomedicina</option>
                        <option value="educacao_fisica">Educação Física</option>
                    </optgroup>
                    <optgroup label="Engenharias">
                        <option value="engenharia_civil">Engenharia Civil</option>
                        <option value="engenharia_eletrica">Engenharia Elétrica</option>
                    </optgroup>
                    <optgroup label="Humanas">
                        <option value="direito">Direito</option>
                        <option value="geografia">Geografia</option>
                        <option value="historia">História</option>
                        <option value="filosofia">Filosofia</option>
                        <option value="pedagogia">Pedagogia</option>
                        <option value="jornalismo">Jornalismo</option>
                        <option value="letras">Letras</option>
                    </optgroup>
                    <optgroup label="Exatas">
                        <option value="arquitetura">Arquitetura</option>
                        <option value="matematica">Matemática</option>
                        <option value="fisica">Física</option>
                        <option value="quimica">Química</option>
                        <option value="economia">Economia</option>
                    </optgroup>
                    <optgroup label="Artes e Comunicação">
                        <option value="publicidade">Publicidade</option>
                        <option value="design">Design</option>
                        <option value="teatro">Teatro</option>
                        <option value="musica">Música</option>
                    </optgroup>
                    <optgroup label="Administração e Negócios">
                        <option value="administracao">Administração</option>
                    </optgroup>
                    <optgroup label="Culinária e Gastronomia">
                        <option value="gastronomia">Gastronomia</option>
                    </optgroup>
                </select>

                <button type="submit">Aplicar Filtro</button>
            </form>
        </div>
        <div id="resultado-busca" class="resultado-busca">
            <!-- O arquivo PHP será incluído diretamente aqui para exibir os recrutadores -->
            <?php

            use PHPMailer\PHPMailer\PHPMailer;
            use PHPMailer\PHPMailer\Exception;

            require 'PHPMailer/src/Exception.php';
            require 'PHPMailer/src/PHPMailer.php';
            require 'PHPMailer/src/SMTP.php';

            include('conexao.php');

            // Inicializa a query base
            $sql = "SELECT id, nomeCompleto, emailPessoal, curso, numeroTel FROM usuarios";

            // Verifica se existe um filtro selecionado
            $whereClause = [];
            $filter = isset($_GET['filter']) ? $_GET['filter'] : '';

            // Adiciona filtros com base no valor do parâmetro 'filter'
            switch ($filter) {
                case 'curriculo':
                    $whereClause[] = "curriculo IS NOT NULL"; // Filtrar candidatos com currículo
                    break;
                case 'soft_skills':
                    $whereClause[] = "biografia LIKE '%soft skills%'"; // Filtrar candidatos com "soft skills" na biografia
                    break;
                case 'email_institucional':
                    $whereClause[] = "emailInstitucional LIKE '%@etec.sp.gov.br'"; // Filtrar e-mails institucionais
                    break;
                    // Filtros por curso
                case 'dsEtim':
                    $whereClause[] = "curso LIKE '%dsEtim%'";
                    break;
                case 'ciencia_computacao':
                    $whereClause[] = "curso LIKE '%Ciência da Computação%'";
                    break;
                case 'nutriEtim':
                    $whereClause[] = "curso LIKE '%Nutrição (ETIM)%'";
                    break;
                case 'medicina':
                    $whereClause[] = "curso LIKE '%Medicina%'";
                    break;
                case 'enfermagem':
                    $whereClause[] = "curso LIKE '%Enfermagem%'";
                    break;
                case 'psicologia':
                    $whereClause[] = "curso LIKE '%Psicologia%'";
                    break;
                case 'odotonlogia':
                    $whereClause[] = "curso LIKE '%Odontologia%'";
                    break;
                case 'fisioterapia':
                    $whereClause[] = "curso LIKE '%Fisioterapia%'";
                    break;
                case 'biomedicina':
                    $whereClause[] = "curso LIKE '%Biomedicina%'";
                    break;
                case 'educacao_fisica':
                    $whereClause[] = "curso LIKE '%Educação Física%'";
                    break;
                case 'engenharia_civil':
                    $whereClause[] = "curso LIKE '%Engenharia Civil%'";
                    break;
                case 'engenharia_eletrica':
                    $whereClause[] = "curso LIKE '%Engenharia Elétrica%'";
                    break;
                case 'direito':
                    $whereClause[] = "curso LIKE '%Direito%'";
                    break;
                case 'geografia':
                    $whereClause[] = "curso LIKE '%Geografia%'";
                    break;
                case 'historia':
                    $whereClause[] = "curso LIKE '%História%'";
                    break;
                case 'filosofia':
                    $whereClause[] = "curso LIKE '%Filosofia%'";
                    break;
                case 'pedagogia':
                    $whereClause[] = "curso LIKE '%Pedagogia%'";
                    break;
                case 'jornalismo':
                    $whereClause[] = "curso LIKE '%Jornalismo%'";
                    break;
                case 'letras':
                    $whereClause[] = "curso LIKE '%Letras%'";
                    break;
                case 'arquitetura':
                    $whereClause[] = "curso LIKE '%Arquitetura%'";
                    break;
                case 'matematica':
                    $whereClause[] = "curso LIKE '%Matemática%'";
                    break;
                case 'fisica':
                    $whereClause[] = "curso LIKE '%Física%'";
                    break;
                case 'quimica':
                    $whereClause[] = "curso LIKE '%Química%'";
                    break;
                case 'economia':
                    $whereClause[] = "curso LIKE '%Economia%'";
                    break;
                case 'publicidade':
                    $whereClause[] = "curso LIKE '%Publicidade%'";
                    break;
                case 'desing':
                    $whereClause[] = "curso LIKE '%Desing%'";
                    break;
                case 'teatro':
                    $whereClause[] = "curso LIKE '%Teatro%'";
                    break;
                case 'musica':
                    $whereClause[] = "curso LIKE '%Música%'";
                    break;
                case 'administracao':
                    $whereClause[] = "curso LIKE '%Administração%'";
                    break;
                case 'gastronomia':
                    $whereClause[] = "curso LIKE '%Gastronomia%'";
                    break;
                default:
                    // Sem filtro específico aplicado
                    break;
            }

            // Monta a cláusula WHERE da consulta, se houver condições
            if (!empty($whereClause)) {
                $sql .= " WHERE " . implode(" AND ", $whereClause);
            }

            // Prepara e executa a consulta
            if ($stmt = $conn->prepare($sql)) {
                // Executa a consulta
                $stmt->execute();
                $result = $stmt->get_result();

                // Verifica se há usuários e exibe em blocos
                if ($result->num_rows > 0) {
                    while ($usuario = $result->fetch_assoc()) {
                        echo '<div class="vaga">';
                        echo '<h2>Nome: ' . htmlspecialchars($usuario['nomeCompleto']) . '</h2>';
                        echo '<p>Email: ' . htmlspecialchars($usuario['emailPessoal']) . '</p>';
                        echo '<p>Curso: ' . htmlspecialchars($usuario['curso']) . '</p>';
                        echo '<p>Telefone: ' . htmlspecialchars($usuario['numeroTel']) . '</p>';
                        echo '<form method="post">';
                        echo '<input type="hidden" name="id" value="' . $usuario['id'] . '">';
                        echo '<a href="perfilUsuario_view.php?id=' . $usuario['id'] . '"><button type="button">Visualizar Perfil</button></a>';
                        echo '</form>';
                        echo '</div>';
                    }
                } else {
                    echo '<h2 style="color: white; text-align: center; margin-top: 40px;">Nenhum usuário encontrado com o filtro selecionado.</h2>';
                }

                // Fecha a declaração
                $stmt->close();
            } else {
                echo 'Erro ao preparar a consulta: ' . $conn->error;
            }

            // Fecha a conexão
            $conn->close();
            ?>

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

            // Função para lidar com o clique do botão de candidatura
            function candidatarSe(event, botaoId) {
                event.preventDefault(); // Previne o envio do formulário
                var botao = document.getElementById(botaoId);
                botao.textContent = 'Você se candidatou!';
                botao.disabled = true; // Desativa o botão após a candidatura
            }
        </script>

        <script src="js/notificacao.js"></script>
</body>

</html>