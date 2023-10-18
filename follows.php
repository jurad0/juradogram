<?php
require_once("CRUD/connection.php");
session_start();
$con = $connect;
$id = ($_GET['id']);
$idSes=($_SESSION['usuario']['id']);
echo $idSes;
try{
    $sql = "INSERT INTO follows (users_id, userToFollowId) VALUES ('$idSes','$id')";
    $guardar = mysqli_query($connect, $sql);
}catch(mysqli_sql_exception $e){
    echo "Ya estas siguiendo a este usuario";}

header("Location: ../profiles/profiles.php?id=$id");
?>
