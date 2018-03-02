<?php

include("../inc/components/calendrierCustomer.php");


$city="";
$activity="";
echo '<div class="container">';
echo '<div class="row">';

if (isset($_POST['activity']) && isset($_POST['city']))
{
	$city = trim($_POST['city']);
	$activity = trim($_POST['activity']);
	$request = $pdo->prepare("SELECT * FROM professional WHERE city = :city AND activity = :activity ORDER BY idPro DESC");
	$request->bindValue(":city", $city, PDO::PARAM_STR);
	$request->bindValue(":activity", $activity, PDO::PARAM_STR);

	$request->execute();


	while ($ligne = $request->fetch(PDO::FETCH_ASSOC))
	{ ?>

<div class="cardBig">
  <div class="front" id="front<?php echo $ligne['idPro'];?>">
		<div class="col-12 col-md-5">
      <div class="imgCardBig"><img class="left" src="<?php if($ligne['picture'] != ''){echo URL.$ligne['picture'];}else{echo 'https://randomuser.me/api/portraits/men/' . rand(0, 99) . '.jpg';}?>"/></div>
       <h1 class="nameCardBig" style="<?php if (!$ligne['title'] == "") {
		echo "color: ".$ligne['title'].";";} ?>">
         <?php
            if (empty($ligne['society']))
            {
                echo $ligne['lastname']. " " . $ligne['firstname'];
         	}
            else
            {

                echo $ligne['society'];
            }
            ?>
       </h1>
		<h1><?php echo $ligne['activity']." ".$ligne['city']; ?></h1>
      <div class="rating rating2">
          <a href="#5" title="Give 5 stars">★</a>
          <a href="#4" title="Give 4 stars">★</a>
          <a href="#3" title="Give 3 stars">★</a>
          <a href="#2" title="Give 2 stars">★</a>
          <!-- <a href="#1" title="Give 1 stars">★</a> -->

      </div>
      <h2 class="linkInCard" id="fab<?php echo $ligne['idPro']; ?>" style="<?php if (!$ligne['link'] == "") { echo "color: ".$ligne['link'].";" ;} ?>"><i class="fa fa-calendar fa-2x"></i> Voir le calendrier</h2>

    </div>
    <div class="col-12 col-md-7">

			<h1 class="titleGeneric descriptionCard">DESCRIPTION</h1>

			<p class="descriptionP"><?php if($ligne['description'] !=''){echo $ligne['description'];}else{echo 'Magnesium is one of the sixat is required by the body for energy production and synthesis of protein and enzymes. It contributes to the development of bones and most importantly it is responsible for synthesis of your DNA and RNA. A new report that';} ?></p>

      <div class="separator"></div>

          <div class="freeSchedules">
          	
			<div class="col-12 col-md-6">
				<?php for ($i=0; $i < 2; $i++) 
          		{ ?>
            	<div class="freeSchedule<?php echo $i+1; ?>">
	            	<p><?php rdvlibre($ligne['idPro'], $i); ?></p>
	            	<?php 
	            	$dateRdvAnnee = formatRdvLibre($ligne['idPro'], $i, 'Y-m-d');
	            	$dateRdvHeure = formatRdvLibre($ligne['idPro'], $i, 'H:i:s');
	            	 ?>
	            	<a href='<?php echo '?action=ajouter&date='.$dateRdvAnnee.'&heure='.$dateRdvHeure.'&idPro='.$ligne["idPro"] ?>'><button class="<?php if($ligne['button'] == ""){echo "hvr-";}else{echo $ligne['button'];}?>"
	            		style="
	            		<?php
	            		if(!$ligne['buttonColor'] == "") 
	            		{
	            			echo "background-color: ".$ligne['buttonColor'].";";
	            		}
	            		?>">
	            			Réserver
	            		</button>
	            	</a>
	            </div>
	        
	            <?php } ?>
	        </div>
	            
			<div class="col-12 col-md-6">
	            <?php for ($i=2; $i < 4; $i++) 
          		{ ?>
            	<div class="freeSchedule2">
	            	<p><?php rdvlibre($ligne['idPro'], $i); ?></p>
	            	<a href='<?php echo '?action=ajouter&date='.$dateRdvAnnee.'&heure='.$dateRdvHeure.'&idPro='.$ligne["idPro"] ?>'><button class="<?php if($ligne['button'] == ""){echo "hvr-";} else{echo $ligne['button'];} ?>"
	            		style="
	            		<?php
	            		if(!$ligne['buttonColor'] == "") 
	            		{
	            			echo "background-color: ".$ligne['buttonColor'].";";
	            		}
	            		?>">Réserver</button></a>
	            </div>
	        
	            <?php } ?>
			</div>
    </div>
  </div>
</div>
</div>
<div class="back" id="back<?php echo $ligne['idPro'];?>">

<?php

calendrier($ligne['idPro']);
 ?>

  <div class="backCardButtons">

  <h1><i class="fa fa-calendar fa-2x"></i><a style='color: black; text-decoration: none;' onmouseover="this.style.color='white';" onmouseout="this.style.color='black';" href="calendrierProCustomer.php?idPro=<?php echo $ligne['idPro'];?>"> Voir les autres semaines</a></h1>
  <h1 id="fab2<?php echo $ligne['idPro']; ?>"><i class="fa fa-credit-card fa-2x"></i> Retourner sur la carte</h1>
  </div>
</div>

	<script type="text/javascript">
	$(function(){

		$('#fab<?php echo $ligne['idPro']; ?>').click(function(){
			// $('.cardBig').toggleClass('flipped');
			//* Anim de la carte */

			$('#front<?php echo $ligne['idPro']; ?>').hide("explode", 500);
			$('#back<?php echo $ligne['idPro']; ?>').hide().delay(500).show("scale", 300);

		});
		//* Affichage du calendrier */

		$('#fab2<?php echo $ligne['idPro']; ?>').click(function(){
		 // $('.cardBig').toggleClass('flipped');
		 $('#back<?php echo $ligne['idPro']; ?>').hide("scale", 500);
		 $('#front<?php echo $ligne['idPro']; ?>').show("scale", 500);

	 });
 });
	</script>


	<?php }
//Fin contener et row


}

echo '</div>';
echo '</div>';

?>
