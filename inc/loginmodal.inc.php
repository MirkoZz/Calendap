<?php

/***** DECLARATION DES VARIABLES *****/
$loginEmail = '';
$loginPassword = '';

$logInSuccess = false;
$msg = '';


/***** CONTROLE DES INFORMATIONS DE CONNEXION *****/
if(isset($_POST['loginEmail']) && isset($_POST['loginPassword']))
{  
  $loginEmail = trim($_POST['loginEmail']);
  $loginPassword = trim($_POST['loginPassword']);

  $customer = $pdo->prepare("SELECT * FROM customer WHERE email = :email");

  $customer->bindValue(":email", $loginEmail, PDO::PARAM_STR);

  $customer->execute();

  $professional = $pdo->prepare("SELECT * FROM professional WHERE email = :email");

  $professional->bindValue(":email", $loginEmail, PDO::PARAM_STR);

  $professional->execute();

  /***** CONNEXION COMPTE PROFESSIONNEL *****/
  if($professional->rowCount() > 0 && $customer->rowCount() > 0)
  {
    $professional_infos = $professional->fetch(PDO::FETCH_ASSOC);
    $customer_infos = $customer->fetch(PDO::FETCH_ASSOC);

    if(password_verify($loginPassword, $professional_infos['password']))
    {
      $_SESSION['professional'] = array();
      $_SESSION['professional']['id'] = $professional_infos['idPro'];
      $_SESSION['professional']['lastname'] = $professional_infos['lastname'];
      $_SESSION['professional']['firstname'] = $professional_infos['firstname'];
      $_SESSION['professional']['email'] = $professional_infos['email'];
      $_SESSION['professional']['phone'] = $professional_infos['phone'];
      $_SESSION['professional']['activity'] = $professional_infos['activity'];
      $_SESSION['professional']['society'] = $professional_infos['society'];
      $_SESSION['professional']['siret'] = $professional_infos['siret'];
      $_SESSION['professional']['address'] = $professional_infos['address'];
      $_SESSION['professional']['postalCode'] = $professional_infos['postalCode'];
      $_SESSION['professional']['city'] = $professional_infos['city'];
      $_SESSION['professional']['picture'] = $professional_infos['picture'];
      $_SESSION['professional']['openingAM'] = substr($professional_infos['openingAM'], 0, 5);
      $_SESSION['professional']['closingAM'] = substr($professional_infos['closingAM'], 0, 5);
      $_SESSION['professional']['openingPM'] = substr($professional_infos['openingPM'], 0, 5);
      $_SESSION['professional']['closingPM'] = substr($professional_infos['closingPM'], 0, 5);
      $_SESSION['professional']['button'] = $professional_infos['button'];
      $_SESSION['professional']['buttonColor'] = $professional_infos['buttonColor'];
      $_SESSION['professional']['title'] = $professional_infos['title'];
      $_SESSION['professional']['avalaible'] = $professional_infos['avalaible'];
      $_SESSION['professional']['link'] = $professional_infos['link'];
      $_SESSION['professional']['description'] = $professional_infos['description'];
      $_SESSION['professional']['days'] = 5;
      $_SESSION['customer']['id'] = $customer_infos['idCustomer'];
      $_SESSION['customer']['lastname'] = $customer_infos['lastname'];
      $_SESSION['customer']['firstname'] = $customer_infos['firstname'];
      $_SESSION['customer']['nickname'] = $customer_infos['nickname'];
      $_SESSION['customer']['email'] = $customer_infos['email'];
      $_SESSION['customer']['phone'] = $customer_infos['phone'];
      $_SESSION['customer']['address'] = $customer_infos['address'];
      $_SESSION['customer']['postalCode'] = $customer_infos['postalCode'];
      $_SESSION['customer']['city'] = $customer_infos['city'];
      $_SESSION['customer']['picture'] = $customer_infos['picture'];
      
      /***** AFFICHAGE DE LA MODALE DE CONNEXION REUSSIE *****/
      $modal = "<script>
          $(function(){
            $('#logInSuccess').modal('show');
          });
          </script>";
    }
    else
    {
      /***** AFFICHAGE DE LA MODALE DE CONNEXION AVEC ERREUR*****/
      $modal = "<script>
          $(function(){
            $('#modalLogin').modal('show');
          });
          </script>";
      $msg = '<div class="erreur alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><span class="span_msg">Email ou mot de passe incorrect</span><br>Veuillez vérifier votre saisie</div>';
    }
  }
  /***** CONNEXION COMPTE CLIENT *****/
  else if($customer->rowCount() > 0)
  {
    $customer_infos = $customer->fetch(PDO::FETCH_ASSOC);
    
    if(password_verify($loginPassword, $customer_infos['password']))
    {
      $_SESSION['customer'] = array();
      $_SESSION['customer']['id'] = $customer_infos['idCustomer'];
      $_SESSION['customer']['lastname'] = $customer_infos['lastname'];
      $_SESSION['customer']['firstname'] = $customer_infos['firstname'];
      $_SESSION['customer']['nickname'] = $customer_infos['nickname'];
      $_SESSION['customer']['email'] = $customer_infos['email'];
      $_SESSION['customer']['phone'] = $customer_infos['phone'];
      $_SESSION['customer']['address'] = $customer_infos['address'];
      $_SESSION['customer']['postalCode'] = $customer_infos['postalCode'];
      $_SESSION['customer']['city'] = $customer_infos['city'];
      $_SESSION['customer']['picture'] = $customer_infos['picture'];
      
      /***** AFFICHAGE DE LA MODALE DE CONNEXION REUSSIE *****/
      $modal = "<script>
          $(function(){
            $('#logInSuccess').modal('show');
          });
          </script>";
    }
    else
    {
      /***** AFFICHAGE DE LA MODALE DE CONNEXION AVEC ERREUR*****/
      $modal = "<script>
          $(function(){
            $('#modalLogin').modal('show');
          });
          </script>";
      $msg = '<div class="erreur alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><span class="span_msg">mot de passe incorrect</span><br>Veuillez vérifier votre saisie</div>';
    }
  }
  else
  {
    /***** AFFICHAGE DE LA MODALE DE CONNEXION AVEC ERREUR*****/
    $modal = "<script>
          $(function(){
            $('#modalLogin').modal('show');
          });
          </script>";
    $msg = '<div class="erreur alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><span class="span_msg">Pseudo ou mot de passe incorrect</span><br>Veuillez vérifier votre saisie</div>';
  }
}
?>

