<?php
if (isset($_GET['idPro'])) 
{
	$idPro = $_GET['idPro'];
}
else
{
	header('location: index.php');
}

require_once("../inc/traitement/init.inc.php");

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
?>

<h1 class="titleGeneric">Calendrier</h1>

<?php


// requete pour tester avec le professionnel
$info = $pdo->query("SELECT * FROM professional WHERE idPro = $idPro");

// transformation des informations en tableau
$infoPro = $info->fetch(PDO::FETCH_ASSOC);

//requete permettant d'obtenir tous les rendez-vous pris
$schedule = $pdo->query("SELECT * FROM calendar WHERE status = 'taken' AND idPro = $idPro");

//initialisation de la variable permettant de mettre tous les rdv pris dans un tableau
$allschedule = array();
$rdvLibre = array();

//injection des rdv pris dans la variable
while ($takenschedule = $schedule->fetch(PDO::FETCH_ASSOC))
	{
		foreach ($takenschedule as $key => $value)
		{
			if($key == 'schedule')
			{
				$allschedule[] = $value;
			}
		}
	}

// date du jour
	$debut = date('d/m/Y');
	$today = getdate();

// nombre de jour d'affichage du calendrier
	if ($today['wday'] == 1 || $today['wday'] == 2) 
	{
		$jour = 15;
		$jourFin = $jour - 1;
	}
	else
	{
		$jour = 16;
		$jourFin = $jour - 1;
	}
	


// date de fin d'affichage
	$fin = new DateTime(date('Y-m-d'));
	$fin = date_modify($fin, "+$jourFin days");
	$fin = $fin->format('d/m/Y');

	echo "<div class='container'>";


	echo "<div class='calendarFull'>";
//Affichage du titre 'semaine du ... au ...'
	echo "<div class='calendarWeekDetail'>Semaine du ".$debut." au ".$fin."</div>";

	echo "<div class='calendarWeek'>";

//initialisation d'une boucle pour un affichage de g jour
	for ($g=0; $g < $jour; $g++)
	{
		// echo "<div class="calendarDay">";
		//echo "<div class='calendarDayDetail'>";
		switch (($today['wday']+$g) % 7 )
		{
			case 1:
			echo '<div class="calendarDay"><div class="calendarDayDetail">Lundi</div>';
			break;
			case 2:
			echo '<div class="calendarDay"><div class="calendarDayDetail">Mardi</div>';
			break;
			case 3:
			echo '<div class="calendarDay"><div class="calendarDayDetail">Mercredi</div>';
			break;
			case 4:
			echo '<div class="calendarDay"><div class="calendarDayDetail">Jeudi</div>';
			break;
			case 5:
			echo '<div class="calendarDay"><div class="calendarDayDetail">Vendredi</div>';
			break;
			case 6:
			echo '<div class="calendarDay"><div class="calendarDayDetail">Samedi</div>';
			break;
			case 0:
			echo '<div class="calendarDay" style="display:none"><div class="calendarDayDetail">Dimanche</div>';
			break;
		}
		//echo "</div>";

		$openingAM = new DateTime($infoPro['openingAM']);
		$closingAM = $infoPro['closingAM'];
		$closingPM = new DateTime($infoPro['closingPM']);


		if(empty($closingAM))
		{
			for ($i=$openingAM; $i < $closingPM; $i = date_modify($i, '+1 hour'))
			{
				$hour = $i->format('H:i:s');
				if($today['month'] < 10)
				{
					$date = $today['year']."-0".$today['mon']."-".($today['mday'])." ".$hour;
					$date = new DateTime($date);
					$date = date_modify($date, "+$g days");
				}
				else
				{
					$date = $today['year']."-0".$today['mon']."-".($today['mday'])." ".$hour;
					$date = new DateTime($date, 'Y-m-d H:i:s');
					$date = date_modify($date, "+$g days");
				}

				$daterdv = $date->format('Y-m-d H:i:s');

				if (in_array($daterdv, $allschedule))
				{
					echo "<div class='occupe'>".date_format($i, 'H:i')."</div>";
				}

				else
				{
					echo "<div class='libre' style='background-color: ".$infoPro['avalaible'].";'><a href='?action=ajouter&date=".date_format($date, 'Y-m-d')."&heure=".date_format($date, 'H:i:s')."&idPro=".$infoPro['idPro']."'>".date_format($i, 'H:i')."</a></div>";
					$rdvLibre[] = $date;
				}
			}
			echo "</div>";
		}

		else
		{
						//horaires mise au format heure
			$closingAM = new DateTime($infoPro['closingAM']);
			$openingPM = new DateTime($infoPro['openingPM']);

						//gestion des horaires du matin
			for ($i=$openingAM; $i < $closingAM; $i = date_modify($i, '+1 hour'))
			{
				$hour = $i->format('H:i:s');
				if($today['month'] < 10)
				{
					$date = $today['year']."-0".$today['mon']."-".($today['mday'])." ".$hour;
					$date = new DateTime($date);
					$date = date_modify($date, "+$g days");
				}
				else
				{
					$date = $today['year']."-0".$today['mon']."-".($today['mday'])." ".$hour;
					$date = new DateTime($date, 'Y-m-d H:i:s');
					$date = date_modify($date, "+$g days");
				}

				$daterdv = $date->format('Y-m-d H:i:s');

				if (in_array($daterdv, $allschedule))
				{

					echo "<div class='occupe'>".date_format($i, 'H:i')."</div>";

				}
				else
				{
					echo "<div class='libre' style='".$infoPro['avalaible']."'><a href='?action=ajouter&date=".date_format($date, 'Y-m-d')."&heure=".date_format($date, 'H:i:s')."&idPro=".$infoPro['idPro']."'>".date_format($i, 'H:i')."</a></div>";
					$rdvLibre[] = $date;
				}

			}
							//gestion des horaires de l'après midi
			for ($i=$openingPM; $i < $closingPM; $i = date_modify($i, '+1 hour'))
			{
				$hour = $i->format('H:i:s');
				if($today['month'] < 10)
				{
					$date = $today['year']."-0".$today['mon']."-".($today['mday'])." ".$hour;
					$date = new DateTime($date);
					$date = date_modify($date, "+$g days");
				}
				else
				{
					$date = $today['year']."-0".$today['mon']."-".($today['mday'])." ".$hour;
					$date = new DateTime($date, 'Y-m-d H:i:s');
					$date = date_modify($date, "+$g days");
				}

				$daterdv = $date->format('Y-m-d H:i:s');

				if (in_array($daterdv, $allschedule))
				{

					echo "<div class='occupe'>".date_format($i, 'H:i')."</div>";

				}
				else
				{
					echo "<div class='libre' style='".$infoPro['avalaible']."'><a href='?action=ajouter&date=".date_format($date, 'Y-m-d')."&heure=".date_format($date, 'H:i:s')."&idPro=".$infoPro['idPro']."'>".date_format($i, 'H:i')."</a></div>";
					$rdvLibre[] = $date;
				}

			}
			echo "</div>";
		}
	}
	echo "</div>";
	echo "</div>";
	echo "</div>";
  echo "<div class='alacon'></div>";

require_once("../inc/components/dateModal.php");

 require_once("../inc/structure/footer.inc.php");
 ?>
