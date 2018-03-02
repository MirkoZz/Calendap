
  <header>
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
        <div class="headerTitle">
          <h1>trouvez et prenez </h1><br><h1 class="headerTitleCalendap">CALENDAP</h1> <br><h1>vos rendez-vous en ligne</h1>
        </div>
        <div class="divForButtonsHeader">
          <a href="<?php echo URL; ?>page/inscription.php" id="btnHeadeLeft" class="btn btn-mdb btn-block">Inscription</a>
          <a href="<?php echo URL; ?>page/pros.php" id="btnHeaderRight" class="btn btn-amber btn-block">Inscription Pro</a>
        </div>


          <!-- <div class="headerTitleButtons">
            <button class="hvr-" type="button" name="button">UTILISATEUR</button>
            <button class="hvr-" type="button" name="button">PROFESSIONNEL</button>
          </div> -->
      <div id="searchHeader">
        <form class="form-group-row" method="post">

          <div class="inputInHeaderHome">
            <div class="form-group">
              <i class="fa fa-user prefix fa-5x faInInputs" id="colorI1"></i>
              <input placeholder="Que recherchez vous? (ex: Coiffeur)" name="activity"class="form-control validate" >
            </div>
              <div class="form-group">
                <i class="fa fa-map-marker prefix fa-5x faInInputs" id="colorI2"></i>
                <input placeholder="Dans quelle ville? (ex: Montpellier)" name="city" class="form-control validate">
              </div>
          </div>
            <div class="form-group">
               <!-- <a id="btnFormHome" class="btn  btn-primary btn-lg">Rechercher</a> -->
            <i class="fa fa-search prefix fa-5x faInInputs" id="colorI3"></i>
            <button type="submit" id="btnHeaderSearch" class="btn btn-amber btn-block">Rechercher</button>
          </div>

        </form>
      </div>
      </div>

      <script type="text/javascript">
      $(function(){

        $('#headerWallpaper').delay(6000).hide("fold", 1000);

     });
      </script>
  </header>
