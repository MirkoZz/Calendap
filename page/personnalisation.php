<?php
require_once("../inc/traitement/init.inc.php");

/***** DECLARATIONS DES VARIABLES *****/
$error = false;
$errorMsg ='';

$id = $_SESSION['professional']['id'];
$title = $_SESSION['professional']['title'];
$button = $_SESSION['professional']['button'];
$buttonColor = $_SESSION['professional']['buttonColor'];
$link = $_SESSION['professional']['link'];
$avalaible = $_SESSION['professional']['avalaible'];
$description = $_SESSION['professional']['description'];

/***** TRAITEMENT DESCHOIX DE PERSONNALISATION *****/
if(isset($_POST['title']) && isset($_POST['button']) && isset($_POST['buttonColor']) && isset($_POST['link']) && isset($_POST['avalaible']) && isset($_POST['description']))
{
  $button = $_POST['button'];
  $buttonColor = $_POST['buttonColor'];
  $title = $_POST['title'];
  $link = $_POST['link'];
  $avalaible = $_POST['avalaible'];
  $description = trim($_POST['description']);

  /***** CONTROLE DES BOUTONS RADIO *****/
  /*if($button != 'snip1562' && $button != 'button2' && $button != 'button3')
  {
    $error = true;
  }*/

  /***** CONTROLE DES CHOIX DE COULEURS *****/
  if(!preg_match('^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$^', $avalaible)
  || !preg_match('^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$^', $link)
  || !preg_match('^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$^', $title)
  || !preg_match('^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$^', $buttonColor))
  {
    $error = true;
  }

  /***** CONTROLE DE LA DESCRIPTION *****/
  if(iconv_strlen($description) > 300 )
  {
    $error = true;
  }

  /***** ENREGISTREMENT DES CHOIX EN BDD *****/
  if(!$error)
  {
    $setting = $pdo->prepare("UPDATE professional SET button = :button, title = :title, buttonColor = :buttonColor, link = :link, avalaible = :avalaible, description =:description WHERE idPro = :idPro");

    $setting->bindValue(":button", $button, PDO::PARAM_STR);
    $setting->bindValue(":title", $title, PDO::PARAM_STR);
    $setting->bindValue(":buttonColor", $buttonColor, PDO::PARAM_STR);
    $setting->bindValue(":link", $link, PDO::PARAM_STR);
    $setting->bindValue(":avalaible", $avalaible, PDO::PARAM_STR);
    $setting->bindValue(":description", $description, PDO::PARAM_STR);
    $setting->bindValue(":idPro", $id, PDO::PARAM_STR);

    $setting->execute();

    $_SESSION['professional']['button'] = $button;
    $_SESSION['professional']['title'] = $title;
    $_SESSION['professional']['buttonColor'] = $buttonColor;
    $_SESSION['professional']['link'] = $link;
    $_SESSION['professional']['avalaible'] = $avalaible;
    $_SESSION['professional']['description'] = $description;

    $errorMsg = '<div class="alert alert-success alert-dismissible fade show text-center" role="alert"><strong>Vos modifications ont bien prises en compte.</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
  }
  else
  {
    $errorMsg = '<div class="alert alert-danger alert-dismissible fade show text-center" role="alert"><strong>Désolé, la page contient une erreur</strong><br>Votre description ne peut contenir que 300 caractères.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
  }
}


require_once("../inc/structure/header.inc.php");
require_once("../inc/structure/nav.inc.php");

