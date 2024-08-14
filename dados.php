<?php
header('Content-Type: application/json');

// Configurações do banco de dados
$host = 'localhost';
$user = 'teste';
$password = ''; // Substitua pela sua senha do MySQL
$database = 'teste'; // Substitua pelo nome do seu banco de dados

// Cria a conexão com o banco de dados
$conn = new mysqli($host, $user, $password, $database);

// Verifica se a conexão foi bem-sucedida
if ($conn->connect_error) {
    die('Erro de conexão: ' . $conn->connect_error);
}

// Consulta os dados da tabela
$sql = 'SELECT * FROM teste'; // Substitua 'usuarios' pelo nome da sua tabela
$result = $conn->query($sql);

// Cria um array para armazenar os dados
$dados = [];

// Verifica se há resultados e os armazena no array
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $dados[] = $row;
    }
}

// Fecha a conexão com o banco de dados
$conn->close();

// Retorna os dados no formato JSON
echo json_encode($dados);
?>