<!-- MODAL DE CONNEXION -->
<div class="modal fade" id="modalLogin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog cascading-modal" role="document">
    <div class="modal-content">
      <div class="modal-header light-blue darken-3 white-text">
        <h4 class="title"><i class="fa fa-user"></i> Connexion</h4>
        <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <form method="post" action="">
        <div class="modal-body">
          <?= $msg; ?>
          <div class="md-form form-sm">
            <i class="fa fa-envelope prefix"></i>
            <input type="text" id="loginEmail" name="loginEmail" class="form-control">
            <label for="loginEmail">Votre email</label>
          </div>
          <div class="md-form form-sm">
            <i class="fa fa-lock prefix active"></i>
            <input type="password" id="loginPassword" name="loginPassword" class="form-control">
            <label for="loginPassword">Votre mot de passe</label>
          </div>
          <div class="text-center mt-2" id="logInModalButtons">
            <button type="submit" class="btn btn-info">Connexion <i class="fa fa-sign-in ml-1"></i></button>
            <div class="g-signin2" data-onsuccess="onSignIn" data-theme="dark"></div>
          </div>
        </div>
        <div class="modal-footer">
          <div class="options text-center text-md-right mt-1">
            <p>Pas encore membre? <a href="<?php echo URL; ?>page/inscription.php">S'inscrire</a></p>
            <p>Vos êtes un professionnel? <a href="<?php echo URL; ?>page/inscriptionPros.php">S'inscrire</a></p>
          </div>
          <button type="button" class="btn btn-outline-info waves-effect ml-auto" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- FIN MODAL DE CONNEXION -->

<!-- MODAL INSCRIPTION REUSSIE -->
<div class="modal fade" id="logInSuccess" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-notify modal-success" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p class="heading lead">Bonjour <?= $_SESSION['customer']['firstname'] . " " . $_SESSION['customer']['lastname']; ?></p>
      </div>
      <div class="modal-body">
        <div class="text-center">
          <i class="fa fa-check fa-4x mb-3 animated rotateIn"></i>
          <h1>Vous êtes connecté!</h1>
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <form method="POST" action="">
          <input type="hidden" name="a">
          <button type="submit" class="btn btn-outline-secondary-modal waves-effect">Fermer</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- FIN MODAL INSCRIPTION REUSSIE -->
