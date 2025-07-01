<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Content-Type: application/json");

require 'connect.php';

$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'GET':
        if (!empty($_GET['id'])) {
            $id = intval($_GET['id']);
            get_user_by_id($id);
        } else {
            get_all_users();
        }
        break;
    case 'POST':
        insert_user();
        break;
    case 'PUT':
        $id = intval($_GET['id']);
        update_user($id);
        break;
    case 'DELETE':
        $id = intval($_GET['id']);
        delete_user($id);
        break;
    default:
        header('HTTP/1.0 405 Method Not Allowed');
        break;
}

function get_all_users() {
    global $conn;
    $query = "SELECT * FROM hackemail";
    $response = array();
    $result = $conn->query($query);
    while ($row = $result->fetch_assoc()) {
        $response[] = $row;
    }
    echo json_encode($response);
}

function get_user_by_id($id) {
    global $conn;
    $query = "SELECT * FROM hackemail WHERE id=$id";
    $result = $conn->query($query);
    $response = $result->fetch_assoc();
    echo json_encode($response);
}

function insert_user() {
    global $conn;
    $data = json_decode(file_get_contents("php://input"), true);
    $email = $data["email"];
    $password = $data["password"];
    $timing = date('y-m-d H:i:s');
    $query = "INSERT INTO hackemail (email, password, timing) VALUES ('$email', '$password', '$timing')";
    if ($conn->query($query)) {
        $response = array(
            "status" => 1,
            "status message" => "successfully added"
        );
    } else {
        $response = array(
            "status" => 0,
            "status message" => "failed: " . $conn->error
        );
    }
    echo json_encode($response);
}

function update_user($id) {
    global $conn;
    $data = json_decode(file_get_contents('php://input'), true);
    $email = $data["email"];
    $password = $data["password"];
    $stmt = $conn->prepare("UPDATE hackemail SET email=?, password=? WHERE id=?");
    $stmt->bind_param('ssi', $email, $password, $id);
    if ($stmt->execute()) {
        $response = array(
            "status" => 1,
            "status message" => "updated successfully"
        );
    } else {
        $response = array(
            "status" => 0,
            "status message" => "update failed"
        );
    }
    echo json_encode($response);
}

function delete_user($id) {
    global $conn;
    $query = "DELETE FROM hackemail WHERE id=$id";
    if ($conn->query($query)) {
        $response = array(
            "status" => 1,
            "status message" => "deleted successfully"
        );
    } else {
        $response = array(
            "status" => 0,
            "status message" => "delete failed"
        );
    }
    echo json_encode($response);
}
?>
