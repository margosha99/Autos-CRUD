<?php
session_start();

    if(isset($_POST['cancel']) ){
        header('Location: index.php');
        return;
    }

    $salt = 'XyZzy12*_';
    $stored_hash =  '1a52e17fa899cf40fb04cfc42e6352f1';   //pw php123

    if ( isset($_POST['email']) && isset($_POST['pass']) ) {
        if ( strlen($_POST['email']) < 1 ) {
                $_SESSION['error'] = "User name and password are required";
                header("Location: login.php");
                return;
            }else if(strlen($_POST['pass']) < 1){
                $_SESSION['error'] = "User name and password are required";
                header("Location: login.php");
                return;
            } else {
                if( !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ){
                    $_SESSION['error'] = 'Email must have an at-sign (@)';
                    header("Location: login.php");
                    return;
                }else{
                    $check = hash('md5', $salt.$_POST['pass']);
                    if ( $check == $stored_hash ) {
                        $_SESSION['name'] = $_POST['email'];
                        header("Location: index.php");
                        error_log("Login success ".$_POST['email']);
                        return;
                    } else {
                        $_SESSION['error'] = "Incorrect password";
                        header("Location: login.php");
                        error_log("Login fail ".$_POST['email']." $check");
                        return;
                    }
                }
            }
        }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>843bc605</title>
</head>
<body>
    <div class="container">
    <h2>Please Log In</h2>
    <?php
    if(isset($_SESSION['error'])){
        echo('<p style="color: red;">'.$_SESSION['error']."</p>\n");
        unset($_SESSION['error']);
    }
    ?>
    <form method="POST">
        User Name <input type="text" name="email"><br/>
        Password <input type="text" name="pass"><br/>
        <input type="submit" value="Log In">
        <a href="index.php">Cancel</a>
    </form>
    </div>
</body>
</html>