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

// Move um item se um nome de exclusão foi enviado
if (isset($_POST['nome'])) {
    $nome = $conn->real_escape_string($_POST['nome']); // Escapa caracteres especiais

    // Move o item para a tabela de serviços prontos
    $sql_move = 'INSERT INTO servicos_prontos (nome, email, setor, data, servico) SELECT nome, email, setor, data, servico FROM teste WHERE nome = ?';
    $stmt_move = $conn->prepare($sql_move);
    if ($stmt_move === false) {
        die('Erro na preparação da declaração: ' . htmlspecialchars($conn->error));
    }
    $stmt_move->bind_param('s', $nome);
    $success_move = $stmt_move->execute();
    $stmt_move->close();

    // Remove o item da tabela principal
    $sql_delete = 'DELETE FROM teste WHERE nome = ?';
    $stmt_delete = $conn->prepare($sql_delete);
    if ($stmt_delete === false) {
        die('Erro na preparação da declaração: ' . htmlspecialchars($conn->error));
    }
    $stmt_delete->bind_param('s', $nome);
    $success_delete = $stmt_delete->execute();
    $stmt_delete->close();

    echo json_encode(['success' => $success_move && $success_delete]);
}

// Fecha a conexão com o banco de dados
$conn->close();
?>
