<!--***** MODAL INSCRIPTION REUSSIE *****-->
<div class="modal fade" id="dateRegister" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-notify modal-success" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p class="heading lead"><?= $_SESSION['customer']['firstname'] . " " . $_SESSION['customer']['lastname']; ?></p>
      </div>
      <div class="modal-body">
        <div class="text-center">
          <i class="fa fa-check fa-4x mb-3 animated rotateIn"></i>
          <h1>Rendez-vous confirmé!</h1>
          <h6><b>Le <?= $modalDate; ?> à <?= $modalHour; ?></b></h6>
          <p><?php if($proInfos['society'] == ''){echo $proInfos['firstname'] . ' ' . $proInfos['lastname'];}else{echo $proInfos['society'];} ?></p>
          <p><?= $proInfos['address']; ?></p>
          <p><?= $proInfos['postalCode'] . ' ' . $proInfos['city']; ?></p>
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <a class="btn btn-outline-secondary-modal waves-effect" href="index.php">Fermer</a>
      </div>
    </div>
  </div>
</div>
<!--***** FIN MODAL INSCRIPTION REUSSIE *****-->  