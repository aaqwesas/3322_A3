<?php
session_start();
$db_conn = mysqli_connect("c3322-db","dummy","c3322b","db3322");
$notificationMessage = "";
if(!$db_conn){
    die("Database connection failed: " . mysqli_connect_error());
}

if (isset($_SESSION['username'])) {
    header("Location: chat.php");
    exit();
}

if (isset($_POST["register"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirm_password"];

    // Check for empty fields and password mismatch first
    if (empty($email)) {
        $notificationMessage = "Missing Email";
    } elseif (strpos($email, "@connect.hku.hk") === false) {
        $notificationMessage = "Please enter a valid HKU @connect email address";
    } elseif (empty($password)) {
        $notificationMessage = "Password is required";
    } elseif ($password !== $confirmPassword) {
        $notificationMessage = "Mismatch passwords";
    } else {
        // Proceed to check if the email is already registered
        $query = "SELECT * FROM account WHERE email = ?";
        $stmt = mysqli_prepare($db_conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $rowCount = mysqli_num_rows($result);
        
        if ($rowCount > 0) {
            $notificationMessage = "Failed to register. Already registered before";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $insertQuery = "INSERT INTO account (email, password) VALUES (?, ?)";
            $stmt = mysqli_prepare($db_conn, $insertQuery);
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "ss", $email, $hashedPassword);
                $success = mysqli_stmt_execute($stmt);
                if ($success) {
                    $notificationMessage = "Registration successful. Please log in.";
                } else {
                    $notificationMessage = "Failed to register. Please try again later.";
                }
            } else {
                die("Something went wrong with preparing the registration query");
            }
        }
    }
}

if (isset($_POST["login"])) {
    $email = mysqli_real_escape_string($db_conn, $_POST["email"]);
    $password = mysqli_real_escape_string($db_conn, $_POST["password"]);
    
    if (empty($email)) {
        $notificationMessage = "Missing Email";
    } elseif (empty($password)) {
        $notificationMessage = "Please provide the password";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) || strpos($email, "@connect.hku.hk") === false) {
        $notificationMessage = "Enter a valid HKU @connect email address";
    } else {
        $query = "SELECT * FROM account WHERE email = ?";
        $stmt = mysqli_prepare($db_conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($user = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $user["password"])) {
                $_SESSION['username'] = strstr($user['email'], '@connect.hku.hk', true);
                header("Location: chat.php");
                exit(); 
            } else {
                $notificationMessage = "Failed to login. Incorrect password.";
            }
        } else {
            $notificationMessage = "Failed to login. Unknown user";
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head> 
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css"> 
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="login.js"></script>
    <title>Comp3322 Assignment3</title> 
</head>
    <body class="container">
    <h1>A Simple Chatroom Service</h1>
        <?php if (!isset($_GET["register"])): ?>
            <h2>Login to Chatroom</h2>
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                    <label>Email:</label>
                    <input id="emailInput" type="text" name="email" placeholder="Enter your email" onblur='verifyEmail()' ><br><br>
                    <label>Password:</label>
                    <input id="login_pw" type="password" name="password" placeholder="Enter your password" " ><br><br>
                    <input type="submit" name="login" value="Login">
                    <p>Click <a href="login.php?register=1">here</a> to register an account</p>
                    <div id="notificationContainer" class="notification">
                        <?php if(!empty($notificationMessage)) echo htmlspecialchars($notificationMessage); ?>
                    </div>
                </form>
        <?php else: ?>
            <h2>Register an account</h2>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?register=1">
                <label>Email:</label>
                <input id="email2" type="text" name="email" placeholder="Enter your email" onblur="verifyEmail_register()" ><br><br>
                <label>Password:</label>
                <input id="register_pw" type="password" name="password" placeholder="Enter your password" ><br><br>
                <label>Confirm Password:</label>
                <input id="confirm" type="password" name="confirm_password" placeholder="Enter your password again" "><br><br>
                <input type="submit" name="register" value="Register">
                <p>Click <a href="login.php">here</a> to login</p>
                <div id="notificationContainer" class="notification">
                        <?php if(!empty($notificationMessage)) echo htmlspecialchars($notificationMessage); ?>
                    </div>
            </form>
        <?php endif; ?>
    </body>
</html>