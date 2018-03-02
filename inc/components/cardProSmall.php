<?php 

// requete pour tester avec le professionnel
$infoCard = $pdo->query("SELECT * FROM professional ORDER BY RAND() LIMIT 3");

// transformation des informations en tableau


?>

<div class="container">
  <!-- <h1> Coup de pouce <i class="fa fa-thumbs-up fa-2x"></h1> -->
<h1 class="titleGeneric" id="ilsSontDispo">Ils sont disponibles</h1>
</div>
<div class="container" id="sectionCardProSmall">

<?php 
while($infoProCard = $infoCard->fetch(PDO::FETCH_ASSOC))

{ ?>


  <div class="asideCarteSmall profile-card">

    <header>

      <!-- here’s the avatar -->
      <a href="">
        <img src="<?php if($infoProCard['picture'] != ''){echo URL . $infoProCard['picture'];}else{echo 'https://randomuser.me/api/portraits/men/' . rand(0, 99) . '.jpg';} ?>" width="128" height="128">
      </a>

      <!-- the username -->
      <h1>
        <?php 
        if (empty($infoProCard['society'])) 
        {
          echo $infoProCard['lastname']." ".$infoProCard['firstname']; 
        }
        else
        {
          echo $infoProCard['society'];
        }
        ?>
          
        </h1>
      
    </header>

    <!-- bit of a bio; who are you? -->
    <div class="profile-bio">

      <h2><?php echo ucfirst($infoProCard['activity'])." à ".$infoProCard['city']; ?></h2>
      <p><?php if($infoProCard['description']){echo $infoProCard['description'];}else{echo 'Haec igitur Epicuri non probo, inquam. De cetero vellem equidem aut ipse doctrinis fuisset instructior est enim, quod tibi ita videri necesse est, non satis politus iis artibus, quas qui tenent, eruditi appellantur aut ne deterruisset alios a studiis. quamquam te quidem video minime esse deterritum.';} ?></p>

    </div>

  </div>

  <?php }?>



</div>
