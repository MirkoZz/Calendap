<?php include('../inc/traitement/init.inc.php') ?>
<?php include('../inc/structure/header.inc.php') ?>
<?php include('../inc/structure/nav.inc.php') ?>


  <!-- Title rainbow -->
  <!-- <div class="wrapper">

  </div> -->

  <div class="about">

  <nav class="toc">
    <ul>
      <li>
        <a href="#prez">Présentation</a></li>
      <li>
        <a href="#team">L'équipe</a>
        <ul>
          <li><a href="#thao">François Thao</a></li>
          <li><a href="#marty">Alex Marty</a></li>
          <li><a href="#roth">Frédéric Roth</a></li>

        </ul>
      </li>
      <li>
        <a href="#technos">Étapes & technlogies</a>
        <ul>
          <li><a href="#model">Modélisation</a></li>
          <li><a href="#vue">Design</a></li>
          <li><a href="#control">Controle</a></li>
        </ul>
      </li>
      <li>
        <a href="#dem">Démonstration</a>
      </li>
      <li>
        <a href="#problem">Problématiques</a>
        <ul>
          <li><a href="#calen">Calendrier</a></li>
          <li><a href="#conf">Conflits</a></li>
          <li><a href="#teamwork">Travail en équipe</a></li>
        </ul>
      </li>
      <li>
        <a href="#evo">Evolution</a>
      </li>
      <ul>
        <li><a href="#eco">Modèle économique</a></li>
        <li><a href="#amelioration">Améliorations</a></li>
        <li><a href="#arret">Arrêt du projet</a></li>
      </ul>
    </ul>
    <svg class="toc-marker" width="200" height="200" xmlns="http://www.w3.org/2000/svg">
      <path stroke="#444" stroke-width="3" fill="transparent" stroke-dasharray="0, 0, 0, 1000" stroke-linecap="round" stroke-linejoin="round" transform="translate(-0.5, -0.5)" />
    </svg>
  </nav>

  <div class="container-fluid">
  <div src="" alt="" id="headerWallpaper">

    <div class="titleCalendapSmoky" id="titleCalendapSmokyHeader">
      <span>C</span>
      <span>A</span>
      <span>L</span>
      <span>E</span>
      <span>N</span>
      <span>D</span>
      <span>A</span>
      <span>P</span>
    </div>

    </div>
    </div>

<div class="container">
  <div class="aboutTitle"><h1 id="prez">présentation</h1></div>

  <div id="stage"></div>

  <div class="aboutTitle"><h1 id="team">L'équipe</h1></div>

<div class="asideCarteSmall profile-card" id="thao">

  <header>

    <!-- here’s the avatar -->
    <a href="#">
      <img src="<?php echo URL;?>img/thao_francois.jpg">
    </a>

    <!-- the username -->
    <h1>François Thao</h1>

  </header>

  <!-- bit of a bio; who are you? -->
  <div class="profile-bio">

    <h2>- Développeur web -</h2>
    <p>Comptable de formation, j'ai choisi de me réorienter dans le développement web de manière naturelle.
      J'ai toujours été intéréssé par l'informatique et le web.
    <br />Le but de cette formation est de pouvoir m'installer en tant que développeur indépendant.</p>

  </div>

</div>
<div class="asideCarteSmall profile-card" id="marty">

  <header>

    <!-- here’s the avatar -->
    <a href="#">
      <img src="<?php echo URL;?>img/marty_alex.jpg">
    </a>

    <!-- the username -->
    <h1>Alexandre Marty</h1>

  </header>

  <!-- bit of a bio; who are you? -->
  <div class="profile-bio">

    <h2>- Développeur web -</h2>
    <p>J'ai un profil polyvalent avec des connaissances en webmarketing, en programmation mobile et en communication
      <br />Je veux me spécialiser dans le développement front end et l'ux design</p>

  </div>

</div>
<div class="asideCarteSmall profile-card" id="roth">

  <header>

    <!-- here’s the avatar -->
    <a href="#">
      <img src="<?php echo URL;?>img/roth_frederic.jpg">
    </a>

    <!-- the username -->
    <h1>Frédéric Roth</h1>

  </header>

  <!-- bit of a bio; who are you? -->
  <div class="profile-bio">

    <h2>- Développeur Web -</h2>
    <p>J'ai intégré la formation WebForce3 dans le cadre d'une reconversion professionnelle. J'ai travaillé 15 ans dans le commerce dont un peu moins d'une dizaine d'année dans l'entreprise IKEA.
    <br />Ma première passion a été l'informatique et j'ai été rapidement attiré par ses langages. C'est la raison pour laquelle je me suis orienté vers un BTS informatique de gestion</p>

  </div>


