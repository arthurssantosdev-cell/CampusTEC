<?php
include('conexao.php');
session_start();

if (isset($_GET['remetente_id']) && isset($_GET['destinatario_id'])) {
    $remetente_id = $_GET['remetente_id'];
    $destinatario_id = $_GET['destinatario_id'];

    $sql = "SELECT * FROM chats 
            WHERE (remetente_id = ? AND destinatario_id = ?) 
            OR (remetente_id = ? AND destinatario_id = ?)
            ORDER BY timestamp ASC";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('iiii', $remetente_id, $destinatario_id, $destinatario_id, $remetente_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $classe = ($row['remetente_id'] == $remetente_id) ? 'enviado' : 'recebido';
        echo '<div class="' . $classe . '">';
        echo '<p>' . htmlspecialchars($row['mensagem'], ENT_QUOTES, 'UTF-8') . '</p>';
        echo '<small>' . $row['timestamp'] . '</small>';
        echo '</div>';
    }
}
?>
