<?php include('../inc/traitement/init.inc.php') ?>
<?php include('../inc/structure/header.inc.php') ?>
<?php include('../inc/structure/nav.inc.php') ?>

<div class="container">

  <!--Section Features-->
<section>

   <!--Section heading-->
   <h1 class="titleGeneric"> PROFESSIONNELS</h1>
   <!--Section description-->
   <p class="px-5 mb-5 pb-3 lead grey-text text-center">Que peut vous apporter CALENDAP ?</p>

   <!--Grid row-->
   <div class="row">

   <!--Grid column-->
   <div class="col-md-4">

       <!--Grid row-->
       <div class="row mb-2">
       <div class="col-2">
           <i class="fa fa-2x fa-search deep-orange-text"></i>
       </div>
       <div class="col-10 text-left">
           <h5 class="font-bold">Présence en ligne</h5>
           <p class="grey-text">Calendap est très bien référencé et vous permet donc d'apparaitre en premier dans les résultats de recherches liées à votre activité et votre lieux de travail</p>
       </div>
       </div>
       <!--Grid row-->
       <!--Grid row-->
       <div class="row mb-2">
       <div class="col-2">
           <i class="fa fa-user fa-2x deep-orange-text"></i>
       </div>
       <div class="col-10 text-left">
           <h5 class="font-bold">Une carte personnalisée</h5>
           <p class="grey-text">Calendap vous permet de personnaliser votre carte de présentation comme vous le désirez (on est pas chez apple) et ainsi faire ressortir votre personnalité</p>
       </div>
       </div>
       <!--Grid row-->


       <!--Grid row-->
       <div class="row mb-2">
       <div class="col-2">
           <i class="fa fa-2x fa-coffee deep-orange-text"></i>
       </div>
       <div class="col-10 text-left">
           <h5 class="font-bold">Automatisation de tâches quotidiennes</h5>
           <p class="grey-text">Calendap permet aux professionnels de gagner plusieurs dizaines de minutes chaque jour grâce à sa gestion automatisée des prises de rendez vous</p>
       </div>
       </div>
       <!--Grid row-->


   </div>
   <!--Grid column-->

   <!--Grid column-->
   <div class="col-md-4 mb-2 center-on-small-only flex-center" style="display: flex; flex-direction: column;">
       <img src="<?= URL; ?>img/phonePrezPro.png" alt="" class="z-depth-0" >
     <?php if(!professionalConnected())
    { ?>
       <div>
       <a class="btn btn-info" href="<?php echo URL; ?>page/inscriptionPros.php">S'inscrire</a>
     </div>
    <?php } ?>


   </div>
   <!--Grid column-->

   <!--Grid column-->
   <div class="col-md-4">


       <!--Grid row-->
       <div class="row mb-2">
       <div class="col-2">
           <i class="fa fa-2x fa-users deep-orange-text"></i>
       </div>
       <div class="col-10 text-left">
           <h5 class="font-bold">De nouveaux clients</h5>
           <p class="grey-text">Calendap permet à tous les professionnels d'avoir accès à une immense base d'utilisateurs et ainsi élargir leur clientelle </p>
       </div>
       </div>
       <!--Grid row-->
       <!--Grid row-->
       <div class="row mb-2">
       <div class="col-2">
           <i class="fa fa-2x fa-calendar deep-orange-text"></i>
       </div>
       <div class="col-10 text-left">
           <h5 class="font-bold">Un calendrier adapté à vos besoins </h5>
           <p class="grey-text">Vous pouvez adapter le calendrier à vos besoins en changeant les horaires disponibles, les jours de congés, le nombre de rendez vous que l'on peut prendre à l'heure etc..</p>
       </div>
       </div>
       <!--Grid row-->
              <!--Grid row-->
              <div class="row mb-2">
              <div class="col-2">
                  <i class="fa fa-2x fa-thumbs-up deep-orange-text"></i>
              </div>
              <div class="col-10 text-left">
                  <h5 class="font-bold">Un service de mise en avant</h5>
                  <p class="grey-text">Pas assez de clients cette semaine? Grâce au programme "coup de pouce" vous pouvez être mis en avant sur des recherches ciblées et liées à un lieu ou une activité</p>
              </div>
              </div>
              <!--Grid row-->

   </div>
   <!--Grid column-->

   </div>
   <!--Grid row-->

</section>
<!--/Section: Features v.4-->


<!-- SECTION  NOS OFFRES -->
<section class="feature-box">

<!--Section heading-->
<h1 class="titleGeneric"> NOS OFFRES</h1>
<!--Section description-->
<p class="px-5 mb-5 pb-3 lead grey-text">Calendap s'adresse à tous types de petites et moyennes entreprises et propose une offre adaptée à tous les profils </p>

<!--Grid row-->
<div class="row features-small">

<!--Grid column-->
<div class="col-md-4 mb-r">
  <div class="col-1 col-md-2 float-left">
  <i class="fa fa-bullhorn blue-text"></i>
  </div>
  <div class="col-10 col-md-9 col-lg-10 float-right">
  <h4 class="font-bold">Offre micro entreprise</h4>
  <p class="grey-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reprehenderit maiores nam, aperiam minima assumenda.</p>
  <h3> 5€ / Mois </h3>
  <a class="btn btn-primary btn-sm ml-0">En savoir plus</a>
  </div>
</div>
<!--Grid column-->

<!--Grid column-->
<div class="col-md-4 mb-r">
  <div class="col-1 col-md-2 float-left">
  <i class="fa fa-cogs pink-text"></i>
  </div>
  <div class="col-10 col-md-9 col-lg-10 float-right">
  <h4 class="font-bold">Offre standard</h4>
  <p class="grey-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reprehenderit maiores nam, aperiam minima assumenda.</p>
  <h3> 15€ / Mois </h3>
  <a class="btn btn-pink btn-sm ml-0">En savoir plus</a>
  </div>
</div>
<!--Grid column-->

<!--Grid column-->
<div class="col-md-4 mb-r">
  <div class="col-1 col-md-2 float-left">
  <i class="fa fa-dashboard purple-text"></i>
  </div>
  <div class="col-10 col-md-9 col-lg-10 float-right">
  <h4 class="font-bold">Offre premium</h4>
  <p class="grey-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reprehenderit maiores nam, aperiam minima assumenda.</p>
  <h3> 30€ / Mois </h3>
  <a class="btn btn-secondary btn-sm ml-0">En savir plus</a>
  </div>
</div>
<!--Grid column-->

</div>
<!--Grid row-->

</section>
<!--Section: Features v.2-->

</div>
<?php require_once('../inc/structure/footer.inc.php') ?>