</div>
<div class="aboutTitle"><h1 id="technos">étapes & technologies</h1></div>

<h1 class="titleGeneric" id="model">Modélisation</h1>

  <div class="technoContener">
    <div class="technosLeft">
      <p>Modélisation de la base de données</p>
      <p>Création du modèle de base de données</p>
      <p>Génération des différents calendriers et divers éléments</p>

    </div>
    <div class="technosRight">
      <p>Algorythmique</p>
      <p>SQL</p>
      <p>PHP</p>
    </div>
  </div>

  <h1 class="titleGeneric" id="vue">Design</h1>

  <div class="technoContener">
    <div class="technosLeft">
      <p>Conception de différents "fragments"</p>
      <p>Design global du site</p>
      <p>Création des animations qui réagissent en fonction de l'utilisateur</p>
    </div>
    <div class="technosRight">
      <p>Diverses animations Css et librairies Jquery</p>
      <p>Bootstrap ->mdb / Material design </p>
      <p>Jquery &  JqueryUI</p>
    </div>
  </div>

  <h1 class="titleGeneric" id="control">Contrôle</h1>

  <div class="technoContener">
    <div class="technosLeft">
      <p>Formulaires d'inscription client/pro</p>
      <p>Gestion des utilisateurs & Modales</p>
      <p>Fonctionnalités de la personnalisation des cartes</p>

    </div>
    <div class="technosRight">
      <p>Bootstrap/JQuery/PHP & SQL/Ajax</p>
      <p>Material Design/JQuery/PHP & SQL</p>
      <p>JQuery/PHP & SQL</p>
    </div>
  </div>

  <div class="aboutTitle"><h1 id="dem"><a href="index.php">Démonstration</a></h1></div>

  <div class="aboutTitle"><h1 id="problem">Problématiques</h1></div>
  <div class="aboutContener">
    <h1 class="titleGeneric" id="calen">Le calendrier</h1>
    <p>Création d'une boucle logique gérant les dates et heures</p>
    <p>Adapter l'ensemble des calendriers aux éléments du site</p>
    <h1 class="titleGeneric" id="conf">Les conflits et l'intégration du php</h1>
    <p>Arriver à enlever tous les bugs liés à l'utilisation de ressources diverses</p>
    <p>Faire un design permissif qui permet l'intégration d'éléments générés dynamiquement </p>

    <h1 class="titleGeneric" id="teamwork">Travail en équipe</h1>
    <p>Fusion du travail de chaque membre de l'équipe et correction des bugs engendrés</p>
    <p>S'adapter à la manière de coder de chacun </p>
  </div>


  <div class="aboutTitle"><h1 id="evo">Perspectives & évolution</h1></div>

    <h1 class="titleGeneric" id="eco">Modèle économique</h1>
    <div class="aboutContener">
      <p>Se concentrer sur un modèle viable adapté aux très petites entreprises de services</p>
      <p>Se servir des données et des retours des premiers utilisateurs pour faire remonter les bugs et améliorer le modèle</p>
      <p>Passer aux petites et moyennes entreprises</p>
      <p>Passer aux grandes entreprises et administrations</p>
      <p>Vendre à une plus grosse société</p>
    </div>
  
  <h1 class="titleGeneric" id="amelioration">Améliorations</h1>
    <div class="aboutContener">
      <p>Gestion plus complexe des calendriers</p>
      <p>Apparition des résultats de la recherche en AJAX</p>
      <p>Géolocalisation</p>
      <p>Autocomplétion des champs de recherche (En cours)</p>
    </div>

    <h1 class="titleGeneric" id="arret">Arrêt du projet</h1>
    <div class="aboutContener">
      <p>Le marché est porteur</p>
      <p>Mais la concurence va être trop rude</p>
      <p>L'équipe préfère se concentrer sur son apprentissage du développement web</p>
    </div>

  </div>

  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.20.3/TweenMax.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.20.3/TweenLite.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.20.3/utils/Draggable.min.js"></script>
  <script src="../js/about/ThrowPropsPlugin.min.js"></script>
  <script src="../js/about/snap.svg-min.js"></script>
  <script src="<?php echo URL; ?>js/about/scriptForAbout.js"></script>

        <script type="text/javascript">
        $(function(){

          $('#headerWallpaper').delay(6000).hide("clip", 1000);

       });
        </script>
  <?php require_once('../inc/structure/footer.inc.php') ?>
