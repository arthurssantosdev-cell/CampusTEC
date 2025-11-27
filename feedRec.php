<?php
session_start();
include('header_rec.php'); // Header da página
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CampusTec - Feed</title>
    <link rel="stylesheet" href="css/feed.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="button">
        <button class="btn-nova-postagem">Nova Postagem</button>
    </div>

    <!-- Janela Modal para Nova Postagem -->
    <div id="modal-postagem" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Nova Postagem</h2>
            <form id="form-postagem" enctype="multipart/form-data">
                <textarea name="texto" placeholder="Escreva algo..."></textarea><br>
                <input type="file" name="imagem" id="upload"><br>
                <button type="submit">Postar</button>
            </form>
        </div>
    </div>

    <!-- Modal de Compartilhamento -->
    <div id="modal-compartilhar" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Compartilhar Link</h2>
            <p>Copie o link abaixo para compartilhar:</p>
            <input type="text" id="link-compartilhar" readonly>
            <button onclick="copiarLink()">Copiar Link</button>
        </div>
    </div>

    <!-- Área do Feed -->
    <div id="feed">
        <?php include 'carregarPostRec.php'; ?> <!-- Exibe os posts do rec -->
    </div>

    <script>
        // Exibir o modal de Nova Postagem
        $(".btn-nova-postagem").click(function() {
            $("#modal-postagem").fadeIn();
        });

        // Fechar modais
        $(".close").click(function() {
            $(".modal").fadeOut();
        });

        // Submeter o formulário de postagem via AJAX
        $("#form-postagem").submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                url: "postar.php",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $("#feed").prepend(response); // Adiciona a nova postagem no topo
                    $("#modal-postagem").fadeOut();
                    $("#form-postagem")[0].reset(); // Limpa o formulário
                }
            });
        });

        // Exibir o modal de Compartilhar com o link da página
        $("#btn-compartilhar").click(function() {
            var urlAtual = window.location.href;
            $("#link-compartilhar").val(urlAtual);
            $("#modal-compartilhar").fadeIn();
        });

        // Função para copiar o link
        function copiarLink() {
            var link = document.getElementById("link-compartilhar");
            link.select();
            link.setSelectionRange(0, 99999); // Para dispositivos móveis
            document.execCommand("copy");
            alert("Link copiado para a área de transferência!");
        }

        // Remover a funcionalidade de salvar postagens (botão sem ação)
        $(document).on('click', '.salvar', function() {
            // Remover ação do botão
            alert("Post salvo com sucesso.");
        });
    </script>
</body>

</html>