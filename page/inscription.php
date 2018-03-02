<?php

require_once("../inc/traitement/init.inc.php");


if(customerConnected())
{
    header('location:profil.php');
}

/***** DECLARATION DES VARIABLES *****/
$lastname = "";
$firstname = "";
$nickname = "";
$password = "";
$passwordCheck = "";
$email = "";
$phone = "";
$address = "";
$postalCode = "";
$city = "";

$error = false;
$errorEmail = false;
$errorMsg = "";
$registerSuccess = false;
$scriptMsg = '';

/***** TRAITEMENT DU FORMULAIRE *****/
if(isset($_POST['lastname']) && isset($_POST['firstname']) && isset($_POST['nickname']) && isset($_POST['password']) && isset($_POST['passwordCheck']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['address']) && isset($_POST['postalCode']) && isset($_POST['city']))
{
  $lastname = trim($_POST['lastname']);
  $firstname = trim($_POST['firstname']);
  $nickname = trim($_POST['nickname']);
  $password = trim($_POST['password']);
  $passwordCheck = trim($_POST['passwordCheck']);
  $email = trim($_POST['email']);
  $phone = trim($_POST['phone']);
  $address = trim($_POST['address']);
  $postalCode = trim($_POST['postalCode']);
  $city = trim($_POST['city']);

  /***** CONTROLE DU NOM ******/
  if(iconv_strlen($lastname)<3 || iconv_strlen($lastname)>20)
  {
    $scriptMsg .= '<script>$("#lastnameHelp").show(); $("#lastname").addClass("invalid").removeClass("valid");</script>';
    $error = true;
  }

  /***** CONTROLE DU PRENOM ******/
  if(iconv_strlen($firstname)<3 || iconv_strlen($firstname)>20)
  {
    $scriptMsg .= '<script>$("#firstnameHelp").show(); $("#firstname").addClass("invalid").removeClass("valid");</script>';
    $error = true;
  }

  /***** CONTROLE DU PSEUDO ******/
  if($nickname != '')
  {
    if(iconv_strlen($nickname)<3 || iconv_strlen($nickname)>20)
    {
      $scriptMsg .= '<script>$("#nicknameHelp").show(); $("nickname").addClass("invalid").removeClass("valid");</script>';
      $error = true;
    }
  }

  /***** CONTROLE DU MOT DE PASSE ******/
  // Controle du format du mot de passe
  if(!preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])[a-zA-Z0-9]{6,}$#', $password))
  {
    $scriptMsg .= '<script>$("#passwordHelp").show(); $("#password").addClass("invalid").removeClass("valid");</script>';
    $error = true;
  }
  // Controle de la correspondance des mots de passe
  else if($password != $passwordCheck)
  {
    $scriptMsg .= '<script>$("#passwordCheckHelp").show(); $("passwordCheck").addClass("invalid").removeClass("valid");</script>';
    $error = true;
  }
  // hachage du mot de passe 
  else
  {
    $password = password_hash($password, PASSWORD_DEFAULT);
  }

  /***** CONTROLE DU MAIL ******/
  // Controle du format du mail
  if(!filter_var($email, FILTER_VALIDATE_EMAIL))
  {
    $scriptMsg .= '<script>$("#emailHelp").show(); $("email").addClass("invalid").removeClass("valid");</script>';
    $error = true;
  }
  // Controle de l'existence de l'adresse mail dans la BDD
  $checkEmail = $pdo->prepare("SELECT * FROM customer WHERE email = :email");
  $checkEmail->bindValue(":email", $email, PDO::PARAM_STR);
  $checkEmail->execute();
  if($checkEmail->rowCount()>0)
  {
    $errorEmail = true;
  }

  /***** CONTROLE DU TELEPHONE ******/
  if(!preg_match('#^(0|\+33)[1-9]( ?-?\.?[0-9]{2}){4}$#', $phone))
  {
    $scriptMsg .= '<script>$("#phoneHelp").show(); $("#phone").addClass("invalid").removeClass("valid");</script>';
    $error = true;
  }

  /***** CONTROLE DU CODE POSTAL ******/
  if($postalCode != '')
  {
    if(!preg_match('#^[0-9]{5}$#', $postalCode))
    {
      $scriptMsg .= '<script>$("#postalCodeHelp").show(); $("#postalCode").addClass("invalid").removeClass("valid");</script>';
      $error = true;
    }
  }
  
  /***** ENREGISTREMENT DANS LA BDD *****/
  if(!$error && !$errorEmail)
  {
    $register = $pdo->prepare("INSERT INTO customer (lastname, firstname, nickname, email, phone, address, postalCode, city, password) VALUES (:lastname, :firstname, :nickname, :email, :phone, :address, :postalCode, :city, :password)");

    $register->bindValue(":lastname", $lastname, PDO::PARAM_STR);
    $register->bindValue(":firstname", $firstname, PDO::PARAM_STR);
    $register->bindValue(":nickname", $nickname, PDO::PARAM_STR);
    $register->bindValue(":email", $email, PDO::PARAM_STR);
    $register->bindValue(":phone", $phone, PDO::PARAM_STR);
    $register->bindValue(":address", $address, PDO::PARAM_STR);
    $register->bindValue(":postalCode", $postalCode, PDO::PARAM_STR);
    $register->bindValue(":city", $city, PDO::PARAM_STR);
    $register->bindValue(":password", $password, PDO::PARAM_STR);

    $register->execute();

    $registerSuccess = true;

  }
  else if($errorEmail)
  {
    $errorMsg = '<div class="alert alert-danger alert-dismissible fade show text-center" role="alert"><strong>Cet email existe déjà</strong><br>Cliquez sur connexion pour vous connecter<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
  }
  else
  {
    $errorMsg = '<div class="alert alert-danger alert-dismissible fade show text-center" role="alert"><strong>Votre formulaire contient une ou plusieurs erreurs</strong><br>Veuillez vérifier votre saisie<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
  }
}

