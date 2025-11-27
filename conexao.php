<?php
// Conexão com o banco de dados
$servername = "localhost";
$username = "campust1_campustec";
$password = "joao2364";
$dbname = "campust1_campustec";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica se a conexão foi bem-sucedida
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}