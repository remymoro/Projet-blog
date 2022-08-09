<?php

 require_once __DIR__ . '/database/database.php';
 $authDB = require_once __DIR__ .'/database/security.php';

$sessionId =$_COOKIE['session'];

if($sessionId){
    if($sessionId){
        $authDB->logout($sessionId);
        header('Location:/auth-login.php');
    }

}





?>




<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once 'includes/head.php' ?>
    <link rel="stylesheet" href="/public/css/profile.css">
    <title>logout</title>
</head>

<body>
    <div class="container">
        <?php require_once 'includes/header.php' ?>
        <div class="content">
           <h1>logout</h1> 
        </div>
        <?php require_once 'includes/footer.php' ?>
    </div>

</body>

</html>