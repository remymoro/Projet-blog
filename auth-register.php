<?php
$pdo = require_once './database/database.php';
$authDB = require_once __DIR__ . '/database/security.php';
define("ERROR_REQUIRED","Veuillez renseigner ce champ");
const ERROR_TOO_SHORT = "Ce champ est trop court";
const ERROR_PASSWORD_TOO_SHORT="le mot de passe doit faire au moin 6 caractères";
const ERROR_EMAIL_INVALID = "l'email n'est pas valide";
define("ERROR_PASSWORD_DIF","Vos mot de passe sont différent ");
$errors =[
    'firstname'=>'',
    'lastname'=>'',
    'email'=>'',
    'password'=>'',
    'confirmpassword'=>'',
];

if($_SERVER['REQUEST_METHOD']==='POST'){
    $_input = filter_input_array(INPUT_POST,[
        'firstname'=>FILTER_SANITIZE_SPECIAL_CHARS,
        'lastname'=>FILTER_SANITIZE_SPECIAL_CHARS,
        'email'=>FILTER_SANITIZE_EMAIL,
    ]);
    $firstname = $_input['firstname'] ?? '';
    $lastname =$_input['lastname'] ?? '';
    $email = $_input['email'] ?? '';
    $password = $_POST['password']?? '';
    $confirmpassword = $_POST['confirmpassword'];
   
    
if(!$firstname){
    $errors['firstname']=ERROR_REQUIRED;
}elseif(mb_strlen($firstname)< 2){
 $errors['firstname']=ERROR_TOO_SHORT;
}
if(!$lastname){
    $errors['lastname']=ERROR_REQUIRED;
}elseif(mb_strlen($lastname)< 2){
 $errors['lastname']=ERROR_TOO_SHORT;
}
if(!$email){
    $errors['email']=ERROR_REQUIRED;
}elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){
 $errors['email']=ERROR_EMAIL_INVALID;
}

if(!$password){
    $errors['password']=ERROR_REQUIRED;
}elseif(mb_strlen($password) < 6 ){
    $errors['password']=ERROR_PASSWORD_TOO_SHORT;
}

if(!$confirmpassword){
    $errors['confirmpassword']=ERROR_REQUIRED;
}elseif($confirmpassword !== $password){
  $errors['confirmpassword']=ERROR_PASSWORD_DIF;
}


if(empty(array_filter($errors,fn($e)=>$e !== ''))){
   $authDB->register([
       'firstname'=>$firstname,
       'lastname'=>$lastname,
       'email'=>$email,
       'password'=>$password
   ]);
    header('Location: /');
}
    


}






?>






<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once 'includes/head.php' ?>
    <link rel="stylesheet" href="/public/css/auth-register.css">
    <title>Mon Profil</title>
</head>

<body>
    <div class="container">
        <?php require_once 'includes/header.php' ?>
        <div class="content">
            <div class="block p-20 form-container">
                <h1> Inscription</h1>
                <form action="/auth-register.php", method="POST">
                    <div class="form-control">
                        <label for="firstname">Votre Prénom</label>
                        <input type="text" name="firstname" id="firstname" value="<?= $firstname ?? '' ?>">
                        <?php if ($errors['firstname']) : ?>
                            <p class="text-danger"><?= $errors['firstname'] ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="form-control">
                        <label for="lastname">Votre Nom</label>
                        <input type="text" name="lastname" id="lastname" value="<?= $lastname ?? '' ?>">
                        <?php if ($errors['lastname']) : ?>
                            <p class="text-danger"><?= $errors['lastname'] ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="form-control">
                        <label for="email">Votre Email</label>
                        <input type="email" name="email" id="email" value="<?= $email ?? '' ?>">
                        <?php if ($errors['email']) : ?>
                            <p class="text-danger"><?= $errors['email'] ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="form-control">
                        <label for="password">Votre Mot de passe</label>
                        <input type="password" name="password" id="password">
                        <?php if ($errors['password']) : ?>
                            <p class="text-danger"><?= $errors['password'] ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="form-control">
                        <label for="confirmpassword">Confirmation mot de passe</label>
                        <input type="password" name="confirmpassword" id="confirmpassword">
                        <?php if ($errors['confirmpassword']) : ?>
                            <p class="text-danger"><?= $errors['confirmpassword'] ?></p>
                        <?php endif; ?>
                        </div>
                    <div class="form-actions">
                        <a href="/" class="btn btn-secondary" type="button">Annuler</a>
                        <button class="btn btn-primary" type="submit">Valider</button>
                    </div>
                </form>
            </div>
        </div>
        <?php require_once 'includes/footer.php' ?>
    </div>
</body>
</html>
        
                   
                   












