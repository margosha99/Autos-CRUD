<?php
require_once 'pdo.php';
session_start();

    if ( ! isset($_GET['autos_id']) ) {
        $_SESSION['error'] = "Missing autos_id";
        header('Location: index.php');
        return;
    }
    if(isset($_POST['delete']) && isset($_POST['autos_id'])){
        $sql = "DELETE FROM autos WHERE autos_id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':id'=>$_POST['autos_id']));
        $_SESSION['success'] = "Record deleted";
        header('Location: index.php');
        return;    

    }
    $stmt = $pdo->prepare("SELECT make,autos_id FROM autos
    WHERE autos_id = :id ");
    $stmt->execute(array(
        ":id" => $_GET['autos_id']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row === false){
            $_SESSION['error'] = 'Bad value for autos_id';
            header('Location: index.php');
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
    <p>Confirm: Deleting <?= htmlentities($row['make']) ?> </p>
    <form method="POST">
        <input type="hidden" name="autos_id" value="<?= $row['autos_id'] ?>">
        <input type="submit" name="delete" value='Delete'>
        <a href="index.php">Cancel</a>
    </form>
    </div>
</body>
</html>