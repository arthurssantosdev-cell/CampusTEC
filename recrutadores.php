    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/recrutadores.css">
        <title>CampusTec</title>
    </head>
    <?php
    include('header_candidato.php');
    ?>


    <body>

        <div class="search-container">
            <h1 id="buscar">Lista de Recrutadores</h1>
            <div id="resultado-busca" class="resultado-busca">
                <!-- O arquivo PHP será incluído diretamente aqui para exibir os recrutadores -->
                <?php include 'processa_rec.php'; ?> <!-- Arquivo PHP que exibe recrutadores -->
            </div>
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
        </script>
        <script src="js/notificacao.js"></script>

    </body>

    </html>