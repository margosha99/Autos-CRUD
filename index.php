<?php
require_once "pdo.php";
session_start();
if(isset($_POST['logout']) ){
    header('Location: logout.php');
    return;
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
<h2>Welcome to the Automobiles Database</h2>
    <?php
        if(isset($_SESSION['success']) ){
            echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
            unset($_SESSION['success']);
        }
    ?>
    <?php
        if(isset($_SESSION['error']) ){
            echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
            unset($_SESSION['error']);
        }
    ?>
    
    <?php
    if(isset($_SESSION['name']) ){
        echo('<table border="1">'."\n");
        echo "<tr><th>";
            echo "Make";
            echo "</th><th>";
            echo "Model";
            echo "</th><th>";
            echo "Year";
            echo "</th><th>";
            echo "Mileage";
            echo "</th><th>";
            echo "Action";
            echo "</th></tr>";
        $stmt = $pdo->query("SELECT make,model,year,autos_id,mileage FROM autos ORDER BY `autos`.`autos_id` ASC");
        if($stmt->rowCount() == 0){
            echo ('<p>No rows found</p>');
        }else{
        while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ){
        

            echo "<tr><td>";
            echo(htmlentities($row['make']));
            echo "</td><td>";
            echo(htmlentities($row['model']));
            echo "</td><td>";
            echo(htmlentities($row['year']));
            echo "</td><td>";
            echo(htmlentities($row['mileage']));
            echo "</td><td>";
            echo('<a href="edit.php?autos_id='.$row['autos_id'].'">Edit</a> /');
            echo('<a href="delete.php?autos_id='.$row['autos_id'].'">Delete</a>');
            echo("</td></tr>\n");
        }
    }
        echo("</table>");
        echo('<a href="add.php">Add New Entry</a></br>');
        echo('<a href="logout.php">Logout</a></br>');

    }
    
    ?>
    <?php 
    if(!isset($_SESSION['name']) ){
        echo ('<p><a href="login.php">Please log in</a></p>');
        echo('<p>Attempt to <a href="add.php">add data </a>without logging in</p>');
    }
    ?>
</div>
</body>
</html>