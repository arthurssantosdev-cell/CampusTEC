<?php
// Conexão com o banco de dados
include('conexao.php');

// Consultar todos os eventos da tabela 'eventos'
$query = "SELECT id, nome FROM eventos";
$result = mysqli_query($conn, $query);

// Verificar se a consulta retornou resultados
if ($result) {
    $notificacoes = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            // Adicionar cada evento ao array de notificações com nome e id
            $notificacoes[] = array('id' => $row['id'], 'mensagem' => $row['nome']);
        }
    } else {
        // Se não houver notificações, retornar uma mensagem apropriada
        $notificacoes[] = array('mensagem' => 'Sem notificações no momento');
    }
    // Retornar as notificações em formato JSON
    echo json_encode($notificacoes);
} else {
    // Em caso de erro na consulta, retornar uma mensagem de erro
    echo json_encode(array('error' => 'Erro ao buscar eventos'));
}

// Fechar a conexão com o banco de dados
mysqli_close($conn);
?>
