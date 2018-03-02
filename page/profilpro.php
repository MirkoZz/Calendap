<?php
require_once("../inc/traitement/init.inc.php");

if(!professionalConnected())
{
    header('location:index.php');
}

/***** DECLARATION DES VARIABLES *****/
$idCustomer = $_SESSION['customer']['id'];
$idPro = $_SESSION['professional']['id'];
$lastname = $_SESSION['professional']['lastname'];
$firstname = $_SESSION['professional']['firstname'];
$email = $_SESSION['professional']['email'];
$phone = $_SESSION['professional']['phone'];
$activity = $_SESSION['professional']['activity'];
$society = $_SESSION['professional']['society'];
$siret = $_SESSION['professional']['siret'];
$address = $_SESSION['professional']['address'];
$postalCode = $_SESSION['professional']['postalCode'];
$city = $_SESSION['professional']['city'];
$picture = $_SESSION['professional']['picture'];
$openingAM = $_SESSION['professional']['openingAM'];
$closingAM = $_SESSION['professional']['closingAM'];
$openingPM = $_SESSION['professional']['openingPM'];
$closingPM = $_SESSION['professional']['closingPM'];
 
$error = false;
$errorEmail = false;
$msg = '';
$errorMsg = '';
$scriptMsg = '';

/***** TRAITEMENT DES MODIFICATIONS DU PROFIL *****/
if(isset($_POST['lastname']) && isset($_POST['firstname']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['society']) && isset($_POST['activity']) && isset($_POST['siret']) && isset($_POST['address']) && isset($_POST['postalCode']) && isset($_POST['city']) && isset($_POST['openingAM']) && isset($_POST['closingAM']) && isset($_POST['openingPM']) && isset($_POST['closingPM']))
{
  $lastname = trim($_POST['lastname']);
  $firstname = trim($_POST['firstname']);
  $email = trim($_POST['email']);
  $phone = trim($_POST['phone']);
  $society = trim($_POST['society']);
  $activity = trim($_POST['activity']);
  $siret = trim($_POST['siret']);
  $address = trim($_POST['address']);
  $postalCode = trim($_POST['postalCode']);
  $city = trim($_POST['city']);
  $openingAM = trim($_POST['openingAM']);
  $closingAM = trim($_POST['closingAM']);
  $openingPM = trim($_POST['openingPM']);
  $closingPM = trim($_POST['closingPM']);

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

  /***** CONTROLE DU MAIL ******/
  // Controle du format du mail
  if(!filter_var($email, FILTER_VALIDATE_EMAIL))
  {
    $scriptMsg .= '<script>$("#emailHelp").show(); $("#emailModif").removeClass("btn-info").addClass("btn-danger");</script>';
    $error = true;
  }
  // Controle de l'existence de l'adresse mail dans la BDD
  if($_SESSION['professional']['email'] != $email)
  {
    $checkEmail = $pdo->prepare("SELECT * FROM professional WHERE email = :email");
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
  
  /***** CONTROLE DE L'ACTIVITE ******/
  if($activity != 'coiffeur' && $activity != 'masseur')
  {
    $scriptMsg .= '<script>$("#activityModif").removeClass("btn-info").addClass("btn-danger");</script>';
    $error = true;  
  }
  
  /***** CONTROLE DU SIRET ******/
  if(!preg_match('#^[0-9]{14}$#', $siret))
  {
    $scriptMsg .= '<script>$("#siretHelp").show(); $("#siretModif").removeClass("btn-info").addClass("btn-danger");</script>';
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
      $picturePath = "img/photo/professional/" . $pictureName;
      $pictureFolder = $_SERVER['DOCUMENT_ROOT'] . '/calendapp/' . $picturePath;
      copy($_FILES['picture']['tmp_name'], $pictureFolder);
    }
    else
    {
      $picturePath = $_SESSION['professional']['picture'];
      $msg .= '<div class="erreur alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><span class="span_msg">Attention, la photo n\'a pas été enregistré</span><br>Extensions autorisées: jpg / jpeg / png / gif /svg</div>';
      $erreur = true;
    }
  }
  else
  {
    $picturePath = $_SESSION['professional']['picture'];
  }

  /***** ENREGISTREMENT DES MODIFICATIONS DANS LA BDD *****/
  if(!$error && !$errorEmail)
  {
    /* modification des informations du compte professionnel */
    $modifPro = $pdo->prepare("UPDATE professional SET lastname = :lastname, firstname = :firstname, email = :email, phone = :phone, activity = :activity, society = :society, siret = :siret, address = :address, postalCode = :postalCode, city = :city, picture = '$picturePath', openingAM = :openingAM, closingAM = :closingAM, openingPM = :openingPM, closingPM = :closingPM WHERE idPro = :idPro");
    
    $modifPro->bindValue(":lastname", $lastname, PDO::PARAM_STR);
    $modifPro->bindValue(":firstname", $firstname, PDO::PARAM_STR);
    $modifPro->bindValue(":email", $email, PDO::PARAM_STR);
    $modifPro->bindValue(":phone", $phone, PDO::PARAM_STR);
    $modifPro->bindValue(":activity", $activity, PDO::PARAM_STR);
    $modifPro->bindValue(":society", $society, PDO::PARAM_STR);
    $modifPro->bindValue(":siret", $siret, PDO::PARAM_STR);
    $modifPro->bindValue(":address", $address, PDO::PARAM_STR);
    $modifPro->bindValue(":postalCode", $postalCode, PDO::PARAM_STR);
    $modifPro->bindValue(":city", $city, PDO::PARAM_STR);
    $modifPro->bindValue(":openingAM", $openingAM, PDO::PARAM_STR);
    
    if($closingAM != NULL)
    {
      $modifPro->bindValue(":closingAM", $closingAM, PDO::PARAM_STR);
    }
    else if($closingAM == NULL)
    {
      $modifPro->bindValue(":closingAM", NULL, PDO::PARAM_STR);
    }
    
    if($openingPM != NULL)
    {
      $modifPro->bindValue(":openingPM", $openingPM, PDO::PARAM_STR);
    }
    else if($openingPM == NULL)
    {
      $modifPro->bindValue(":openingPM", NULL, PDO::PARAM_STR);
    }
    
    $modifPro->bindValue(":closingPM", $closingPM, PDO::PARAM_STR);
    $modifPro->bindValue(":idPro", $idPro, PDO::PARAM_STR);

    $modifPro->execute();
    
    /* modification des informations du compte client */
    $modifCustomer = $pdo->prepare("UPDATE customer SET lastname = :lastname, firstname = :firstname, email = :email, phone = :phone, address = :address, postalCode = :postalCode, city = :city, picture = '$picturePath' WHERE idCustomer = :idCustomer");

    $modifCustomer->bindValue(":lastname", $lastname, PDO::PARAM_STR);
    $modifCustomer->bindValue(":firstname", $firstname, PDO::PARAM_STR);
    $modifCustomer->bindValue(":email", $email, PDO::PARAM_STR);
    $modifCustomer->bindValue(":phone", $phone, PDO::PARAM_STR);
    $modifCustomer->bindValue(":address", $address, PDO::PARAM_STR);
    $modifCustomer->bindValue(":postalCode", $postalCode, PDO::PARAM_STR);
    $modifCustomer->bindValue(":city", $city, PDO::PARAM_STR);
    $modifCustomer->bindValue(":idCustomer", $idCustomer, PDO::PARAM_STR);

    $modifCustomer->execute();
    
    $_SESSION['professional']['lastname'] = $lastname;
    $_SESSION['professional']['firstname'] = $firstname;
    $_SESSION['professional']['email'] = $email;
    $_SESSION['professional']['phone'] = $phone;
    $_SESSION['professional']['activity'] = $activity;
    $_SESSION['professional']['society'] = $society;
    $_SESSION['professional']['siret'] = $siret;
    $_SESSION['professional']['address'] = $address;
    $_SESSION['professional']['postalCode'] = $postalCode;
    $_SESSION['professional']['city'] = $city;
    $_SESSION['professional']['picture'] = $picturePath;
    $_SESSION['professional']['openingAM'] = $openingAM;
    $_SESSION['professional']['closingAM'] = $closingAM;
    $_SESSION['professional']['openingPM'] = $openingPM;
    $_SESSION['professional']['closingPM'] = $closingPM;
    
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
      <div class="col-sm-8">
        <div class="list-group">
          <span class="list-group-item disabled">
            <span class="label_profil">Bonjour</span> 
            <h3><?php echo $_SESSION['professional']['firstname'] . ' ' . $_SESSION['professional']['lastname']; ?></h3>
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
              <div id="select">
                <span class="label_profil">Activité:</span> <b id="activityValue"><?php echo ucfirst($activity); ?></b> 
                <select  id="activityProfil" name="activity" class="form-control form-control-sm">
                  <option value="coiffeur" <?php if($activity == 'coiffeur'){echo 'selected';} ?>>Coiffeur</option>
                  <option value="masseur" <?php if($activity == 'masseur'){echo 'selected';} ?>>Masseur</option>
                </select>
              </div>
              <div>
                <button type="button" id="activityModif" class="btn btn-info btn-sm"><i class="fa fa-pencil-square" aria-hidden="true"></i></button>
              </div>
            </div>
          </span>
          <span class="list-group-item">
            <div class="content">
              <div>
                <span class="label_profil">Société:</span> <b id="societyValue"><?php echo ucfirst($society); ?></b> <input type ="text" id="societyProfil" name="society" value="<?php echo ucfirst($society); ?>">
              </div>
              <div>
                <button type="button" id="societyModif" class="btn btn-info btn-sm"><i class="fa fa-pencil-square" aria-hidden="true"></i></button>
              </div>
            </div>
            <div>
              <small id="societyHelp" class="inputHelp">Votre nom de société doit contenir entre 3 et 20 caractères</small>
            </div>
          </span>
          <span class="list-group-item">
            <div class="content">
              <div>
                <span class="label_profil">SIRET:</span> <b id="siretValue"><?php echo $siret; ?></b> <input type ="text" id="siretProfil" name="siret" value="<?php echo $siret; ?>">
              </div>
              <div>
                <button type="button" id="siretModif" class="btn btn-info btn-sm"><i class="fa fa-pencil-square" aria-hidden="true"></i></button>
              </div>
            </div>
            <div>
              <small id="siretHelp" class="inputHelp">Le format de votre SIRET est incorrect</small>
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
              <small id="addressHelp" class="inputHelp">Votre adresse doit contenir entre 3 et 20 caractères.</small>
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
              <small id="postalCodeHelp" class="inputHelp">Le format de votre code postal est incorrect.</small>
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
              <small id="cityHelp" class="inputHelp">Le nom de votre ville doit contenir entre 3 et 20 caractères.</small>
            </div>
          </span>
          <span class="list-group-item">
            <div class="content">
            <div>
              <span class="label_profil">Heure d'ouverture (Matin):</span> <b id="openingAMValue"><?php echo $openingAM; ?></b> <input type="time" id="openingAMProfil" name="openingAM" value="<?php echo $openingAM; ?>">
            </div>
            <div>
              <button type="button" id="openingAMModif" class="btn btn-info btn-sm"><i class="fa fa-pencil-square" aria-hidden="true"></i></button>
            </div>
              </div>
          </span>
          <span class="list-group-item">
            <div class="content">
            <div>
              <span class="label_profil">Heure de fermeture (Matin):</span> <b id="closingAMValue"><?php echo $closingAM; ?></b> <input type="time" id="closingAMProfil" name="closingAM" value="<?php echo $closingAM; ?>">
            </div>
            <div>
              <button type="button" id="closingAMModif" class="btn btn-info btn-sm"><i class="fa fa-pencil-square" aria-hidden="true"></i></button>
            </div>
              </div>
          </span>
          <span class="list-group-item">
            <div class="content">
            <div>
              <span class="label_profil">Heure d'ouverture (Après-midi):</span> <b id="openingPMValue"><?php echo $openingPM; ?></b> <input type="time" id="openingPMProfil" name="openingPM" value="<?php echo $openingPM; ?>">
            </div>
            <div>
              <button type="button" id="openingPMModif" class="btn btn-info btn-sm"><i class="fa fa-pencil-square" aria-hidden="true"></i></button>
            </div>
              </div>
          </span>
          <span class="list-group-item">
            <div class="content">
            <div>
              <span class="label_profil">Heure de fermeture (Après-midi):</span> <b id="closingPMValue"><?php echo $closingPM; ?></b> <input type="time" id="closingPMProfil" name="closingPM" value="<?php echo $closingPM; ?>">
            </div>
            <div>
              <button type="button" id="closingPMModif" class="btn btn-info btn-sm"><i class="fa fa-pencil-square" aria-hidden="true"></i></button>
            </div>
              </div>
          </span>
          
          
        </div><!-- list-group -->
        <button type="submit" class="btn btn-info">Valider</button>
      </div><!-- col-sm-8 -->
      
      <div class="col-sm-1"></div>
        
    
      <div class="col-sm-3" id="picture">
        <img id="photo_profil" src="
        <?php
          if($_SESSION['professional']['picture'] == '')
          {
            echo URL . '/img/photo/photo_profil.png';
          }
          else
          {
            echo URL . $_SESSION['professional']['picture'];
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
<script src="../js/profilpro.js"></script>

