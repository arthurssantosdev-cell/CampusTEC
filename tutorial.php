<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/home.css">
    <title>CampusTec</title>
</head>
<?php
include('header_candidato.php');
?>

<body>
    <style>
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

<iframe src="https://gamma.app/embed/9ym17sgazuu47ns" style="width: 90%; max-width: 100%; height: 600px; margin-left: 80px; margin-top: 20px" allow="fullscreen" title="CampusTec: Sistema de Empregabilidade – WebApp"></iframe>


    <script>
        function openMenu() {
            document.getElementById("side-menu").style.width = "250px";
        }

        function closeMenu() {
            document.getElementById("side-menu").style.width = "0";
        }

        document.getElementById("menu-btn").onclick = openMenu;

        function buscarVagas(event) {
            event.preventDefault();

            var busca = document.getElementById('busca').value;

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'processa_pesquisa_home.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    document.getElementById('resultado-busca').innerHTML = xhr.responseText;
                } else {
                    console.error('Erro na requisição AJAX');
                }
            };

            xhr.send('busca=' + encodeURIComponent(busca));
        }

        // Função para lidar com o clique do botão de candidatura
        function candidatarSe(event, botaoId) {
            event.preventDefault(); // Previne o envio do formulário
            var botao = document.getElementById(botaoId);
            botao.textContent = 'Você se candidatou!';
            botao.disabled = true; // Desativa o botão após a candidatura
        }

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
</body>

</html>