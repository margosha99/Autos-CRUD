<?php
session_start();
require_once "pdo.php";

    if(!isset($_SESSION['name']) ){
        die("ACCESS DENIED");
    }
    if( isset($_POST['cancel']) ){
        header('Location: index.php');
        return;
    }
    if(isset($_POST[('add')]) ){

        if(strlen($_POST['make']) < 1){
            $_SESSION['error'] = "All fields are required";
            header("Location: add.php");
            return;
        }else if( strlen($_POST['model']) < 1 ){
            $_SESSION['error'] = "All fields are required";
            header("Location: add.php");
            return;
        }else if( !is_numeric($_POST['year']) ){
            $_SESSION['error'] = "Year must be an integer";
            header("Location: add.php");
            return;
        }else if( !is_numeric($_POST['mileage']) ){
            $_SESSION['error'] = "Mileage must be an integer";
            header("Location: add.php");
            return;
        }
        else{
            
            $stmt = $pdo->prepare('INSERT INTO autos (make,model,year,mileage) VALUES ( :mk, :md, :yr, :mi)');
            $stmt->execute(array(
                ':mk'=>$_POST['make'],
                ':md'=>$_POST['model'],
                ':yr'=>$_POST['year'],
                ':mi'=>$_POST['mileage']));
            $_SESSION['success'] = 'Record added';
            header('Location: index.php');
            return;
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
        <?php
            if(isset($_SESSION['name']) ){
                echo "<h2>Tracking Autos for: ";
                echo htmlentities($_SESSION['name']);
                echo "</h2>\n";
            }
        ?>
        <?
            if(isset($_SESSION['error'])){
                echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
                unset($_SESSION['error']);
            }

        ?>
        <form method="POST">
            <p>Make: <input type="text" name="make" size="40"></p>
            <p>Model <input type="text"  name="model" size="40"></p>
            <p>Year <input type="text"  name="year" size="40"></p>
            <p>Mileage <input type="text"  name="mileage" size="40"></p>
            <input type="submit" name="add" id="add" value="Add">
            <input type="submit" name="cancel" id="cancel" value="Cancel">
        </form>
    </div>
</body>
</html>