<?php

$dns = 'mysql:host=localhost;dbname=blog';
$user = 'root';
$pwd = 'toto';

// la version de ton serveur sql ensuite l'host et le non de ta table 
// passe en argument aux parametre de PDO
// le user de ta base de donné 

try {
  $pdo = new PDO($dns, $user, $pwd, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
  ]);
} catch (PDOException $e) {
  echo "ERROR : " . $e->getMessage();
}


return $pdo;
