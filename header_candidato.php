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
</style>

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
    <a href="tutorial_cand.php">Como usar o sistema</a>
    <a href="editar_perfil.php">Editar Perfil</a>
    <a href="curriculo.php">Criador de currículo</a>
    <a href="feed.php">Feed</a>
    <a href="entrevista.php">Simulação de Entrevista</a>
    <a href="recrutadores.php">Recrutadores</a>
    <a href="visualizar_evento.php">Eventos</a>
    <a href="meus_eventos.php">Eventos Salvos</a>
    <a href="sobre_nos.php">Sobre Nós</a>
    <a href="logout.php">Logout</a>
</div>

<div id="notificacaoDialog" class="dialog">
    <span class="close-btn" id="closeBtn">&times;</span>
    <h2>Notificações</h2>
    <div id="notificacoes-content">
        <!-- As notificações serão carregadas aqui -->
    </div>
</div>

<script>
    function openMenu() {
        document.getElementById("side-menu").style.width = "250px";
    }

    function closeMenu() {
        document.getElementById("side-menu").style.width = "0";
    }

    document.getElementById("menu-btn").onclick = openMenu;

    // Função para abrir e fechar o diálogo de notificações
    document.getElementById('notificacao').addEventListener('click', function() {
        getNotificacoes();
        document.getElementById('notificacaoDialog').style.display = 'block';
    });

    // Fechar o diálogo ao clicar no botão de fechar
    document.getElementById('closeBtn').addEventListener('click', function() {
        document.getElementById('notificacaoDialog').style.display = 'none';
    });

    // Fechar o diálogo ao clicar fora dele
    window.addEventListener('click', function(event) {
        const dialog = document.getElementById('notificacaoDialog');
        if (event.target == dialog) {
            dialog.style.display = 'none';
        }
    });

    // Função para obter as notificações via AJAX
    function getNotificacoes() {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'get_notificacoes.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                try {
                    var notificacoes = JSON.parse(xhr.responseText);
                    var notificacoesContent = document.getElementById('notificacoes-content');
                    notificacoesContent.innerHTML = ''; // Limpa o conteúdo anterior

                    if (notificacoes.length > 0) {
                        var html = '';
                        for (var i = 0; i < notificacoes.length; i++) {
                            var notificacao = notificacoes[i];

                            // Adicionar linha separadora
                            html += '<div style="border-bottom: 1px solid #ccc; padding: 10px 0;">';

                            // Exibir o nome do evento
                            html += '<p>' + notificacao.mensagem + '</p>';

                            // Adicionar botão "Ver evento" se o ID do evento estiver presente
                            if (notificacao.id) {
                                html += '<a href="visualizar_evento.php"' + notificacao.id + '</a>';
                                html += '<button onclick="verEvento(' + notificacao.id + ') id="btn_not">Ver evento</button>';
                            }

                            html += '</div>'; // Fechar o bloco da notificação
                        }
                        notificacoesContent.innerHTML = html;
                    } else {
                        notificacoesContent.innerHTML = 'Sem notificações';
                    }
                } catch (e) {
                    console.error('Erro ao processar as notificações:', e);
                    notificacoesContent.innerHTML = 'Erro ao carregar notificações';
                }
            } else {
                console.error('Erro na requisição AJAX');
            }
        };

        // Envie o ID do usuário (você precisa ajustar isso de acordo com sua implementação de sessão)
        var userID = 1; // Defina isso corretamente
        xhr.send('id_usuario=' + encodeURIComponent(userID));
    }

    // Função para redirecionar o usuário para a página de visualização de eventos
    function verEvento(eventoId) {
        window.location.href = 'visualizar_evento.php?id=' + eventoId;
    }
</script>