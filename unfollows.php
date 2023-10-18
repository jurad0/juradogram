<?php
require_once("CRUD/connection.php");
session_start();
$con = $connect;
$id = ($_GET['id']);
$idSes=($_SESSION['usuario']['id']);
echo $idSes;

$sql = "DELETE FROM follows WHERE users_id ='$idSes' AND userToFollowId = '$id'";
$guardar = mysqli_query($connect, $sql);
header("Location: ../profiles/profiles.php?id=$id");
?>