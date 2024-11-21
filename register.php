<?php

if ($_SERVER['REQUES_METHOD'] == 'POST')
$cpf = $_POST['cpf'];
$email = $_POST['email'];
$senha = $_POST['senha'];
$confirm_senha = $_POST['confirm_senha'];

//checar pass correto

if ($senha != $confirm_senha) {
    echo "As senhas não coincidem...";
    exit;
}

// HASH the pass > *encriptar dados*

$senhaHash = password_hash($senha, PASSWORD_BCRYPT);

// conexão db

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bfpay_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

    $stmt = $conn->prepare("INSERT INTO users (cpf, email, senha) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $cpf, $email, $senhaHash);

    if ($stmt->execute()) {
        echo "Cadastro realizado com sucesso!";
    } else {
        echo "Erro ao cadastrar: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>