<nav>
  <ul class="nav justify-content-end" id="myNav2">
    <li  class="nav-item <?php currentClass(URL . 'page/index.php'); ?>">
      <img src="<?php echo URL; ?>img/logoCalendapMini.png" alt="Icone Calendapp" width="30" height="30">
      <a class="nav-link" data-hover="Accueil" href="<?php echo URL; ?>page/index.php">Accueil</a>
      </li>
  </ul>
  <ul class="nav justify-content-end" id="myNav">
  <!-- current = active -->
    <li id="navAccueilSmallScreen" class="nav-item <?php currentClass(URL . 'page/index.php'); ?>">
    <img src="<?php echo URL; ?>img/logoCalendapMini.png" alt="Icone Calendapp" width="30" height="30">
    <a class="nav-link" data-hover="Accueil" href="<?php echo URL; ?>page/index.php">Accueil</a>
    </li>
    <?php if(!customerConnected() && !professionalConnected()) { ?>
    <li class="nav-item <?php currentClass(URL . 'page/about.php'); ?>">
      <a class="nav-link" data-hover="About" href="<?php echo URL; ?>page/about.php">About</a>
    </li>
    
    <?php } if(professionalConnected() || (!professionalConnected() && !customerConnected())) { ?>
    <li class="nav-item <?php currentClass(URL . 'page/pros.php'); ?>">
      <a class="nav-link" data-hover="Professionnels" href="<?php echo URL; ?>page/pros.php">Professionnels</a>
    </li>

    <?php } if(customerConnected() && !professionalConnected()) { ?>
    <li class="nav-item <?php currentClass(URL . 'page/profil.php'); ?>">
      <a class="nav-link" data-hover="Profil" href="<?php echo URL; ?>page/profil.php">Profil</a>
    </li>
    <?php } else if(professionalConnected()) { ?>
    <li class="nav-item <?php currentClass(URL . 'page/profilpro.php'); ?>">
      <a class="nav-link" data-hover="Compte" href="<?php echo URL; ?>page/profilpro.php">compte</a>
    </li><li class="nav-item <?php currentClass(URL . 'page/calendrierPro.php'); ?>">
      <a class="nav-link" data-hover="Calendrier" href="<?php echo URL; ?>page/calendrierPro.php">Calendrier</a>
    </li>
    <li class="nav-item <?php currentClass(URL . 'page/personnalisation.php'); ?>">
      <a class="nav-link" data-hover="Personnalisation" href="<?php echo URL; ?>page/personnalisation.php">Personnalisation</a>
    </li>
    <?php } if(customerConnected() || professionalConnected()) { ?>
    <li class="nav-item">
      <a class="nav-link" data-hover="Déconnexion" href="<?php echo URL; ?>page/index.php?task=disconnection">Déconnexion</a>
    </li>
    <?php } else { ?>
    <li class="nav-item">
      <a class="nav-link" id="connectionModal" data-toggle="modal" data-hover="Connexion" href="#modalLogin">Connexion</a>
    </li>
    <?php } ?>
  </ul>
</nav>
