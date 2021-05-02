<?php session_start();

require_once ('bd.php');

$photoID=$_GET['photoId'];
$_SESSION['photoId']=$photoID;
if(isset($_SESSION['']))
