<?php
require_once("../inc/traitement/init.inc.php");

// si l'utilisateur demande une déconnexion
if(isset($_GET['task']) && $_GET['task'] == 'disconnection')
{
  session_destroy();
  header('location:index.php');
}

$modal ="";

/***** AJOUT D'UN NOUVEAU RDV DANS LA BDD *****/
if(isset($_GET['action']) && $_GET['action'] == 'ajouter')
{
  $_SESSION['rdv']['action'] = $_GET['action'];
  $_SESSION['rdv']['date'] = $_GET['date'];
  $_SESSION['rdv']['heure'] = $_GET['heure'];
  $_SESSION['rdv']['idPro'] = $_GET['idPro'];
  if(customerConnected())
  {
    $idPro = $_GET['idPro'];
    $idCustomer = $_SESSION['customer']['id'];
    $date = $_GET['date'];
    $hour = $_GET['heure'];
    $modalHour = substr($hour, 0, 2) . 'h' . substr($hour, 3, 2);
    $modalDate = date('d/m/Y', strtotime($date));
    $schedule = $date . " " . $hour;
    
    /***** ENREGISTREMENT DU RDV EN BDD *****/
    $dateRegister = $pdo->prepare("INSERT INTO calendar (idPro, idCustomer, status, schedule) VALUES (:idPro, :idCustomer, 'taken', :date)");
    
    $dateRegister->bindValue(':idPro', $idPro, PDO::PARAM_INT);
    $dateRegister->bindValue(':idCustomer', $idCustomer, PDO::PARAM_INT);
    $dateRegister->bindValue(':date', $schedule, PDO::PARAM_STR);
    
    $dateRegister->execute();
    
    /***** RECUPERATION DES INFOS DU PRO POUR LA MODALE DE CONFIRMATION *****/
    $proInfosSearch = $pdo->prepare("SELECT * FROM professional WHERE idPro = :idPro");
    
    $proInfosSearch->bindValue(':idPro', $idPro, PDO::PARAM_INT);
    
    $proInfosSearch->execute();
    
    $proInfos = $proInfosSearch->fetch(PDO::FETCH_ASSOC);
    
    /***** AFFICHAGE DE LA MODALE DE CONFIRMATION DU RDV *****/
    $modal = "<script>
          $(function(){
            $('#dateRegister').modal('show');
          });
          </script>";
    
    unset($_SESSION['rdv']);
  }
  else
  {
    /***** AFFICHAGE DE LA MODALE DE CONNEXION *****/
    $modal = "<script>
          $(function(){
            $('#modalLogin').modal('show');
          });
          </script>";
  }
}



require_once("../inc/structure/header.inc.php");
require_once("../inc/structure/nav.inc.php");
require_once("../inc/components/headerHome.php");

// require_once("../inc/components/cardProBig.php");
require_once("../inc/components/test.php");

require_once("../inc/components/cardProSmall.php");
require_once("../inc/components/dateModal.php");

require_once("../inc/structure/footer.inc.php");
?>
