<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/sobre_nos.css">
    <title>Sobre Nós</title>
</head>
<?php
include('header_candidato.php');
?>

<body>

    <section class="sobre">
        <div class="texto-sobre">

            <h1>O que é o CampusTec</h1><br>

            <p>O CampusTec é uma plataforma online especialmente projetada para jovens estudantes da ETEC que buscam
                oportunidades de empregabilidade e crescimento profissional. Nosso compromisso é fornecer um ambiente
                virtual
                inclusivo e enriquecedor, onde os alunos possam se conectar com vagas de emprego relacionadas às suas
                áreas de
                formação e dar o próximo passo em suas carreiras com confiança.</p><br>
            <hr><br>

            <h2>O que buscamos?</h2><br>

            <p>No CampusTec, nosso objetivo é ajudar jovens estudantes da ETEC a encontrarem oportunidades que estejam
                alinhadas com
                suas áreas de estudo e interesses profissionais. Reconhecemos que muitos jovens enfrentam desafios ao
                ingressar no
                mercado de trabalho, e queremos ser a ponte que facilita essa transição. A plataforma busca oferecer
                acesso a vagas de
                emprego, estágios e programas de trainee que correspondam às qualificações e ao desenvolvimento dos
                nossos usuários,
                proporcionando uma maneira eficaz de iniciar e avançar na carreira.</p><br>
            <hr><br>

            <h2>O que oferecemos?</h2><br>

            <p>Oferecemos uma ampla gama de oportunidades de emprego e estágios em diversas áreas de formação, como
                tecnologia da
                informação, engenharia, administração, e muito mais. Os usuários podem se candidatar diretamente a vagas
                relacionadas
                às suas áreas de estudo e interesse. Além disso, a plataforma proporciona uma ferramenta para criação de
                currículos,
                seu perfil que pode ser 100% personalizado e que disponibiliza suas principais informações e
                habilidades.</p><br>
            <hr><br>

            <h2>Nossa Missão</h2><br>

            <p> No CampusTec, nossa missão é conectar estudantes da ETEC com oportunidades profissionais que ajudem a
                alcançar seu potencial máximo. Acreditamos que todos os jovens merecem a chance de
                construir uma carreira promissora e bem-sucedida. Estamos comprometidos em fornecer acesso a
                oportunidades de emprego
                relevantes e recursos de orientação profissional, permitindo que nossos usuários superem desafios e
                avancem em suas
                jornadas profissionais.</p><br>
            <hr><br>

            <h2>História e Fundação</h2><br>

            <p>O CampusTec foi fundado por um grupo de 5 indivíduos determinados a oferecer a jovens uma entrada no
                mercado de trabalho.
                Nossa jornada começou em uma aula de desenvolvimento de sistemas na escola ETEC Uirapuru, onde surgiu a
                ideia de criar
                uma plataforma para integrar oportunidades de emprego e estágio com as áreas de formação dos alunos.
                Desenvolvemos um
                espaço online onde os estudantes podem acessar vagas de emprego e receber suporte para se inserir no
                mercado de trabalho,
                independentemente de suas origens ou recursos financeiros.</p><br>
            <hr><br>

            <h2>Valores e Princípios</h2><br>

            <p>No CampusTec, valorizamos a igualdade de oportunidades, a diversidade, a inclusão, a qualidade e a
                empatia. Acreditamos
                que todos os jovens merecem acesso a oportunidades que correspondam ao seu potencial e formação. Nosso
                compromisso com a
                qualidade e a empatia orienta nossas ações e interações diárias, garantindo um ambiente de suporte e
                respeito para todos
                os nossos usuários.</p><br>
            <hr><br>

            <h2>Junte-se a Nós!</h2><br>

            <p>Estamos empolgados por você estar aqui e esperamos que você se junte à nossa comunidade. No CampusTec,
                você encontrará
                o suporte necessário para dar os primeiros passos ou avançar na sua carreira. Juntos, podemos construir
                um futuro
                brilhante para todos os jovens estudantes da ETEC, conectando-os com as oportunidades que merecem.</p>
            <br>
            <hr><br>

            <h2>Criadores</h2><br>

            <ul>
                <li>Arthur Santana dos Santos - Desenvolvedor Full-Stack <a href="https://www.linkedin.com/in/arthursantosdev/" style="color: white; font-weight: bold; font-size: 21px; margin-left: 10px;" target="_blank">LinkedIn</a></li>
                <li>Bruno Rodrigues da Costa - Gestor <a href="https://www.linkedin.com/in/bruno-rodrigues-da-costa-/" style="color: white; font-weight: bold; font-size: 21px; margin-left: 10px;" target="_blank">LinkedIn</a></li>
                <li>João Pedro da Penha Santos - Desenvolvedor Full-Stack <a href="https://www.linkedin.com/in/jpsantosdev/" style="color: white; font-weight: bold; font-size: 21px; margin-left: 10px;" target="_blank">LinkedIn</a></li>
                <li>Kaio Jesus de Sousa - Designer <a href="https://www.linkedin.com/in/kaio-sousa-47387b33a/" style="color: white; font-weight: bold; font-size: 21px; margin-left: 10px;" target="_blank">LinkedIn</a></li>
                <li>Kauê Nunes dos Santos - Designer <a href="https://www.linkedin.com/in/kauesantos2007/" style="color: white; font-weight: bold; font-size: 21px; margin-left: 10px;" target="_blank">LinkedIn</a></li>
            </ul>



        </div>


    </section>


    <!-- Rodapé -->
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

        // Adicionar evento ao ícone de menu
        document.getElementById("menu-btn").onclick = openMenu;
    </script>
</body>

</html>