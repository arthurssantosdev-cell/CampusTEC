-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 15, 2025 at 04:28 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `campustec`
--

-- --------------------------------------------------------

--
-- Table structure for table `eventos`
--

CREATE TABLE `eventos` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `data` date NOT NULL,
  `local` varchar(255) NOT NULL,
  `google_maps_link` varchar(500) DEFAULT NULL,
  `criador_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `eventos`
--

INSERT INTO `eventos` (`id`, `nome`, `data`, `local`, `google_maps_link`, `criador_id`) VALUES
(8, 'CampusParty', '2024-07-19', 'Expocenter norte', 'https://www.google.com.br/maps/place/Expo+Center+Norte/@-23.5105962,-46.614633,17z/data=!3m1!4b1!4m6!3m5!1s0x94ce58bd535698b1:0x32d44ab158b94c5d!8m2!3d-23.5106011!4d-46.6120581!16s%2Fg%2F1211rcc4?entry=ttu&g_ep=EgoyMDI0MTEyNC4xIKXMDSoASAFQAw%3D%3D', 58);

-- --------------------------------------------------------

--
-- Table structure for table `eventos_salvos`
--

CREATE TABLE `eventos_salvos` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `evento_id` int(11) NOT NULL,
  `data_salvamento` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mensagens`
--

CREATE TABLE `mensagens` (
  `id` int(11) NOT NULL,
  `mensagem` text NOT NULL,
  `remetente_id` int(11) NOT NULL,
  `remetente_tipo` enum('candidato','recrutador') NOT NULL,
  `destinatario_id` int(11) NOT NULL,
  `destinatario_tipo` enum('candidato','recrutador') NOT NULL,
  `data_envio` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mensagens`
--

INSERT INTO `mensagens` (`id`, `mensagem`, `remetente_id`, `remetente_tipo`, `destinatario_id`, `destinatario_tipo`, `data_envio`) VALUES
(19, 'Olá. Tudo bem?', 9, 'candidato', 0, 'candidato', '2024-12-03 09:46:19');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expira_em` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`id`, `user_id`, `token`, `expira_em`) VALUES
(1, 1, 'e404b510f48fceacfff5b1592ab7e97d0595320cb62ee191291463f7b48f62857929a35ea92de463b9d914ffb130dd7783c1', '2024-09-23 15:48:12');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `recrutador_id` int(11) DEFAULT NULL,
  `tipo_autor` enum('usuario','recrutador') NOT NULL,
  `texto` text DEFAULT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `data_postagem` timestamp NOT NULL DEFAULT current_timestamp()
) ;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `usuario_id`, `recrutador_id`, `tipo_autor`, `texto`, `imagem`, `data_postagem`) VALUES
(6, 9, NULL, 'usuario', 'Campus Party', 'uploads/cpbr.png', '2024-12-03 12:44:50');

-- --------------------------------------------------------

--
-- Table structure for table `posts_salvos`
--

CREATE TABLE `posts_salvos` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `data_salvo` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `recrutadores`
--