?>
<div class="container-fluid">
  <?= $errorMsg; ?>
  <?= $error; ?>
  <h1 class="titleGeneric">PERSONNALISATION</h1>
  
  <form method="post" action="">
    
    <!--***** CHOIX DES COULEURS *****-->
    <div class="sideBarPersoRow">
      <div class="sideBarPersoColor1">
        <h3>Couleur des titres</h3>
        <div>
          <label for="title">Couleur utilisée pour votre nom et votre activité</label>
          <input id="title" type="color" class="sideBarPersoColors" name="title" <?php if($title != ''){echo 'value="' . $title . '"';}?> >
        </div>
      </div>

      <div class="sideBarPersoColor2">
        <h3>Couleur des boutons</h3>
        <div>
          <label for="buttonColor">Couleur des 4 boutons de réservation</label>
          <input id="buttonColor" type="color" class="sideBarPersoColors" name="buttonColor" <?php if($buttonColor != ''){echo 'value="' . $buttonColor . '"';} ?> >
        </div>
      </div>

      <div class="sideBarPersoColor3">
        <h3>Couleurs des liens de la carte</h3>
        <div>
          <label for="link">Couleur des liens de la carte et du calendrier</label>
          <input id="link" type="color" class="sideBarPersoColors" name="link" <?php if($link != ''){echo 'value="' . $link . '"';} ?> >
        </div>
      </div>

      <div class="sideBarPersoColor4">
      <h3>Couleurs des crénaux libres</h3>
        <div>
          <label for="avalaible">Couleur des crénaux libres sur le calendrier</label>
          <input id="avalaible" type="color" class="sideBarPersoColors" name="avalaible" <?php if($avalaible != ''){echo 'value="' . $avalaible . '"';}else{echo 'value="#ffffff"';}  ?> >
        </div>
      </div>
    </div> <!-- FIN sideBarPersoRow -->
    
    <div class="row">
      <div class="col-md-4">
    
        <div class="sideBarPerso">

          <!--***** TEXTE DE DESCRIPTION *****-->
          <div class="sideBarPersoDesc">
            <h3>DESCRIPTION</h3>
            <div class="md-form" id="description">
              <textarea name="description" class="md-textarea" length="300"><?= $description ?></textarea>
            </div>
          </div>

          <!--***** CHOIX DES BOUTTONS *****-->
          <div class="sideBarPersoButtons">
            <h3 id="buttonchoice">ANIMATION DES BOUTONS</h3>
            <div>
              
              <div class="btnAsidePerso">
                <div class="md-form">
                  <input id="borderFade" name="button" type="radio" value="hvr-border-fade" <?php if($button == 'hvr-border-fade' || $button == ''){echo 'checked="checked"';} ?>>
                  <label for="borderFade"><button type="button" class="hvr-border-fade">border fade</button></label>
                </div>
                <div class="md-form">
                  <input id="wobVert" name="button" type="radio" value="hvr-wobble-vertical" <?php if($button == 'hvr-wobble-vertical'){echo 'checked="checked"';} ?>>
                  <label for="wobVert"><button type="button" class="hvr-wobble-vertical">wobble</button></label>
                </div>
              </div>

              <div class="btnAsidePerso">
                <div class="md-form">
                  <input id="hvrBounceIn" name="button" type="radio" value="hvr-bounce-in" <?php if($button == 'hvr-bounce-in'){echo 'checked="checked"';} ?>>
                  <label for="hvrBounceIn"><button type="button" class="hvr-bounce-in">bouce in</button></label>
                </div>
                <div class="md-form">
                  <input id="inputFade" name="button" type="radio" value="hvr-fade" <?php if($button == 'hvr-fade'){echo 'checked="checked"';} ?>>
                  <label for="inputFade"><button type="button" class="hvr-fade">fade</button></label>
                </div>
              </div>
              
              <div class="btnAsidePerso">
                <div class="md-form">
                  <input id="recIn" name="button" type="radio" value="hvr-rectangle-in" <?php if($button == 'hvr-rectangle-in'){echo 'checked="checked"';} ?> >
                  <label for="recIn"><button type="button" class="hvr-rectangle-in">regtangle in</button></label>
                </div>
                <div class="md-form">
                  <input id="recOut" name="button" type="radio" value="hvr-rectangle-out" <?php if($button == 'hvr-rectangle-out'){echo 'checked="checked"';} ?> >
                  <label for="recOut"><button type="button" class="hvr-rectangle-out">regtangle out</button></label>
                </div>
              </div>
              
              <div class="btnAsidePerso">
                <div class="md-form">
                  <input id="inputRadIn" name="button" type="radio" value="hvr-radial-in" <?php if($button == 'hvr-radial-in'){echo 'checked="checked"';} ?> >
                  <label for="inputRadIn"><button type="button" class="hvr-radial-in">radial in</button></label>
                </div>
                <div class="md-form">
                  <input id="inputRadOut" name="button" type="radio" value="hvr-radial-out" <?php if($button == 'hvr-radial-out'){echo 'checked="checked"';} ?> >
                  <label for="inputRadOut"><button type="button" class="hvr-radial-out">radial out</button></label>
                </div>
              </div>
              
              <div class="btnAsidePerso">
                <div class="md-form">
                  <input id="sweepRight" name="button" type="radio" value="hvr-sweep-to-right" <?php if($button == 'hvr-sweep-to-right'){echo 'checked="checked"';} ?> >
                  <label for="sweepRight"><button type="button" class="hvr-sweep-to-right">sweep right</button></label>
                </div>
                <div class="md-form">
                  <input id="sweepLeft" name="button" type="radio" value="hvr-sweep-to-left" <?php if($button == 'hvr-sweep-to-left'){echo 'checked="checked"';} ?> >
                  <label for="sweepLeft"><button type="button" class="hvr-sweep-to-left">sweep left</button></label>
                </div>
              </div>
              
              <div class="btnAsidePerso">
                <div class="md-form">
                  <input id="sweepBottom" name="button" type="radio" value="hvr-sweep-to-bottom" <?php if($button == 'hvr-sweep-to-bottom'){echo 'checked="checked"';} ?> >
                  <label for="sweepBottom"><button type="button" class="hvr-sweep-to-bottom">sweep bottom</button></label>
                </div>
                <div class="md-form">
                  <input id="sweepTop" name="button" type="radio" value="hvr-sweep-to-top" <?php if($button == 'hvr-sweep-to-top'){echo 'checked="checked"';} ?> >
                  <label for="sweepTop"><button type="button" class="hvr-sweep-to-top">sweep top</button></label>
                </div>
              </div>
              
              <div class="btnAsidePerso">
                <div class="md-form">
                  <input id="shInHor" name="button" type="radio" value="hvr-shutter-in-horizontal" <?php if($button == 'hvr-shutter-in-horizontal'){echo 'checked="checked"';} ?> >
                  <label for="shInHor"><button type="button" class="hvr-shutter-in-horizontal">shutter in Y</button></label>
                </div>
                <div class="md-form">
                  <input id="shOutHor" name="button" type="radio" value="hvr-shutter-out-horizontal" <?php if($button == 'hvr-shutter-out-horizontal'){echo 'checked="checked"';} ?> >
                  <label for="shOutHor"><button type="button" class="hvr-shutter-out-horizontal">shutter out Y</button></label>
                </div>
              </div>
              
              <div class="btnAsidePerso">
                <div class="md-form">
                  <input id="shInVer" name="button" type="radio" value="hvr-shutter-in-vertical" <?php if($button == 'hvr-shutter-in-vertical'){echo 'checked="checked"';} ?> >
                  <label for="shInVer"><button type="button" class="hvr-shutter-in-vertical">shutter out X</button></label>
                </div>
                <div class="md-form">
                  <input id="shOutVer" name="button" type="radio" value="hvr-shutter-out-vertical" <?php if($button == 'hvr-shutter-out-vertical'){echo 'checked="checked"';} ?> >
                  <label for="shOutVer"><button type="button" class="hvr-shutter-out-vertical">shutter out X</button></label>
                </div>
              </div>
              
            </div>
          </div><!-- FIN sideBarPersoButtons -->

          <!--<button id="btnDsPersoVoirModif" type="submit" class="btn btn-block btn-warning">Voir les modifications</button>-->

        </div><!-- FIN sideBarPerso -->
      </div><!-- FIN col-md-4 -->
    
      <div class="col-md-8">
        
        <button id="btnDsPersoVoirModif" type="submit" class="btn btn-block btn-warning">Valider les modifications</button>        

        <div class="containerCardBigPerso">
        <?php

        include("../inc/components/calendrierCustomer.php");

        $request = $pdo->query("SELECT * FROM professional WHERE idPro = $id");
        echo '<div class="container">';
        echo '<div class="row">';


        	while ($ligne = $request->fetch(PDO::FETCH_ASSOC))
        	{ ?>

          <div class="cardBig">
            <div class="front" id="front<?php echo $ligne['idPro'];?>">
                  <div class="col-12 col-md-5">
                <div class="imgCardBig"><img class="left" src="<?php if($ligne['picture'] != ''){echo URL.$ligne['picture'];}else{echo URL.'img/photo/photo_profil.png';}?>"/></div>
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

                      <p class="descriptionInCard"><?php if($description !=''){echo $description;}else{echo 'Magnesium is one of the sixat is required by the body for energy production and synthesis of protein and enzymes. It contributes to the development of bones and most importantly it is responsible for synthesis of your DNA and RNA. A new report that';} ?></p>

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

          <h1 class="linkInCard"><i class="fa fa-calendar fa-2x "></i> Voir les autres semaines</h1>
          <h1 class="linkInCard" id="fab2<?php echo $ligne['idPro']; ?>"><i class="fa fa-credit-card fa-2x"></i> Retourner sur la carte</h1>
          </div>
        </div>

      </div>
      </div>
      
      
        </form>
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
        echo '</div>';
        echo '</div>';

        require_once("../inc/structure/footer.inc.php");
?>

<script>
$(document).ready(function()
{
  /***** APERCU DES BOUTONS SUR LA CARTE *****/
  $('#borderFade').click(function()
  {
      $('.freeSchedules button').removeClass().addClass('hvr-border-fade');
  });

  $('#wobVert').click(function()
  {
      $('.freeSchedules button').removeClass().addClass('hvr-wobble-vertical');
  });

  $('#hvrBounceIn').click(function()
  {
      $('.freeSchedules button').removeClass().addClass('hvr-bounce-in');
  });

  $('#inputFade').click(function()
  {
      $('.freeSchedules button').removeClass().addClass('hvr-fade');
  });

  $('#recIn').click(function()
  {
      $('.freeSchedules button').removeClass().addClass('hvr-rectangle-in');
  });

  $('#recOut').click(function()
  {
      $('.freeSchedules button').removeClass().addClass('hvr-rectangle-out');
  });

  $('#inputRadIn').click(function()
  {
      $('.freeSchedules button').removeClass().addClass('hvr-radial-in');
  });

  $('#inputRadOut').click(function()
  {
      $('.freeSchedules button').removeClass().addClass('hvr-radial-out');
  });

  $('#isweepRight').click(function()
  {
      var buttonColor = $('#buttonColor').val();

      $('.freeSchedules button').removeClass().addClass('hvr-sweep-to-right');
      $('.hvr-sweep-to-left:before').css('background', buttonColor);
  });

  $('#sweepLeft').click(function()
  {
      $('.freeSchedules button').removeClass().addClass('hvr-sweep-to-left');
  });

  $('#sweepBottom').click(function()
  {
      $('.freeSchedules button').removeClass().addClass('hvr-sweep-to-bottom');
  });

  $('#sweepTop').click(function()
  {
      $('.freeSchedules button').removeClass().addClass('hvr-sweep-to-top');
  });

  $('#sweepBottom').click(function()
  {
      $('.freeSchedules button').removeClass().addClass('hvr-sweep-to-bottom');
  });

  $('#shInHor').click(function()
  {
      $('.freeSchedules button').removeClass().addClass('hvr-shutter-in-horizontal');
  });

  $('#shOutHor').click(function()
  {
      $('.freeSchedules button').removeClass().addClass('hvr-shutter-out-horizontal');
  });

  $('#shInVer').click(function()
  {
      $('.freeSchedules button').removeClass().addClass('hvr-shutter-in-vertical');
  });


  $('#shOutVer').click(function()
  {
      $('.freeSchedules button').removeClass().addClass('hvr-shutter-out-vertical');
  });


  /***** APERCU DES COULEURS SUR LA CARTE *****/


  $('#title').change(function()
  {
    var titleColor = $('#title').val();
    $('.nameCardBig').css('color', titleColor);

  });

  $('#buttonColor').change(function()
  {
    var buttonColor = $('#buttonColor').val();
    $('.freeSchedules button').css('backgroundColor', buttonColor);
  });

  $('#link').change(function()
  {
    var linkColor = $('#link').val();
    $('.linkInCard').css('color', linkColor);
  });

  $('#avalaible').change(function()
  {
    var avalaibleColor = $('#avalaible').val();
    $('.libre').css('backgroundColor', avalaibleColor);
  });

  $('#description').keyup(function(){
    var desc = $('#description textarea').val();
    $('.descriptionInCard').html(desc);
    console.log(desc);
  });

//Fin jquery
});

</script>
