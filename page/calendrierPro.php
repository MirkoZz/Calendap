<?php
require_once("../inc/traitement/init.inc.php");


require_once("../inc/structure/header.inc.php");
require_once("../inc/structure/nav.inc.php");

$idPro = $_SESSION['professional']['id'];

// requete pour tester avec le professionnel
$info = $pdo->query("SELECT * FROM professional WHERE idPro = $idPro");


// transformation des informations en tableau
$infoPro = $info->fetch(PDO::FETCH_ASSOC);

//requete permettant d'obtenir tous les rendez-vous pris
$schedule = $pdo->query("SELECT * FROM calendar WHERE status = 'taken' AND idPro = $idPro");

//initialisation de la variable permettant de mettre tous les rdv pris dans un tableau
$allschedule = array();

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

//test de recuperation des données
// echo "<pre>"; var_dump($allschedule); echo "</pre>";
echo '<div class="container">';

?>
<div id="formCalendrierPro">
	<h1 class="titleGeneric">Nombre de jours à afficher</h1>

	<form method="post">
		<input id="inputCalendrierPro" type="number" name="days">
		<button id="buttonCalendrierPro" type="submit" class="btn btn-mdb ">Valider</button>
	</form>

</div>
<?php

if(isset($_GET['action']) && $_GET['action'] == 'ajouter')
{
	$pdo->query("INSERT INTO calendar (idPro, idCustomer, status, schedule) VALUES ($idPro, 0, 'taken', '".$_GET['date']." ".$_GET['heure']."')");
	// echo "<pre>"; var_dump ($test); echo "</pre>";
	header('Location: calendrierPro.php');

}

// nombre de jour d'affichage du calendrier
if (isset($_POST['days']))
{
	$_SESSION['professional']['days'] = $_POST['days'];
}

	$jour = $_SESSION['professional']['days'];

	$jourFin = $jour - 1;

// date du jour
	$debut = date('d/m/Y');
	$today = getdate();

// date de fin d'affichage
	$fin = new DateTime(date('Y-m-d'));
	$fin = date_modify($fin, "+$jourFin days");
	$fin = $fin->format('d/m/Y');


//Affichage du titre 'semaine du ... au ...'
	echo "<div class='dateCalendrierPro'><h1>Du ".$debut." au ".$fin."</h1></div>";
	echo '<div class="contenerCalendrierpro">';