CREATE TABLE `recrutadores` (
  `id` int(11) NOT NULL,
  `nomeCompleto` varchar(255) NOT NULL,
  `numeroTel` varchar(20) NOT NULL,
  `setor` varchar(100) NOT NULL,
  `emailPessoal` varchar(255) NOT NULL,
  `emailCorporativo` varchar(255) DEFAULT NULL,
  `senha` varchar(255) NOT NULL,
  `biografia` text DEFAULT NULL,
  `competencias` text DEFAULT NULL,
  `empresa` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recrutadores`
--

INSERT INTO `recrutadores` (`id`, `nomeCompleto`, `numeroTel`, `setor`, `emailPessoal`, `emailCorporativo`, `senha`, `biografia`, `competencias`, `empresa`) VALUES
(22, 'Steve Jobs', '1234567890', 'Tecnologia', 'stevejobs@apple.com', 'steve@apple.com', 'senha123', 'Steve Jobs foi co-fundador da Apple Inc. e um dos visionários mais notáveis da era da computação pessoal. Ele desempenhou um papel fundamental no design de produtos inovadores como o iPhone, iPad e MacBook, revolucionando a forma como as pessoas interagem com a tecnologia. Jobs era conhecido por sua busca implacável pela perfeição no design e pela criação de um ecossistema que combina hardware e software de forma única.', 'Inovação, liderança, design de produto, visão estratégica', 'Apple'),
(23, 'Mark Zuckerberg', '1234567891', 'Tecnologia', 'mark@facebook.com', 'mark@meta.com', 'senha123', 'Mark Zuckerberg é co-fundador e CEO do Facebook (agora Meta), uma das maiores redes sociais do mundo. Desde a criação do Facebook em 2004, ele transformou a maneira como as pessoas se conectam e interagem online. Além de seu trabalho com o Facebook, Zuckerberg também tem investido em novas tecnologias, incluindo realidade virtual e inteligência artificial, com a visão de conectar o mundo em formas ainda mais profundas.', 'Programação, redes sociais, liderança, inovação tecnológica', 'Meta'),
(24, 'Elon Musk', '1234567892', 'Tecnologia', 'elon@spacex.com', 'elon@tesla.com', 'senha123', 'Elon Musk é um dos empresários mais influentes do século XXI, conhecido por suas empresas revolucionárias como Tesla e SpaceX. Musk lidera a Tesla na busca por um futuro sustentável com carros elétricos e energia renovável, enquanto a SpaceX visa tornar a exploração espacial acessível e viável para o ser humano. Além disso, Musk tem investido em tecnologias de ponta, como inteligência artificial e transporte de alta velocidade.', 'Inovação, engenharia, empreendedorismo, energia sustentável', 'Tesla, SpaceX'),
(25, 'Sundar Pichai', '1234567893', 'Tecnologia', 'sundar@google.com', 'sundar@google.com', 'senha123', 'Sundar Pichai é o CEO do Google e da Alphabet, tendo liderado a transformação do Google em uma das maiores empresas de tecnologia do mundo. Desde que assumiu o cargo de CEO em 2015, ele tem se concentrado no crescimento de áreas como inteligência artificial, computação em nuvem e hardware. Pichai também é conhecido por seu estilo de liderança acessível e por seu trabalho em promover a inclusão dentro da tecnologia.', 'Liderança, inteligência artificial, software, nuvem', 'Google'),
(26, 'Jeff Bezos', '1234567894', 'E-commerce', 'jeff@amazon.com', 'jeff@amazon.com', 'senha123', 'Jeff Bezos é o fundador da Amazon, a maior varejista online do mundo. Desde a criação da empresa em 1994, Bezos revolucionou o comércio eletrônico, criando uma plataforma que vende tudo, de livros a produtos tecnológicos. Ele também fundou a Blue Origin, uma empresa espacial focada em viagens comerciais ao espaço. Bezos é um defensor da inovação e da eficiência, sempre buscando novas maneiras de otimizar a experiência do cliente e expandir os negócios.', 'E-commerce, logística, inovação, empreendedorismo', 'Amazon'),
(27, 'Bill Gates', '1234567895', 'Tecnologia', 'billgates@microsoft.com', 'billgates@microsoft.com', 'senha123', 'Bill Gates é um dos fundadores da Microsoft e um dos homens mais ricos do mundo. Desde o início da Microsoft nos anos 70, ele tem sido uma figura chave na revolução do software, com o Windows se tornando o sistema operacional dominante no mundo. Após sua saída da Microsoft, Gates se concentrou em filantropia por meio da Fundação Bill e Melinda Gates, focando na saúde global, educação e redução da pobreza.', 'Tecnologia, filantropia, liderança, inovação', 'Microsoft'),
(28, 'Larry Page', '1234567896', 'Tecnologia', 'larry@google.com', 'larry@alphabet.com', 'senha123', 'Larry Page é um dos co-fundadores do Google, a gigante de tecnologia que começou como um motor de busca e se expandiu para diversas outras áreas, como publicidade digital, computação em nuvem e inteligência artificial. Além de seu trabalho no Google, Page tem sido um defensor do desenvolvimento de novas tecnologias para melhorar a vida humana e tornar o mundo mais conectado.', 'Programação, inovação, tecnologia, inteligência artificial', 'Google'),
(29, 'Sergey Brin', '1234567897', 'Tecnologia', 'sergey@google.com', 'sergey@alphabet.com', 'senha123', 'Sergey Brin é co-fundador do Google e uma das mentes por trás da criação de um dos motores de busca mais poderosos do mundo. Junto com Larry Page, Brin ajudou a fundar o Google, que se tornou a principal ferramenta de pesquisa da internet. Ele também esteve envolvido no desenvolvimento de vários outros projetos no Google, incluindo o sistema operacional Android e o Google Glass.', 'Tecnologia, inovação, empreendedorismo', 'Google'),
(30, 'Tim Cook', '1234567898', 'Tecnologia', 'tim@apple.com', 'tim@apple.com', 'senha123', 'Tim Cook é o CEO da Apple, empresa que revolucionou a tecnologia de consumo com dispositivos como o iPhone, iPad e MacBook. Cook assumiu a liderança da Apple após a morte de Steve Jobs e manteve a empresa como uma das mais valiosas do mundo. Ele é conhecido por sua atenção aos detalhes, foco em sustentabilidade e por garantir que a Apple mantenha sua posição como líder em inovação tecnológica.', 'Liderança, inovação, sustentabilidade, estratégia empresarial', 'Apple'),
(31, 'Jack Dorsey', '1234567899', 'Tecnologia', 'jack@twitter.com', 'jack@block.com', 'senha123', 'Jack Dorsey é o co-fundador e ex-CEO do Twitter, a plataforma de mídia social que mudou a maneira como as pessoas se comunicam globalmente. Além de seu trabalho no Twitter, Dorsey fundou o Square, uma empresa de pagamentos digitais que facilita transações financeiras para pequenas empresas. Ele é um defensor da simplicidade no design de produtos e serviços tecnológicos.', 'Tecnologia, inovação, fintech, comunicação digital', 'Twitter, Square'),
(32, 'Sheryl Sandberg', '1234567800', 'Tecnologia', 'sheryl@facebook.com', 'sheryl@meta.com', 'senha123', 'Sheryl Sandberg foi COO do Facebook e uma das principais responsáveis pelo crescimento e monetização da plataforma. Ela também é autora do best-seller \"Lean In\", que promove a liderança feminina no ambiente de trabalho. Durante sua carreira, Sandberg defendeu a diversidade e a inclusão no setor de tecnologia, além de liderar iniciativas de marketing e publicidade digital.', 'Gestão, liderança, marketing digital, diversidade', 'Meta'),
(33, 'Reed Hastings', '1234567801', 'Tecnologia', 'reed@netflix.com', 'reed@netflix.com', 'senha123', 'Reed Hastings é o co-fundador e CEO da Netflix, a plataforma de streaming que mudou a indústria do entretenimento. Sob sua liderança, a Netflix se transformou de um serviço de aluguel de DVDs para o maior serviço de streaming do mundo, com produções originais e alcance global. Hastings também é um defensor de inovações em mídia e tecnologia.', 'Estratégia empresarial, inovação em mídia, streaming', 'Netflix'),
(34, 'Evan Spiegel', '1234567802', 'Tecnologia', 'evan@snapchat.com', 'evan@snap.com', 'senha123', 'Evan Spiegel é o co-fundador e CEO do Snapchat, a plataforma de mensagens efêmeras que inovou a maneira como os jovens se comunicam. Spiegel é conhecido por seu foco em design de produto e inovação, criando uma plataforma que introduziu novas formas de expressão visual, como filtros e lentes em tempo real.', 'Design de produto, inovação social, comunicação digital', 'Snapchat'),
(35, 'Marissa Mayer', '1234567803', 'Tecnologia', 'marissa@google.com', 'marissa@verizon.com', 'senha123', 'Marissa Mayer foi uma executiva do Google e CEO do Yahoo, onde ajudou a orientar a empresa em tempos de mudança. Durante sua carreira no Google, Mayer esteve à frente de vários produtos importantes, incluindo o Google Search e o Gmail. Depois de seu tempo no Yahoo, ela continuou a influenciar a indústria de tecnologia, com foco em design de produto e experiência do usuário.', 'Liderança, UX/UI, design de produto, tecnologia', 'Yahoo'),
(36, 'Brian Chesky', '1234567804', 'Tecnologia', 'brian@airbnb.com', 'brian@airbnb.com', 'senha123', 'Brian Chesky é o co-fundador e CEO do Airbnb, a plataforma de aluguel de imóveis que transformou a indústria de hospitalidade. Chesky iniciou o Airbnb em 2008, e desde então tem trabalhado para expandir o conceito de \"economia compartilhada\", permitindo que pessoas alugem suas casas ou apartamentos para hóspedes de todo o mundo.', 'Empreendedorismo, inovação, hospitalidade, economia compartilhada', 'Airbnb'),
(37, 'Maria Aparecida Costa', '1234567810', 'Nutrição', 'mariacosta@nutri.com', 'mariacosta@hospital.com', 'senha123', 'Maria Aparecida Costa é nutricionista com 15 anos de experiência na área hospitalar. Ao longo de sua carreira, ela se especializou em dietas terapêuticas para pacientes com doenças crônicas e promoveu ações educativas para a adoção de hábitos alimentares saudáveis.', 'Nutrição clínica, dietas terapêuticas, educação nutricional, saúde pública', 'Hospital Saúde Viva'),
(38, 'João Pereira Silva', '1234567811', 'Nutrição', 'joao@nutri.com', 'joao@clinicadieta.com', 'senha123', 'João Pereira Silva é um nutricionista que atua na área de alimentação coletiva e nutrição esportiva. Com vasta experiência em cardápios nutricionais para grandes empresas e academias, ele foca na otimização do desempenho dos clientes por meio de alimentação adequada.', 'Nutrição esportiva, alimentação coletiva, planejamento alimentar', 'Clínica NutriVita'),
(39, 'Carlos Alberto Souza', '1234567812', 'Dietética', 'carlos@dietista.com', 'carlos@nutriempresa.com', 'senha123', 'Carlos Alberto Souza é dietista e tem grande experiência em aconselhamento dietético para perda de peso e controle de doenças metabólicas. Ele tem trabalhado com uma abordagem personalizada de dieta, considerando as necessidades nutricionais e preferências de cada paciente.', 'Dieta personalizada, controle de peso, doenças metabólicas', 'NutriEmpresa'),
(40, 'Ana Beatriz Lima', '1234567813', 'Nutrição', 'ana@nutricaoprofissional.com', 'ana@consultoriomelhorar.com', 'senha123', 'Ana Beatriz Lima é especialista em nutrição infantil e atua com o desenvolvimento de estratégias alimentares para crianças e adolescentes com necessidades específicas. Seu trabalho é focado na promoção de uma alimentação saudável desde a infância para prevenir problemas nutricionais na vida adulta.', 'Nutrição pediátrica, saúde infantil, orientação alimentar', 'Consultório Alimentar Infantil'),
(41, 'Lucas Martins Ribeiro', '1234567814', 'Nutrição', 'lucas@nutriem.com', 'lucas@emnutri.com', 'senha123', 'Lucas Martins Ribeiro é nutricionista especializado em nutrição para idosos, desenvolvendo planos alimentares adaptados às necessidades nutricionais da terceira idade, visando melhorar a qualidade de vida e prevenir doenças comuns da faixa etária.', 'Nutrição geriátrica, envelhecimento saudável, controle de doenças', 'EmNutri'),
(42, 'Renata Martins', '1234567815', 'Nutrição', 'renata@nutriempresa.com', 'renata@empresafood.com', 'senha123', 'Renata Martins é nutricionista especialista em alimentação funcional e atua promovendo a alimentação preventiva e o uso de alimentos que ajudam no fortalecimento do sistema imunológico e na prevenção de doenças.', 'Alimentação funcional, prevenção de doenças, saúde intestinal', 'FoodCorp'),
(43, 'Paula Oliveira Souza', '1234567816', 'Nutrição', 'paula@clinicaalimenta.com', 'paula@clinicaalimenta.com', 'senha123', 'Paula Oliveira Souza é nutricionista clínica com foco em nutrição comportamental. Ela trabalha com pacientes que têm dificuldades para mudar hábitos alimentares, ajudando a superar transtornos alimentares e a encontrar uma relação saudável com a comida.', 'Nutrição comportamental, transtornos alimentares, psicologia nutricional', 'Clínica Alimentar'),
(44, 'Raquel Oliveira', '1234567817', 'Nutrição', 'raquel@consultorio.com', 'raquel@consultorionutricao.com', 'senha123', 'Raquel Oliveira é nutricionista especializada em nutrição hospitalar, atuando no planejamento de cardápios para unidades de saúde e promovendo a reabilitação nutricional de pacientes em recuperação.', 'Nutrição hospitalar, cardápios terapêuticos, reabilitação nutricional', 'Consultório de Nutrição'),
(45, 'Marcos Tadeu Gomes', '1234567818', 'Administração', 'marcos@administra.com', 'marcos@corp.com', 'senha123', 'Marcos Tadeu Gomes é administrador com experiência em gestão estratégica e operacional em empresas de grande porte. Ele tem trabalhado no desenvolvimento de soluções empresariais que visam otimizar recursos e aumentar a competitividade no mercado.', 'Gestão estratégica, administração financeira, planejamento empresarial', 'Corp'),
(46, 'Laura Silva Costa', '1234567819', 'Administração', 'laura@admincom.com', 'laura@empresa.com', 'senha123', 'Laura Silva Costa é administradora focada em gestão de pessoas e desenvolvimento organizacional. Ela tem atuado em empresas multinacionais, implementando programas de treinamento e desenvolvimento para melhorar o desempenho das equipes.', 'Gestão de pessoas, treinamento, desenvolvimento organizacional', 'EmpresaCorp'),
(47, 'Fernando Almeida', '1234567820', 'Administração', 'fernando@admincorporativo.com', 'fernando@corporativo.com', 'senha123', 'Fernando Almeida é especialista em gestão financeira e controladoria, com experiência em planejamento orçamentário e análise de performance de empresas de diferentes segmentos. Ele tem ajudado empresas a otimizar seus custos e maximizar seus lucros.', 'Gestão financeira, controladoria, planejamento orçamentário', 'Corporativo Ltda'),
(48, 'Carla Rodrigues', '1234567821', 'Administração', 'carla@adminbrasil.com', 'carla@brasilcorporate.com', 'senha123', 'Carla Rodrigues é administradora especializada em logística e cadeia de suprimentos. Ela tem atuado na reestruturação de processos logísticos para grandes empresas, promovendo melhorias na distribuição de produtos e na gestão de estoques.', 'Logística, cadeia de suprimentos, gestão de estoques', 'Brasil Corporate'),
(49, 'Juliana Martins', '1234567822', 'Enfermagem', 'juliana@enfermeira.com', 'juliana@hospitallink.com', 'senha123', 'Juliana Martins é enfermeira com vasta experiência em cuidados intensivos e emergências. Ela tem sido parte fundamental de equipes de UTI e pronto-socorro, oferecendo cuidados imediatos e especializados a pacientes em estado grave.', 'Cuidados intensivos, emergência, enfermagem clínica', 'Hospital Link'),
(50, 'André Luiz Ferreira', '1234567823', 'Enfermagem', 'andre@enfermagemclinic.com', 'andre@clinicavida.com', 'senha123', 'André Luiz Ferreira é enfermeiro especializado em enfermagem geriátrica, oferecendo cuidados de saúde essenciais a idosos, tanto em ambientes hospitalares quanto domiciliares. Ele trabalha para garantir o conforto e bem-estar da terceira idade.', 'Enfermagem geriátrica, cuidados domiciliares, saúde do idoso', 'Clínica Vida'),
(51, 'Viviane Souza', '1234567824', 'Enfermagem', 'viviane@enfermeiraclinica.com', 'viviane@saudeintegral.com', 'senha123', 'Viviane Souza é enfermeira que atua na área de oncologia, fornecendo suporte e cuidados a pacientes com câncer, auxiliando na gestão de sintomas e promovendo uma abordagem holística no tratamento.', 'Enfermagem oncológica, cuidados paliativos, suporte ao paciente', 'Saúde Integral'),
(52, 'Felipe Costa Rocha', '1234567825', 'Enfermagem', 'felipe@enfermeirohospitalar.com', 'felipe@hospitalluz.com', 'senha123', 'Felipe Costa Rocha é enfermeiro especializado em atendimento de urgência e emergência, com experiência em unidades de pronto-socorro. Ele é responsável por fornecer cuidados rápidos e eficazes a pacientes em situações críticas.', 'Urgência, emergência, cuidados intensivos', 'Hospital Luz'),
(53, 'Renata Almeida', '1234567826', 'Segurança do Trabalho', 'renata@segurancadotrabalho.com', 'renata@trabalhaseguro.com', 'senha123', 'Renata Almeida é especialista em segurança do trabalho com 10 anos de experiência na implementação de políticas de segurança em empresas industriais e comerciais. Ela desenvolve treinamentos e programas de prevenção de acidentes no ambiente de trabalho.', 'Prevenção de acidentes, segurança do trabalho, treinamentos', 'TrabalhaSeguro'),
(54, 'Carlos Henrique Lima', '1234567827', 'Segurança do Trabalho', 'carlos@segurancatrabalhista.com', 'carlos@empresasegura.com', 'senha123', 'Carlos Henrique Lima é especialista em segurança ocupacional, atuando na identificação e mitigação de riscos no ambiente de trabalho. Ele tem implementado estratégias de segurança para empresas de diferentes setores, garantindo ambientes de trabalho mais seguros e saudáveis.', 'Segurança ocupacional, prevenção de riscos, auditoria', 'Empresa Segura'),
(55, 'Paulo Henrique Silva', '1234567828', 'Gastronomia', 'paulo@chefdecozinha.com', 'paulo@cozinhagourmet.com', 'senha123', 'Paulo Henrique Silva é chef de cozinha e consultor gastronômico. Ele tem uma vasta experiência em criação de cardápios para restaurantes de alto padrão e eventos corporativos, com ênfase em pratos contemporâneos e técnicas culinárias inovadoras.', 'Culinária contemporânea, consultoria gastronômica, elaboração de cardápios', 'Cozinha Gourmet'),
(56, 'Gabriela Lima', '1234567829', 'Gastronomia', 'gabriela@chefgastronomica.com', 'gabriela@restaurantechef.com', 'senha123', 'Gabriela Lima é chef especializada em gastronomia internacional, com experiência em cozinha francesa e italiana. Ela oferece aulas de culinária e workshops para iniciantes e profissionais que buscam aprimorar suas técnicas culinárias.', 'Gastronomia internacional, culinária francesa, aulas de cozinha', 'Restaurante Chef'),
(57, 'Roberto Santos', '1234567830', 'Gastronomia', 'roberto@cozinheiroprofissional.com', 'roberto@restauranterapida.com', 'senha123', 'Roberto Santos é cozinheiro profissional especializado em culinária brasileira, com foco em pratos regionais e tradicionais. Ele também atua como consultor para restaurantes de comida rápida, criando cardápios com foco em qualidade e velocidade.', 'Culinária brasileira, comida rápida, consultoria de restaurantes', 'Restaurante Rápido'),
(58, 'Recrutador da Silva', '(21) 99890-9789', 'outro', 'recrutador@email.com', 'recrutador@campustec.com', '$2y$10$B5gKrMy9xOjzryECN/92/ujBlIb1gm9X9R5D/.AIQOmqVKBZOfJQO', 'Sou um perfil de teste', 'Otimo em testes de softwares\r\nO fundador da profissão Q.A', 'CampusTec');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nomeCompleto` varchar(255) NOT NULL,
  `numeroTel` varchar(20) NOT NULL,
  `curso` varchar(100) NOT NULL,
  `emailInstitucional` varchar(255) NOT NULL,
  `emailPessoal` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `biografia` text DEFAULT NULL,
  `curriculo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `nomeCompleto`, `numeroTel`, `curso`, `emailInstitucional`, `emailPessoal`, `senha`, `biografia`, `curriculo`) VALUES
(1, 'João Pedro da Penha Santos', '(11) 96164-6121', 'dsEtim', 'joao.santos1857@etec.sp.gov.br', 'jotape5195@gmail.com', '$2y$10$f5LQIu3rjg6Vw9X7rveu2.73pluNLjblargyLRL6qX6GzUJ2CbkAu', 'Sou estudante de Desenvolvimento de Sistemas na ETEC Uirapuru, com grande interesse em desenvolvimento Web e Mobile. Escolhi essa área por afinidade com tecnologia e programação, e, ao longo do curso, adquiri uma sólida base de conhecimentos. Apliquei esse aprendizado em projetos funcionais, tanto Web quanto Mobile, ampliando minhas competências em disciplinas como Lógica de Programação, Banco de Dados, Design Digital, Programação de Aplicativos Mobile e Desenvolvimento de Sistemas.', NULL),
(2, 'João Santos', '11988888888', 'Nutrição e Dietética', 'joao.santos@etec.com', 'joaosantos@yahoo.com', 'senhaForte456', 'Estudante dedicado, interessado em alimentação saudável.', NULL),
(3, 'Maria Oliveira', '11977777777', 'Administração', 'maria.oliveira@etec.com', 'mariaoliveira@hotmail.com', 'admin2024', NULL, 'maria_curriculo.pdf'),
(4, 'Carlos Pereira', '11966666666', 'Desenvolvimento de Sistemas', 'carlos.pereira@etec.com', 'carlospereira@outlook.com', 'senhaCarlos789', 'Estudante de programação com foco em soluções criativas.', NULL),
(5, 'Fernanda Costa', '11955555555', 'Logística', 'fernanda.costa@etec.com', 'fernandacosta@gmail.com', 'logistica321', 'Interesse em otimização de processos e cadeia de suprimentos.', 'fernanda_curriculo.docx'),
(6, 'Ana Silva', '11999999999', 'Desenvolvimento de Sistemas', 'ana.silva@etec.com', 'anasilva@gmail.com', 'senhaSegura123', 'Apaixonada por tecnologia e desenvolvimento web.', NULL),
(9, 'arthur', '(11) 11111-1112', 'dsEtim', 'arthur@etec.sp.gov.br', 'arthur@gmail.com', '$2y$10$48gmwNyVDZZOe3rZtWjVzOKeqMvbGKhvQCAQV/Ymp8XJR.ZoiIBWi', 'Dev full stack', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vagas_emprego`
--

CREATE TABLE `vagas_emprego` (
  `id` int(11) NOT NULL,
  `nome_empresa` varchar(100) DEFAULT NULL,
  `empregador` varchar(100) DEFAULT NULL,
  `descricao_vaga` text DEFAULT NULL,
  `salario` decimal(10,2) DEFAULT NULL,
  `pretensoes` text DEFAULT NULL,
  `email_contratante` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vagas_emprego`
--

INSERT INTO `vagas_emprego` (`id`, `nome_empresa`, `empregador`, `descricao_vaga`, `salario`, `pretensoes`, `email_contratante`) VALUES
(1, 'Tech Solutions', 'Ana Silva', 'Desenvolvedor Júnior para atuar em projetos de desenvolvimento web. Conhecimento em HTML, CSS, e JavaScript é desejável.', 3000.00, 'Proatividade, habilidades de comunicação e desejo de aprender.', 'arthur.santosguitarrista@gmail.com'),
(2, 'DevWorks', 'Carlos Pereira', 'Estamos em busca de um desenvolvedor júnior para trabalhar com Python e Django. Experiência com frameworks é um plus.', 3200.00, 'Boa capacidade de resolução de problemas e interesse em novas tecnologias.', 'carlos.pereira@gmail.com'),
(3, 'Innovatech', 'Mariana Oliveira', 'Vaga para desenvolvedor júnior com foco em desenvolvimento de aplicativos móveis. Conhecimentos em Swift ou Kotlin são desejados.', 3500.00, 'Entusiasmo por tecnologia e capacidade de trabalhar em equipe.', 'mariana.oliveira@gmail.com'),
(4, 'WebStart', 'João Souza', 'Procuramos um desenvolvedor júnior para integração de APIs e manutenção de sistemas existentes. Conhecimento em Node.js é um diferencial.', 3100.00, 'Capacidade de trabalhar sob pressão e interesse por desenvolvimento contínuo.', 'joão.souza@gmail.com'),
(5, 'FutureCode', 'Fernanda Costa', 'Desenvolvedor júnior para trabalhar em projetos de e-commerce. Experiência com PHP e MySQL é preferencial.', 2900.00, 'Organização e atenção aos detalhes.', 'fernanda.costa@gmail.com'),
(6, 'TechNet', 'Roberto Lima', 'Buscamos um desenvolvedor júnior para suporte e manutenção de sistemas internos. Conhecimento básico em C# é necessário.', 3300.00, 'Capacidade analítica e vontade de aprender novas ferramentas.', 'roberto.lima@gmail.com'),
(7, 'SoftTech', 'Luciana Santos', 'Vaga para desenvolvedor júnior para atuar em projetos de frontend. Experiência com React é um diferencial.', 3400.00, 'Criatividade e interesse por design de interfaces.', 'luciana.santos@gmail.com'),
(8, 'CodeLab', 'Pedro Almeida', 'Desenvolvedor júnior para trabalhar com Java e Spring Boot. Experiência anterior em projetos pessoais será considerada.', 3200.00, 'Boa comunicação e habilidades de trabalho em equipe.', 'pedro.almeida@gmail.com'),
(9, 'DataDriven', 'Julia Martins', 'Estamos procurando um desenvolvedor júnior para trabalhar em projetos de análise de dados e desenvolvimento de scripts. Conhecimento em SQL é desejável.', 3100.00, 'Interesse por dados e habilidade em resolver problemas complexos.', 'julia.martins@gmail.com'),
(10, 'XtremeDev', 'Eduardo Oliveira', 'Vaga para desenvolvedor júnior com foco em desenvolvimento backend. Conhecimento em Ruby on Rails é um diferencial.', 3000.00, 'Capacidade de aprender rapidamente e trabalhar em projetos desafiadores.', 'eduardo.oliveira@gmail.com'),
(11, 'Tech Innovations', 'Lucas Andrade', 'Desenvolvedor júnior para atuar em projetos de integração de sistemas. Conhecimento em APIs e RESTful services é desejável.', 3300.00, 'Vontade de aprender e habilidades de resolução de problemas.', 'lucas.andrade@gmail.com'),
(12, 'Digital Solutions', 'Tatiane Rodrigues', 'Vaga para desenvolvedor júnior com experiência em desenvolvimento web. Conhecimentos em Angular são um plus.', 3400.00, 'Capacidade de trabalhar bem em equipe e bom senso crítico.', 'tatiane.rodrigues@gmail.com'),
(13, 'WebWorks', 'Marcelo Lima', 'Desenvolvedor júnior para atuar em projetos de manutenção e suporte técnico. Conhecimento básico em .NET é necessário.', 3000.00, 'Disposição para aprender e atenção aos detalhes.', 'marcelo.lima@gmail.com'),
(14, 'SoftLab', 'Giovana Almeida', 'Buscamos um desenvolvedor júnior para atuar em projetos de mobile e web. Experiência com Flutter é desejada.', 3200.00, 'Criatividade e capacidade de se adaptar a novas tecnologias.', 'giovana.almeida@gmail.com'),
(15, 'CodeWorks', 'Vinícius Silva', 'Desenvolvedor júnior para projetos de front-end e back-end. Conhecimento em Vue.js é um diferencial.', 3300.00, 'Interesse por desenvolvimento full-stack e capacidade de aprender novas ferramentas.', 'vinícius.silva@gmail.com'),
(16, 'TechGen', 'Isabela Costa', 'Vaga para desenvolvedor júnior com foco em APIs e serviços web. Conhecimentos em Express.js são desejados.', 3100.00, 'Capacidade de resolver problemas e trabalhar em equipe.', 'isabela.costa@gmail.com'),
(17, 'NextGen Technologies', 'Thiago Pereira', 'Desenvolvedor júnior para atuar em projetos de software de gestão. Conhecimento em Java é um plus.', 3400.00, 'Interesse por desenvolvimento de software e habilidades de análise de requisitos.', 'thiago.pereira@gmail.com'),
(18, 'Innovative Solutions', 'Amanda Santos', 'Procuramos um desenvolvedor júnior para atuar em projetos de integração de dados e backend. Experiência com Python é desejável.', 3200.00, 'Boa capacidade de organização e interesse por novos desafios.', 'amanda.santos@gmail.com'),
(19, 'GlobalTech', 'Felipe Ferreira', 'Desenvolvedor júnior para trabalhar com sistemas de automação. Conhecimento em PHP e MySQL é necessário.', 3000.00, 'Capacidade de trabalhar com prazos curtos e vontade de aprender.', 'felipe.ferreira@gmail.com'),
(20, 'CyberTech', 'Marcelly Rocha', 'Vaga para desenvolvedor júnior com foco em desenvolvimento de aplicativos web. Experiência com JavaScript e frameworks é um plus.', 3300.00, 'Criatividade e interesse por design de sistemas.', 'marcelly.rocha@gmail.com'),
(21, 'TechFuture', 'Bruno Silva', 'Desenvolvedor júnior para atuar em projetos de desenvolvimento de jogos. Conhecimento em Unity é um diferencial.', 3500.00, 'Interesse por gamificação e habilidades de programação orientada a objetos.', 'bruno.silva@gmail.com'),
(22, 'SmartTech', 'Beatriz Costa', 'Vaga para desenvolvedor júnior com experiência em integração de sistemas e APIs. Conhecimento em Java é desejável.', 3200.00, 'Capacidade de trabalhar bem sob pressão e desejo de aprimorar habilidades.', 'beatriz.costa@gmail.com'),
(23, 'Evolutech', 'Carlos Santos', 'Desenvolvedor júnior para trabalhar em projetos de tecnologia educacional. Conhecimento em HTML5 e CSS3 é um plus.', 3100.00, 'Habilidade de comunicação e interesse em tecnologia educacional.', 'carlos.santos@gmail.com'),
(24, 'BlueTech', 'Sofia Lima', 'Procuramos um desenvolvedor júnior para atuar em manutenção de sistemas. Conhecimento básico em C++ é necessário.', 3000.00, 'Atenção aos detalhes e vontade de aprender novas linguagens.', 'sofia.lima@gmail.com'),
(25, 'VisionTech', 'Daniela Silva', 'Desenvolvedor júnior para projetos de software de análise de dados. Conhecimento em R ou Python é desejado.', 3300.00, 'Interesse por análise de dados e habilidade de trabalhar com grandes volumes de dados.', 'daniela.silva@gmail.com'),
(26, 'AlphaTech', 'Gustavo Almeida', 'Vaga para desenvolvedor júnior com foco em segurança da informação. Conhecimento em técnicas básicas de segurança é um plus.', 3200.00, 'Curiosidade por segurança cibernética e capacidade de se manter atualizado sobre ameaças.', 'gustavo.almeida@gmail.com'),
(27, 'TechStar', 'Rafaela Santos', 'Desenvolvedor júnior para projetos de aplicativos móveis e web. Conhecimento em Java e Kotlin é desejável.', 3400.00, 'Capacidade de trabalhar em ambientes dinâmicos e desejo de aprender novas tecnologias.', 'rafaela.santos@gmail.com'),
(28, 'ProTech', 'André Pereira', 'Vaga para desenvolvedor júnior com experiência em sistemas ERP. Conhecimento em PHP é um diferencial.', 3000.00, 'Interesse em sistemas ERP e habilidades de resolução de problemas.', 'andré.pereira@gmail.com'),
(29, 'FutureWorks', 'Laura Lima', 'Desenvolvedor júnior para trabalhar em desenvolvimento de software e aplicativos. Conhecimento em React Native é desejável.', 3100.00, 'Capacidade de aprender rapidamente e trabalhar em equipe.', 'laura.lima@gmail.com'),
(30, 'BrightTech', 'Rodrigo Costa', 'Desenvolvedor júnior para projetos de desenvolvimento ágil. Conhecimento em metodologias ágeis é um plus.', 3300.00, 'Boa capacidade de adaptação e desejo de crescer profissionalmente.', 'rodrigo.costa@gmail.com'),
(31, 'Innovate IT', 'Camila Rocha', 'Vaga para desenvolvedor júnior com foco em projetos de automação. Conhecimento básico em Python é desejado.', 3200.00, 'Interesse por automação e capacidade de resolver problemas de forma criativa.', 'camila.rocha@gmail.com'),
(32, 'Dynamic Tech', 'João Paulo', 'Desenvolvedor júnior para trabalhar com APIs e serviços web. Conhecimento em Node.js é um diferencial.', 3400.00, 'Capacidade de trabalhar bem em equipe e boa comunicação.', 'joão.paulo@gmail.com'),
(33, 'TechNexus', 'Viviane Pereira', 'Procuramos um desenvolvedor júnior para projetos de desenvolvimento de software para dispositivos móveis. Conhecimento em Flutter é desejável.', 3100.00, 'Entusiasmo por desenvolvimento de aplicativos móveis e capacidade de aprender novas tecnologias.', 'viviane.pereira@gmail.com'),
(34, 'Global Solutions', 'Eduardo Lima', 'Desenvolvedor júnior para atuar em projetos de software empresarial. Conhecimento em .NET é necessário.', 3300.00, 'Boa capacidade analítica e vontade de aprender e crescer na carreira.', 'eduardo.lima@gmail.com'),
(35, 'CodePro', 'Mariana Ferreira', 'Vaga para desenvolvedor júnior com experiência em desenvolvimento front-end. Conhecimento em Angular é um plus.', 3200.00, 'Capacidade de trabalhar bem sob pressão e interesse por design de interfaces.', 'mariana.ferreira@gmail.com'),
(36, 'TechGenie', 'Fernando Silva', 'Desenvolvedor júnior para projetos de software de análise de dados. Conhecimento em SQL é desejado.', 3100.00, 'Habilidade para trabalhar com grandes conjuntos de dados e desejo de aprimorar habilidades analíticas.', 'fernando.silva@gmail.com'),
(37, 'AdvanceTech', 'Tatiane Santos', 'Vaga para desenvolvedor júnior com foco em integração de sistemas. Conhecimento em Java é um diferencial.', 3400.00, 'Boa comunicação e capacidade de resolução de problemas complexos.', 'tatiane.santos@gmail.com'),
(38, 'NextLevel Tech', 'Rafael Oliveira', 'Desenvolvedor júnior para atuar em projetos de software e aplicativos web. Conhecimento em Vue.js é desejável.', 3200.00, 'Criatividade e interesse por novos desafios tecnológicos.', 'rafael.oliveira@gmail.com'),
(39, 'BrightFuture', 'Simone Rodrigues', 'Procuramos um desenvolvedor júnior para trabalhar em projetos de desenvolvimento de software e suporte técnico. Conhecimento em PHP é necessário.', 3300.00, 'Boa capacidade de aprendizado e habilidades de comunicação.', 'simone.rodrigues@gmail.com'),
(40, 'Innovative Systems', 'Paula Lima', 'Desenvolvedor júnior para atuar em projetos de automação de processos. Conhecimento básico em Python é desejável.', 3100.00, 'Capacidade de trabalhar em equipe e desejo de aprender novas ferramentas e técnicas.', 'paula.lima@gmail.com'),
(41, 'TechSavvy', 'Lucas Santos', 'Vaga para desenvolvedor júnior com experiência em desenvolvimento web e mobile. Conhecimento em React e React Native é um diferencial.', 3200.00, 'Interesse por desenvolvimento full-stack e capacidade de se adaptar a diferentes tecnologias.', 'lucas.santos@gmail.com'),
(42, 'FutureTech', 'Juliana Silva', 'Desenvolvedor júnior para projetos de desenvolvimento de software para educação. Conhecimento em JavaScript é desejado.', 3300.00, 'Entusiasmo por tecnologia educacional e boa capacidade de resolução de problemas.', 'juliana.silva@gmail.com'),
(43, 'Tech Solutions', 'Amanda Costa', 'Vaga para desenvolvedor júnior com foco em software de automação industrial. Conhecimento em C# é um diferencial.', 3100.00, 'Boa capacidade analítica e interesse por automação industrial.', 'amanda.costa@gmail.com'),
(44, 'CodeWorks', 'Bruno Pereira', 'Desenvolvedor júnior para projetos de desenvolvimento backend. Conhecimento em Ruby é desejável.', 3200.00, 'Capacidade de resolver problemas e interesse por desenvolvimento backend.', 'bruno.pereira@gmail.com'),
(45, 'SoftSkills', 'Luana Rodrigues', 'Procuramos um desenvolvedor júnior para atuar em projetos de manutenção de software. Conhecimento em Java é necessário.', 3300.00, 'Boa capacidade de trabalhar em equipe e habilidades de resolução de problemas.', 'luana.rodrigues@gmail.com'),
(46, 'TechPro', 'Mateus Silva', 'Desenvolvedor júnior para atuar em projetos de desenvolvimento de jogos. Conhecimento em Unity é um plus.', 3400.00, 'Interesse por desenvolvimento de jogos e habilidades de programação orientada a objetos.', 'mateus.silva@gmail.com'),
(47, 'NextTech', 'Tatiane Almeida', 'Vaga para desenvolvedor júnior com experiência em sistemas de gestão e ERP. Conhecimento em Python é desejável.', 3100.00, 'Habilidade de resolver problemas e desejo de crescer profissionalmente.', 'tatiane.almeida@gmail.com'),
(48, 'Innovate Systems', 'Lucas Costa', 'Desenvolvedor júnior para atuar em projetos de software para dispositivos móveis. Conhecimento em Java e Kotlin é um diferencial.', 3200.00, 'Entusiasmo por desenvolvimento de aplicativos móveis e boa comunicação.', 'lucas.costa@gmail.com'),
(49, 'TechGenie', 'Fernanda Lima', 'Procuramos um desenvolvedor júnior para projetos de software e sistemas integrados. Conhecimento em PHP e MySQL é desejado.', 3300.00, 'Capacidade de trabalhar bem em equipe e interesse por novos desafios.', 'fernanda.lima@gmail.com'),
(50, 'WebNexus', 'Rafael Santos', 'Desenvolvedor júnior para atuar em projetos de desenvolvimento de front-end e back-end. Conhecimento em React é um diferencial.', 3100.00, 'Boa capacidade de adaptação e desejo de aprender novas tecnologias.', 'rafael.santos@gmail.com'),
(51, 'CodeCrafter', 'Juliana Costa', 'Vaga para desenvolvedor júnior com foco em desenvolvimento de sistemas para empresas. Conhecimento em .NET é desejado.', 3200.00, 'Boa comunicação e interesse por desenvolvimento de software empresarial.', 'juliana.costa@gmail.com'),
(52, 'FutureTech', 'Vinícius Costa', 'Desenvolvedor júnior para trabalhar com projetos de software de análise de dados. Conhecimento em R é um diferencial.', 3300.00, 'Habilidade analítica e desejo de aprimorar habilidades de análise de dados.', 'vinícius.costa@gmail.com'),
(53, 'BrightTech', 'Isabela Pereira', 'Procuramos um desenvolvedor júnior para atuar em projetos de software e aplicativos web. Conhecimento em Angular é desejável.', 3100.00, 'Criatividade e capacidade de aprender novas ferramentas e técnicas.', 'isabela.pereira@gmail.com'),
(54, 'TechFuture', 'Roberta Lima', 'Desenvolvedor júnior para projetos de automação de processos. Conhecimento em Python e SQL é desejável.', 3200.00, 'Capacidade de resolver problemas e interesse por automação de processos.', 'roberta.lima@gmail.com'),
(55, 'NextLevel Tech', 'Felipe Pereira', 'Vaga para desenvolvedor júnior com experiência em desenvolvimento de software e aplicativos móveis. Conhecimento em Flutter é um plus.', 3300.00, 'Boa capacidade de comunicação e desejo de aprender novas tecnologias.', 'felipe.pereira@gmail.com'),
(56, 'Innovative Solutions', 'Paula Silva', 'Desenvolvedor júnior para projetos de software para gestão empresarial. Conhecimento em Java é necessário.', 3100.00, 'Capacidade de trabalhar bem em equipe e interesse por desenvolvimento de software.', 'paula.silva@gmail.com'),
(57, 'Tech Innovations', 'Lucas Costa', 'Vaga para desenvolvedor júnior com foco em desenvolvimento de jogos e aplicativos. Conhecimento em Unity e C# é desejável.', 3400.00, 'Interesse por desenvolvimento de jogos e capacidade de aprender rapidamente.', 'lucas.costa@gmail.com'),
(58, 'Dynamic Tech', 'Gabriela Almeida', 'Desenvolvedor júnior para atuar em projetos de software de automação. Conhecimento em Python é um diferencial.', 3200.00, 'Interesse por automação e capacidade de trabalhar com grandes volumes de dados.', 'gabriela.almeida@gmail.com'),
(59, 'TechNet', 'André Lima', 'Vaga para desenvolvedor júnior com foco em integração de sistemas e APIs. Conhecimento em Node.js é desejável.', 3100.00, 'Boa comunicação e capacidade de trabalhar em equipe.', 'andré.lima@gmail.com'),
(60, 'WebWorks', 'Tatiane Costa', 'Desenvolvedor júnior para trabalhar com desenvolvimento de aplicativos móveis e web. Conhecimento em React Native é um plus.', 3300.00, 'Capacidade de adaptação e desejo de aprender novas tecnologias.', 'tatiane.costa@gmail.com'),
(61, 'TechPro', 'Carlos Santos', 'Vaga para desenvolvedor júnior com experiência em sistemas de gestão e ERP. Conhecimento em PHP e MySQL é desejável.', 3200.00, 'Boa capacidade de resolução de problemas e desejo de crescer profissionalmente.', 'carlos.santos@gmail.com'),
(62, 'Innovative Systems', 'Juliana Silva', 'Desenvolvedor júnior para projetos de software de análise de dados. Conhecimento em SQL é um diferencial.', 3100.00, 'Habilidade analítica e desejo de aprender novas técnicas e ferramentas.', 'juliana.silva@gmail.com'),
(63, 'CodeWorks', 'Bruno Costa', 'Vaga para desenvolvedor júnior com foco em desenvolvimento de software para dispositivos móveis. Conhecimento em Kotlin é desejável.', 3300.00, 'Interesse por desenvolvimento de aplicativos móveis e boa comunicação.', 'bruno.costa@gmail.com'),
(64, 'NextTech', 'Mariana Almeida', 'Desenvolvedor júnior para atuar em projetos de software e sistemas integrados. Conhecimento em Java é um diferencial.', 3200.00, 'Capacidade de trabalhar bem em equipe e desejo de aprender novas tecnologias.', 'mariana.almeida@gmail.com'),
(65, 'TechSavvy', 'Rafael Oliveira', 'Vaga para desenvolvedor júnior com foco em desenvolvimento web e mobile. Conhecimento em React é desejável.', 3100.00, 'Criatividade e capacidade de se adaptar a diferentes tecnologias.', 'rafael.oliveira@gmail.com'),
(66, 'Innovate IT', 'Luciana Lima', 'Desenvolvedor júnior para projetos de software para educação e e-learning. Conhecimento em HTML5 e CSS3 é um plus.', 3300.00, 'Interesse por tecnologia educacional e boas habilidades de resolução de problemas.', 'luciana.lima@gmail.com'),
(67, 'BrightFuture', 'Eduardo Costa', 'Vaga para desenvolvedor júnior com foco em desenvolvimento de software e suporte técnico. Conhecimento em PHP e MySQL é desejável.', 3200.00, 'Boa capacidade de comunicação e desejo de aprender novas ferramentas.', 'eduardo.costa@gmail.com'),
(68, 'FutureTech', 'Roberta Pereira', 'Desenvolvedor júnior para atuar em projetos de desenvolvimento de software para dispositivos móveis. Conhecimento em Flutter é um diferencial.', 3400.00, 'Capacidade de trabalhar em equipe e entusiasmo por novas tecnologias.', 'roberta.pereira@gmail.com'),
(69, 'WebNexus', 'Felipe Almeida', 'Desenvolvedor júnior para projetos de desenvolvimento de software e integração de sistemas. Conhecimento em Python é desejável.', 3300.00, 'Boa capacidade analítica e interesse por novos desafios.', 'felipe.almeida@gmail.com'),
(70, 'TechGenie', 'Camila Santos', 'Vaga para desenvolvedor júnior com experiência em desenvolvimento de jogos e aplicativos. Conhecimento em Unity é um plus.', 3200.00, 'Criatividade e capacidade de resolver problemas complexos.', 'camila.santos@gmail.com'),
(71, 'CodeCrafter', 'Marcos Silva', 'Desenvolvedor júnior para trabalhar em projetos de software e manutenção de sistemas. Conhecimento em Java é desejado.', 3100.00, 'Boa capacidade de resolução de problemas e desejo de crescer na carreira.', 'marcos.silva@gmail.com'),
(72, 'FutureTech', 'Ana Costa', 'Vaga para desenvolvedor júnior com foco em desenvolvimento de software para educação. Conhecimento em JavaScript é um diferencial.', 3300.00, 'Entusiasmo por tecnologia educacional e capacidade de trabalhar bem em equipe.', 'ana.costa@gmail.com'),
(73, 'Innovative Solutions', 'Paula Silva', 'Desenvolvedor júnior para projetos de desenvolvimento de software e automação. Conhecimento em Python e SQL é desejável.', 3200.00, 'Interesse por automação e boas habilidades analíticas.', 'paula.silva@gmail.com'),
(74, 'TechFuture', 'Lucas Pereira', 'Vaga para desenvolvedor júnior com experiência em desenvolvimento web e aplicativos. Conhecimento em React e React Native é um diferencial.', 3300.00, 'Criatividade e capacidade de aprender novas ferramentas e técnicas.', 'lucas.pereira@gmail.com'),
(75, 'BrightTech', 'Juliana Lima', 'Desenvolvedor júnior para atuar em projetos de desenvolvimento de software e análise de dados. Conhecimento em SQL é desejável.', 3100.00, 'Boa capacidade de comunicação e interesse em análise de dados.', 'juliana.lima@gmail.com'),
(76, 'TechNet', 'Gustavo Costa', 'Vaga para desenvolvedor júnior com foco em sistemas de gestão e automação. Conhecimento em Java é um diferencial.', 3200.00, 'Boa capacidade analítica e desejo de aprender novas tecnologias.', 'gustavo.costa@gmail.com'),
(77, 'CodeWorks', 'Fernanda Oliveira', 'Desenvolvedor júnior para atuar em projetos de software e integração de sistemas. Conhecimento em PHP é desejável.', 3300.00, 'Capacidade de trabalhar bem em equipe e interesse por novos desafios.', 'fernanda.oliveira@gmail.com'),
(78, 'Innovate Systems', 'Rodrigo Pereira', 'Vaga para desenvolvedor júnior com foco em desenvolvimento de software e aplicativos móveis. Conhecimento em Kotlin é um diferencial.', 3200.00, 'Entusiasmo por desenvolvimento de aplicativos e boa capacidade de resolução de problemas.', 'rodrigo.pereira@gmail.com'),
(79, 'TechSavvy', 'Amanda Almeida', 'Desenvolvedor júnior para atuar em projetos de desenvolvimento de software e manutenção de sistemas. Conhecimento em Python é desejável.', 3300.00, 'Boa capacidade de comunicação e desejo de aprender novas ferramentas.', 'amanda.almeida@gmail.com'),
(80, 'BrightFuture', 'Marcelly Costa', 'Vaga para desenvolvedor júnior com foco em desenvolvimento web e integração de sistemas. Conhecimento em JavaScript é desejável.', 3100.00, 'Criatividade e capacidade de trabalhar em equipe.', 'marcelly.costa@gmail.com'),
(81, 'Innovate IT', 'Lucas Rodrigues', 'Desenvolvedor júnior para projetos de software e desenvolvimento de aplicativos. Conhecimento em Flutter é um diferencial.', 3400.00, 'Boa capacidade analítica e desejo de crescer profissionalmente.', 'lucas.rodrigues@gmail.com'),
(82, 'TechGenie', 'Sofia Santos', 'Procuramos um desenvolvedor júnior para trabalhar em projetos de software para dispositivos móveis. Conhecimento em React Native é desejável.', 3200.00, 'Capacidade de aprender rapidamente e interesse por desenvolvimento de aplicativos móveis.', 'sofia.santos@gmail.com'),
(83, 'FutureWorks', 'Tatiane Lima', 'Desenvolvedor júnior para atuar em projetos de desenvolvimento de software e sistemas integrados. Conhecimento em Python é desejável.', 3300.00, 'Boa capacidade de resolução de problemas e desejo de crescer na carreira.', 'tatiane.lima@gmail.com'),
(84, 'WebNexus', 'Eduardo Ferreira', 'Vaga para desenvolvedor júnior com foco em desenvolvimento de software e manutenção de sistemas. Conhecimento em PHP e MySQL é um diferencial.', 3100.00, 'Entusiasmo por desenvolvimento de software e boas habilidades analíticas.', 'eduardo.ferreira@gmail.com'),
(85, 'TechFuture', 'Paula Costa', 'Desenvolvedor júnior para projetos de automação de processos e integração de sistemas. Conhecimento em Java é desejável.', 3200.00, 'Boa capacidade de comunicação e desejo de aprender novas ferramentas.', 'paula.costa@gmail.com'),
(86, 'Innovative Solutions', 'Rodrigo Santos', 'Vaga para desenvolvedor júnior com foco em desenvolvimento de software e aplicativos móveis. Conhecimento em Kotlin é um diferencial.', 3300.00, 'Capacidade de trabalhar bem em equipe e interesse por novos desafios.', 'rodrigo.santos@gmail.com'),
(87, 'TechSavvy', 'Giovana Lima', 'Desenvolvedor júnior para atuar em projetos de software e análise de dados. Conhecimento em SQL é desejável.', 3100.00, 'Habilidade analítica e desejo de aprender novas técnicas e ferramentas.', 'giovana.lima@gmail.com'),
(88, 'BrightTech', 'Bruno Santos', 'Vaga para desenvolvedor júnior com foco em desenvolvimento de aplicativos móveis e web. Conhecimento em Flutter é desejável.', 3400.00, 'Capacidade de se adaptar a novas tecnologias e bom trabalho em equipe.', 'bruno.santos@gmail.com'),
(89, 'Innovate IT', 'Juliana Rodrigues', 'Desenvolvedor júnior para projetos de software e manutenção de sistemas. Conhecimento em Python é desejável.', 3300.00, 'Boa capacidade de comunicação e interesse por desenvolvimento de software.', 'juliana.rodrigues@gmail.com'),
(90, 'FutureTech', 'André Costa', 'Vaga para desenvolvedor júnior com foco em desenvolvimento web e mobile. Conhecimento em React Native é um diferencial.', 3200.00, 'Criatividade e desejo de aprender novas ferramentas e técnicas.', 'andré.costa@gmail.com'),
(91, 'TechGenie', 'Natalia Silva', 'Desenvolvedor júnior para projetos de software e integração de sistemas. Conhecimento em PHP e MySQL é desejável.', 3100.00, 'Boa capacidade analítica e desejo de crescer na carreira.', 'natalia.silva@gmail.com'),
(92, 'BrightFuture', 'Felipe Almeida', 'Vaga para desenvolvedor júnior com foco em desenvolvimento de software para educação. Conhecimento em HTML5 e CSS3 é desejável.', 3300.00, 'Entusiasmo por tecnologia educacional e boas habilidades de comunicação.', 'felipe.almeida@gmail.com'),
(93, 'TechSavvy', 'Mariana Costa', 'Desenvolvedor júnior para atuar em projetos de desenvolvimento de software e manutenção de sistemas. Conhecimento em Java é desejável.', 3200.00, 'Boa capacidade de resolução de problemas e desejo de aprender novas ferramentas.', 'mariana.costa@gmail.com'),
(94, 'FutureWorks', 'Eduardo Silva', 'Desenvolvedor júnior para projetos de software e aplicativos móveis. Conhecimento em Kotlin é um diferencial.', 3100.00, 'Interesse por desenvolvimento de aplicativos e capacidade de aprender rapidamente.', 'eduardo.silva@gmail.com'),
(95, 'TechNet', 'Patrícia Almeida', 'Vaga para desenvolvedor júnior com foco em desenvolvimento de software para sistemas empresariais. Conhecimento em .NET é desejável.', 3300.00, 'Boa capacidade de comunicação e desejo de crescer na carreira.', 'patrícia.almeida@gmail.com'),
(96, 'Innovative Systems', 'Roberta Ferreira', 'Desenvolvedor júnior para atuar em projetos de automação e integração de sistemas. Conhecimento em Python é um diferencial.', 3200.00, 'Capacidade de resolver problemas complexos e interesse por automação.', 'roberta.ferreira@gmail.com'),
(97, 'FutureTech', 'Daniel Oliveira', 'Desenvolvedor júnior para projetos de desenvolvimento de software e sistemas integrados. Conhecimento em React é desejável.', 3100.00, 'Boa capacidade de adaptação e desejo de aprender novas tecnologias.', 'daniel.oliveira@gmail.com'),
(98, 'TechGenie', 'Tatiane Lima', 'Vaga para desenvolvedor júnior com foco em desenvolvimento de aplicativos móveis e web. Conhecimento em Flutter é desejável.', 3400.00, 'Criatividade e interesse por novas tecnologias.', 'tatiane.lima@gmail.com'),
(99, 'BrightFuture', 'Lucas Costa', 'Desenvolvedor júnior para trabalhar com desenvolvimento de software e manutenção de sistemas. Conhecimento em JavaScript é um diferencial.', 3200.00, 'Boa capacidade de comunicação e desejo de aprender novas técnicas.', 'lucas.costa@gmail.com'),
(100, 'FutureWorks', 'Giovana Santos', 'Vaga para desenvolvedor júnior com foco em desenvolvimento de software para gestão empresarial. Conhecimento em PHP é desejável.', 3300.00, 'Boa capacidade analítica e desejo de crescer na carreira.', 'giovana.santos@gmail.com'),
(101, 'TechSavvy', 'Juliana Pereira', 'Desenvolvedor júnior para atuar em projetos de software e desenvolvimento de aplicativos. Conhecimento em React Native é um diferencial.', 3100.00, 'Criatividade e capacidade de se adaptar a novas tecnologias.', 'juliana.pereira@gmail.com'),
(102, 'Innovate IT', 'Rafael Almeida', 'Desenvolvedor júnior para projetos de desenvolvimento de software e integração de sistemas. Conhecimento em Python é desejável.', 3200.00, 'Boa capacidade de resolução de problemas e desejo de aprender novas ferramentas.', 'rafael.almeida@gmail.com'),
(103, 'TechGenie', 'Sofia Lima', 'Procuramos um desenvolvedor júnior para trabalhar em projetos de desenvolvimento de software para dispositivos móveis. Conhecimento em Kotlin é um diferencial.', 3300.00, 'Capacidade de trabalhar bem em equipe e interesse por desenvolvimento de aplicativos móveis.', 'sofia.lima@gmail.com'),
(104, 'BrightFuture', 'Carlos Costa', 'Vaga para desenvolvedor júnior com foco em desenvolvimento de software e manutenção de sistemas. Conhecimento em Java é desejável.', 3100.00, 'Boa capacidade analítica e desejo de aprender novas técnicas.', 'carlos.costa@gmail.com'),
(105, 'TechSavvy', 'Fernanda Rodrigues', 'Desenvolvedor júnior para projetos de software e análise de dados. Conhecimento em SQL é um diferencial.', 3200.00, 'Habilidade analítica e desejo de crescer profissionalmente.', 'fernanda.rodrigues@gmail.com'),
(106, 'FutureTech', 'Eduardo Silva', 'Desenvolvedor júnior para atuar em projetos de desenvolvimento de software e sistemas integrados. Conhecimento em React é desejável.', 3300.00, 'Criatividade e capacidade de aprender novas tecnologias.', 'eduardo.silva@gmail.com'),
(107, 'Innovative Solutions', 'Mariana Costa', 'Vaga para desenvolvedor júnior com foco em desenvolvimento de software e automação. Conhecimento em Python e SQL é desejável.', 3200.00, 'Boa capacidade analítica e desejo de aprender novas ferramentas.', 'mariana.costa@gmail.com'),
(108, 'TechGenie', 'Lucas Almeida', 'Desenvolvedor júnior para projetos de desenvolvimento de software e aplicativos móveis. Conhecimento em Flutter é um diferencial.', 3100.00, 'Capacidade de resolver problemas e desejo de crescer profissionalmente.', 'lucas.almeida@gmail.com'),
(109, 'BrightFuture', 'Tatiane Lima', 'Vaga para desenvolvedor júnior com foco em desenvolvimento de software para educação. Conhecimento em HTML5 e CSS3 é desejável.', 3200.00, 'Entusiasmo por tecnologia educacional e boas habilidades de comunicação.', 'tatiane.lima@gmail.com'),
(110, 'teste', 'paulinho', 'dev', 3000.00, 'codigo', 'paulo@email.com'),
(111, 'teste', 'paulinho', 'dev', 3000.00, 'codigo', 'paulo@email.com'),
(112, 'NutriSaúde', 'Carlos Alberto Souza', 'Vaga para dietista especializado em alimentação clínica, atuando com pacientes em unidades hospitalares. Necessária experiência em dietas terapêuticas e atendimento multidisciplinar.', 4000.00, 'Formação em Dietética, experiência hospitalar, conhecimentos de dietas terapêuticas e suporte nutricional.', 'contato@nutrisaude.com'),
(113, 'Alimentar Bem', 'Renata Martins', 'Vaga para nutricionista clínica com foco em alimentação funcional e preventiva. O profissional será responsável pela elaboração de cardápios balanceados e acompanhamento de pacientes.', 3200.00, 'Especialização em nutrição funcional, experiência em atendimento clínico e orientação nutricional.', 'contato@alimentarbem.com'),
(114, 'Clínica Alimentar', 'Paula Oliveira Souza', 'Vaga para nutricionista comportamental, com foco em atender pacientes com transtornos alimentares e orientação em terapias para mudança de comportamento alimentar.', 3300.00, 'Formação em Nutrição Comportamental, experiência em atendimento psicológico alimentar e suporte em reeducação alimentar.', 'contato@clinicaalimentar.com'),
(115, 'Admin Consult', 'Luís Miguel Souza', 'Vaga para analista administrativo, responsável pela organização de processos e suporte à gestão financeira. Necessário conhecimento em ferramentas de controle de fluxo de caixa e organização de documentos.', 2500.00, 'Formação em Administração, conhecimento em gestão financeira e experiência com ferramentas de planejamento e controle de processos.', 'rh@adminconsult.com'),
(116, 'Tecnobras', 'Fernanda Carvalho', 'Vaga para assistente administrativo, com foco em organização de agendas e comunicação interna. O candidato ideal deve ter boa comunicação e habilidades com planilhas e relatórios.', 2200.00, 'Experiência em tarefas administrativas gerais, boa organização e habilidades de comunicação e informática.', 'contato@tecnobras.com'),
(117, 'GlobalHealth', 'Lucas Fernandes', 'Vaga para coordenador administrativo, responsável pela gestão de equipes e apoio ao departamento financeiro. Necessário conhecimento em gestão de pessoas e controles financeiros.', 4500.00, 'Experiência em gestão de equipes, administração financeira e habilidades de liderança.', 'rh@globalhealth.com'),
(118, 'MediCare', 'Joana Lima', 'Vaga para assistente de enfermagem com experiência em atendimento domiciliar. O profissional será responsável por fornecer cuidados básicos de saúde para pacientes em suas casas.', 2500.00, 'Curso técnico de enfermagem, experiência em cuidados domiciliares e empatia no atendimento ao paciente.', 'contato@medicare.com'),
(119, 'Clínica Saúde', 'Ricardo Almeida', 'Vaga para enfermeiro responsável por coordenar a equipe de enfermagem em unidade hospitalar. Necessário experiência em hospitais e liderança de equipes de saúde.', 5500.00, 'Formação em Enfermagem, experiência de 5 anos em hospitais e capacidade de liderar equipes de profissionais de saúde.', 'rh@clinicasaude.com'),
(120, 'Hospital Vital', 'Mariana Gomes', 'Vaga para técnico de enfermagem, atuando em atendimento de urgência e emergência. O candidato deve ter conhecimento em primeiros socorros e estar disponível para turnos variados.', 3000.00, 'Formação técnica em Enfermagem, experiência em emergências e disponibilidade para trabalhar em turnos.', 'contato@hospitalvital.com'),
(121, 'SegurançaPro', 'Eduardo Santos', 'Vaga para técnico de segurança do trabalho, com experiência em elaboração de laudos e auditorias internas. O profissional será responsável por garantir a segurança no ambiente de trabalho e o cumprimento das normas.', 3500.00, 'Formação técnica em Segurança do Trabalho, experiência em empresas de grande porte e conhecimento em normas regulamentadoras.', 'rh@segurancapro.com'),
(122, 'SafeTech', 'Mariana Costa', 'Vaga para engenheiro de segurança do trabalho, responsável por implementar e gerenciar sistemas de segurança. Necessário conhecimento em auditorias e elaboração de políticas de segurança.', 6000.00, 'Formação em Engenharia de Segurança do Trabalho, experiência em grandes obras e gestão de riscos.', 'contato@safetech.com'),
(123, 'ProSegurança', 'Felipe Silva', 'Vaga para auxiliar de segurança do trabalho, com foco em apoio às atividades de prevenção e controle de riscos. O candidato ideal deve ter conhecimento básico de segurança e protocolos de segurança no trabalho.', 1800.00, 'Curso de segurança do trabalho, boa comunicação e interesse em aprender sobre prevenção de riscos.', 'rh@proseguranca.com'),
(124, 'Gastronomia Real', 'Marcelo Oliveira', 'Vaga para chef de cozinha especializada em gastronomia francesa, com ênfase em técnicas clássicas e modernidade. O candidato ideal deve ter experiência com cardápios sofisticados e alta gastronomia.', 8000.00, 'Formação em Gastronomia, experiência em cozinha francesa e habilidades em gestão de cozinha de alto padrão.', 'contato@gastronomiareal.com'),
(125, 'Restaurante Elite', 'Luciana Ferreira', 'Vaga para sous chef de cozinha, com experiência em coordenação de equipe e elaboração de cardápios. Foco em pratos contemporâneos e técnicas inovadoras de culinária.', 5000.00, 'Experiência prévia como sous chef, conhecimento em alta gastronomia e habilidade para coordenar equipes.', 'rh@restauranteelite.com'),
(126, 'Chef Express', 'Roberta Martins', 'Vaga para cozinheiro com especialização em pratos italianos, com experiência em massas e molhos. O candidato ideal deve ter atenção aos detalhes e ser apaixonado por culinária tradicional.', 3000.00, 'Experiência com cozinha italiana, domínio de massas e molhos e trabalho sob pressão.', 'contato@chefexpress.com'),
(127, 'Delícias do Chef', 'Gustavo Almeida', 'Vaga para pasteleiro, com experiência em doces e salgados de alta qualidade. O candidato ideal deve ser criativo, organizado e ter experiência em confecção de massas finas e recheios sofisticados.', 2500.00, 'Experiência com confeitaria e produção de doces e salgados de alta qualidade.', 'contato@deliciasdochef.com'),
(128, 'Restaurante Maré', 'Pedro Santana', 'Vaga para cozinheiro especializado em frutos do mar, com foco em pratos gourmet. O candidato deve ter experiência na preparação de pratos refinados e com apresentação impecável.', 4500.00, 'Experiência em cozinha de frutos do mar, habilidades em apresentação de pratos e técnicas de cozinha sofisticada.', 'rh@restauranemare.com'),
(129, 'Sabor & Arte', 'Camila Rodrigues', 'Vaga para ajudante de cozinha, com foco em apoio nas atividades de preparação e organização da cozinha. Ideal para quem busca aprendizado e crescimento na área gastronômica.', 1600.00, 'Interesse em aprender sobre culinária e organização de cozinha, boa disposição e trabalho em equipe.', 'contato@saborarte.com'),
(130, 'Gastronomia Gourmet', 'Ricardo Oliveira', 'Vaga para cozinheiro chefe, com experiência em elaboração de cardápios e gestão de cozinha. O candidato deve ter formação em gastronomia e experiência em restaurantes de alto nível.', 7000.00, 'Formação em Gastronomia, experiência em gestão de cozinha e elaboração de cardápios sofisticados.', 'rh@gastronomiagourmet.com'),
(131, 'NutriTech', 'Carla Mendes', 'Vaga para nutricionista em clínica de emagrecimento, com foco em elaboração de dietas personalizadas e acompanhamento contínuo de pacientes.', 3600.00, 'Experiência com emagrecimento e nutrição personalizada, habilidades em motivação de pacientes e acompanhamento diário.', 'contato@nutritech.com'),
(132, 'NutriCorp', 'Ricardo Pereira', 'Vaga para nutricionista em clínica de nutrição clínica, com especialização em nutrição funcional e em cardápios para pessoas com doenças crônicas.', 3500.00, 'Formação em Nutrição Funcional, experiência com pacientes de doenças crônicas, e elaboração de dietas terapêuticas.', 'rh@nutricorp.com'),
(133, 'Saúde Integrada', 'Lucas Almeida', 'Vaga para nutricionista para atendimento em clínicas de estética. Responsável por aconselhamento nutricional e acompanhamento de dietas para tratamentos estéticos.', 3200.00, 'Experiência com nutrição estética, conhecimentos em emagrecimento e nutrição anti-idade.', 'contato@saudeintegrada.com'),
(134, 'Viva Bem', 'Cláudia Souza', 'Vaga para nutricionista com especialização em nutrição geriátrica. O profissional deverá planejar dietas balanceadas e ajudar no acompanhamento nutricional de idosos.', 2800.00, 'Especialização em Nutrição Geriátrica, experiência com atendimento a idosos e elaboração de dietas adequadas.', 'contato@vivabem.com'),
(135, 'MedCorps', 'Felipe Ramos', 'Vaga para nutricionista hospitalar com experiência em dietas clínicas para pacientes internados, com foco em recuperação pós-cirúrgica.', 4000.00, 'Experiência em hospitais, com conhecimento de dietas terapêuticas e acompanhamento nutricional em ambientes clínicos.', 'rh@medcorps.com'),
(136, 'EcoAdmin', 'Vera Silva', 'Vaga para analista administrativo, com foco em otimização de processos e gestão de equipe administrativa. Responsável por fazer relatórios financeiros e apoiar a gestão.', 2800.00, 'Experiência em administração de empresas, com habilidade para gerar relatórios financeiros e otimizar processos.', 'rh@ecoadmin.com'),
(137, 'Prime Solutions', 'Marcos Oliveira', 'Vaga para gerente administrativo, com foco em gerenciamento de contratos e supervisão de equipes. O candidato ideal deverá ter experiência em gerenciar processos administrativos e financeiros.', 6000.00, 'Experiência em gestão de pessoas, contratos e administração financeira.', 'contato@primesolutions.com'),
(138, 'Gestão Conectada', 'Raquel Barbosa', 'Vaga para coordenador administrativo, com ênfase em gestão de equipe e controle de orçamento. O candidato deverá ser capaz de liderar processos administrativos internos e otimizar recursos.', 5500.00, 'Experiência em gestão de equipes e controle de recursos administrativos, com conhecimento em orçamento corporativo.', 'rh@gestaoconectada.com'),
(139, 'MedCare Solutions', 'Juliana Costa', 'Vaga para auxiliar de enfermagem, com foco em cuidados de pacientes pós-operatórios e apoio ao cuidado diário. Experiência em clínicas de recuperação será um diferencial.', 2500.00, 'Curso técnico de Enfermagem, experiência com pacientes pós-operatórios e trabalho em equipe.', 'rh@medcaresolutions.com'),
(140, 'Hospitais São João', 'Eduardo Oliveira', 'Vaga para enfermeiro responsável por gerenciar a equipe de enfermagem e coordenar o atendimento a pacientes de UTI. O candidato deve ter experiência com gestão de unidades de terapia intensiva.', 7500.00, 'Formação em Enfermagem com especialização em UTI e experiência em gestão de equipes de saúde.', 'rh@hospitaissaoinha.com'),
(141, 'Saúde & Vida', 'Alessandra Pereira', 'Vaga para enfermeiro com foco em acompanhamento de pacientes com doenças cardíacas. O candidato deverá realizar visitas domiciliares para monitoramento de condições de saúde.', 3800.00, 'Experiência em doenças cardíacas, visitas domiciliares e monitoramento remoto de pacientes.', 'contato@saudevida.com'),
(142, 'Inova Saúde', 'Marco Aurélio', 'Vaga para técnico de segurança do trabalho para realizar auditorias internas e garantir o cumprimento das normas de segurança no ambiente de trabalho.', 2800.00, 'Experiência em auditorias e implementação de normas de segurança, cursos de atualização nas NR\'s.', 'rh@inovasaude.com'),
(143, 'ProSeg', 'Fernanda Martins', 'Vaga para engenheiro de segurança do trabalho responsável pela criação de políticas preventivas e gestão de segurança em um ambiente corporativo de grande porte.', 6500.00, 'Formação em Engenharia de Segurança, experiência com normas regulamentadoras e políticas preventivas.', 'rh@proseg.com'),
(144, 'SafeTech', 'Tiago Lima', 'Vaga para técnico de segurança do trabalho para realizar treinamentos e instruir colaboradores sobre práticas seguras de trabalho, além de monitorar o uso de equipamentos de proteção.', 3000.00, 'Formação técnica em Segurança do Trabalho, experiência em treinamentos e controle de EPIs.', 'contato@safetech.com'),
(145, 'Gastronomia Gourmet', 'Júlia Costa', 'Vaga para chef de cozinha especializado em cozinha italiana. O candidato será responsável por criar pratos sofisticados e coordenar a equipe de cozinha.', 8500.00, 'Experiência em cozinha italiana, criatividade e habilidades de liderança em cozinhas gourmet.', 'rh@gastronomagourmet.com'),
(146, 'Restaurante Bom Sabor', 'Isabel Ferreira', 'Vaga para chef de cozinha, com foco em pratos orgânicos e saudáveis. O candidato ideal deve ter experiência na preparação de cardápios naturais e orgânicos.', 4800.00, 'Experiência com alimentos orgânicos, habilidade na criação de cardápios saudáveis e criativos.', 'contato@restaurantebomsabor.com'),
(147, 'Sabores do Brasil', 'Ricardo Azevedo', 'Vaga para cozinheiro especializado em pratos típicos brasileiros. O candidato deverá conhecer a fundo as tradições culinárias de diversas regiões do Brasil.', 2800.00, 'Experiência com culinária brasileira, domínio das técnicas de pratos típicos e conhecimento sobre ingredientes nacionais.', 'rh@saboresdobrasil.com'),
(148, 'Restaurante Delícias', 'Patricia Gomes', 'Vaga para confeiteiro especializado em sobremesas finas. O candidato ideal deve ter experiência em doces sofisticados e técnicas de confeitaria moderna.', 3300.00, 'Experiência com confeitaria gourmet, doces finos e habilidades em decoração de sobremesas.', 'contato@restaurantedelicias.com'),
(149, 'Gastronomia de Autor', 'Maurício Oliveira', 'Vaga para sous chef especializado em cozinha molecular. O candidato deve ter experiência com a utilização de técnicas modernas e inovadoras de preparo de alimentos.', 7000.00, 'Experiência em cozinha molecular, criatividade e habilidades de liderança em cozinha de vanguarda.', 'rh@gastronomiodeautor.com'),
(150, 'Chef Criativo', 'André Ferreira', 'Vaga para cozinheiro com experiência em cozinha de fusão. O candidato deve ser criativo e ter habilidade para mesclar sabores de diferentes culturas gastronômicas.', 3500.00, 'Experiência com cozinha de fusão, criatividade e capacidade de trabalhar sob pressão.', 'contato@chefcriativo.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `criador_id` (`criador_id`);

--
-- Indexes for table `eventos_salvos`
--
ALTER TABLE `eventos_salvos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `evento_id` (`evento_id`);

--
-- Indexes for table `mensagens`
--
ALTER TABLE `mensagens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `recrutador_id` (`recrutador_id`);

--
-- Indexes for table `posts_salvos`
--
ALTER TABLE `posts_salvos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `recrutadores`
--
ALTER TABLE `recrutadores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `emailPessoal` (`emailPessoal`),
  ADD UNIQUE KEY `emailCorporativo` (`emailCorporativo`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vagas_emprego`
--
ALTER TABLE `vagas_emprego`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `eventos`
--
ALTER TABLE `eventos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `eventos_salvos`
--
ALTER TABLE `eventos_salvos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `mensagens`
--
ALTER TABLE `mensagens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts_salvos`
--
ALTER TABLE `posts_salvos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `recrutadores`
--
ALTER TABLE `recrutadores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `vagas_emprego`
--
ALTER TABLE `vagas_emprego`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `eventos`
--
ALTER TABLE `eventos`
  ADD CONSTRAINT `eventos_ibfk_1` FOREIGN KEY (`criador_id`) REFERENCES `recrutadores` (`id`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `fk_posts_recrutadores` FOREIGN KEY (`recrutador_id`) REFERENCES `recrutadores` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_posts_usuarios` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `posts_salvos`
--
ALTER TABLE `posts_salvos`
  ADD CONSTRAINT `posts_salvos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `posts_salvos_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