require_once("../inc/structure/header.inc.php");
require_once("../inc/structure/nav.inc.php");
?>

<div class="container">
  <div class="row">
    <div class="col-md-8 offset-md-2">
      <?= $errorMsg; ?>
      <h1 class="titleGeneric">Inscription</h1>
      <!--***** FORMULAIRE D'INSCRIPTION *****-->
      <form method="post" action="">
        <div class="md-form">
          <i class="fa fa-user prefix grey-text"></i>
          <input type="text" id="lastname" name="lastname" class="form-control" value="<?= $lastname; ?>">
          <label for="lastname">Votre nom *</label>
          <small id="lastnameHelp" class="form-text text-muted inputHelp">Votre nom doit contenir entre 3 et 20 caractères.</small>
        </div>
        <div class="md-form">
          <i class="prefix"></i>
          <input type="text" id="firstname" name="firstname" class="form-control" value="<?= $firstname; ?>">
          <label for="firstname">Votre prénom *</label>
          <small id="firstnameHelp" class="form-text text-muted inputHelp">Votre prénom doit contenir entre 3 et 20 caractères.</small>
        </div>
        <div class="md-form">
          <i class="prefix"></i>
          <input type="text" id="nickname" name="nickname" class="form-control" value="<?= $nickname; ?>">
          <label for="nickname">Votre pseudo</label>
          <small id="nicknameHelp" class="form-text text-muted inputHelp">Votre pseudo doit contenir entre 3 et 20 caractères.</small>
        </div>
        <div class="md-form">
          <i class="fa fa-lock prefix grey-text"></i>
          <input type="password" id="password" name="password" class="form-control" aria-describedby="passwordHelp">
          <label for="password">Votre mot de passe *</label>
          <small id="passwordHelp" class="form-text text-muted inputHelp">Votre mot de passe doit contenir au moins une minuscule, une majuscule et un chiffre.</small>
        </div>
        <div class="md-form">
          <i class="prefix"></i>
          <input type="password" id="passwordCheck" name="passwordCheck" class="form-control">
          <label for="passwordCheck">Vérification de votre mot de passe *</label>
          <small id="passwordCheckHelp" class="form-text text-muted inputHelp">Vos mots de passe ne sont pas identiques</small>
        </div>
        <div class="md-form">
          <i class="fa fa-envelope prefix grey-text"></i>
          <input type="email" id="email" name="email" class="form-control" value="<?= $email; ?>">
          <label for="email">Votre mail *</label>
          <small id="emailHelp" class="form-text text-muted inputHelp">Le format de votre email est incorrect.</small>
        </div>
        <div class="md-form">
          <i class="fa fa-phone prefix grey-text"></i>
          <input type="text" id="phone" name="phone" class="form-control" value="<?= $phone; ?>">
          <label for="phone">Votre téléphone *</label>
          <small id="phoneHelp" class="form-text text-muted inputHelp">Le format de votre numéro de téléphone est incorrect.</small>
        </div>
        <div class="md-form">
          <i class="fa fa-location-arrow prefix grey-text"></i>
          <input type="text" id="address" name="address" class="form-control" value="<?= $address; ?>">
          <label for="address">Votre adresse</label>
        </div>
        <div class="md-form">
          <i class="prefix"></i>
          <input type="number" id="postalCode" name="postalCode" class="form-control" value="<?= $postalCode; ?>">
          <label for="postalCode">Votre code postal</label>
          <small id="postalCodeHelp" class="form-text text-muted inputHelp">Le format de votre code postal est incorrect.</small>
        </div>
        <div class="md-form" id="cityArea">
          <i class="prefix"></i>
          <input type="text" id="city" name="city" class="form-control" value="<?= $city; ?>">
          <label for="city" id="cityLabel">Votre ville</label>
        </div>

        <div class="text-center"><div class="md-form" id="obligatoire">
          <label class="text-center">* Champs obligatoires</label>
        </div>
          <button class="btn btn-cyan" btn-rounded>S'inscrire</button>

        </div>

      </form><!--***** FIN FORMULAIRE D'INSCRIPTION *****-->

    </div><!--***** FIN col-md-6 offset-md-3 *****-->
  </div><!--***** FIN row *****-->
</div><!--***** FIN container ******-->

<!--***** MODAL INSCRIPTION REUSSIE *****-->
<div class="modal fade" id="registerSuccess" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-notify modal-success" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p class="heading lead">Bienvenue <?= $firstname . " " . $lastname; ?></p>
      </div>
      <div class="modal-body">
        <div class="text-center">
          <i class="fa fa-check fa-4x mb-3 animated rotateIn"></i>
          <h1>Votre Compte a bien été crée!</h1>
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-primary-modal" data-toggle="modal" data-target="#modalLogin" data-dismiss="modal">Connexion<i class="fa fa-sign-in ml-1"></i></button>
        <a class="btn btn-outline-secondary-modal waves-effect" href="index.php">Fermer</a>
      </div>
    </div>
  </div>
</div>
<!--***** FIN MODAL INSCRIPTION REUSSIE *****-->

<?php
require_once("../inc/structure/footer.inc.php");

/* AFFICHAGE DE LA MODAL D'ENREGISTREMENT AVEC SUCCES */
if($registerSuccess)
{
  ?>
  <script>$('#registerSuccess').modal('show');</script>
  <?php
}

echo $scriptMsg;
?>

<!--***** TRAITEMENT DU FORMULAIRE *****-->
<script src="../js/form.js"></script>
<script src="../js/postalcode.js"></script>