//initialisation d'une boucle pour un affichage de g jour
	for ($g=0; $g < $jour; $g++)
	{
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

		$openingAM = new DateTime($infoPro['openingAM']);
		$closingAM = $infoPro['closingAM'];
		$closingPM = new DateTime($infoPro['closingPM']);


		if($closingAM == NULL)
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
					$details = $pdo->query("SELECT * FROM calendar, customer WHERE schedule = '$daterdv' AND calendar.idCustomer = customer.idCustomer AND idPro = $idPro");
					$detailsrdv = $details->fetch(PDO::FETCH_ASSOC);

					echo "<div class='occupe'>
							<p>"
								.date_format($i, 'H:i').
							"</p>
							<p>
								<a data-toggle='modal' data-target='#myModal".$date->format('Y-m-d-H-i-s')."'>Détails</a>
								<div class='modal fade' id='myModal".$date->format('Y-m-d-H-i-s')."' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
								     <div class='modal-dialog modal-notify modal-success' role='document'>
								      <div class='modal-content'>
								        <div class='modal-header'>
								          <h4 class='heading lead'>Rendez-vous du ".date_format($date, 'd/m/Y')." à ".date_format($date, 'H')."h".date_format($date, 'i')."</h4>
								        </div>
								        <div class='modal-body'>
								          <p>";
								          if($detailsrdv['idCustomer'] == 0)
								          {
								          	echo "Vous avez bloqué ce rendez-vous vous même.";
								          }
								          else
								          {
								          	echo " Vous avez rendez-vous avec ".$detailsrdv['firstname']." ".$detailsrdv['lastname'].".</p>
								          <p>Vous pouvez joindre cette personne au ".$detailsrdv['phone']."";
								          }
								          echo "</p>
								        </div>
								        <div class='modal-footer'>
								          <button class='btn btn-outline-secondary-modal waves-effect' data-dismiss='modal'>Fermer</button>
								        </div>
								      </div>

								    </div>
								  </div>
							</p>
						</div>";
				}

				else
				{
					echo "<div class='libre'><p>".date_format($i, 'H:i')."</p><p><a href='?action=ajouter&date=".date_format($date, 'Y-m-d')."&heure=".date_format($date, 'H:i:s')."'>Bloquer</a></p></div>";
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
					$date = date_modify($date, "+$g  days");
				}

				$daterdv = $date->format('Y-m-d H:i:s');

				if (in_array($daterdv, $allschedule))
				{
					$details = $pdo->query("SELECT * FROM calendar, customer WHERE schedule = '$daterdv' AND calendar.idCustomer = customer.idCustomer AND idPro = $idPro");
					$detailsrdv = $details->fetch(PDO::FETCH_ASSOC);

					echo "<div class='occupe'>
							<p>"
								.date_format($i, 'H:i').
							"</p>
							<p>
								<a data-toggle='modal' data-target='#myModal".$date->format('Y-m-d-H-i-s')."'>Détails</a>
								<div class='modal fade' id='myModal".$date->format('Y-m-d-H-i-s')."' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
								     <div class='modal-dialog modal-notify modal-success' role='document'>
								      <div class='modal-content'>
								        <div class='modal-header'>
								          <h4 class='heading lead'>Rendez-vous du ".date_format($date, 'd/m/Y')." à ".date_format($date, 'H')."h".date_format($date, 'i')."</h4>
								        </div>
								        <div class='modal-body'>
								          <p>";
								          if($detailsrdv['idCustomer'] == 0)
								          {
								          	echo "Vous avez bloqué ce rendez-vous vous même.";
								          }
								          else
								          {
								          	echo " Vous avez rendez-vous avec ".$detailsrdv['firstname']." ".$detailsrdv['lastname'].".</p>
								          <p>Vous pouvez joindre cette personne au ".$detailsrdv['phone']."";
								          }
								          echo "</p>
								        </div>
								        <div class='modal-footer'>
								          <button class='btn btn-outline-secondary-modal waves-effect' data-dismiss='modal'>Fermer</button>
								        </div>
								      </div>

								    </div>
								  </div>
							</p>
						</div>";

				}
				else
				{
					echo "<div class='libre'><p>".date_format($i, 'H:i')."</p><p><a href='?action=ajouter&date=".date_format($date, 'Y-m-d')."&heure=".date_format($date, 'H:i:s')."'>Bloquer</a></p></div>";
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

					$details = $pdo->query("SELECT * FROM calendar, customer WHERE schedule = '$daterdv' AND calendar.idCustomer = customer.idCustomer AND idPro = $idPro");
					$detailsrdv = $details->fetch(PDO::FETCH_ASSOC);

					echo "<div class='occupe'>
							<p>"
								.date_format($i, 'H:i').
							"</p>
							<p>
								<a data-toggle='modal' data-target='#myModal".$date->format('Y-m-d-H-i-s')."'>Détails</a>
								<div class='modal fade' id='myModal".$date->format('Y-m-d-H-i-s')."' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
								     <div class='modal-dialog modal-notify modal-success' role='document'>
								      <div class='modal-content'>
								        <div class='modal-header'>
								          <h4 class='heading lead'>Rendez-vous du ".date_format($date, 'd/m/Y')." à ".date_format($date, 'H')."h".date_format($date, 'i')."</h4>
								        </div>
								        <div class='modal-body'>
								          <p>";
								          if($detailsrdv['idCustomer'] == 0)
								          {
								          	echo "Vous avez bloqué ce rendez-vous vous même.";
								          }
								          else
								          {
								          	echo " Vous avez rendez-vous avec ".$detailsrdv['firstname']." ".$detailsrdv['lastname'].".</p>
								          <p>Vous pouvez joindre cette personne au ".$detailsrdv['phone']."";
								          }
								          echo "</p>
								        </div>
								        <div class='modal-footer'>
								          <button class='btn btn-outline-secondary-modal waves-effect' data-dismiss='modal'>Fermer</button>
								        </div>
								      </div>

								    </div>
								  </div>
							</p>
						</div>";

				}
				else
				{
					echo "<div class='libre'><p>".date_format($i, 'H:i')."</p><p><a href='?action=ajouter&date=".date_format($date, 'Y-m-d')."&heure=".date_format($date, 'H:i:s')."'>Bloquer</a></p></div>";
				}

			}
			echo "</div>";
		}

	}
	echo '</div>';

echo "</div>";
?>



<?php require_once("../inc/structure/footer.inc.php");
 ?>
