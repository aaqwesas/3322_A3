<?php
session_start();
$db_conn = mysqli_connect("c3322-db","dummy","c3322b","db3322");

if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
}else{
    alert("Please Login");
    echo "<script type='text/javascript'>window.location.href = 'login.php';</script>";
    exit();
}
function alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
}

function isLoggedIn() {
    return isset($_SESSION['username']);
}

function logout() {
    $_SESSION = array();
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_destroy();
    exit();
}


if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

if (isset($_POST['action']) && $_POST['action'] == 'logout') {
    logout();
}

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit();
}

?>

<script type="text/javascript">
    var currentUsername = <?php echo json_encode($username); ?>;
    console.log(currentUsername);
</script>

<!DOCTYPE html>
<html>
<head>
  <title>Chatroom</title>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <link rel="stylesheet" href="chat.css">
  <script src="chat.js"></script>
</head>
<body>
    <div id="chatroom-container">
        <div id="chatroom-header">
            <h1>A simple Chatroom Service</h1>
            <form id="logout-form" action="chat.php" method="post">
                <input type="hidden" name="logout" value="1">
                <button type="submit" id="logout-button">Logout</button>
            </form>
        </div>
        <div id="messages-container">
            <!-- Messages will be displayed here -->
        </div>
        <form id="chatroom-form" action="chat.php" method="post">
            <input type="text" id="chatroom-input" name="message" placeholder="Type your message here...">
            <button type="submit" name="send-button">Send</button>
        </form>
    </div>
</body>
</html>