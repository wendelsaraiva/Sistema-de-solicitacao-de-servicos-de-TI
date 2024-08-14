<?php
// Conexão com o banco de dados (exemplo usando MySQLi)
$servername = "localhost"; // endereço do servidor do banco de dados
$username = "teste"; // seu nome de usuário do banco de dados
$password = ""; // sua senha do banco de dados
$dbname = "teste"; // nome do seu banco de dados

// Criando a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificando a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Preparando os dados para inserção no banco
$nome = $_POST['nome'];
$email = $_POST['email'];
$setor = $_POST['setor'];
$data = $_POST['data'];
$servico = $_POST['servico'];

// Preparando a consulta SQL para inserir os dados
$sql = "INSERT INTO teste (nome, email, setor, data, servico) 
        VALUES ('$nome', '$email', '$setor', '$data', '$servico')";

// Executando a consulta e verificando se foi bem-sucedida

  
if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Solicitação enviada com sucesso! Entraremos em contato em breve."); window.location.href = "index.html";</script>';
    } else {
        echo '<script>alert("Ocorreu um erro ao enviar a solicitação. Por favor, tente novamente."); window.history.back();</script>';
    }


// Fechando a conexão com o banco de dados
$conn->close();
?>
