  <!-- FOOTER -->
  <footer class="footer">
      <!-- <footer class="page-footer center-on-small-only stylish-color-dark"> -->

      <!--Footer Links-->
      <div class="container-fluid">
          <div class="row">

              <!--First column-->
              <div class="col-md-4">
                  <h5 class="titleFooter">Description</h5>
                  <p> CALENDAP est un projet réalisé par <a>Frédéric Roth</a>, <a>François Thao </a> et <a>Alexandre Marty</a>
                        dans le cadre de la formation <a href="http://www.wf3.fr" target="_blank">WebForce3</a> Montferrier 2017 en partenariat avec le pôle <a href="https://yncrea.fr" target="_blank">Yncrea</a>.</p>
              </div>
              <!--/.First column-->

              <hr class="clearfix w-100 d-md-none">

              <!--Second column-->
              <div class="col-md-6 mx-auto">
                <h5 class="titleFooter" id="titleRS">Réseaux sociaux</h5>

                <div class="sociaNetwork">
                  <div class="wrp">
                    <a class="icon icon-github" href="https://github.com/" target="_blank">
                      <i class="fa fa-github"></i>
                    </a>
                    <a class="icon icon-twitter" href="https://twitter.com/" target="_blank">
                      <i class="fa fa-twitter"></i>
                    </a>
                    <a class="icon icon-linkedin" href="https://fr.linkedin.com/" target="_blank">
                      <i class="fa fa-linkedin"></i>
                    </a>
                    <a class="icon icon-facebook" href="https://www.facebook.com/" target="_blank">
                      <i class="fa fa-facebook"></i>
                    </a>
                    <a class="icon icon-instagram" href="https://www.instagram.com/" target="_blank">
                      <i class="fa fa-instagram"></i>
                    </a>
                    <a class="icon icon-gplus" href="https://gsuite.google.fr/intl/fr/products/googleplus/" target="_blank">
                      <i class="fa fa-google-plus"></i>
                    </a>
                  </div>
                </div>
              </div>


              <hr class="clearfix w-100 d-md-none">

              <!--Fourth column-->
              <div class="col-md-2 mx-auto">
                  <h5 class="titleFooter">Liens</h5>
                      <p><a href="#!">Mentions légales</a></p>
                      <p><a href="#!">Copyright..</a></p>
                      <p><a href="#!">Plan du site</a></p>
              </div>
              <!--/.Fourth column-->
          </div>
      </div>

    </footer>

  <?php
  if(!customerConnected() || !professionalConnected())
  {
    require_once("../inc/loginmodal.inc.php");
  }

  if(!isset($modal)){
  $modal= '';
  }

  echo $modal;
  ?>


  <!-- Jquery -->

  <!-- bootstrap -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="../js/bootstrap/bootstrap.min.js"></script>

  <!-- MDB -->
  <script src="<?php echo URL; ?>js/mdb/mdb.js"></script>
  <script src="<?php echo URL; ?>js/mdb/tether.js"></script>

  <!-- Mon js -->
  
  <script src="<?php echo URL; ?>js/script.js"></script>

  </body>

</html>
