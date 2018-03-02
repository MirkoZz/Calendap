
<?php

function calendrier($idPro)
{
	$pdo = new PDO(
    'mysql:host=db725185457.db.1and1.com;dbname=db725185457;port=3306',
    'dbo725185457',
    'Fred@11210032',
    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')
    );



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
		$jour = 5;
		$jourFin = $jour - 1;
	}
	else
	{
		$jour = 6;
		$jourFin = $jour - 1;
	}
	


// date de fin d'affichage
	$fin = new DateTime(date('Y-m-d'));
	$fin = date_modify($fin, "+$jourFin days");
	$fin = $fin->format('d/m/Y');


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
}



function rdvLibre($idPro, $n)
{
	$pdo = new PDO(
    'mysql:host=db725185457.db.1and1.com;dbname=db725185457;port=3306',
    'dbo725185457',
    'Fred@11210032',
    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')
    );



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
		$jour = 8;
		$jourFin = $jour - 1;
	}
	else
	{
		$jour = 6;
		$jourFin = $jour - 1;
	}
	


// date de fin d'affichage
	$fin = new DateTime(date('Y-m-d'));
	$fin = date_modify($fin, "+$jourFin days");
	$fin = $fin->format('d/m/Y');


//initialisation d'une boucle pour un affichage de g jour
	for ($g=0; $g < $jour; $g++)
	{

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

				if (!in_array($daterdv, $allschedule))
				{
					$rdvLibre[] = $date;
				}
			}
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

				if (!in_array($daterdv, $allschedule))
				{

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

				if (!in_array($daterdv, $allschedule))
				{

					$rdvLibre[] = $date;

				}

			}
		}
	}
	echo "Dispo le ".$rdvLibre[$n]->format('d/m')." à ".$rdvLibre[$n]->format('H:i');
}

function formatRdvLibre($idPro, $n, $f)
{
	$pdo = new PDO(
    'mysql:host=db725185457.db.1and1.com;dbname=db725185457;port=3306',
    'dbo725185457',
    'Fred@11210032',
    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')
    );



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
		$jour = 8;
		$jourFin = $jour - 1;
	}
	else
	{
		$jour = 6;
		$jourFin = $jour - 1;
	}
	


// date de fin d'affichage
	$fin = new DateTime(date('Y-m-d'));
	$fin = date_modify($fin, "+$jourFin days");
	$fin = $fin->format('d/m/Y');


//initialisation d'une boucle pour un affichage de g jour
	for ($g=0; $g < $jour; $g++)
	{

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

				if (!in_array($daterdv, $allschedule))
				{
					$rdvLibre[] = $date;
				}
			}
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

				if (!in_array($daterdv, $allschedule))
				{

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

				if (!in_array($daterdv, $allschedule))
				{

					$rdvLibre[] = $date;

				}

			}
		}
	}
	return $rdvLibre[$n]->format($f);
}