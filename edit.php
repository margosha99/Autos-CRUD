<?php
require_once 'pdo.php';
session_start();

    if(!isset($_SESSION['name']) ){
        die("ACCESS DENIED");
    }

    if(isset($_POST['make']) && isset($_POST['year'])
    && isset($_POST['model']) && isset($_POST['mileage']) ){


        if(strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1){
            $_SESSION['error'] = 'All fields are required';
            header("Location: edit.php?autos_id=".$_POST['autos_id']);
            return;
        }

        if(!is_numeric($_POST['year']) ){
            $_SESSION['error'] = 'Year must be numeric';
            header("Location: edit.php?autos_id=".$_POST['autos_id']);
            return;
        }
        if(!is_numeric($_POST['mileage']) ){
            $_SESSION['error'] = 'Mileage must be numeric';
            header("Location: edit.php?autos_id=".$_POST['autos_id']);
            return;
        }
        $sql = "UPDATE autos SET make = :make, model = :model,
        year = :year, mileage = :mileage WHERE autos_id = :autos_id";

        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':make' => $_POST['make'],
            ':model' => $_POST['model'],
            ':year' => $_POST['year'],
            ':mileage' => $_POST['mileage'],
            ':autos_id'=>$_GET['autos_id']));
        $_SESSION['success'] = 'Record edited';
        header( 'Location: index.php' ) ;
        return;
    }
// Guardian: Make sure that user_id is present
if ( ! isset($_GET['autos_id']) ) {
    $_SESSION['error'] = "Missing autos_id";
    header('Location: index.php');
    return;
}
$stmt = $pdo->prepare("SELECT * FROM autos where autos_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['autos_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for autos_id';
    header( 'Location: index.php' ) ;
    return;
}

$make = htmlentities($row['make']);
$model = htmlentities($row['model']);
$year = htmlentities($row['year']);
$mileage = htmlentities($row['mileage']);
$autos_id = $row['autos_id'];
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
    <h2>Editing Automobile</h2>
    <?php
    if ( isset($_SESSION['error']) ) {
        echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
        unset($_SESSION['error']);
    }
    ?>
    <form method="POST">
            <p>Make: <input type="text" name="make" size="40" value="<?= $make ?>"></p>
            <p>Model <input type="text"  name="model" size="40" value="<?= $model ?>"></p>
            <p>Year <input type="text"  name="year" size="40" value="<?= $year ?>"></p>
            <p>Mileage <input type="text"  name="mileage" size="40" value="<?= $mileage ?>"></p>
            <input type="hidden" name="autos_id" value="<?= $autos_id ?>">
            <input type="submit" value="Save">
            <a href="index.php">Cancel</a></p>
    </form>
</div>    
</body>
</html>