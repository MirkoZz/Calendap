<?php
require_once("../inc/traitement/init.inc.php");

if(!customerConnected())
{
    header('location:index.php');
}

if(professionalConnected())
{
    header('location:profilpro.php');
}

/***** DECLARATION DES VARIABLES *****/
$id = $_SESSION['customer']['id'];
$lastname = $_SESSION['customer']['lastname'];
$firstname = $_SESSION['customer']['firstname'];
$nickname = $_SESSION['customer']['nickname'];
$email = $_SESSION['customer']['email'];
$phone = $_SESSION['customer']['phone'];
$address = $_SESSION['customer']['address'];
$postalCode = $_SESSION['customer']['postalCode'];
$city = $_SESSION['customer']['city'];
$picture = $_SESSION['customer']['picture'];

$error = false;
$errorEmail = false;
$errorMsg = '';
$scriptMsg = '';

/***** TRAITEMENT DES MODIFICATIONS DU PROFIL *****/
if(isset($_POST['lastname']) && isset($_POST['firstname']) && isset($_POST['nickname']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['address']) && isset($_POST['postalCode']) && isset($_POST['city']))
{
  $lastname = trim($_POST['lastname']);
  $firstname = trim($_POST['firstname']);
  $nickname = trim($_POST['nickname']);
  $email = trim($_POST['email']);
  $phone = trim($_POST['phone']);
  $address = trim($_POST['address']);
  $postalCode = trim($_POST['postalCode']);
  $city = trim($_POST['city']);

  /***** CONTROLE DU NOM ******/   
  if(iconv_strlen($lastname)<3 || iconv_strlen($lastname)>20)
  {
    $scriptMsg .= '<script>$("#lastnameHelp").show(); $("#lastnameModif").removeClass("btn-info").addClass("btn-danger");</script>';
    $error = true;   
  }

  /***** CONTROLE DU PRENOM ******/    
  if(iconv_strlen($firstname)<3 || iconv_strlen($firstname)>20)
  {
    $scriptMsg .= '<script>$("#firstnameHelp").show(); $("#firstnameModif").removeClass("btn-info").addClass("btn-danger");</script>';
    $error = true;   
  }

  /***** CONTROLE DU PSEUDO ******/
  if((iconv_strlen($nickname)<3 || iconv_strlen($nickname)>20) && $nickname != '')
  {
    $scriptMsg .= '<script>$("#nicknameHelp").show(); $("#nicknameModif").removeClass("btn-info").addClass("btn-danger");</script>';
    $error = true;   
  }

  /***** CONTROLE DU MAIL ******/
  // Controle du format du mail
  if(!filter_var($email, FILTER_VALIDATE_EMAIL))
  {
    $scriptMsg .= '<script>$("#emailnameHelp").show(); $("#emailnameModif").removeClass("btn-info").addClass("btn-danger");</script>';
    $error = true;
  }
  // Controle de l'existence de l'adresse mail dans la BDD
  if($_SESSION['customer']['email'] != $email)
  {
    $checkEmail = $pdo->prepare("SELECT * FROM customer WHERE email = :email");
    $checkEmail->bindValue(":email", $email, PDO::PARAM_STR);
    $checkEmail->execute();
    if($checkEmail->rowCount()>0)
    {
      $scriptMsg .= '<script>$("#emailModif").removeClass("btn-info").addClass("btn-danger");</script>';
      $errorEmail = true;
    }
  }

  /***** CONTROLE DU TELEPHONE ******/
  if(!preg_match('#^(0|\+33)[1-9]( ?-?\.?[0-9]{2}){4}$#', $phone))
  {
    $scriptMsg .= '<script>$("#phoneHelp").show(); $("#phoneModif").removeClass("btn-info").addClass("btn-danger");</script>';
    $error = true;
  }

  /***** CONTROLE DU CODE POSTAL ******/
  if(!preg_match('#^[0-9]{5}$#', $postalCode))
  {
    $scriptMsg .= '<script>$("#postalCodeHelp").show(); $("#postalCodeModif").removeClass("btn-info").addClass("btn-danger");</script>';
    $error = true;  
  }
  
  /***** CONTROLE DE LA PHOTO *****/
  if(!empty($_FILES['picture']['name']) && !$error)
  {
    // Controle de l'extension
    if(fileCheck())
    {
      $pictureName = $email . $_FILES['picture']['name'];
      $picturePath = "img/photo/customer/" . $pictureName;
      $pictureFolder = $_SERVER['DOCUMENT_ROOT'] . '/projet-final/' . $picturePath;
      copy($_FILES['picture']['tmp_name'], $pictureFolder);
      echo'<pre>';var_dump($_SERVER['DOCUMENT_ROOT']);echo '</pre>';
    }
    else
    {
      $picturePath = $_SESSION['customer']['picture'];
      $msg .= '<div class="erreur alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><span class="span_msg">Attention, la photo n\'a pas été enregistré</span><br>Extensions autorisées: jpg / jpeg / png / gif /svg</div>';
      $erreur = true;
    }
  }
  else
  {
    $picturePath = $_SESSION['customer']['picture'];
  }

  /***** ENREGISTREMENT DES MODIFICATIONS DANS LA BDD *****/
  if(!$error && !$errorEmail)
  {
    $modif = $pdo->prepare("UPDATE customer SET lastname = :lastname, firstname = :firstname, nickname = :nickname, email = :email, phone = :phone, address = :address, postalCode = :postalCode, city = :city, picture = '$picturePath' WHERE idCustomer = :idCustomer");

    $modif->bindValue(":lastname", $lastname, PDO::PARAM_STR);
    $modif->bindValue(":firstname", $firstname, PDO::PARAM_STR);
    $modif->bindValue(":nickname", $nickname, PDO::PARAM_STR);
    $modif->bindValue(":email", $email, PDO::PARAM_STR);
    $modif->bindValue(":phone", $phone, PDO::PARAM_STR);
    $modif->bindValue(":address", $address, PDO::PARAM_STR);
    $modif->bindValue(":postalCode", $postalCode, PDO::PARAM_STR);
    $modif->bindValue(":city", $city, PDO::PARAM_STR);
    $modif->bindValue(":idCustomer", $id, PDO::PARAM_STR);

    $modif->execute();
    
    $_SESSION['customer']['lastname'] = $lastname;
    $_SESSION['customer']['firstname'] = $firstname;
    $_SESSION['customer']['nickname'] = $nickname;
    $_SESSION['customer']['email'] = $email;
    $_SESSION['customer']['phone'] = $phone;
    $_SESSION['customer']['address'] = $address;
    $_SESSION['customer']['postalCode'] = $postalCode;
    $_SESSION['customer']['city'] = $city;
    $_SESSION['customer']['picture'] = $picturePath;
    
    $errorMsg = '<div class="alert alert-success alert-dismissible fade show text-center" role="alert"><strong>Vos informations ont bien été mis à jour.</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
  }
  else if($errorEmail)
  {
    $errorMsg = '<div class="alert alert-danger alert-dismissible fade show text-center" role="alert"><strong>Cet email existe déjà</strong><br>Veuillez vérifier votre saisi<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
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

  <?= $errorMsg; ?>
  <h1 class="titleGeneric">Profil</h1>
    
  <div class="row">
    <div class="col-sm-12">
    <form method="post" enctype="multipart/form-data">
      <div class="row">
      <div class="col-sm-7">
        <div class="list-group">
          <span class="list-group-item disabled">
            <span class="label_profil">Bonjour</span> 
            <h3><?php echo $_SESSION['customer']['firstname'] . ' ' . $_SESSION['customer']['lastname']; ?></h3>
          </span>
          <span class="list-group-item">
            <div class="content">
              <div>
                <span class="label_profil">Nom:</span> <b id="lastnameValue"><?php echo ucfirst($lastname); ?></b> <input type ="text" id="lastnameProfil" name="lastname" value="<?php echo ucfirst($lastname); ?>">
              </div>
              <div>
                <button type="button" id="lastnameModif" class="btn btn-info btn-sm"><i class="fa fa-pencil-square" aria-hidden="true"></i></button>
              </div>
            </div>
            <div>
              <small id="lastnameHelp" class="inputHelp">Votre nom doit contenir entre 3 et 20 caractères</small>
            </div>
          </span>
          <span class="list-group-item">
            <div class="content">
              <div>
                <span class="label_profil">Prénom:</span> <b id="firstnameValue"><?php echo ucfirst($firstname); ?></b> <input type ="text" id="firstnameProfil" name="firstname" value="<?php echo ucfirst($firstname); ?>">
              </div>
              <div>
                <button type="button" id="firstnameModif" class="btn btn-info btn-sm"><i class="fa fa-pencil-square" aria-hidden="true"></i></button>
              </div>
            </div>
            <div>
              <small id="firstnameHelp" class="inputHelp">Votre prénom doit contenir entre 3 et 20 caractères</small>
            </div>
          </span>
          <span class="list-group-item">
            <div class="content">
              <div>
                <span class="label_profil">Pseudo:</span> <b id="nicknameValue"><?php echo ucfirst($nickname); ?></b> <input type ="text" id="nicknameProfil" name="nickname" value="<?php echo ucfirst($nickname); ?>">
              </div>
              <div>
                <button type="button" id="nicknameModif" class="btn btn-info btn-sm"><i class="fa fa-pencil-square" aria-hidden="true"></i></button>
              </div>
            </div>
            <div>
              <small id="nicknameHelp" class="inputHelp">Votre pseudo doit contenir entre 3 et 20 caractères. (Pseudo non obligatoire)</small>
            </div>
          </span>
          <span class="list-group-item">
            <div class="content">
              <div>
                <span class="label_profil">Email:</span> <b id="emailValue"><?php echo $email; ?></b> <input type ="text" id="emailProfil" name="email" value="<?php echo $email; ?>">
              </div>
              <div>
                <button type="button" id="emailModif" class="btn btn-info btn-sm"><i class="fa fa-pencil-square" aria-hidden="true"></i></button>
              </div>
            </div>
            <div>
              <small id="emailHelp" class="inputHelp">Le format de votre email est incorrect</small>
            </div>
          </span>
          <span class="list-group-item">
            <div class="content">
              <div>
                <span class="label_profil">Téléphone:</span> <b id="phoneValue"><?php echo $phone; ?></b> <input type ="text" id="phoneProfil" name="phone" value="<?php echo $phone; ?>">
              </div>
              <div>
                <button type="button" id="phoneModif" class="btn btn-info btn-sm"><i class="fa fa-pencil-square" aria-hidden="true"></i></button>
              </div>
            </div>
            <div>
              <small id="phoneHelp" class="inputHelp">Le format de votre numéro de téléphone est incorrect</small>
            </div>
          </span>
          <span class="list-group-item">
            <div class="content">
              <div>
                <span class="label_profil">Adresse:</span> <b id="addressValue"><?php echo $address; ?></b> <input type ="text" id="addressProfil" name="address" value="<?php echo $address; ?>">
              </div>
              <div>
                <button type="button" id="addressModif" class="btn btn-info btn-sm"><i class="fa fa-pencil-square" aria-hidden="true"></i></button>
              </div>
            </div>
            <div>
              <small id="addressHelp" class="inputHelp">Votre adresse doit contenir entre 3 et 20 caractères. (Adresse non obligatoire)</small>
            </div>
          </span>
          <span class="list-group-item">
            <div class="content">
              <div>
                <span class="label_profil">Code postal:</span> <b id="postalCodeValue"><?php echo $postalCode; ?></b> <input type ="text" id="postalCodeProfil" name="postalCode" value="<?php echo $postalCode; ?>">
              </div>
              <div>
                <button type="button" id="postalCodeModif" class="btn btn-info btn-sm"><i class="fa fa-pencil-square" aria-hidden="true"></i></button>
              </div>
            </div>
            <div>
              <small id="postalCodeHelp" class="inputHelp">Le format de votre code postal est incorrect. (Code postal non obligatoire)</small>
            </div>
          </span>
          <span class="list-group-item">
            <div class="content">
              <div>
                <span class="label_profil">Ville:</span> <b id="cityValue"><?php echo ucfirst($city); ?></b> <input type ="text" id="cityProfil" name="city" value="<?php echo ucfirst($city); ?>">
              </div>
              <div>
                <button type="button" id="cityModif" class="btn btn-info btn-sm"><i class="fa fa-pencil-square" aria-hidden="true"></i></button>
              </div>
            </div>
            <div>
              <small id="cityHelp" class="inputHelp">Le nom de votre ville doit contenir entre 3 et 20 caractères. (Ville non obligatoire)</small>
            </div>
          </span>
          
        </div><!-- list-group -->
        <button type="submit" class="btn btn-info">Valider</button>
      </div><!-- col-sm-8 -->
      
      <div class="col-sm-1"></div>
        
    
      <div class="col-sm-4" id="picture">
        <img id="photo_profil" src="
        <?php
          if($picture == '')
          {
            echo URL . '/img/photo/photo_profil.png';
          }
          else
          {
            echo URL . $picture;
          }
        ?>
        " alt="photo de profil" class="img-thumbnail">
        <div>
          <input type="file" class="" name="picture" id="picture">
        </div>
      </div><!-- col-sm-3 -->
      </div>
      
    </form>
    </div>
  </div><!-- row --> 
</div><!-- container -->

<?php
require_once("../inc/structure/footer.inc.php");

echo $scriptMsg;
?>

<!--***** TRAITEMENT DU PROFIL *****-->
<script src="../js/profil.js"></script>