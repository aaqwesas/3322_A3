<?php
session_start();
header("Content-Type: application/json; charset=UTF-8");


ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL); 


if (isset($_SESSION['username']) || !$_SESSION['username']) {
    $username = $_SESSION['username'];
} else {
    http_response_code(401);
    header('Location: login.php');
    exit();
}

$db_host = "c3322-db";
$db_user = "dummy";
$db_password = "c3322b";
$db_name = "db3322";
$db_conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);

if (!$db_conn) {
    echo json_encode(['error' => 'Database connection failed: ' . mysqli_connect_error()]);
    exit;
}

function store_message($db_conn, $message, $username){
    $query = "INSERT INTO message (`time`, `message`, `person`) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($db_conn, $query);
    $time = time();
    mysqli_stmt_bind_param($stmt, "iss", $time, $message, $username);
    $success = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $success;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_SESSION['username'];
    $message = trim($_POST['message']);
    
    if (!empty($message)) {
        $success = store_message($db_conn, $message, $username);
        echo json_encode(['success' => $success]);
    } else {
        echo json_encode(['error' => 'Message is empty']);
    }
}else{
    $query = "SELECT `time`, `message`, `person` FROM message ORDER BY `time` ASC";
    $result = mysqli_query($db_conn, $query);

    if (!$result) {
        echo json_encode(['error' => 'Error fetching messages: ' . mysqli_error($db_conn)]); 
    }else{

    $chatMessages = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $chatMessages[] = $row;
    }

    mysqli_free_result($result);
    mysqli_close($db_conn);
    echo json_encode($chatMessages);
}
}
?>