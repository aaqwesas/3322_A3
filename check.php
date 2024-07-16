<?php
$db_conn = mysqli_connect("c3322-db","dummy","c3322b","db3322");
$notificationMessage = "";
if(!$db_conn){
    die("Database connection failed: " . mysqli_connect_error());
}else{
    if (isset($_POST["checkEmail"])) {
        $email = $_POST["email"];
        $stmt = mysqli_prepare($db_conn, "SELECT * FROM account WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $rowCount = mysqli_num_rows($result);
        echo $rowCount > 0 ? "exists" : "not_exists";
        exit();
    }
}
?>