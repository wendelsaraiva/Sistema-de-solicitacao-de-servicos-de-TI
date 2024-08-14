<?php
// Configurações do banco de dados
$host = 'localhost';
$user = 'root';
$password = ''; // Substitua pela sua senha do MySQL
$database = 'teste'; // Substitua pelo nome do seu banco de dados

// Cria a conexão com o banco de dados
$conn = new mysqli($host, $user, $password, $database);

// Verifica se a conexão foi bem-sucedida
if ($conn->connect_error) {
    die('Erro de conexão: ' . htmlspecialchars($conn->connect_error));
}

// Exclui um item se um nome de exclusão foi enviado
if (isset($_POST['nome'])) {
    $nome = $conn->real_escape_string($_POST['nome']); // Escapa caracteres especiais
    $sql = 'DELETE FROM servicos_prontos WHERE nome = ?'; // Ajuste 'usuarios' e 'nome'
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die('Erro na preparação da declaração: ' . htmlspecialchars($conn->error));
    }
    $stmt->bind_param('s', $nome); // 's' indica que $nome é uma string
    $success = $stmt->execute();
    $stmt->close();
    echo json_encode(['success' => $success]);
}

// Fecha a conexão com o banco de dados
$conn->close();


?>
