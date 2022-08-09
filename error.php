<?php
require_once './database/database.php';
$AuthDB = require __DIR__ .'/database/security.php';
$currentUser = $AuthDB->isloggedin();
$articleDB = require_once __DIR__ . '/database/model/ArticleDB.php';
$articles =$articleDB->fetchAll();
$categories = [];



$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$selectedCat = $_GET['cat'] ?? '';

if (count($articles)) {
    $cattmp = array_map(fn ($a) => $a['category'],  $articles);
    $categories = array_reduce($cattmp, function ($acc, $cat) {
         
        if (isset($acc[$cat])) {
            $acc[$cat]++;
        } else {
            $acc[$cat] = 1;
        }
        return $acc;
    }, []);
    $articlePerCategories = array_reduce($articles, function ($acc, $article) {
        if (isset($acc[$article['category']])) {
            $acc[$article['category']] = [...$acc[$article['category']], $article];
        } else {
            $acc[$article['category']] = [$article];
        }
        return $acc;
    }, []);
}


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once 'includes/head.php' ?>
    <link rel="stylesheet" href="/public/css/index.css">
    <title>Blog</title>
</head>

<body>
    <div class="container">
        <?php require_once 'includes/header.php' ?>
        <div class="content">
           <h1 style="font-size: 7rem;text-align:center;">Oups une erreur est survenue </h1>
        </div>
        <?php require_once 'includes/footer.php' ?>
    </div>

</body>

</html>