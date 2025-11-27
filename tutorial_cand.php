<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/home.css">
    <title>CampusTec - Tutorial</title>
</head>
<?php
include('header_candidato.php');
?>

<body>
    <iframe src="https://gamma.app/embed/9ym17sgazuu47ns" style="width: 90%; height: 550px; margin-top: 40px; margin-left: 75px" allow="fullscreen" title="CampusTec: Sistema de Empregabilidade – WebApp"></iframe>


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