<?php
require __DIR__ . '/database/database.php';
// je récupère le fichier database.php 
// pour la connexion à pdo
$authDB = require __DIR__ . '/database/security.php';
// gestion des routes quand pour voir via le coockie si la personne est connecté 
$currentUser = $authDB->isLoggedin();
// dans le currentUser on récupère depuis database sécurity la méthode isLoggeding
// qui va nous permetre de recupérer le cookie de session 
// voir grafikart coockie de session php 
$articleDB = require_once __DIR__ . '/database/model/ArticleDB.php';
// le modèle article db contient la classe pour créer des articles ensuite supprimer lire et mettre à jours

$articles = $articleDB->fetchAll();
// je récupères tout les articles via la méthode fetchAll

$categories = [];
// iniitilisation de tableau vide 
$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
//  filtration de toute les requète get

$selectedCat = $_GET['cat'] ?? '';
// opérateur de fusion nul 




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
            <div class="newsfeed-container">
                <ul class="category-container">
                    <li class=<?= $selectedCat ? '' : 'cat-active' ?>><a href="/">Tous les articles <span class="small">(<?= count($articles) ?>)</span></a></li>
                    <?php foreach ($categories as $catName => $catNum) : ?>
                        <li class=<?= $selectedCat ===  $catName ? 'cat-active' : '' ?>><a href="/?cat=<?= $catName ?>"> <?= $catName ?><span class="small">(<?= $catNum ?>)</span> </a></li>
                    <?php endforeach; ?>
                </ul>
                <div class="newsfeed-content">
                    <?php if (!$selectedCat) : ?>
                        <?php foreach ($categories as $cat => $num) : ?>
                            <h2><?= $cat ?></h2>
                            <div class="articles-container">
                                <?php foreach ($articlePerCategories[$cat] as $a) : ?>
                                    <a href="/show-article.php?id=<?= $a['id'] ?>" class="article block">
                                        <div class="overflow">
                                            <div class="img-container" style="background-image:url(<?= $a['image'] ?>"></div>
                                        </div>
                                        <h3><?= $a['title'] ?></h3>
                                        <?php if ($a['author']) : ?>
                                            <div class="article-author">
                                                <p><?= $a['firstname'] . ' ' . $a['lastname']  ?></p>
                                            </div>
                                        <?php endif; ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <h2><?= $selectedCat ?></h2>
                        <div class="articles-container">
                            <?php foreach ($articlePerCategories[$selectedCat] as $a) : ?>
                                <a href="/show-article.php?id=<?= $a['id'] ?>" class="article block">
                                    <div class="overflow">
                                        <div class="img-container" style="background-image:url(<?= $a['image'] ?>"></div>
                                    </div>
                                    <h3><?= $a['title'] ?></h3>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php require_once 'includes/footer.php' ?>
    </div>

</body>

</html>