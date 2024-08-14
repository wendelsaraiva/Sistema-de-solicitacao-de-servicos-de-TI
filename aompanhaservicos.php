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

// Consulta os dados da tabela principal
$sql = 'SELECT * FROM teste'; // Substitua 'teste' pelo nome da sua tabela principal
$result = $conn->query($sql);

// Verifica se a consulta foi bem-sucedida
if ($result === false) {
    die('Erro na consulta: ' . htmlspecialchars($conn->error));
}

// Cria um array para armazenar os dados
$dados = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $dados[] = $row;
    }
}

// Consulta os dados da tabela de serviços prontos
$sql_servicos = 'SELECT * FROM servicos_prontos'; // Substitua 'servicos_prontos' pelo nome da sua tabela de serviços prontos
$result_servicos = $conn->query($sql_servicos);

// Verifica se a consulta foi bem-sucedida
if ($result_servicos === false) {
    die('Erro na consulta: ' . htmlspecialchars($conn->error));
}

// Cria um array para armazenar os dados
$dados_servicos = [];
if ($result_servicos->num_rows > 0) {
    while ($row = $result_servicos->fetch_assoc()) {
        $dados_servicos[] = $row;
    }
}

// Fecha a conexão com o banco de dados
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dados do Banco de Dados</title>
    <meta http-equiv="refresh" content="30"> <!-- Atualiza a página a cada 30 segundos -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #e2e2e2;
        }
        .move-button, .delete-button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 12px;
            margin: 2px 1px;
            cursor: pointer;
            border-radius: 3px;
        }
        .delete-button {
            background-color: #f44336; /* Cor vermelha para o botão de exclusão */
        }
        .delete-button:hover {
            background-color: #c62828; /* Cor vermelha escura no hover */
        }
    </style>
</head>
<body>
    <h1>Dados do Banco de Dados</h1>
    <table id="data-table">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Setor</th>
                <th>Data</th>
                <th>Serviço</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($dados)): ?>
                <?php foreach ($dados as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['nome']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['setor']); ?></td>
                        <td><?php echo htmlspecialchars($row['data']); ?></td>
                        <td><?php echo htmlspecialchars($row['servico']); ?></td>
                        <td>
                            <button class="move-button" onclick="moveItem('<?php echo htmlspecialchars($row['nome']); ?>')">Mover</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6">Nenhum dado encontrado.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <h2>Serviços Prontos</h2>
    <table id="servicos-table">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Setor</th>
                <th>Data</th>
                <th>Serviço</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($dados_servicos)): ?>
                <?php foreach ($dados_servicos as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['nome']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['setor']); ?></td>
                        <td><?php echo htmlspecialchars($row['data']); ?></td>
                        <td><?php echo htmlspecialchars($row['servico']); ?></td>
                        <td>
                            <button class="delete-button" onclick="deleteItem('<?php echo htmlspecialchars($row['nome']); ?>')">Excluir</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6">Nenhum dado encontrado.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <script>
        function moveItem(nome) {
            if (confirm('Tem certeza de que deseja mover este item para "Serviços Prontos"?')) {
                fetch('move.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        'nome': nome,
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload(); // Recarrega a página sem atualizar a posição da rolagem
                    } else {
                        alert('Erro ao mover item.');
                    }
                })
                .catch(error => console.error('Erro:', error));
            }
        }

        function deleteItem(nome) {
            if (confirm('Tem certeza de que deseja excluir este item?')) {
                fetch('delete.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        'nome': nome,
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload(); // Recarrega a página sem atualizar a posição da rolagem
                    } else {
                        alert('Erro ao excluir item.');
                    }
                })
                .catch(error => console.error('Erro:', error));
            }
        }
    </script>
</body>
</html>
